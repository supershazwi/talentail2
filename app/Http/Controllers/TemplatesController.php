<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use App\Template;
use App\TemplateShot;
use App\Competency;
use App\Notification;
use App\Message;
use App\ShoppingCart;
use App\Credit;

use Validator;

class TemplatesController extends Controller
{
    public function index() {
        $templates = Template::all();

    	return view('templates.index', [
            
            'templates' => $templates,
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    }

    public function show() {
        $routeParameters = Route::getCurrentRoute()->parameters();

        $template = Template::find($routeParameters['templateId']);

        if($template) {
            return view('templates.show', [
                
                'template' => $template,
                'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
            ]);
        } else {
            return redirect('templates');
        }
        
    }

    public function upload() {
    	if(Auth::user()->creator) {
	    	return view('templates.upload', [
                
	            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
	        ]);
    	} else {
    		return redirect('templates');
    	}
    }

    public function uploadFile(Request $request) {
    	$validator = Validator::make($request->all(), [
    	    'title' => 'required',
    	    'description' => 'required',
    	    'file' => 'required',
            'shot' => 'required',
    	]);

    	if($validator->fails()) {
    	    return redirect('templates/upload')
    	                ->withErrors($validator)
    	                ->withInput();
    	}

    	$template = new Template;

    	$template->title = $request->input('title');
    	$template->description = $request->input('description');
        $template->url = Storage::disk('gcs')->put('/assets', $request->file('file')[0], 'public');
    	$template->mime_type = $request->file('file')[0]->getMimeType();
    	$template->size = $request->file('file')[0]->getSize();
        $template->user_id = Auth::id();

    	$template->save();

        for($fileCounter = 0; $fileCounter < count($request->file('shot')); $fileCounter++) {

            $templateShot = new TemplateShot;

            $templateShot->url = Storage::disk('gcs')->put('/assets', $request->file('shot')[$fileCounter], 'public');
            $templateShot->template_id = $template->id;

            $templateShot->save();
        }

    	return redirect('templates');
    }
}
