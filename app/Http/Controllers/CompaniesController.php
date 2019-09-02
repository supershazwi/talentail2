<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Company;
use App\ShoppingCart;
use App\Message;
use App\Credit;
use App\Notification;

class CompaniesController extends Controller
{

    public function index() {
        $companies = Company::all();

    	return view('companies.index', [
            
            'companies' => $companies,
            'parameter' => 'company',
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    }

    public function create() {
    	return view('companies.create', [
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    }

    public function store() {
    	$company = new Company;

    	$company->title = request('title');
    	$company->description = request('description');
        $company->website = request('website');
        $company->facebook = request('facebook');
        $company->twitter = request('twitter');
        $company->linkedin = request('linkedin');
        $company->email = request('email');
        $company->slug = str_slug(request('title'), '-');

        if(request('avatar')) {
            $company->avatar = request('avatar')->getClientOriginalName();
            $company->url = Storage::disk('gcs')->put('/avatars', request('avatar'), 'public');
        }

    	$company->save();

    	return redirect('/companies');
    }

    public function show($slug) {
        $company = Company::where('slug', $slug)->first();

        return view('companies.show', [
            
            'company' => $company,
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    }
}
