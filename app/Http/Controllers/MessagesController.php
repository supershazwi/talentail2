<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Message;
use App\Credit;
use App\ShoppingCart;
use App\User;
use App\Project;
use App\Notification;
use App\Http\Controllers\stdClass;
use DB;

class MessagesController extends Controller
{
    var $pusher;
    var $user;
    var $messageChannel;

    const DEFAULT_message_CHANNEL = 'message';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->pusher = App::make('pusher');
        $this->user = Auth::user();
        $this->messageChannel = self::DEFAULT_message_CHANNEL;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if(!Auth::user())
        // {
        //     return redirect('/login');
        // }

        // return view('messages.show', ['messageChannel' => $this->messageChannel]);

        $messages = Message::where('recipient_id', Auth::id())->orWhere('sender_id', Auth::id())->get();

        // i need to loop through the messages to sift out users that i need to display at the right hand side

        $loggedInUserId = Auth::id();

        $allUsersIdArray = array();
        $allProjectsUsersIdArray = array();

        $allProjectsIdArray = array();

        foreach($messages as $message) {
            if(!in_array($message->recipient_id, $allUsersIdArray) && $message->recipient_id != $loggedInUserId) {
                array_push($allUsersIdArray, $message->recipient_id);
            } 
            if(!in_array($message->sender_id, $allUsersIdArray) && $message->sender_id != $loggedInUserId) {
                array_push($allUsersIdArray, $message->sender_id);
            } 
            if($message->project_id && $message->recipient_id != $loggedInUserId) {
                if(!in_array($message->project_id, $allProjectsIdArray) && !in_array($message->recipient_id, $allProjectsUsersIdArray)) {
                    array_push($allProjectsUsersIdArray, $message->recipient_id);
                    array_push($allProjectsIdArray, $message->project_id);
                }
            } 
            if($message->project_id && $message->sender_id != $loggedInUserId) {
                if(!in_array($message->project_id, $allProjectsIdArray) && !in_array($message->sender_id, $allProjectsUsersIdArray)) {
                    array_push($allProjectsUsersIdArray, $message->sender_id);
                    array_push($allProjectsIdArray, $message->project_id);
                }
            } 
        }

        $allNewArray = array();

        foreach($allProjectsUsersIdArray as $key=>$projectUserId) {
            $app = app();
            $obj = $app->make('stdClass');
            $obj->user = User::find($projectUserId);
            $obj->project = Project::find($allProjectsIdArray[$key]);
            array_push($allNewArray, $obj);
        }

        foreach($messages as $message) {
            if(!in_array($message->recipient_id, $allUsersIdArray) && $message->recipient_id != $loggedInUserId) {
                array_push($allUsersIdArray, $message->recipient_id);
            } 
            if(!in_array($message->sender_id, $allUsersIdArray) && $message->sender_id != $loggedInUserId) {
                array_push($allUsersIdArray, $message->sender_id);
            } 
            if($message->project_id && $message->recipient_id != $loggedInUserId) {
                array_push($allProjectsUsersIdArray, $message->recipient_id);
            } 
            if($message->project_id && $message->sender_id != $loggedInUserId) {
                array_push($allProjectsUsersIdArray, $message->sender_id);
            } 
        }

        $users = User::find($allUsersIdArray);
        $projectUsers = User::find($allProjectsUsersIdArray);


