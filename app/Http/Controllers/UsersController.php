<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Experience;
use App\User;
use App\Message;
use App\Credit;


use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function saveProfile(Request $request) {
        dd($request);
    }

    public function store(Request $request) {
        dd($request);
        // dd(request());

        // dd($request->file('file'));

        $request->file('file')->store('/assets', 'gcs');

        // $disk = Storage::disk('gcs');
        // $disk->put('/assets/1', $fileContents);

        // redirect('/file-upload');
    }
}
