<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

use App\Notification;
use App\Message;
use App\Credit;
use App\ShoppingCart;


class NotificationController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // to show a view that lets a user send a notification
    public function index()
    {
        $notifications = Notification::where('recipient_id', Auth::id())->orderBy('created_at', 'desc')->get();

        foreach($notifications as $notification) {
            $notification->read = true;

            $notification->save();
        }
        
        return view('notifications', [
            
            'notifications' => $notifications,
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    }

    // to handle a notification request and trigger the notification event
    public function postNotify(Request $request)
    {
        $notifyText = e($request->input('notify_text'));

        // TODO: Get Pusher instance from service container
        $pusher = App::make('pusher');

        // TODO: The notification event data should have a property named 'text'
        $message = array('message' => 'hello thambi');

        // TODO: On the 'notifications' channel trigger a 'new-notification' event
        $pusher->trigger('notifications', 'new-notification', $message);
    }
}
