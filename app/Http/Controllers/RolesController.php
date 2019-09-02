<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Role;
use App\Competency;
use App\Message;
use App\Credit;
use App\Notification;
use App\ShoppingCart;


class RolesController extends Controller
{
    public function index() {
        $roles = Role::all();

    	return view('roles.index', [
            
            'roles' => $roles,
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    }

    public function create() {
    	return view('roles.create', [
            
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    }

    public function store() {
    	$role = new Role;

    	$role->title = request('title');
    	$role->description = request('description');
        $role->slug = str_slug(request('title'), '-');

    	$role->save();

    	return redirect('/roles');
    }

    public function show($slug) {
        $role = Role::where('slug', $slug)->first();

        $competencies = Competency::where('role_id', $role->id)->get();

        return view('roles.show', [
            
            'role' => $role,
            'competencies' => $competencies,
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    }
}
