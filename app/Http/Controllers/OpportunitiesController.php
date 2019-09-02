<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Opportunity;
use App\Role;
use App\Company;
use App\Message;
use App\Credit;
use App\Notification;
use App\ShoppingCart;


class OpportunitiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $opportunities = Opportunity::all();

        return view('opportunities.index', [
            'parameter' => 'opportunity',
            'opportunities' => $opportunities,
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    }

    public function create() {
        return view('opportunities.create', [
            'company' => $company,
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    }

    public function store() {
    	$opportunity = new Opportunity;

    	$opportunity->title = request('title');
    	$opportunity->description = request('description');
        $opportunity->role_id = request('role_id');
        $opportunity->location = request('location');
        $opportunity->company_id = request('company_id');

        $company = Company::select('title')->where('id', request('company_id'))->first();

        $opportunity->slug = strtolower($company->title) . '-' . str_slug(request('title'), '-');

    	$opportunity->save();

    	return redirect('/');
    }

    public function show($slug) {
        $opportunity = Opportunity::where('slug', $slug)->first();

        return view('opportunities.show', [
            
            'opportunity' => $opportunity,
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    }
}
