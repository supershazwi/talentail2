<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendProjectPurchasedMail;

use App\ShoppingCartLineItem;

use App\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\IPNStatus;
use App\Notification;
use App\Message;
use App\AnsweredTask;
use App\Invoice;
use App\CompetencyScore;
use App\User;
use App\InvoiceLineItem;
use App\AttemptedProject;
use App\ShoppingCart;


class PayPalController extends Controller
{
    /**
     * @var ExpressCheckout
     */
    protected $provider;

    public function __construct()
    {
        $this->provider = new ExpressCheckout();
    }

    public function getIndex(Request $request)
    {
        $response = [];
        if (session()->has('code')) {
            $response['code'] = session()->get('code');
            session()->forget('code');
        }

        if (session()->has('message')) {
            $response['message'] = session()->get('message');
            session()->forget('message');
        }

        return view('welcome', [
            'response' => $response,
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getExpressCheckout(Request $request)
    {
        $routeParameters = Route::getCurrentRoute()->parameters();

        $recurring = false;
        $cart = $this->getCheckoutData($recurring);

        try {
            $response = $this->provider->setExpressCheckout($cart, $recurring);

            return redirect($response['paypal_link']);
        } catch (\Exception $e) {
            // $invoice = $this->updateShoppingCart($cart, 'Invalid');

            session()->put(['code' => 'danger', 'message' => "Error processing PayPal payment for Order $invoice->id!"]);
        }
    }

    /**
     * Process payment on PayPal.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getExpressCheckoutSuccess(Request $request)
    {
        $recurring = ($request->get('mode') === 'recurring') ? true : false;
        $token = $request->get('token');
        $PayerID = $request->get('PayerID');

        $cart = $this->getCheckoutData($recurring);

        // Verify Express Checkout Token
        $response = $this->provider->getExpressCheckoutDetails($token);

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
           
            // Perform transaction on PayPal
            $payment_status = $this->provider->doExpressCheckoutPayment($cart, $token, $PayerID);
            $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];

            $this->updateShoppingCart($cart, $status);

            $routeParameters = Route::getCurrentRoute()->parameters();
            $shoppingCart = ShoppingCart::find($routeParameters['shoppingCartId']);

            $projectsNameArray = array();

            foreach($shoppingCart->shopping_cart_line_items as $shoppingCartLineItem) {
                array_push($projectsNameArray, $shoppingCartLineItem->project->title);
            }

            if ($shoppingCart->status == "paid") {
                return redirect('/shopping-cart')->with('projectsNameArray', $projectsNameArray);
            } else {
                return redirect('/shopping-cart')->with('error', "Error processing PayPal payment for Order $shoppingCart->id!");
            }
        }
    }

    /**
     * Parse PayPal IPN.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function notify(Request $request)
    {
        if (!($this->provider instanceof ExpressCheckout)) {
            $this->provider = new ExpressCheckout();
        }

        $post = [
            'cmd' => '_notify-validate'
        ];
        $data = $request->all();
        foreach ($data as $key => $value) {
            $post[$key] = $value;
        }

        $response = (string) $this->provider->verifyIPN($post);

        $ipn = new IPNStatus();
        $ipn->payload = json_encode($post);
        $ipn->status = $response;
        $ipn->save();            
    }

    /**
     * Set cart data for processing payment on PayPal.
     *
     * @param bool $recurring
     *
     * @return array
     */
    protected function getCheckoutData($recurring = false)
    {
        $routeParameters = Route::getCurrentRoute()->parameters();

        $shoppingCart = ShoppingCart::find($routeParameters['shoppingCartId']);

        $items = array();

        foreach($shoppingCart->shopping_cart_line_items as $shoppingCartLineItem) {
            $lineItemToAdd['name'] = $shoppingCartLineItem->project->title;
            $lineItemToAdd['price'] = $shoppingCartLineItem->project->amount;
            $lineItemToAdd['qty'] = 1;

            array_push($items, $lineItemToAdd);
        }

        $data = [];

        $order_id = $shoppingCart->id;

        $data['items'] = $items;

        $data['return_url'] = url('/checkout/'.$shoppingCart->id.'/success');

        $data['invoice_id'] = $order_id;
        $data['invoice_description'] = "Order #$order_id Invoice. You have purchased a total of " . sizeof($shoppingCart->shopping_cart_line_items) . " project(s).";
        $data['cancel_url'] = url('/shopping-cart');

        $total = 0;
        foreach ($data['items'] as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $data['total'] = $total;

        return $data;
    }

    /**
     * Create invoice.
     *
     * @param array  $cart
     * @param string $status
     *
     * @return \App\Invoice
     */
    protected function updateShoppingCart($cart, $status)
    {
        $routeParameters = Route::getCurrentRoute()->parameters();
        $shoppingCart = ShoppingCart::find($routeParameters['shoppingCartId']);            
        $shoppingCart->status = "paid";

        $shoppingCart->save();

        // check for how many project creators i need to create invoices
        // invoices are tagged to each shopping cart

        $creatorIds = array();
        $creatorTotalAmount;

        foreach($shoppingCart->shopping_cart_line_items as $shoppingCartLineItem) {
            $creatorId = $shoppingCartLineItem->project->user_id;

            if(!in_array($creatorId, $creatorIds)) {
                array_push($creatorIds, $creatorId);

                $creatorTotalAmount[$creatorId] = 0;
            } 

            $creatorTotalAmount[$creatorId] += $shoppingCartLineItem->project->amount;
        }

        $creatorIdAndInvoiceId;
        $creatorProjectsToEmail;

        foreach($creatorIds as $creatorId) {
            $invoice = new Invoice;

            $invoice->status = "Pending Payout";
            $invoice->total = $creatorTotalAmount[$creatorId];
            $invoice->user_id = $creatorId;
            $invoice->shopping_cart_id = $shoppingCart->id;

            $invoice->save();

            $creatorIdAndInvoiceId[$creatorId] = $invoice->id;
            $creatorProjectsToEmail[$creatorId] = array();
        }

        

        foreach($shoppingCart->shopping_cart_line_items as $shoppingCartLineItem) {
            $attemptedProject = new AttemptedProject;

            $attemptedProject->project_id = $shoppingCartLineItem->project_id;
            $attemptedProject->user_id = Auth::id();
            $attemptedProject->status = "Attempting";
            $attemptedProject->creator_id = $shoppingCartLineItem->project->user_id;

            // calculate the deadline of the project by adding project hours to current date
            $attemptedProject->deadline = date("Y-m-d H:i:s", time() + ($shoppingCartLineItem->project->hours * 60 * 60));

            $attemptedProject->save();

            foreach($shoppingCartLineItem->project->tasks as $task) {
                $answeredTask = new AnsweredTask;
                $answeredTask->answer = "";
                $answeredTask->response = "";
                $answeredTask->user_id = Auth::id();
                $answeredTask->task_id = $task->id;
                $answeredTask->project_id = $shoppingCartLineItem->project->id;

                $answeredTask->save();
            }

            foreach($shoppingCartLineItem->project->competencies as $competency) {
                // create new competencyscore for each

                $competencyScore = new CompetencyScore;

                $competencyScore->competency_id = $competency->id;
                $competencyScore->role_gained_id = $shoppingCartLineItem->project->role_id;
                $competencyScore->score = 0;
                $competencyScore->user_id = Auth::id();
                $competencyScore->project_id = $shoppingCartLineItem->project->id;
                $competencyScore->attempted_project_id = $attemptedProject->id;

                $competencyScore->save();
            }

            array_push($creatorProjectsToEmail[$attemptedProject->creator_id], $attemptedProject->project->title);

            $invoiceLineItem = new InvoiceLineItem;

            $invoiceLineItem->project_id = $attemptedProject->project_id;
            $invoiceLineItem->invoice_id = $creatorIdAndInvoiceId[$attemptedProject->project->user_id];

            $invoiceLineItem->save();
        
            $userToEmail = User::find($attemptedProject->project->user_id);

            Mail::to($userToEmail->email)->send(new SendProjectPurchasedMail($userToEmail, $creatorProjectsToEmail[$creatorId], "https://talentail.com/roles/" . $attemptedProject->project->role->slug . "/projects/" . $attemptedProject->project->slug . "/" . Auth::id()));   
        }

        // foreach($creatorIds as $creatorId) {
        //     $userToEmail = User::find($creatorId);
        //     Mail::to($userToEmail->email)->send(new SendProjectPurchasedMail($userToEmail, $creatorProjectsToEmail[$creatorId], "https://talentail.com/roles/" . $attemptedProject->project->role->slug . "/projects/" . $attemptedProject->project->slug . "/" . Auth::id()));
        // }
    }
}