        return view('messages.index', [
            
            'users' => $users,
            'projectUsers' => $projectUsers,
            'messages' => null,
            'userProjectObjectArray' => $allNewArray,
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    }

    public function showIndividualChannel() {
        $routeParameters = Route::getCurrentRoute()->parameters();

        if(Auth::id() == $routeParameters['userId']) {
            return redirect('/messages');
        } 

        $messages = Message::where('recipient_id', Auth::id())->orWhere('sender_id', Auth::id())->get();

        // i need to loop through the messages to sift out users that i need to display at the right hand side

        $loggedInUserId = Auth::id();

        $allUsersIdArray = array();
        $allProjectsUsersIdArray = array();

        // $app = app();
        // $projectUsersObject = $app->make('stdClass');

        $allProjectsIdArray = array();

        foreach($messages as $message) {
            if(!in_array($message->recipient_id, $allUsersIdArray) && $message->recipient_id != $loggedInUserId) {
                array_push($allUsersIdArray, $message->recipient_id);
            } 
            if(!in_array($message->sender_id, $allUsersIdArray) && $message->sender_id != $loggedInUserId) {
                array_push($allUsersIdArray, $message->sender_id);
            } 
            if($message->project_id && $message->recipient_id != $loggedInUserId) {
                if(!in_array($message->project_id, $allProjectsIdArray) && !in_array($message->recipient_id, $allProjectsUsersIdArray)) {
                    array_push($allProjectsUsersIdArray, $message->recipient_id);
                    array_push($allProjectsIdArray, $message->project_id);
                }
            } 
            if($message->project_id && $message->sender_id != $loggedInUserId) {
                if(!in_array($message->project_id, $allProjectsIdArray) && !in_array($message->sender_id, $allProjectsUsersIdArray)) {
                    array_push($allProjectsUsersIdArray, $message->sender_id);
                    array_push($allProjectsIdArray, $message->project_id);
                }
            } 
        }

        $allNewArray = array();

        foreach($allProjectsUsersIdArray as $key=>$projectUserId) {
            $app = app();
            $obj = $app->make('stdClass');
            $obj->user = User::find($projectUserId);
            $obj->project = Project::find($allProjectsIdArray[$key]);
            array_push($allNewArray, $obj);
        }

        $users = User::find($allUsersIdArray);
        $projectUsers = User::find($allProjectsUsersIdArray);

        $clickedUserId = $routeParameters['userId'];

        $messages = Message::where('project_id', '=', 0)
                ->where(function ($query) {
                    $query->where('recipient_id', '=', Route::getCurrentRoute()->parameters()['userId'])
                          ->where('sender_id', '=', Auth::id())
                          ->where('project_id', '=', 0);
                })
                ->orWhere(function ($query) {
                    $query->where('recipient_id', '=', Auth::id())
                          ->where('sender_id', '=', Route::getCurrentRoute()->parameters()['userId'])
                          ->where('project_id', '=', 0);
                })
                ->get();

        $messages = $messages->sortBy('created_at');

        $subscribeString;

        if($loggedInUserId < $clickedUserId) {
            $subscribeString = $loggedInUserId . "_" . $clickedUserId;
        } else {
            $subscribeString = $clickedUserId . "_" . $loggedInUserId;   
        }

        foreach($messages as $message) {
            $message->read = true;

            $message->save();
        }

        // dd($allNewArray);



        return view('messages.index', [
            
            'users' => $users,
            'userProjectObjectArray' => $allNewArray,
            'messages' => $messages,
            'messageChannel' => 'messages_'.$subscribeString,
            'clickedUserId' => $clickedUserId,
            'clickedUser' => User::select('name')->where('id', $clickedUserId)->first(),
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    }

    public function showIndividualProjectChannel() {
        $routeParameters = Route::getCurrentRoute()->parameters();

        $messages = Message::where('recipient_id', Auth::id())->orWhere('sender_id', Auth::id())->get();

        // i need to loop through the messages to sift out users that i need to display at the right hand side

        $loggedInUserId = Auth::id();

        $allUsersIdArray = array();
        $allProjectsUsersIdArray = array();

        // $app = app();
        // $projectUsersObject = $app->make('stdClass');

        $allProjectsIdArray = array();

        foreach($messages as $message) {
            if(!in_array($message->recipient_id, $allUsersIdArray) && $message->recipient_id != $loggedInUserId) {
                array_push($allUsersIdArray, $message->recipient_id);
            } 
            if(!in_array($message->sender_id, $allUsersIdArray) && $message->sender_id != $loggedInUserId) {
                array_push($allUsersIdArray, $message->sender_id);
            } 
            if($message->project_id && $message->recipient_id != $loggedInUserId) {
                if(!in_array($message->project_id, $allProjectsIdArray) && !in_array($message->recipient_id, $allProjectsUsersIdArray)) {
                    array_push($allProjectsUsersIdArray, $message->recipient_id);
                    array_push($allProjectsIdArray, $message->project_id);
                }
            } 
            if($message->project_id && $message->sender_id != $loggedInUserId) {
                if(!in_array($message->project_id, $allProjectsIdArray) && !in_array($message->sender_id, $allProjectsUsersIdArray)) {
                    array_push($allProjectsUsersIdArray, $message->sender_id);
                    array_push($allProjectsIdArray, $message->project_id);
                }
            } 
        }

        $allNewArray = array();

        foreach($allProjectsUsersIdArray as $key=>$projectUserId) {
            $app = app();
            $obj = $app->make('stdClass');
            $obj->user = User::find($projectUserId);
            $obj->project = Project::find($allProjectsIdArray[$key]);
            array_push($allNewArray, $obj);
        }

        $users = User::find($allUsersIdArray);
        $projectUsers = User::find($allProjectsUsersIdArray);

        $clickedUserId = $routeParameters['userId'];
        $clickedProjectId = $routeParameters['projectId'];

        $messages = Message::where('project_id', '=', $clickedProjectId)
                ->where(function ($query) {
                    $query->where('recipient_id', '=', Route::getCurrentRoute()->parameters()['userId'])
                          ->where('sender_id', '=', Auth::id())
                          ->where('project_id', '=', Route::getCurrentRoute()->parameters()['projectId']);
                })
                ->orWhere(function ($query) {
                    $query->where('recipient_id', '=', Auth::id())
                          ->where('sender_id', '=', Route::getCurrentRoute()->parameters()['userId'])
                          ->where('project_id', '=', Route::getCurrentRoute()->parameters()['projectId']);
                })
                ->get();

        $messages = $messages->sortBy('created_at');

        $subscribeString;

        if($loggedInUserId < $clickedUserId) {
            $subscribeString = $loggedInUserId . "_" . $clickedUserId;
        } else {
            $subscribeString = $clickedUserId . "_" . $loggedInUserId;   
        }

        foreach($messages as $message) {
            $message->read = true;

            $message->save();
        }

        return view('messages.index', [
            
            'users' => $users,
            'userProjectObjectArray' => $allNewArray,
            'messages' => $messages,
            'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$clickedProjectId,
            'clickedUserId' => $clickedUserId,
            'clickedProject' => Project::find($clickedProjectId),
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    }

    public function sendMessage(Request $request) {
        $messageToSave = new Message;
        $messageToSave->message = $request->input('message_text');
        $messageToSave->sender_id = Auth::id();
        $messageToSave->recipient_id = $request->input('clickedUserId');

        $messageToSave->user_id = Auth::id();

        $messageToSave->project_id = 0;

        if($request->input('projectId')) {
            $messageToSave->project_id = $request->input('projectId');
        }

        $messageToSave->save();

        $url;

        if($messageToSave->project_id == 0) {
            $url = '/messages/' . Auth::id();
        } else {
            $url = '/messages/' . Auth::id() . '/projects/' . $messageToSave->project_id;
        }

        $message = [
            'text' => e($request->input('message_text')),
            'username' => Auth::user()->name,
            'avatar' => Auth::user()->avatar,
            'timestamp' => (time()*1000),
            'projectId' => $messageToSave->projectId,
            'url' => $url
        ];

        $this->pusher->trigger($request->input('messageChannel'), 'new-message', $message);

        $otherChannel;

        $channelString = explode("_", $request->input('messageChannel'));

        if(Auth::id() == $channelString[1]) {
            $otherChannel = 'messages_' . $channelString[2];
        } else {
            $otherChannel = 'messages_' . $channelString[1];
        }

        $this->pusher->trigger($otherChannel, 'new-message', $message);
    }

    public function testMessage(Request $request) {
        App::make('pusher')->trigger('channel', 'new-message', 'test');
    }
}
