<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

use App\Project;
use App\Review;
use App\AttemptedProject;
use App\AnsweredTask;
use App\AnsweredTaskFile;
use App\Credit;
use App\Task;
use App\Answer;
use App\ProjectFile;
use App\Role;
use App\RoleGained;
use App\Competency;
use App\CompetencyScore;
use App\Message;
use App\User;
use App\Notification;
use App\ShoppingCart;
use App\ReviewedAnsweredTaskFile;

use App\Mail\SendProfileReviewedMail;
use Illuminate\Support\Facades\Mail;

use Validator;

use Illuminate\Support\Facades\Storage;

class ReviewsController extends Controller
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
    }

    public function leaveReview() {
        $routeParameters = Route::getCurrentRoute()->parameters();

        $role = Role::select('id', 'title', 'slug', 'description')->where('slug', $routeParameters['roleSlug'])->get()[0];
        $project = Project::select('id', 'title', 'slug', 'user_id', 'description')->where('slug', $routeParameters['projectSlug'])->get()[0];

        if(array_key_exists('userId', $routeParameters)) {
            return view('reviews.create', [
                
                'project' => $project,
                'role' => $role,
                'attemptedProject' => AttemptedProject::where('project_id', $project->id)->where('user_id', $routeParameters['userId'])->get()[0],
                'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
            ]);
        } else {
            return view('reviews.create', [
                
                'project' => $project,
                'role' => $role,
                'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
            ]);
        }
    }

    public function submitReview(Request $request) {
        $routeParameters = Route::getCurrentRoute()->parameters();

        $role = Role::select('id', 'title', 'slug', 'description')->where('slug', $routeParameters['roleSlug'])->get()[0];
        $project = Project::select('id', 'title', 'slug', 'user_id')->where('slug', $routeParameters['projectSlug'])->get()[0];

        $validator = Validator::make($request->all(), [
            'rating' => 'required',
            'review' => 'required',
        ]);

        if($validator->fails()) {
            if(array_key_exists('userId', $routeParameters)) {
                return redirect('/roles/'.$routeParameters['roleSlug'].'/projects/'.$routeParameters['projectSlug'].'/'.$routeParameters['userId'].'/review')
                    ->withErrors($validator)
                    ->withInput();
            } else {
                return redirect('/roles/'.$routeParameters['roleSlug'].'/projects/'.$routeParameters['projectSlug'].'/review')
                    ->withErrors($validator)
                    ->withInput();
            }
        } else {
            // create a new review

            $review = new Review;

            $review->rating = $request->input('rating');
            $review->description = $request->input('review');

            if(array_key_exists('userId', $routeParameters)) {
                $review->sender_id = Auth::id();
                $review->receiver_id = $routeParameters['userId'];
            } else {
                $review->sender_id = Auth::id();
                $review->receiver_id = $project->user_id;
            }

            $review->project_id = $project->id;

            $attemptedProject = AttemptedProject::where('user_id', $routeParameters['userId'])->where('project_id', $project->id)->first();

            $review->attempted_project_id = $attemptedProject->id;

            $review->save();

            $notification = new Notification;

            $notification->message = "has left an overall review on your profile";
            $notification->recipient_id = $review->receiver_id;
            $notification->user_id = $review->sender_id;
            $notification->url = "/profile/reviews";

            $notification->save();

            $userToEmail = User::find($review->receiver_id);

            Mail::to($userToEmail->email)->send(new SendProfileReviewedMail(Auth::user()->name, $userToEmail->name, 'https://talentail.com/profile/reviews'));

            if(array_key_exists('userId', $routeParameters)) {
                $attemptedProject = AttemptedProject::where('user_id', $routeParameters['userId'])->where('project_id', $project->id)->first();

                $attemptedProject->status = "Reviewed";

                $attemptedProject->save();

                return redirect('/roles/'.$routeParameters['roleSlug'].'/projects/'.$routeParameters['projectSlug'].'/'.$routeParameters['userId']);
            } else {
                return redirect('/roles/'.$routeParameters['roleSlug'].'/projects/'.$routeParameters['projectSlug']);
            }
        }
    }
}
