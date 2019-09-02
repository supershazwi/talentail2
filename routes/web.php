<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendContactMail;
use Illuminate\Validation\Rule;

use App\Experience;
use App\User;
use App\AnswerFile;
use App\OpportunitySubmission;
use App\AppliedOpportunity;
use App\Credit;
use App\Exercise;
use App\ExerciseGrouping;
use App\Community;
use App\Feedback;
use App\FeedbackFile;
use App\ResponseFile;
use App\Opportunity;
use App\Vote;
use App\CommunityPost;
use App\CommunityPostFile;
use App\CommunityPostComment;
use App\CommunityPostCommentFile;
use App\Category;
use App\Company;
use App\Notification;
use App\AnsweredExercise;
use App\PendingNotification;
use App\Role;
use App\Task;
use App\Project;
use App\Endorser;
use App\Industry;
use App\AnsweredExerciseFile;
use App\ExerciseFile;
use App\Invoice;
use App\Review;
use App\RoleGained;
use App\ShoppingCart;
use App\Portfolio;
use App\ShoppingCartLineItem;
use App\Message;
use App\ContactMessage;
use App\Post;
use App\Referral;
use App\CreatorApplication;
use App\CompanyApplication;
use App\CreatorApplicationFile;
use App\AttemptedProject;
use App\Mail\SendResetPasswordLink;

use Pusher\Laravel\Facades\Pusher;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Passwords\PasswordBroker;

use App\Mail\SendEndorsersMail;
use App\Mail\UserRegistered;
use App\Mail\SendAttemptedProjectReviewedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;

Route::get('/score', function(Request $request) {


    return view('score', [
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]); 
})->middleware('auth');

Route::post('/password/send-email', function(Request $request) {
    // find email

    $emailArray['email'] = $request->input('email');

    $token = Password::broker()->customToken($emailArray);

    $user = User::where('email', $request->input('email'))->first();

    if(!$user) {
        return redirect('/password/reset')->with('error', 'User not found.');
    }

    $url = url(config('app.url').route('password.reset', $token, false));

    dd(config('app.url'));

    Mail::to($request->input('email'))->send(new SendResetPasswordLink($user, $url));

    return redirect('password/reset')->with('sent', 'We have e-mailed your password reset link!');

    //https://talentail.com/password/reset/a464542384b9c1d164f2dc60471851abd01e1eb3776a6e0a0061b58ca5d524f0
});

Route::get('/for-companies', function() {

    return view('forCompanies', [
        'parameter' => 'forCompanies',   
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});


Route::get('/opportunities/post-an-opportunity', function() {

    return view('postOpportunity', [
        'parameter' => 'opportunity',   
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('/opportunities/{roleSlug}/{opportunitySlug}', function() {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $opportunity = Opportunity::where('slug', $routeParameters['opportunitySlug'])->first();

    $statusArray = array();

    // this has to have all competent
    $loopExerciseGroupingArray = array();

    foreach($opportunity->exercise_groupings as $exerciseGrouping) {
        foreach($exerciseGrouping->exercises as $exercise) {
            $answeredExercise = AnsweredExercise::select('status')->where('exercise_id', $exercise->id)->where('user_id', Auth::id())->first();

            if($answeredExercise) {
                $statusArray[$exercise->id] = $answeredExercise->status;
            } else {
                $statusArray[$exercise->id] = "Not Attempted";
            }
        }

        if(in_array("Competent", $statusArray)) {
            array_push($loopExerciseGroupingArray, "Competent");
        }
    }

    $applicable = in_array("Competent",$loopExerciseGroupingArray);

    return view('opportunities.show', [
        'statusArray' => $statusArray,
        'parameter' => 'opportunity',
        'opportunity' => $opportunity,
        'applicable' => $applicable,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('enterprise', function() {
    return view('enterprise.index', [
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::post('/exercise-groupings/save-exercise-grouping', function(Request $request) {
    $exerciseGrouping = new ExerciseGrouping;

    $exerciseGrouping->task_id = $request->input('task');
    $exerciseGrouping->opportunity_id = $request->input('opportunity');

    $opportunity = Opportunity::find($request->input('opportunity'));

    $exerciseGrouping->slug = str_slug($opportunity->company->slug, '-') . "-" . str_slug($opportunity->slug, '-') . "-" . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 10);
    $exerciseGrouping->title = $exerciseGrouping->slug;

    $exerciseGrouping->save();

    $exerciseGrouping->exercises()->attach($request->input('exercises'));

    return redirect('/dashboard');

})->middleware('auth');

Route::get('/exercise-groupings/create', function() {
    if(Auth::user()->admin) {
        $opportunities = Opportunity::all();
        $tasks = Task::all();

        return view('exerciseGroupings.create', [
            'opportunities' => $opportunities,
            'tasks' => $tasks,
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]); 
    } else {
        return redirect('/dashboard');
    }
})->middleware('auth');

Route::post('/companies/{companySlug}/save-company', function() {
    if(Auth::user() && Auth::user()->admin) {
        $routeParameters = Route::getCurrentRoute()->parameters();

        $company = Company::where('slug', $routeParameters['companySlug'])->first();

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

        return redirect('/companies/'.$company->slug);
    }
})->middleware('auth');

Route::post('/community-post-comment/{communityPostCommentId}/downvote', function(Request $request) {
    $returnArray = array();

    $routeParameters = Route::getCurrentRoute()->parameters();

    $communityPostComment = CommunityPostComment::find($request->input('communityPostCommentId'));

    // i need to attach the upvote or neutral here
    // check whether exists first
    // if exist, change to neutral and delete row
    $vote = Vote::where('user_id', $request->input('userId'))->where('community_post_comment_id', $request->input('communityPostCommentId'))->first();

    if($vote) {
        // that means it exists
        // check whether its neutral, upvoted or downvoted

        if($vote->upvote || $vote->neutral) {
            if($vote->neutral) {
                $communityPostComment->score = $communityPostComment->score - 1;
                array_push($returnArray, "downvote");

                $user = User::find($communityPostComment->user_id);
                $user->score = $user->score - 1;
                $user->save();
            }

            if($vote->upvote) {
                $communityPostComment->score = $communityPostComment->score - 2;
                array_push($returnArray, "downvote");

                $user = User::find($communityPostComment->user_id);
                $user->score = $user->score - 2;
                $user->save();
            }

            $communityPostComment->save();

            $vote->downvote = 1;
            $vote->upvote = 0;
            $vote->neutral = 0;

            $vote->save();
        } else {
            $communityPostComment->score = $communityPostComment->score + 1;

            $communityPostComment->save();

            $vote->neutral = 1;
            $vote->downvote = 0;
            $vote->upvote = 0;

            $vote->save();

            $user = User::find($communityPostComment->user_id);
            $user->score = $user->score + 1;
            $user->save();

            array_push($returnArray, "neutral");
        }
    } else {
        $vote = new Vote;

        $vote->community_post_comment_id = $request->input('communityPostCommentId');
        $vote->user_id = $request->input('userId');
        $vote->downvote = 1;

        $vote->save();

        $communityPostComment->score = $communityPostComment->score - 1;

        $communityPostComment->save();

        $user = User::find($communityPostComment->user_id);
        $user->score = $user->score - 1;
        $user->save();

        array_push($returnArray, "downvote");
    }

    array_push($returnArray, $communityPostComment->score);

    return $returnArray;

})->middleware('auth');

Route::post('/community-post-comment/{communityPostCommentId}/upvote', function(Request $request) {
    $returnArray = array();

    $routeParameters = Route::getCurrentRoute()->parameters();

    // i need to attach the upvote or neutral here
    // check whether exists first
    // if exist, change to neutral and delete row
    $vote = Vote::where('user_id', $request->input('userId'))->where('community_post_comment_id', $request->input('communityPostCommentId'))->first();

    if($vote) {
        // that means it exists
        // check whether its neutral, upvoted or downvoted

        if($vote->downvote || $vote->neutral) {
            $communityPostComment = CommunityPostComment::find($request->input('communityPostCommentId'));

            if($vote->neutral) {
                $communityPostComment->score = $communityPostComment->score + 1;
                array_push($returnArray, "upvote");

                $user = User::find($communityPostComment->user_id);
                $user->score = $user->score + 1;
                $user->save();
            }

            if($vote->downvote) {
                $communityPostComment->score = $communityPostComment->score + 2;
                array_push($returnArray, "upvote");

                $user = User::find($communityPostComment->user_id);
                $user->score = $user->score + 2;
                $user->save();
            }

            $communityPostComment->save();

            $vote->upvote = 1;
            $vote->downvote = 0;
            $vote->neutral = 0;

            $vote->save();
        } else {
            $communityPostComment = CommunityPostComment::find($request->input('communityPostCommentId'));

            $communityPostComment->score = $communityPostComment->score - 1;

            $communityPostComment->save();

            $vote->neutral = 1;
            $vote->downvote = 0;
            $vote->upvote = 0;

            $vote->save();

            $user = User::find($communityPostComment->user_id);
            $user->score = $user->score - 1;
            $user->save();

            array_push($returnArray, "neutral");
        }
    } else {
        $vote = new Vote;

        $vote->community_post_comment_id = $request->input('communityPostCommentId');
        $vote->user_id = $request->input('userId');
        $vote->upvote = 1;

        $vote->save();

        $communityPostComment = CommunityPostComment::find($request->input('communityPostCommentId'));

        $communityPostComment->score = $communityPostComment->score + 1;

        $communityPostComment->save();

        $user = User::find($communityPostComment->user_id);
        $user->score = $user->score - 1;
        $user->save();

        array_push($returnArray, "upvote");
    }

    array_push($returnArray, $communityPostComment->score);

    return $returnArray;

})->middleware('auth');

Route::post('/community-post/{communityPostId}/upvote', function(Request $request) {
    $returnArray = array();

    $routeParameters = Route::getCurrentRoute()->parameters();

    // i need to attach the upvote or neutral here
    // check whether exists first
    // if exist, change to neutral and delete row
    $vote = Vote::where('user_id', $request->input('userId'))->where('community_post_id', $request->input('communityPostId'))->first();

    if($vote) {
        // that means it exists
        // check whether its neutral, upvoted or downvoted

        if($vote->downvote || $vote->neutral) {
            $communityPost = CommunityPost::find($request->input('communityPostId'));

            if($vote->neutral) {
                $communityPost->score = $communityPost->score + 1;
                array_push($returnArray, "upvote");

                $user = User::find($communityPost->user_id);
                $user->score = $user->score + 1;
                $user->save();
            }

            if($vote->downvote) {
                $communityPost->score = $communityPost->score + 2;
                array_push($returnArray, "upvote");

                $user = User::find($communityPost->user_id);
                $user->score = $user->score + 2;
                $user->save();
            }

            $communityPost->save();

            $vote->upvote = 1;
            $vote->downvote = 0;
            $vote->neutral = 0;

            $vote->save();
        } else {
            $communityPost = CommunityPost::find($request->input('communityPostId'));

            $communityPost->score = $communityPost->score - 1;

            $communityPost->save();

            $vote->neutral = 1;
            $vote->downvote = 0;
            $vote->upvote = 0;

            $vote->save();

            $user = User::find($communityPost->user_id);
            $user->score = $user->score - 1;
            $user->save();

            array_push($returnArray, "neutral");
        }
    } else {
        $vote = new Vote;

        $vote->community_post_id = $request->input('communityPostId');
        $vote->user_id = $request->input('userId');
        $vote->upvote = 1;

        $vote->save();

        $communityPost = CommunityPost::find($request->input('communityPostId'));

        $communityPost->score = $communityPost->score + 1;

        $communityPost->save();

        $user = User::find($communityPost->user_id);
        $user->score = $user->score + 1;
        $user->save();

        array_push($returnArray, "upvote");
    }

    array_push($returnArray, $communityPost->score);

    return $returnArray;

})->middleware('auth');

Route::post('/community-post/{communityPostId}/downvote', function(Request $request) {
    $returnArray = array();

    $routeParameters = Route::getCurrentRoute()->parameters();

        // i need to attach the upvote or neutral here
        // check whether exists first
        // if exist, change to neutral and delete row
        $vote = Vote::where('user_id', $request->input('userId'))->where('community_post_id', $request->input('communityPostId'))->first();

        if($vote) {
            // that means it exists
            // check whether its neutral, upvoted or downvoted

            if($vote->upvote || $vote->neutral) {
                $communityPost = CommunityPost::find($request->input('communityPostId'));

                if($vote->neutral) {
                    $communityPost->score = $communityPost->score - 1;

                    array_push($returnArray, "downvote");

                    $user = User::find($communityPost->user_id);
                    $user->score = $user->score - 1;
                    $user->save();
                }

                if($vote->upvote) {
                    $communityPost->score = $communityPost->score - 2;

                    array_push($returnArray, "downvote");

                    $user = User::find($communityPost->user_id);
                    $user->score = $user->score - 2;
                    $user->save();
                }

                $communityPost->save();

                $vote->upvote = 0;
                $vote->downvote = 1;
                $vote->neutral = 0;

                $vote->save();
            } else {
                $communityPost = CommunityPost::find($request->input('communityPostId'));

                $communityPost->score = $communityPost->score + 1;

                $communityPost->save();

                $vote->neutral = 1;
                $vote->downvote = 0;
                $vote->upvote = 0;

                $vote->save();

                $user = User::find($communityPost->user_id);
                $user->score = $user->score + 1;
                $user->save();

                array_push($returnArray, "neutral");
            }
        } else {
            $vote = new Vote;

            $vote->community_post_id = $request->input('communityPostId');
            $vote->user_id = $request->input('userId');
            $vote->downvote = 1;

            $vote->save();

            $communityPost = CommunityPost::find($request->input('communityPostId'));

            $communityPost->score = $communityPost->score - 1;

            $communityPost->save();

            $user = User::find($communityPost->user_id);
            $user->score = $user->score - 1;
            $user->save();

            array_push($returnArray, "downvote");
        }

        array_push($returnArray, $communityPost->score);

        return $returnArray;

})->middleware('auth');

Route::post('/communities/{communitySlug}/subscribe', function(Request $request) {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $community = Community::where('slug', $routeParameters['communitySlug'])->first();

    $community->users()->attach(Auth::id());

    return redirect('/communities/' . $routeParameters['communitySlug']);

})->middleware('auth');

Route::get('/communities/{communitySlug}/posts/{communityPostId}', function() {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $communityPost = CommunityPost::find($routeParameters['communityPostId']);

    if(Auth::user()) 
        $subscribed = Auth::user()->communities()->where('user_id', Auth::id())->exists();
    else
        $subscribed = false;

    $community = Community::where('slug', $routeParameters['communitySlug'])->first();

    $communityTopPostVote = null;

    $voteArray = array();

    if(Auth::id()) {
        $vote = Vote::where('user_id', Auth::id())->where('community_post_id', $routeParameters['communityPostId'])->first();
        if($vote != null) {
            if($vote->upvote) {
                $communityTopPostVote = "u";
            } else if($vote->downvote) {
                $communityTopPostVote = "d";
            } else {
                $communityTopPostVote = "n";
            }
        }

        $votes = Vote::where('user_id', Auth::id())->where('community_post_id', 0)->get();
        foreach($votes as $vote) {
            if($vote->upvote) {
                $voteArray[$vote->community_post_comment_id] = "u";
            } else if($vote->downvote) {
                $voteArray[$vote->community_post_comment_id] = "d";
            } else {
                $voteArray[$vote->community_post_comment_id] = "n";
            }
        }
    } 

    $communityPostCommentsArray = array();

    foreach($communityPost->community_post_comments as $communityPostComment) {
        array_push($communityPostCommentsArray, $communityPostComment->id);
        foreach($communityPostComment->nested_comments as $nestedComment) {
            array_push($communityPostCommentsArray, $nestedComment->id);
        }
    }

    return view('communities.showPost', [
        'communityPostCommentsArray' => implode(",", $communityPostCommentsArray),
        'communityPost' => $communityPost,
        'communityTopPostVote' => $communityTopPostVote,
        'community' => $community,
        'parameter' => 'community',
        'voteArray' => $voteArray,
        'subscribed' => $subscribed,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]); 
});

Route::post('/community-post/{communityPostId}/create-comment', function(Request $request) {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $communityPost = CommunityPost::find($routeParameters['communityPostId']);

    $communityPostComment = new CommunityPostComment;

    $communityPostComment->content = $request->input('content');
    $communityPostComment->score = 1;
    $communityPostComment->user_id = Auth::id();
    $communityPostComment->community_post_id = $routeParameters['communityPostId'];

    $communityPostComment->save();    

    if($request->file('topFile')) {
        for($fileCounter = 0; $fileCounter < count($request->file('topFile')); $fileCounter++) {

            $communityPostCommentFile = new CommunityPostCommentFile;

            $communityPostCommentFile->title = $request->file('topFile')[$fileCounter]->getClientOriginalName();
            $communityPostCommentFile->size = $request->file('topFile')[$fileCounter]->getSize();
            $communityPostCommentFile->url = Storage::disk('gcs')->put('/assets', $request->file('topFile')[$fileCounter], 'public');
            $communityPostCommentFile->mime_type = $request->file('topFile')[$fileCounter]->getMimeType();
            $communityPostCommentFile->community_post_comment_id = $communityPostComment->id;
            $communityPostCommentFile->user_id = Auth::id();

            $communityPostCommentFile->save();
        }
    }

    if(Auth::id() != $communityPost->user_id) {

        $notification = new Notification;

        $notification->message = "has left a comment on your post: "  . $communityPost->title;
        $notification->recipient_id = $communityPost->user_id;
        $notification->user_id = Auth::id();
        $notification->url = "/communities/".$communityPost->community->slug."/posts/".$routeParameters['communityPostId'];

        $notification->save();
    }

    return redirect('/communities/'.$request->input('communitySlug').'/posts/'.$request->input('communityPostId'));
});

Route::post('/community-post-comment/{communityPostCommentId}/create-comment', function(Request $request) {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $originalCommunityPostComment = CommunityPostComment::find($routeParameters['communityPostCommentId']);

    $communityPostComment = new CommunityPostComment;

    $communityPostComment->content = $request->input('content');
    $communityPostComment->score = 1;
    $communityPostComment->user_id = Auth::id();
    $communityPostComment->community_post_comment_id = $routeParameters['communityPostCommentId'];

    $communityPostComment->save();    

    if($request->file('file_'.$request->input('nestedCommentId'))) {
        for($fileCounter = 0; $fileCounter < count($request->file('file_'.$request->input('nestedCommentId'))); $fileCounter++) {

            $communityPostCommentFile = new CommunityPostCommentFile;

            $communityPostCommentFile->title = $request->file('file_'.$request->input('nestedCommentId'))[$fileCounter]->getClientOriginalName();
            $communityPostCommentFile->size = $request->file('file_'.$request->input('nestedCommentId'))[$fileCounter]->getSize();
            $communityPostCommentFile->url = Storage::disk('gcs')->put('/assets', $request->file('file_'.$request->input('nestedCommentId'))[$fileCounter], 'public');
            $communityPostCommentFile->mime_type = $request->file('file_'.$request->input('nestedCommentId'))[$fileCounter]->getMimeType();
            $communityPostCommentFile->community_post_comment_id = $communityPostComment->id;
            $communityPostCommentFile->user_id = Auth::id();

            $communityPostCommentFile->save();
        }
    }

    if($request->file('file_'.$routeParameters['communityPostCommentId'])) {
        for($fileCounter = 0; $fileCounter < count($request->file('file_'.$routeParameters['communityPostCommentId'])); $fileCounter++) {

            $communityPostCommentFile = new CommunityPostCommentFile;

            $communityPostCommentFile->title = $request->file('file_'.$routeParameters['communityPostCommentId'])[$fileCounter]->getClientOriginalName();
            $communityPostCommentFile->size = $request->file('file_'.$routeParameters['communityPostCommentId'])[$fileCounter]->getSize();
            $communityPostCommentFile->url = Storage::disk('gcs')->put('/assets', $request->file('file_'.$routeParameters['communityPostCommentId'])[$fileCounter], 'public');
            $communityPostCommentFile->mime_type = $request->file('file_'.$routeParameters['communityPostCommentId'])[$fileCounter]->getMimeType();
            $communityPostCommentFile->community_post_comment_id = $communityPostComment->id;
            $communityPostCommentFile->user_id = Auth::id();

            $communityPostCommentFile->save();
        }
    }

    if(Auth::id() != $originalCommunityPostComment->user_id) {

        $notification = new Notification;

        $notification->message = "has left a comment on your post: " . $originalCommunityPostComment->content;
        $notification->recipient_id = $originalCommunityPostComment->user_id;
        $notification->user_id = Auth::id();
        $notification->url = '/communities/'.$request->input('communitySlug').'/posts/'.$request->input('communityPostId');

        $notification->save();
    }

    return redirect('/communities/'.$request->input('communitySlug').'/posts/'.$request->input('communityPostId'));
});

Route::post('/communities/{communitySlug}/create-post', function(Request $request) {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $community = Community::where('slug', $routeParameters['communitySlug'])->first();

    $communityPost = new CommunityPost;

    $communityPost->title = $request->input('title');
    $communityPost->description = $request->input('description');
    $communityPost->score = 1;
    $communityPost->user_id = Auth::id();
    $communityPost->community_id = $community->id;

    $communityPost->save();

    if($request->file('file')) {
        for($fileCounter = 0; $fileCounter < count($request->file('file')); $fileCounter++) {

            $communityPostFile = new CommunityPostFile;

            $communityPostFile->title = $request->file('file')[$fileCounter]->getClientOriginalName();
            $communityPostFile->size = $request->file('file')[$fileCounter]->getSize();
            $communityPostFile->url = Storage::disk('gcs')->put('/assets', $request->file('file')[$fileCounter], 'public');
            $communityPostFile->mime_type = $request->file('file')[$fileCounter]->getMimeType();
            $communityPostFile->community_post_id = $communityPost->id;
            $communityPostFile->user_id = Auth::id();

            $communityPostFile->save();
        }
    }

    $user = User::find(Auth::id());

    $user->score = $user->score + 1;

    $user->save();

    return redirect('/communities/'.$routeParameters['communitySlug'].'/posts/'.$communityPost->id);
});


Route::get('/communities/{communitySlug}/create-post', function() {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $community = Community::where('slug', $routeParameters['communitySlug'])->first();

    if(Auth::user()) 
        $subscribed = Auth::user()->communities()->where('user_id', Auth::id())->exists();
    else
        $subscribed = false;

    return view('communities.createPost', [
        'community' => $community,
        'subscribed' => $subscribed,
        'parameter' => 'community',
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]); 
})->middleware('auth');

Route::post('/delete-community-post/{communityPostId}', function(Request $request) {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $communityPostComments = CommunityPostComment::where('community_post_id', $request->input('community-post-id'))->get();

    foreach($communityPostComments as $communityPostComment) {
        CommunityPostCommentFile::where('community_post_comment_id', $communityPostComment->id)->delete();

        CommunityPostComment::destroy($communityPostComment->id);
    }

    CommunityPostFile::where('community_post_id', $request->input('community-post-id'))->delete();

    CommunityPost::destroy($request->input('community-post-id'));

    return redirect('/communities/'.$request->input('community-slug'));

})->middleware('auth');

Route::post('/delete-community-post-comment/{communityPostCommentId}', function(Request $request) {
    $routeParameters = Route::getCurrentRoute()->parameters();

    // check for files

    CommunityPostCommentFile::where('community_post_comment_id', $request->input('community-post-comment-id'))->delete();

    CommunityPostComment::destroy($request->input('community-post-comment-id'));

    return redirect('/communities/'.$request->input('community-slug').'/posts/'.$request->input('community-post-id'));

})->middleware('auth');

Route::get('/communities/{communitySlug}', function() {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $community = Community::where('slug', $routeParameters['communitySlug'])->first();

    $communityPosts = CommunityPost::where('community_id', $community->id)->orderBy('created_at', 'desc')->paginate(10);

    if(Auth::user()) 
        $subscribed = Auth::user()->communities()->where('user_id', Auth::id())->exists();
    else
        $subscribed = false;

    $voteArray = array();

    if(Auth::id()) {
        $votes = Vote::where('user_id', Auth::id())->where('community_post_comment_id', 0)->get();
        foreach($votes as $vote) {
            if($vote->upvote) {
                $voteArray[$vote->community_post_id] = "u";
            } else if($vote->downvote) {
                $voteArray[$vote->community_post_id] = "d";
            } else {
                $voteArray[$vote->community_post_id] = "n";
            }
        }
    } 

    return view('communities.show', [
        'community' => $community,
        'voteArray' => $voteArray,
        'parameter' => 'community',
        'communityPosts' => $communityPosts,
        'subscribed' => $subscribed,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]); 
});

Route::get('/checkout/{shoppingCartId}', 'PayPalController@getExpressCheckout');
Route::get('/checkout/{shoppingCartId}/success', 'PayPalController@getExpressCheckoutSuccess');

Route::post('/connect-paypal', function(Request $request) {
    $user = User::find(Auth::id());

    $user->paypal_email = $request->input('paypal_email');

    $user->creator = true;

    $user->save();

    $creatorApplication = CreatorApplication::where('user_id', Auth::id())->first();

    $creatorApplication->status = "connected";

    $creatorApplication->save();

    return redirect('/creator-stripe-account')->with('paypal-success', "You have successfully connected " . $request->input('paypal_email') . " with PayPal.");
});

Route::get('/communities', function() {
    return view('communities.index', [
        'roles' => Role::all(),
        'parameter' => 'community',
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('/tasks', function() {
    return view('tasks.index', [
        'roles' => Role::all(),
        'parameter' => 'task',
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('/roles/business-analyst', function() {
    $role = Role::find(1);
    $tasks = Task::orderBy('order', 'desc')->where('role_id', 1)->get();

    return view('roles.show', [
        'role' => $role,
        'tasks' => $tasks,
        'parameter' => 'task',
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('/payment-information', function() {
    return view('payment-information', [
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]); 
});

Route::post('/exercises/{exerciseSlug}/submit-feedback', function(Request $request) {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $exercise = Exercise::where('slug', $routeParameters['exerciseSlug'])->first();

    $feedback = new Feedback;

    $feedback->content = $request->input('content');
    $feedback->user_id = Auth::id();

    $feedback->save();

    if($request->file('file')) {
        for($fileCounter = 0; $fileCounter < count($request->file('file')); $fileCounter++) {

            $feedbackFile = new FeedbackFile;

            $feedbackFile->title = $request->file('file')[$fileCounter]->getClientOriginalName();
            $feedbackFile->size = $request->file('file')[$fileCounter]->getSize();
            $feedbackFile->url = Storage::disk('gcs')->put('/assets', $request->file('file')[$fileCounter], 'public');
            $feedbackFile->mime_type = $request->file('file')[$fileCounter]->getMimeType();
            $feedbackFile->feedback_id = $feedback->id;
            $feedbackFile->user_id = Auth::id();

            $feedbackFile->save();
        }
    }

    return redirect('/exercises/'.$routeParameters['exerciseSlug'])->with('status', 'Your feedback has been submitted.');
});

Route::get('/exercises/{exerciseSlug}/feedback', function() {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $exercise = Exercise::where('slug', $routeParameters['exerciseSlug'])->first();

    return view('feedbacks.create', [
        'exercise' => $exercise,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::get('/exercises/{exerciseSlug}/edit', function() {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $exercise = Exercise::where('slug', $routeParameters['exerciseSlug'])->first();
    $tasks = Task::all();

    return view('exercises.edit', [
        'exercise' => $exercise,
        'tasks' => $tasks,
        'parameter' => 'task',
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::post('/exercises/{exerciseSlug}/recall-attempt', function(Request $request) {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $answeredExercise = AnsweredExercise::find($request->input('answeredExerciseId'));

    $answeredExercise->status = "Attempted";

    $answeredExercise->save();

    return redirect('/exercises/' . $routeParameters['exerciseSlug'])->with('status', 'You have recalled your submission.');;
});

Route::post('/exercises/{exerciseSlug}/{userId}/submit-review', function(Request $request) {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $answeredExercise = AnsweredExercise::find($request->input('answeredExerciseId'));

    $answeredExercise->response = $request->input('response');
    $answeredExercise->status = $request->input('status');
    $answeredExercise->visible = 1;

    $answeredExercise->save();

    if($request->file('file')) {
        for($fileCounter = 0; $fileCounter < count($request->file('file')); $fileCounter++) {

            $responseFile = new ResponseFile;

            $responseFile->title = $request->file('file')[$fileCounter]->getClientOriginalName();
            $responseFile->size = $request->file('file')[$fileCounter]->getSize();
            $responseFile->url = Storage::disk('gcs')->put('/assets', $request->file('file')[$fileCounter], 'public');
            $responseFile->mime_type = $request->file('file')[$fileCounter]->getMimeType();
            $responseFile->answered_exercise_id = $request->input('answeredExerciseId');
            $responseFile->user_id = Auth::id();

            $responseFile->save();
        }
    }

    return redirect('/exercises/'.$routeParameters['exerciseSlug'].'/'.$answeredExercise->user_id);
});

Route::post('/exercises/{exerciseSlug}/save-attempt', function(Request $request) {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $answeredExercise = AnsweredExercise::find($request->input('answeredExerciseId'));

    $answeredExercise->answer = $request->input('answer');

    $status;

    if($request->input('status') != null && $request->input('status') == "submitForReview") {
        $answeredExercise->status = "Submitted For Review";
        $status = "You have submitted your exercise for review.";
    } else {
        $answeredExercise->status = "Attempted";
        $status = "You have saved your exercise.";
    }

    $answeredExercise->save();

    if($request->file('file')) {
        for($fileCounter = 0; $fileCounter < count($request->file('file')); $fileCounter++) {

            $answeredExerciseFile = new AnsweredExerciseFile;

            $answeredExerciseFile->title = $request->file('file')[$fileCounter]->getClientOriginalName();
            $answeredExerciseFile->size = $request->file('file')[$fileCounter]->getSize();
            $answeredExerciseFile->url = Storage::disk('gcs')->put('/assets', $request->file('file')[$fileCounter], 'public');
            $answeredExerciseFile->mime_type = $request->file('file')[$fileCounter]->getMimeType();
            $answeredExerciseFile->answered_exercise_id = $request->input('answeredExerciseId');
            $answeredExerciseFile->user_id = Auth::id();

            $answeredExerciseFile->save();
        }
    }

    $removedFilesIdArray = $request->input('files-deleted_'.$request->input('answeredExerciseId'));

    if($removedFilesIdArray != null) {
        $removedFilesIdArray = explode(",",$removedFilesIdArray);
        foreach($removedFilesIdArray as $removedFileId) {
            AnsweredExerciseFile::destroy($removedFileId);
        }
    }

    return redirect('/exercises/' . $routeParameters['exerciseSlug'])->with('status', $status);
});

Route::post('/exercises/{exerciseSlug}/attempt-exercise', function(Request $request) {

    $routeParameters = Route::getCurrentRoute()->parameters();

    // check whether got portfolio

    $exercise = Exercise::find($request->input('exerciseId'));

    $answeredExercise = new AnsweredExercise;
    $answeredExercise->answer = "";
    $answeredExercise->response = "";
    $answeredExercise->user_id = Auth::id();
    $answeredExercise->exercise_id = $exercise->id;
    $answeredExercise->task_id = $exercise->task->id;
    $answeredExercise->status = "Attempted";

    $answeredExercise->save();

    $portfolio = Portfolio::where('user_id', Auth::id())->where('role_id', $exercise->role_id)->first();

    if(!$portfolio) {
        $portfolio = new Portfolio;

        $portfolio->user_id = Auth::id();
        $portfolio->role_id = $exercise->task->role_id;

        $portfolio->save();
    }

    return redirect('/exercises/' . $routeParameters['exerciseSlug']);
})->middleware('auth');

Route::post('/categories/{categorySlug}/tasks/{taskSlug}/save-task', function(Request $request) {

    $routeParameters = Route::getCurrentRoute()->parameters();

    if($request->file('file')) {
        for($fileCounter = 0; $fileCounter < count($request->file('file')); $fileCounter++) {

            $answeredTaskFile = new AnsweredTaskFile;

            $answeredTaskFile->title = $request->file('file')[$fileCounter]->getClientOriginalName();
            $answeredTaskFile->size = $request->file('file')[$fileCounter]->getSize();
            $answeredTaskFile->url = Storage::disk('gcs')->put('/assets', $request->file('file')[$fileCounter], 'public');
            $answeredTaskFile->mime_type = $request->file('file')[$fileCounter]->getMimeType();
            $answeredTaskFile->answered_task_id = $request->input('answeredTaskId');
            $answeredTaskFile->user_id = Auth::id();

            $answeredTaskFile->save();
        }
    }

    $removedFilesIdArray = $request->input('files-deleted_'.$request->input('answeredTaskId'));

    if($removedFilesIdArray != null) {
        $removedFilesIdArray = explode(",",$removedFilesIdArray);
        foreach($removedFilesIdArray as $removedFileId) {
            AnsweredTaskFile::destroy($removedFileId);
        }
    }

    return redirect('/categories/' . $routeParameters['categorySlug'] . '/tasks/' . $routeParameters['taskSlug']);
});

Route::get('/tasks/create', function() {
    $roles = Role::all();

    return view('tasks.create', [
        'roles' => $roles,
        'parameter' => 'task',
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('/tasks/{taskSlug}/edit', function() {

    $routeParameters = Route::getCurrentRoute()->parameters();

    if(!Auth::user()->admin) {
        return redirect('/tasks/'.$routeParameters['taskSlug']);
    }

    $task = Task::where('slug', $routeParameters['taskSlug'])->first();

    return view('tasks.edit', [
        'task' => $task,
        'parameter' => 'task',
        'roles' => Role::all(),
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::get('/tasks/{taskSlug}', function() {

    $routeParameters = Route::getCurrentRoute()->parameters();

    $task = Task::where('slug', $routeParameters['taskSlug'])->first();

    return view('tasks.show', [
        'task' => $task,
        'parameter' => 'task',
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('/categories/create', function() {
    return view('categories.create', [
        'roles' => Role::all(),
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('/categories/{categorySlug}', function() {

    $routeParameters = Route::getCurrentRoute()->parameters();

    $category = Category::where('slug', $routeParameters['categorySlug'])->first();

    return view('categories.show', [
        'category' => $category,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

// Route::get('/portfolios/{portfolioId}/projects/{attemptedProjectId}/leave-review', function() {
//     $routeParameters = Route::getCurrentRoute()->parameters();

//     $portfolioId = $routeParameters['portfolioId'];
//     $attemptedProjectId = $routeParameters['attemptedProjectId'];

//     // check whether user is authorised
//     $userIsEndorser = Endorser::where('attempted_project_id', $attemptedProjectId)->where('portfolio_id', $portfolioId)->where('email', Auth::user()->email)->first();

//     if($userIsEndorser) {
//         $portfolio = Portfolio::find($routeParameters['portfolioId']);
//         $attemptedProject = AttemptedProject::find($routeParameters['attemptedProjectId']);

//         return view('portfolios.leaveReviewOnIndividualProject', [
//             'portfolio' => $portfolio,
//             'attemptedProject' => $attemptedProject,
//             'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
//             'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
//             'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
//         ]);
//     } else {
//         return redirect('/portfolios/'.$portfolioId.'/projects/'.$attemptedProjectId)->with('notAuthorised', 'You are not authorised to leave a review.');
//     }
// })->middleware('auth');

// Route::post('/portfolios/{portfolioId}/projects/{attemptedProjectId}/leave-review', function(Request $request) {
//     $routeParameters = Route::getCurrentRoute()->parameters();

//     $attemptedProject = AttemptedProject::find($routeParameters['attemptedProjectId']);

//     $role = $attemptedProject->project->role;
//     $project = $attemptedProject->project;

//     $validator = Validator::make($request->all(), [
//         'rating' => 'required',
//         'review' => 'required',
//     ]);

//     if($validator->fails()) {
//         if(array_key_exists('userId', $routeParameters)) {
//             return redirect('/portfolios/'.$routeParameters['portfolioId'].'/projects/'.$routeParameters['attemptedProjectId'].'/leave-review')
//                 ->withErrors($validator)
//                 ->withInput();
//         } else {
//             return redirect('/portfolios/'.$routeParameters['portfolioId'].'/projects/'.$routeParameters['attemptedProjectId'].'/leave-review')
//             ->withErrors($validator)
//             ->withInput(); 
//         }
//     } else {
//         // create a new review

//         $review = new Review;

//         $review->rating = $request->input('rating');
//         $review->description = $request->input('review');

//         if(array_key_exists('userId', $routeParameters)) {
//             $review->sender_id = Auth::id();
//             $review->receiver_id = $routeParameters['userId'];
//         } else {
//             $review->sender_id = Auth::id();
//             $review->receiver_id = $attemptedProject->user_id;
//         }

//         $review->project_id = $project->id;
//         $review->attempted_project_id = $attemptedProject->id;

//         $review->save();

//         $endorser = Endorser::where('attempted_project_id', $attemptedProject->id)->where('portfolio_id', $routeParameters['portfolioId'])->where('email', Auth::user()->email)->first();

//         $endorser->left_review = true;

//         $endorser->save();

//         $notification = new Notification;

//         $notification->message = "has left a review on a project on your portfolio";
//         $notification->recipient_id = $attemptedProject->user_id;
//         $notification->user_id = $review->sender_id;
//         $notification->url = "/portfolios/".$routeParameters['portfolioId']."/projects/".$routeParameters['attemptedProjectId'];

//         $notification->save();

//         $userToEmail = User::find($review->receiver_id);

//         Mail::to($userToEmail->email)->send(new SendAttemptedProjectReviewedMail(Auth::user()->name, $userToEmail->name, 'https://talentail.com/portfolios/'.$routeParameters['portfolioId'].'/projects/'.$routeParameters['attemptedProjectId']));

//         return redirect('/portfolios/'.$routeParameters['portfolioId'].'/projects/'.$routeParameters['attemptedProjectId'].'/leave-review');
//     }
// });

// Route::get('/portfolios/{portfolioId}/projects/{attemptedProjectId}', function() {
//     $routeParameters = Route::getCurrentRoute()->parameters();

//     $portfolio = Portfolio::find($routeParameters['portfolioId']);
//     $attemptedProject = AttemptedProject::find($routeParameters['attemptedProjectId']);

//     return view('portfolios.showIndividualProject', [
//         'portfolio' => $portfolio,
//         'attemptedProject' => $attemptedProject,
//         'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
//         'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
//         'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
//     ]);
// });

Route::get('/ordered-projects', function() {
    $orderedProjects = AttemptedProject::where('creator_id', Auth::id())->get();

    return view('ordered-projects', [
        'orderedProjects' => $orderedProjects,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]); 
});

Route::get('/stripe-add-account', function() {
    \Stripe\Stripe::setApiKey("sk_test_M3fWET2nMbe5RHdA65AqhlE5");

    // $acct = \Stripe\Account::create([
    //     "country" => "SG",
    //     "type" => "standard",
    //     "email" => "thetalentail@db.com"
    // ]);

    $customer = \Stripe\Customer::create([
        'source' => 'tok_mastercard',
        'email' => 'aiya@gmail.com',
    ]);

    dd($customer);

    // $user = User::find(36);

    // $user->stripe_account_id = $acct->id;

    // $user->save();
});

Route::post('/blog/posts/{postId}/update', function(Request $request) {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $post = Post::find($routeParameters['postId']);

    $post->title = $request->input('title');
    $post->content = $request->input('content');
    $post->tags = $request->input('tags');
    $post->notes = $request->input('notes');
    $post->slug = str_slug($request->input('title'), '-');
    $post->user_id = Auth::id();

    if($request->input('thumbnail-deleted') != "false") {
        if($request->file('thumbnail')) {
            $post->thumbnail = $request->file('thumbnail')->getClientOriginalName();
            $post->url = Storage::disk('gcs')->put('/thumbnails', $request->file('thumbnail'), 'public');
        } else {
            $post->thumbnail = "";
            $post->url = "";
        }
    } 

    if($request->file('thumbnail')) {
        $post->thumbnail = $request->file('thumbnail')->getClientOriginalName();
        $post->url = Storage::disk('gcs')->put('/thumbnails', $request->file('thumbnail'), 'public');
    }

    $post->save();

    return redirect('/blog/posts/' . $post->slug);
});

Route::post('/blog/save', function(Request $request) {
    $post = new Post;

    $post->title = $request->input('title');
    $post->content = $request->input('content');
    $post->tags = $request->input('tags');
    $post->notes = $request->input('notes');
    $post->slug = str_slug($request->input('title'), '-');
    $post->user_id = Auth::id();

    if($request->file('thumbnail')) {
        $post->thumbnail = $request->file('thumbnail')->getClientOriginalName();
        $post->url = Storage::disk('gcs')->put('/thumbnails', $request->file('thumbnail'), 'public');
    }

    $post->save();

    return redirect('/blog/posts/' . $post->slug);
});

Route::get('/blog/posts/{slug}/edit', function() {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $post = Post::where('slug', $routeParameters['slug'])->first();

    return view('posts.edit', [
        'post' => $post,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]); 
});

Route::get('/blog/posts/{slug}', function() {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $post = Post::where('slug', $routeParameters['slug'])->first();

    $tags = explode(" ", $post->tags);

    return view('posts.show', [
        'post' => $post,
        'tags' => $tags,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]); 
});

Route::post('/blog/posts/toggle-visibility', function(Request $request) {
    $post = Post::find($request->input('post_id'));

    $post->published = !$post->published;

    $post->save();

    return redirect('/blog/posts/'.$post->slug);
});

Route::post('/blog/posts/delete-post', function(Request $request) {
    Post::destroy($request->input('post_id'));

    return redirect('/blog/admin');
});

Route::get('/blog/add', function() {
    return view('blog.add', [
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]); 
});

Route::get('/admin/companies', function() {
    $companies = Company::all();
    
    return view('admin.companies.index', [
        'companies' => $companies,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]); 
});

Route::get('/blog/admin', function() {
    $posts = Post::all();

    return view('blog.admin', [
        'posts' => $posts,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]); 
});

Route::get('/blog', function() {
    $posts = Post::where('published', 1)->orderBy('created_at', 'desc')->get();

    return view('blog.index', [
        'posts' => $posts,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]); 
});

Route::get('/stripe', function() {
    \Stripe\Stripe::setApiKey("sk_test_M3fWET2nMbe5RHdA65AqhlE5");

    $charge = \Stripe\Charge::create([
      "amount" => 1000,
      "currency" => "usd",
      "source" => "tok_visa",
      "application_fee" => 123,
    ], ["stripe_account" => "acct_1DfKKTBEnOu189lD"]);

    dd($charge);
});

// Route::get('/portfolios/0', function() {
//     return view('portfolios.sample', [
//         'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
//         'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
//         'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
//     ]);
// });

Route::get('/referrals', function() {
    $referred = Referral::where('referrer_id', Auth::id())->get();

    return view('referrals.index', [
        'referred' => $referred,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('/credits/add', function() {
    return view('credits.add', [
        
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::post('/companies/apply', function(Request $request) {
    // check whether or not both select box and input field selected


    $errorArray = array();

    if($request->input('description') == null) {
        array_push($errorArray, "Please provide a description of the role you play at your company.");
    }

    if($request->input('company') == "Nil" && $request->input('title') == null) {
        array_push($errorArray, "Please provide a valid company that you belong to.");
    }

    if($request->input('company') != "Nil" && $request->input('title')) {
        array_push($errorArray, "You should either select a company from the provided list or provide one that isn't found in the provided list.");
    }

    if(sizeof($errorArray) > 0) {
        return redirect("/company-application")->with('error', $errorArray)->withInput();
    } else {
        $companyApplication = new CompanyApplication;
        $companyApplication->description = $request->input('description');
        $companyApplication->user_id = Auth::id();
        $companyApplication->status = "pending";

        // check if new company

        if($request->input('title')) {
            $company = new Company;
            $company->title = $request->input('title');
            $company->save();
            $companyApplication->company_id = $company->id;
        } else {
            $companyApplication->company_id = $request->input('company');
        }

        $companyApplication->save();

        return redirect('/company-application-status')->with('success', 'Your application has been submitted. We will get back to you shortly.');
    }
});

Route::post('/credits/add-credits-to-cart', function(Request $request) {
    $creditType = $request->input('type');

    $credit = Credit::where('type', $creditType)->first();

    $shoppingCart = ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first();

    if($shoppingCart) {
        // already has a shopping cart
    } else {
        // no shopping cart, create new one

        $shoppingCart = new ShoppingCart;

        $shoppingCart->status = "pending";
        $shoppingCart->total = 0;
        $shoppingCart->no_of_items = 0;
        $shoppingCart->user_id = Auth::id();
    }

    $shoppingCart->no_of_items = $shoppingCart->no_of_items + 1;
    $shoppingCart->total = $shoppingCart->total + $credit->amount;

    $shoppingCart->save();

    $shoppingCartLineItem = new ShoppingCartLineItem;

    $shoppingCartLineItem->credit_id = $credit->id;
    $shoppingCartLineItem->shopping_cart_id = $shoppingCart->id;

    $shoppingCartLineItem->save();

    return redirect('/credits/add')->with('success', 'Credits added to cart.');
});

Route::get('/credits', function() {
    return view('credits.index', [
        
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::post('/work-experience', function(Request $request) {
    $user = Auth::user();

    $counter = 1;

    if(Experience::where('user_id', $user->id)) {
        Experience::where('user_id', $user->id)->delete();
    }

    while (Input::has('company_'.$counter) || Input::has('role_'.$counter) || Input::has('work-description_'.$counter) || Input::has('start-date_'.$counter) || Input::has('end-date_'.$counter)) {

        $experience = new Experience;

        $experience->company = Input::get('company_'.$counter);
        $experience->role = Input::get('role_'.$counter);
        $experience->description = preg_replace("/[\r\n]/","\r\n",Input::get('work-description_'.$counter));
        $experience->user_id = $user->id;
        $experience->start_date = Input::get('start-date_'.$counter);
        if(Input::get('end-date_'.$counter) == null) {
            $experience->end_date = 0;
        } else {
            $experience->end_date = Input::get('end-date_'.$counter);
        }

        $experience->save();

        $counter++;
    }

    $user->save();

    return redirect('/work-experience');
});

Route::post('/portfolios/{id}/add-portfolio-to-cart', function(Request $request) {
    $routeParameters = Route::getCurrentRoute()->parameters();
    $portfolio = Portfolio::find($request->input('portfolio_id'));

    // find whether or not there is an existing shopping cart
    $shoppingCart = ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first();

    if($shoppingCart) {
        // already has a shopping cart
    } else {
        // no shopping cart, create new one

        $shoppingCart = new ShoppingCart;

        $shoppingCart->status = "pending";
        $shoppingCart->total = 0;
        $shoppingCart->no_of_items = 0;
        $shoppingCart->user_id = Auth::id();
    }

    $shoppingCart->no_of_items = $shoppingCart->no_of_items + 1;
    $shoppingCart->total = $shoppingCart->total + 25;

    $shoppingCart->save();

    $shoppingCartLineItem = new ShoppingCartLineItem;

    $shoppingCartLineItem->portfolio_id = $portfolio->id;
    $shoppingCartLineItem->shopping_cart_id = $shoppingCart->id;

    $shoppingCartLineItem->save();

    return redirect('/portfolios/'.$routeParameters['id']);
});

Route::get('/portfolios/add', function() {
    $roleId = session('roleId');

    // check if there is a current portfolio
    $portfolio = Portfolio::where('role_id', $roleId)->first();

    if($portfolio) {
        return redirect('/portfolios/'.$portfolio->id);
    }

    $reviewedExercises = AnsweredExercise::where('user_id', Auth::id())->where('status', 'Reviewed')->get();

    return view('portfolios.add', [
        'reviewedExercises' => $reviewedExercises,
        'industries' => Industry::all(),
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::get('/portfolios/select-role', function() {
    $roles = Role::select('id', 'title')->orderBy('title', 'asc')->get();

    return view('portfolios.selectRole', [
        
        'roles' => $roles,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::post('/portfolios/{portfolioId}/save', function(Request $request) {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $answeredExercises = AnsweredExercise::where('user_id', Auth::id())->get();

    $answeredExerciseInput = $request->input('answeredExercise');

    if($answeredExercises) {
        foreach($answeredExercises as $answeredExercise) {
            if(!empty($answeredExerciseInput) && in_array($answeredExercise->id, $answeredExerciseInput)) {
                $answeredExercise->visible = 1;
            } else {
                $answeredExercise->visible = 0;
            }

            $answeredExercise->save();
        }
    }

    return redirect('/portfolios/'.$routeParameters['portfolioId']); 
})->middleware('auth');

// Route::post('/portfolios/save', function(Request $request) {
//     $roleId = $request->input('roleId');

//     // check if there is a current portfolio
//     $portfolio = Portfolio::where('role_id', $roleId)->first();

//     $addedProjects = $request->input('attemptedProject');

//     if(!$portfolio) {
//         $portfolio = new Portfolio;

//         $portfolio->user_id = Auth::id();
//         $portfolio->role_id = $roleId;

//         $portfolio->save();
//     } else {
//         // detach all attempted projects from portfolio first
//         // before reattaching them back later

//         // $portfolio->attempted_projects()->detach();

//         // $addedProjects = $request->input('attemptedProject');

//         // dd($addedProjects);

//         $newlyAddedProjects = array();
//         $newlyRemovedProjects = array();

//         // if addedProjects is null, all internal projects have been removed
//         if($addedProjects == null) {
//             if($portfolio->attempted_projects) {
//                 foreach($portfolio->attempted_projects as $attemptedProject) {
//                     if($attemptedProject->project->internal) {
//                         $attemptedProject->added = 0;
//                         $attemptedProject->save();

//                         $portfolio->industries()->detach($attemptedProject->project->industry_id);
//                         $portfolio->attempted_projects()->detach($attemptedProject->id);
//                     }
//                 }
//             }
//         } else {
//             // there are still existing projects in the addedProjects array
//             // some may be removed
//             // some may be newly added

//             foreach($portfolio->attempted_projects as $attemptedProject) {
//                 if($attemptedProject->project->internal) {
//                     // check whether the current list of attempted projects still exist in the new set of added projects
//                     if(!in_array($attemptedProject->id, $addedProjects)) {
//                         $attemptedProject->added = 0;
//                         $attemptedProject->save();

//                         $portfolio->industries()->detach($attemptedProject->project->industry_id);
//                         $portfolio->attempted_projects()->detach($attemptedProject->id);
//                     } else {
//                         array_splice($addedProjects, array_search($attemptedProject->id, $addedProjects));
//                     }
//                 }
//             }

//             // remaining added projects are new ones
//             foreach($addedProjects as $addedProject) {
//                 $attemptedProject = AttemptedProject::find($addedProject);
//                 $attemptedProject->added = 1;
//                 $attemptedProject->save();

//                 $projectAdded = Project::find($attemptedProject->project_id);

//                 $industry = Industry::find($attemptedProject->project->industry_id);
//                 $portfolio->industries()->attach($industry);

//                 $portfolio->attempted_projects()->attach($attemptedProject);
//             }
//         }

//         // look at external projects now

//         $removedAttemptedProjectsIdArray = $request->input('projects-deleted');

//         if($removedAttemptedProjectsIdArray != null) {
//             $removedAttemptedProjectsIdArray = explode(",",$removedAttemptedProjectsIdArray);

//             foreach($portfolio->attempted_projects as $attemptedProject) {
//                 if(!$attemptedProject->project->internal) {
//                     // check whether the current list of attempted project exists in the removedAttemptedProjectsIdArray
//                     if(in_array($attemptedProject->id, $removedAttemptedProjectsIdArray)) {
//                         // remove project
//                         Project::destroy($attemptedProject->project->id);

//                         // remove answeredtaskfiles
//                         AnsweredTaskFile::where('attempted_project_id', $attemptedProject->project->id)->delete();

//                         // remove endorsers
//                         Endorsers::where('attempted_project_id', $attemptedProject->project->id)->delete();

//                         // detach portfolio industries
//                         $portfolio->industries()->detach($attemptedProject->project->industry_id);

//                         // detach portfolio attempted projects
//                         $portfolio->attempted_projects()->detach($attemptedProject->id);

//                         // remove attempted project
//                         AttemptedProject::destroy($attemptedProject->id);
//                     } else {
//                         // even if project isnt removed, we need to check whether each value has changed
//                     }
//                 }
//             }
//         }

//         $projectCounter = 1;

//         while($request->input('project-title_'.$projectCounter) != null) {
//             // check whether it's existing or brand new

//             // existing
//             if($request->input('project-id_'.$projectCounter) != null) {
//                 // need to check existing attempted projects whether changes have been made

//                 $attemptedProject = AttemptedProject::find($request->input('project-id_'.$projectCounter));

//                 if($attemptedProject->project->title != $request->input('project-title_'.$projectCounter)) {
//                     $attemptedProject->project->title = $request->input('project-title_'.$projectCounter);
//                 }

//                 if($attemptedProject->project->description != $request->input('project-description_'.$projectCounter)) {
//                     $attemptedProject->project->description = $request->input('project-description_'.$projectCounter);
//                 }

//                 if($attemptedProject->project->industry_id != $request->input('industry_'.$projectCounter)) {
                    
//                     // need to detach and attach
//                     $portfolio->industries()->detach($attemptedProject->project->industry_id);
//                     $portfolio->industries()->attach($request->input('industry_'.$projectCounter));

//                     $attemptedProject->project->industry_id = $request->input('industry_'.$projectCounter);
//                 }

//                 // files
//                 $removedAnsweredTaskFilesIdArray = $request->input('files-deleted');

//                 if($removedAnsweredTaskFilesIdArray != null) {
//                     $removedAnsweredTaskFilesIdArray = explode(",",$removedAnsweredTaskFilesIdArray);

//                     foreach($attemptedProject->answered_task_files as $answeredTaskFile) {
//                         if(in_array($answeredTaskFile->id, $removedAnsweredTaskFilesIdArray)) {
//                             AnsweredTaskFile::destroy($answeredTaskFile->id);
//                         }
//                     }
//                 }

//                 if($request->file('file_'.$projectCounter)) {
//                     for($fileCounter = 0; $fileCounter < count($request->file('file_'.$projectCounter)); $fileCounter++) {

//                         $answeredTaskFile = new AnsweredTaskFile;

//                         $answeredTaskFile->title = $request->file('file_'.$projectCounter)[$fileCounter]->getClientOriginalName();
//                         $answeredTaskFile->size = $request->file('file_'.$projectCounter)[$fileCounter]->getSize();
//                         $answeredTaskFile->url = Storage::disk('gcs')->put('/assets', $request->file('file_'.$projectCounter)[$fileCounter], 'public');
//                         $answeredTaskFile->mime_type = $request->file('file_'.$projectCounter)[$fileCounter]->getMimeType();
//                         $answeredTaskFile->project_id = $attemptedProject->project->id;
//                         $answeredTaskFile->answered_task_id = 0;
//                         $answeredTaskFile->attempted_project_id = $attemptedProject->id;
//                         $answeredTaskFile->user_id = Auth::id();

//                         $answeredTaskFile->save();
//                     }
//                 }

//                 // endorsers
//                 $removedEndorsersIdArray = $request->input('endorsers-deleted');

//                 if($removedEndorsersIdArray != null) {
//                     $removedEndorsersIdArray = explode(",",$removedEndorsersIdArray);

//                     foreach($attemptedProject->endorsers as $endorser) {
//                         if(in_array($endorser->id, $removedEndorsersIdArray)) {
//                             Endorser::destroy($endorser->id);
//                         }
//                     }
//                 }

//                 if($request->input('project-endorsers_'.$projectCounter) != null) {
//                     $endorserArray = explode(",", $request->input('project-endorsers_'.$projectCounter));

//                     foreach ($endorserArray as $key => $endorserInput) {
//                         $endorser = new Endorser;

//                         $endorser->email = trim($endorserInput);
//                         $endorser->attempted_project_id = $attemptedProject->id;
//                         $endorser->mail_sent = 1;
//                         $endorser->portfolio_id = $portfolio->id;

//                         $endorser->save();

//                         // need to check whether or not user is already a member
//                         // if not, store notification in pending notification
//                         $userExists = User::where('email', $endorser->email)->first();

//                         if($userExists) {
//                             // create notification for user
//                             $notification = new Notification;

//                             $notification->message = "has requested your endorsement on portfolio: " . $attemptedProject->project->role->title;
//                             $notification->recipient_id = $userExists->id;
//                             $notification->user_id = Auth::id();
//                             $notification->url = "/xxx";

//                             $notification->save();
//                         } else {
//                             // create pending notification for user
//                             $pendingNotification = new PendingNotification;

//                             $pendingNotification->message = "has requested your endorsement on portfolio: " . $attemptedProject->project->role->title;
//                             $pendingNotification->recipient_email = $endorser->email;
//                             $pendingNotification->user_id = Auth::id();
//                             $pendingNotification->url = "/xxx";

//                             $pendingNotification->save();
//                         }

//                         Mail::to($endorser->email)->send(new SendEndorsersMail(Auth::user()->name, $attemptedProject->project->role->title, "https://talentail.com"));
//                     }
//                 }

//                 $attemptedProject->project->save();

//                 $attemptedProject->save();

//             } else {
//                 // new
//                 $project = new Project;

//                 $project->title = $request->input('project-title_'.$projectCounter);
//                 $project->description = $request->input('project-description_'.$projectCounter);
//                 $project->role_id = $roleId;
//                 $project->user_id = Auth::id();
//                 $project->internal = 0;
//                 $project->industry_id = $request->input('industry_'.$projectCounter);

//                 $project->save();

//                 $industry = Industry::find($request->input('industry_'.$projectCounter));
//                 $portfolio->industries()->attach($industry);

//                 $attemptedProject = new AttemptedProject;

//                 $attemptedProject->project_id = $project->id;
//                 $attemptedProject->user_id = Auth::id();
//                 $attemptedProject->status = "NA";
//                 $attemptedProject->creator_id = 0;
//                 $attemptedProject->added = 0;

//                 $attemptedProject->save();

//                 $portfolio->attempted_projects()->attach($attemptedProject);

//                 if($request->file('file_'.$projectCounter)) {
//                     for($fileCounter = 0; $fileCounter < count($request->file('file_'.$projectCounter)); $fileCounter++) {

//                         $answeredTaskFile = new AnsweredTaskFile;

//                         $answeredTaskFile->title = $request->file('file_'.$projectCounter)[$fileCounter]->getClientOriginalName();
//                         $answeredTaskFile->size = $request->file('file_'.$projectCounter)[$fileCounter]->getSize();
//                         $answeredTaskFile->url = Storage::disk('gcs')->put('/assets', $request->file('file_'.$projectCounter)[$fileCounter], 'public');
//                         $answeredTaskFile->mime_type = $request->file('file_'.$projectCounter)[$fileCounter]->getMimeType();
//                         $answeredTaskFile->project_id = $project->id;
//                         $answeredTaskFile->answered_task_id = 0;
//                         $answeredTaskFile->attempted_project_id = $attemptedProject->id;
//                         $answeredTaskFile->user_id = Auth::id();

//                         $answeredTaskFile->save();
//                     }
//                 }

//                 if($request->input('project-endorsers_'.$projectCounter) != null) {
//                     $endorserArray = explode(",", $request->input('project-endorsers_'.$projectCounter));

//                     foreach ($endorserArray as $key => $endorserInput) {
//                         $endorser = new Endorser;

//                         $endorser->email = trim($endorserInput);
//                         $endorser->attempted_project_id = $attemptedProject->id;
//                         $endorser->mail_sent = 1;
//                         $endorser->portfolio_id = $portfolio->id;

//                         $endorser->save();

//                         // need to check whether or not user is already a member
//                         // if not, store notification in pending notification
//                         $userExists = User::where('email', $endorser->email)->first();

//                         if($userExists) {
//                             // create notification for user
//                             $notification = new Notification;

//                             $notification->message = "has requested your endorsement on portfolio: " . $attemptedProject->project->role->title;
//                             $notification->recipient_id = $userExists->id;
//                             $notification->user_id = Auth::id();
//                             $notification->url = "/xxx";

//                             $notification->save();
//                         } else {
//                             // create pending notification for user
//                             $pendingNotification = new PendingNotification;

//                             $pendingNotification->message = "has requested your endorsement on portfolio: " . $attemptedProject->project->role->title;
//                             $pendingNotification->recipient_email = $endorser->email;
//                             $pendingNotification->user_id = Auth::id();
//                             $pendingNotification->url = "/xxx";

//                             $pendingNotification->save();
//                         }

//                         Mail::to($endorser->email)->send(new SendEndorsersMail(Auth::user()->name, $attemptedProject->project->role->title, "https://talentail.com"));
//                     }
//                 }
//             }

//             $projectCounter++;
//         }


//         return redirect('/portfolios/'.$portfolio->id);
//     }

//     // add projects if exists
//     $projectCounter = 1;

//     while($request->input('project-title_'.$projectCounter) != null) {
//         $project = new Project;

//         $project->title = $request->input('project-title_'.$projectCounter);
//         $project->description = $request->input('project-description_'.$projectCounter);
//         $project->role_id = $roleId;
//         $project->user_id = Auth::id();
//         $project->internal = 0;
//         $project->industry_id = $request->input('industry_'.$projectCounter);

//         $project->save();

//         $industry = Industry::find($request->input('industry_'.$projectCounter));
//         $portfolio->industries()->attach($industry);

//         $attemptedProject = new AttemptedProject;

//         $attemptedProject->project_id = $project->id;
//         $attemptedProject->user_id = Auth::id();
//         $attemptedProject->status = "NA";
//         $attemptedProject->creator_id = 0;
//         $attemptedProject->added = 0;

//         $attemptedProject->save();

//         $portfolio->attempted_projects()->attach($attemptedProject);

//         if($request->file('file_'.$projectCounter)) {
//             for($fileCounter = 0; $fileCounter < count($request->file('file_'.$projectCounter)); $fileCounter++) {

//                 $answeredTaskFile = new AnsweredTaskFile;

//                 $answeredTaskFile->title = $request->file('file_'.$projectCounter)[$fileCounter]->getClientOriginalName();
//                 $answeredTaskFile->size = $request->file('file_'.$projectCounter)[$fileCounter]->getSize();
//                 $answeredTaskFile->url = Storage::disk('gcs')->put('/assets', $request->file('file_'.$projectCounter)[$fileCounter], 'public');
//                 $answeredTaskFile->mime_type = $request->file('file_'.$projectCounter)[$fileCounter]->getMimeType();
//                 $answeredTaskFile->project_id = $project->id;
//                 $answeredTaskFile->answered_task_id = 0;
//                 $answeredTaskFile->attempted_project_id = $attemptedProject->id;
//                 $answeredTaskFile->user_id = Auth::id();

//                 $answeredTaskFile->save();
//             }
//         }

//         if($request->input('project-endorsers_'.$projectCounter) != null) {
//             $endorserArray = explode(",", $request->input('project-endorsers_'.$projectCounter));

//             foreach ($endorserArray as $key => $endorserInput) {
//                 $endorser = new Endorser;

//                 $endorser->email = trim($endorserInput);
//                 $endorser->attempted_project_id = $attemptedProject->id;
//                 $endorser->mail_sent = 1;
//                 $endorser->portfolio_id = $portfolio->id;

//                 $endorser->save();

//                 // need to check whether or not user is already a member
//                 // if not, store notification in pending notification
//                 $userExists = User::where('email', $endorser->email)->first();

//                 if($userExists) {
//                     // create notification for user
//                     $notification = new Notification;

//                     $notification->message = "has requested your endorsement on portfolio: " . $attemptedProject->project->role->title;
//                     $notification->recipient_id = $userExists->id;
//                     $notification->user_id = Auth::id();
//                     $notification->url = "/xxx";

//                     $notification->save();
//                 } else {
//                     // create pending notification for user
//                     $pendingNotification = new PendingNotification;

//                     $pendingNotification->message = "has requested your endorsement on portfolio: " . $attemptedProject->project->role->title;
//                     $pendingNotification->recipient_email = $endorser->email;
//                     $pendingNotification->user_id = Auth::id();
//                     $pendingNotification->url = "/xxx";

//                     $pendingNotification->save();
//                 }

//                 Mail::to($endorser->email)->send(new SendEndorsersMail(Auth::user()->name, $attemptedProject->project->role->title, "https://talentail.com"));
//             }
//         }

//         $projectCounter++;
//     }

//     foreach($addedProjects as $addedProject) {
//         $attemptedProject = AttemptedProject::find($addedProject);
//         $attemptedProject->added = 1;
//         $attemptedProject->save();

//         $projectAdded = Project::find($attemptedProject->project_id);

//         $industry = Industry::find($attemptedProject->project->industry_id);
//         $portfolio->industries()->attach($industry);

//         $portfolio->attempted_projects()->attach($attemptedProject);
//     }

//     return redirect('/portfolios/'.$portfolio->id);
// })->middleware('auth');

Route::post('/portfolios/select-role', function() {
    if(request('role') != null) {
        $roleId = request('role');
        if($roleId == "Nil") {
            return redirect('/portfolios/select-role')->with('selectRoleSelected', 'Please select a role.');
        }
        $role = Role::find($roleId);

        session(['roleId' => $roleId]);

        // check whether user already has a portfolio with selected role

        return redirect('/portfolios/add')->with('selectedRole', $role);
    }
    $roles = Role::select('id', 'title')->orderBy('title', 'asc')->get();

    return view('portfolios.selectRole', [  
        'roles' => $roles,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::get('/portfolios/{id}/manage-portfolio', function() {
    $routeParameters = Route::getCurrentRoute()->parameters();
    $portfolio = Portfolio::find($routeParameters['id']);
    
    return view('portfolios.manage', [ 
        'industries' => Industry::all(), 
        'portfolio' => $portfolio,
        'answeredExercises' => AnsweredExercise::where('user_id', $portfolio->user_id)->get(),
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);

})->middleware('auth');

Route::get('/portfolios/{id}', function() {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $portfolio = Portfolio::find($routeParameters['id']);

    $shoppingCart = ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first();
    if($shoppingCart) {
        $addedToCart = ShoppingCartLineItem::where('portfolio_id', $portfolio->id)->where('shopping_cart_id', $shoppingCart->id)->first();
    } else {
        $addedToCart = null;
    }

    $reviewedExercises = AnsweredExercise::where('user_id', $portfolio->user_id)->where('status', 'Reviewed')->where('visible', 1)->get();

    return view('portfolios.show', [
        'addedToCart' => $addedToCart,
        'portfolio' => $portfolio,
        'reviewedExercises' => $reviewedExercises,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('/welcome', function() {

    return view('welcome');
});

Route::get('/work-experience', function() {
    $user = Auth::user();

    return view('workExperience', [
        
        'user' => $user,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('/created-projects', function() {
    return view('createdProjects', [
        
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('/opportunities', function() {
    return view('opportunities.index', [
        'parameter' => 'opportunity',
        'roles' => Role::all(),
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('/opportunities/create', function() {
    $roles = Role::all();
    $tasks = Task::all();
    $companies = Company::all();

    if(Auth::user()->admin) {
    	return view('opportunities.create', [
    	    'roles' => $roles,
    	    'parameter' => 'opportunity',
    	    'companies' => $companies,
    	    'tasks' => $tasks,
    	    'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
    	    'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
    	    'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    	]);
    } else {
    	return view('opportunities.create2', [
    	    'roles' => $roles,
    	    'parameter' => 'opportunity',
    	    'companies' => $companies,
    	    'tasks' => $tasks,
    	    'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
    	    'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
    	    'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    	]);
    }

    
})->middleware('auth');

Route::get('/opportunities/{roleSlug}', function() {
    $opportunities = Opportunity::where('visible', true)->orderBy('created_at', 'desc')->get();

    $routeParameters = Route::getCurrentRoute()->parameters();

    $role = Role::where('slug', $routeParameters['roleSlug'])->first();

    return view('opportunities.showRole', [
        'parameter' => 'opportunity',
        'role' => $role,
        'opportunities' => $opportunities,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::post('/opportunities/{opportunitySlug}/toggle-visibility', function(Request $request) {
    $routeParameters = Route::getCurrentRoute()->parameters();
    $opportunity = Opportunity::where('slug', $routeParameters['opportunitySlug'])->first();
    $opportunity->visible = !$opportunity->visible;
    $opportunity->save();

    return redirect('/opportunities/'.$routeParameters['opportunitySlug']);
})->middleware('auth');

Route::post('/opportunities/{opportunitySlug}/delete-opportunity', function(Request $request) {
    $routeParameters = Route::getCurrentRoute()->parameters();
    $opportunity = Opportunity::where('slug', $routeParameters['opportunitySlug'])->first();
    $opportunity->tasks()->detach();
    $opportunity->exercises()->detach();
    Opportunity::destroy($opportunity->id);

    return redirect('/opportunities');
})->middleware('auth');

Route::post('/opportunities/{opportunitySlug}/save-opportunity', function(Request $request) {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $company = Company::find($request->input('company'));

    $opportunity = Opportunity::where('slug', $routeParameters['opportunitySlug'])->first();

    $opportunity->title = $request->input('title');
    $opportunity->role_id = $request->input('role');
    $opportunity->link = $request->input('link');
    $opportunity->posted_at = $request->input('posted_at');
    $opportunity->company_id = $request->input('company');
    $opportunity->slug = strtolower($company->slug) . "-" . str_slug($opportunity->title, '-') . "-" . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 10);
    $opportunity->description = $request->input('description');
    $opportunity->location = $request->input('location');
    $opportunity->level = $request->input('level');
    $opportunity->type = $request->input('type');

    $opportunity->save();

    // $opportunity->tasks()->detach();
    // $opportunity->exercises()->detach();

    // $opportunity->exercises()->attach($request->input('exercises'));

    // $exercises = DB::table('exercises')
    //                     ->whereIn('id', $request->input('exercises'))
    //                     ->get();

    // $tasksIdArray = array();

    // foreach($exercises as $exercise) {
    //     if(!in_array($exercise->task_id, $tasksIdArray)) {
    //         array_push($tasksIdArray, $exercise->task_id);
    //     }
    // }

    // $opportunity->tasks()->attach($tasksIdArray);

    return redirect('/opportunities/' . $opportunity->slug);
})->middleware('auth');

Route::get('/opportunities/{opportunitySlug}/edit', function() {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $roles = Role::all();
    $tasks = Task::all();
    $companies = Company::all();

    $opportunity = Opportunity::where('slug', $routeParameters['opportunitySlug'])->first();

    $exerciseIdArray = array();

    foreach($opportunity->exercises as $exercise) {
        array_push($exerciseIdArray, $exercise->id);
    }

    return view('opportunities.edit', [
        'roles' => $roles,
        'companies' => $companies,
        'tasks' => $tasks,
        'parameter' => 'opportunity',
        'opportunity' => $opportunity,
        'exerciseIdArray' => $exerciseIdArray, 
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::post('/opportunity-submissions/{opportunitySubmissionSlug}/save-opportunity' , function(Request $request) {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $opportunitySubmission = OpportunitySubmission::where('slug', $routeParameters['opportunitySubmissionSlug'])->first();

    if($opportunitySubmission->title != $request->input('title') || $opportunitySubmission->company != $request->input('company')) {
        $opportunitySubmission->slug = str_slug($request->input('company'), '-') . "-" . str_slug($request->title, '-') . "-" . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 10);
    }

    $opportunitySubmission->title = $request->input('title');
    $opportunitySubmission->role_id = $request->input('role');
    $opportunitySubmission->company = $request->input('company');
    $opportunitySubmission->description = $request->input('description');
    $opportunitySubmission->location = $request->input('location');
    $opportunitySubmission->level = $request->input('level');
    $opportunitySubmission->type = $request->input('type');

    $opportunitySubmission->save();

    return redirect('/opportunity-submissions/'.$opportunitySubmission->slug);
})->middleware('auth');

Route::get('/opportunity-submissions/{opportunitySubmissionSlug}/edit' , function() {
    $routeParameters = Route::getCurrentRoute()->parameters();

    return view('opportunitySubmissions.edit', [
        'roles' => Role::all(),
        'opportunitySubmission' => OpportunitySubmission::where('slug', $routeParameters['opportunitySubmissionSlug'])->first(),
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);

})->middleware('auth');

Route::get('/opportunity-submissions/{opportunitySubmissionSlug}' , function() {
    $routeParameters = Route::getCurrentRoute()->parameters();

    return view('opportunitySubmissions.show', [
        'opportunitySubmission' => OpportunitySubmission::where('slug', $routeParameters['opportunitySubmissionSlug'])->first(),
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);

})->middleware('auth');

Route::post('/opportunities/save-opportunity', function(Request $request) {

    if(Auth::user()->admin) {

        $opportunity = new Opportunity;

        $company = Company::find($request->input('company'));

        $opportunity->title = $request->input('title');
        $opportunity->role_id = $request->input('role');
        $opportunity->link = $request->input('link');
        $opportunity->posted_at = $request->input('posted_at');
        $opportunity->company_id = $request->input('company');
        $opportunity->slug = strtolower($company->slug) . "-" . str_slug($opportunity->title, '-') . "-" . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 10);
        $opportunity->description = $request->input('description');
        $opportunity->location = $request->input('location');
        $opportunity->level = $request->input('level');
        $opportunity->type = $request->input('type');

        $opportunity->save();

        return redirect('/opportunities/' . $opportunity->slug);
    } else {
        $opportunitySubmission = new OpportunitySubmission;

        $opportunitySubmission->title = $request->input('title');
        $opportunitySubmission->role_id = $request->input('role');
        $opportunitySubmission->company = $request->input('company');
        $opportunitySubmission->slug = str_slug($request->input('company'), '-') . "-" . str_slug($opportunitySubmission->title, '-') . "-" . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 10);
        $opportunitySubmission->description = $request->input('description');
        $opportunitySubmission->location = $request->input('location');
        $opportunitySubmission->level = $request->input('level');
        $opportunitySubmission->type = $request->input('type');
        $opportunitySubmission->user_id = Auth::id();

        $opportunitySubmission->save();

        return redirect('/opportunity-submissions/' . $opportunitySubmission->slug);
    }

})->middleware('auth');

Route::get('dashboard', function() {

    if(Auth::user()->admin) {
        $roles = Role::all();
        $tasks = Task::all();
        $exercises = Exercise::all();
        $opportunities = Opportunity::all();
        $answeredExercises = AnsweredExercise::all();  
        $exerciseGroupings = ExerciseGrouping::all();
        $opportunitySubmissions = OpportunitySubmission::all();

        return view('dashboard', [
            'opportunities' => $opportunities,
            'answeredExercises' => $answeredExercises,
            'exerciseGroupings' => $exerciseGroupings,
            'opportunitySubmissions' => $opportunitySubmissions,
            'roles' => $roles,
            'tasks' => $tasks,
            'exercises' => $exercises,
            'parameter' => 'index',
            'parameter' => 'none',
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        ]);
    } else {
        $answeredExercises = AnsweredExercise::where("user_id", Auth::id())->get();
        $opportunitySubmissions = OpportunitySubmission::all();

        return view('dashboard', [
            'answeredExercises' => $answeredExercises,
            'opportunitySubmissions' => $opportunitySubmissions,
            'appliedOpportunities' => AppliedOpportunity::where('user_id', Auth::id())->get(),
            'parameter' => 'index',
            'parameter' => 'none',
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        ]);
    }

    
})->middleware('auth');

Route::post('/shopping-cart/empty-cart', function(Request $request) {
    $shoppingCartId = Input::get('shopping_cart_id');

    ShoppingCartLineItem::where('shopping_cart_id', $shoppingCartId)->delete();
    ShoppingCart::destroy($shoppingCartId);

    return redirect('/shopping-cart');
});

Route::post('/shopping-cart/remove-line-item', function(Request $request) {
    ShoppingCartLineItem::destroy(Input::get('shopping_cart_line_item_id'));

    $shoppingCart = ShoppingCart::find(Input::get('shopping_cart_id'));
    $shoppingCart->no_of_items = $shoppingCart->no_of_items - 1;

    $shoppingCart->total = 0;

    foreach($shoppingCart->shopping_cart_line_items as $shoppingCartLineItem) {
        if($shoppingCartLineItem->project_id) {
            $shoppingCart->total = $shoppingCart->total + $shoppingCartLineItem->project->amount;
        } elseif($shoppingCartLineItem->credit_id) {
            $shoppingCart->total = $shoppingCart->total + $shoppingCartLineItem->credit->amount;
        }
    }

    if($shoppingCart->total == 0) {
        ShoppingCart::destroy($shoppingCart->id);
    } else {
        $shoppingCart->save();
    }

    return redirect('/shopping-cart');
});

Route::get('/invoices/{invoiceId}', function() {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $invoice = Invoice::find($routeParameters['invoiceId']);

    return view('invoices.show', [
        'invoice' => $invoice,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending'
    ]);
})->middleware('auth');


Route::get('/invoices', function() {
    // $invoices = ShoppingCart::where('user_id', Auth::id())->where('status', 'paid')->orderBy('created_at', 'desc')->get();

    $invoices = Invoice::where('user_id', Auth::id())->get();

    return view('invoices.index', [
        
        'invoices' => $invoices,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending'
    ]);
})->middleware('auth');

Route::get('/shopping-cart/history', function() {
    $shoppingCarts = ShoppingCart::where('user_id', Auth::id())->where('status', 'Paid')->get();

    return view('shoppingCartHistory', [
        'shoppingCarts' => $shoppingCarts,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::get('/shopping-cart/{shoppingCartId}', function() {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $shoppingCart = ShoppingCart::find($routeParameters['shoppingCartId']);

    return view('shoppingCartShow', [
        'shoppingCart' => $shoppingCart,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::get('/shopping-cart', function() {
    $shoppingCart = ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first();

    $projectsArray = array();

    if($shoppingCart) {
        foreach($shoppingCart->shopping_cart_line_items as $shoppingCartLineItem) {
            if($shoppingCartLineItem->project_id) {
                array_push($projectsArray, $shoppingCartLineItem->project_id);
            }
        }
    }

    return view('shoppingCart', [
        'shoppingCart' => $shoppingCart,
        'projectsArray' => implode(",", $projectsArray),
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::post('/process-payment', function(Request $request) {
    \Stripe\Stripe::setApiKey("sk_test_M3fWET2nMbe5RHdA65AqhlE5");

    $pusher = App::make('pusher');

    $projectsArray = $request->input('projectsArray');

    $projectsNameArray = array();

    if($projectsArray != null) {
        $projectsArray = explode(",", $projectsArray);
        if(sizeof($projectsArray) > 0) {
            foreach($projectsArray as $key=>$projectId) {
                $project = Project::find($projectId);

                $token;

                if(Auth::user()->stripe_customer_id) {
                    $token = \Stripe\Token::create(
                          ["customer" => Auth::user()->stripe_customer_id], 
                          ["stripe_account" => $project->user->stripe_account_id]);
                } else {
                    $token = $request->input('stripeToken');

                    $customer = \Stripe\Customer::create([
                        'source' => $token,
                        'email' => Auth::user()->email,
                    ]);

                    $token = \Stripe\Token::create(
                      ["customer" => $customer->id], 
                      ["stripe_account" => $project->user->stripe_account_id]);

                    $userToUpdate = User::find(Auth::id());

                    $userToUpdate->stripe_customer_id = $customer->id;

                    $userToUpdate->save();
                }

                $charge = \Stripe\Charge::create([
                    'amount' => $project->amount * 100,
                    "metadata" => [
                        "candidate_id" => Auth::id(),
                        "creator_id" => $project->user_id
                    ],
                    'description' => Auth::user()->name . " purchased " . $project->title . ".",
                    'currency' => 'sgd',
                    "application_fee" => round(($project->amount * 100 * 0.2) - ($project->amount * 100 * 0.029 + 30)),
                    'source' => $token->id,
                    'receipt_email' => Auth::user()->email,
                ], ["stripe_account" => $project->user->stripe_account_id]);

                if($charge->status == "succeeded") {
                    array_push($projectsNameArray, $project->title);

                    $attemptedProject = new AttemptedProject;

                    $attemptedProject->project_id = $projectId;
                    $attemptedProject->user_id = Auth::id();
                    $attemptedProject->status = "Attempting";
                    $attemptedProject->creator_id = $project->user_id;

                    // calculate the deadline of the project by adding project hours to current date
                    $attemptedProject->deadline = date("Y-m-d H:i:s", time() + ($project->hours * 60 * 60));

                    $attemptedProject->save();

                    // add all the answeredtasks so that it can be loaded on the attempt page
                    foreach($project->tasks as $task) {
                        $answeredTask = new AnsweredTask;
                        $answeredTask->answer = "";
                        $answeredTask->response = "";
                        $answeredTask->user_id = Auth::id();
                        $answeredTask->task_id = $task->id;
                        $answeredTask->project_id = $project->id;

                        $answeredTask->save();
                    }

                    // notify creator
                    $notification = new Notification;

                    $notification->message = "purchased project: " . $project->title;
                    $notification->recipient_id = $project->user_id;
                    $notification->user_id = Auth::id();
                    $notification->url = "/roles/" . $project->role->slug . "/projects/" . $project->slug;

                    $notification->save();

                    $message = [
                        'text' => e("purchased project: " . $project->title),
                        'username' => Auth::user()->name,
                        'avatar' => Auth::user()->avatar,
                        'timestamp' => (time()*1000),
                        'projectId' => $project->id,
                        'url' => '/notifications'
                    ];

                    $pusher->trigger('notifications_' . $project->user_id, 'new-notification', $message);
                } else {
                    return redirect('/shopping-cart')->with('error', 'There may have been an error. If it persists, contact support.');
                }
            }
        }
    }

    $shoppingCart = ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first();

    $shoppingCart->status = "Paid";

    $shoppingCart->save();

    return redirect('/shopping-cart')->with('projectsNameArray', $projectsNameArray);
});

Route::get('/payment/process', 'PaymentsController@process')->name('payment.process');

Route::get('/tutorials/how-to-create-a-project', function() {
    return view('tutorials.create-projects',[
        
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('tutorials/attempt-projects', function() {
    return view('tutorials.attempt-projects',[
        
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('tutorials/creators', function() {
    return view('tutorials.creators',[
        
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('tutorials', function() {
    return view('tutorials.index',[
        
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('privacy-policy', function() {
    return view('privacy',[
        
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('terms-and-conditions', function() {
    return view('terms', [
        
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('/verifyuser', function() {
    return view('emails.verifyUser');
});

Route::get('/sendemail', function() {
    Mail::send('thetalentail@gmail.com', ['title' => 'You have been contacted', 'content' => 'Hi'], function ($message) use ($attach)
    {

        $message->from('yolomolotolo@gmail.com', 'Christian Nwamba');

        $message->to('chrisn@scotch.io');

        //Attach file
        $message->attach($attach);

        //Add a subject
        $message->subject("Hello from Scotch");

    });
});


Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');

Route::get('/send-message', function() {
    Mail::to('supershazwi@gmail.com')->send(new UserRegistered());
});

Route::post('/messages/{userId}', 'MessagesController@sendMessage');

Route::post('/purchase-projects', 'ProjectsController@purchaseProjects');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Auth::routes(['verify' => true]);

Route::get('/profile/edit', function() {
    $user = Auth::user();

    foreach($user->experiences as $experience) {
        $experience->description = preg_replace("/\r\n\r\n/","\r\n",$experience->description);

        // dd($experience->description);

        $experience->save();

        // dd(preg_replace("/\r\n\r\n/","\r\n",$experience->description));
    }

    return view('edit-profile', [
        
        'user' => $user,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::get('/profile/{userId}/reviews', function() {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $user = User::find($routeParameters['userId']);

    return view('profile.reviews', [
        'showMessage' => true,
        'user' => $user,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('/profile/{userId}/resume', function() {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $user = User::find($routeParameters['userId']);

    $reviewedExercisesCount = AnsweredExercise::where('user_id', $user->id)->where('status', 'Reviewed')->where('visible', 1)->count();

    return view('profile.resume', [
        'showMessage' => true,
        'user' => $user,
        'reviewedExercisesCount' => $reviewedExercisesCount,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('/profile/{userId}/projects', function() {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $user = User::find($routeParameters['userId']);

    $projects = Project::where('user_id', $user->id)->get();

    return view('profile.projects', [
        'showMessage' => true,
        'user' => $user,
        'projects' => $projects,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('/profile/reviews', function() {
    $user = Auth::user();

    return view('profile.reviews', [
        'showMessage' => false,
        'user' => $user,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::get('/profile/interviews', function() {
    $user = Auth::user();

    return view('profile.interviews', [
        
        'user' => $user,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::get('/profile/lessons', function() {
    $user = Auth::user();

    return view('profile.lessons', [
        
        'user' => $user,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::get('/profile/resume', function() {
    $user = Auth::user();

    return view('profile.resume', [
        'showMessage' => false,
        'user' => $user,
        'parameter' => 'portfolio',
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::get('/profile/projects', function() {
    $user = Auth::user();

    // find out skills gained
    $projects = Project::where('user_id', Auth::id())->get();

    return view('profile.projects', [
        'showMessage' => false,
        'user' => $user,
        'parameter' => 'project',
        'projects' => $projects,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::get('/profile/{userId}', function() {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $user = User::find($routeParameters['userId']);

    $reviewedExercisesCount = AnsweredExercise::where('user_id', $user->id)->where('status', 'Reviewed')->where('visible', 1)->count();

    if($user->id == Auth::id()) {
        return redirect('/profile');
    } else {
        return view('profile', [
            'showMessage' => true,
            'user' => $user,
            'reviewedExercisesCount' => $reviewedExercisesCount,
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        ]);
    }
})->middleware('auth');

Route::get('/profile/{profileId}', function() {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $loggedInUserId = Auth::id();

    $clickedUserId = $routeParameters['profileId'];

    if($loggedInUserId == $clickedUserId) {
        return redirect('/profile');
    } else {
        $subscribeString;

        if($loggedInUserId < $clickedUserId) {
            $subscribeString = $loggedInUserId . "_" . $clickedUserId;
        } else {
            $subscribeString = $clickedUserId . "_" . $loggedInUserId;   
        }

        $user = User::find(Route::getCurrentRoute()->parameters()['profileId']);

        if($user == null) {
            return view('error');
        }

        $rolesGained = RoleGained::where('user_id', Auth::id())->get();
        $attemptedProjects = AttemptedProject::where('user_id', Auth::id())->get();

        $messages1 = Message::where('sender_id', $loggedInUserId)->where('recipient_id', $clickedUserId)->where('project_id', 0)->get();
        $messages2 = Message::where('sender_id', $clickedUserId)->where('recipient_id', $loggedInUserId)->where('project_id', 0)->get();
        $messages3 = $messages1->merge($messages2);

        $messages3 = $messages3->sortBy('created_at');

        return view('profile', [
            
            'user' => $user,
            'showMessage' => true,
            'rolesGained' => $rolesGained,
            'messages' => $messages3,
            'clickedUserId' => $clickedUserId,
            'attemptedProjects' => $attemptedProjects,
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
            'messageChannel' => 'messages_'.$subscribeString,
        ]);
    }
});

Route::get('/projects-overview', function() {
    if(Auth::user()->creator) {
       $projects = Project::where('user_id', Auth::id())->get();

       return view('projects.overview', [
           
           'projects' => $projects,
           'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
           'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
           'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
       ]); 
   } else {
    return redirect('/projects-overview/attempted');
   }
    
})->middleware('auth');

Route::get('/projects-overview/attempted', function() {
    $attemptedProjects = AttemptedProject::where('user_id', Auth::id())->get();

    return view('projects.attempted', [
        
        'attemptedProjects' => $attemptedProjects,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::get('projects/clone', function() {
    if(session('selectedRole')) {
        $selectedRole = Role::find(session('selectedRole')); 
    }

    return view('projects.clone', [
        
        'sampleProjects' => Project::where('sample', 1)->get(),
        'createdProjects' => Project::where('user_id', Auth::id())->get(),
        'selectedRole' => $selectedRole,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::post("/company-applications/update-status", function(Request $request) {
    $companyApplication = CompanyApplication::find($request->input('company_application_id'));

    $companyApplication->status = $request->input('status');

    $companyApplication->save();

    if($request->input('status') == "approved") {
        $user = User::find($companyApplication->user_id);

        $user->company = true;

        $user->save();
    }

    return redirect("/creator-application-overview");
});

Route::post("/creator-applications/update-status", function(Request $request) {
    $creatorApplication = CreatorApplication::find($request->input('creator_application_id'));

    $creatorApplication->status = $request->input('status');

    $creatorApplication->save();

    if($request->input('status') == "approved") {
        $user = User::find($creatorApplication->user_id);

        $user->creator = true;

        \Stripe\Stripe::setApiKey("sk_test_M3fWET2nMbe5RHdA65AqhlE5");

        $acct = \Stripe\Account::create([
            "country" => "US",
            "type" => "standard",
            "email" => $user->email
        ]);

        $user->stripe_account_id = $acct->id;

        $user->save();
    }

    return redirect("/creator-application-overview");
});

Route::get('/creator-application-status', function() {
    $creatorApplication = CreatorApplication::where('user_id', Auth::id())->first();

    return view('creator-application-status', [
        'creatorApplication' => $creatorApplication,
        
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::get('/company-application-status', function() {
    $companyApplication = CompanyApplication::where('user_id', Auth::id())->first();

    return view('company-application-status', [
        'companyApplication' => $companyApplication,
        
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::get('/company-applications/{userId}', function() {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $companyApplication = CompanyApplication::where('user_id', $routeParameters['userId'])->first();

    return view('company-application-show', [
        'companyApplication' => $companyApplication,
        
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::get('/creator-applications/{userId}', function() {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $creatorApplication = CreatorApplication::where('user_id', $routeParameters['userId'])->first();

    return view('creator-application-show', [
        'creatorApplication' => $creatorApplication,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::get('/creator-application-overview', function() {
    $creatorApplications = CreatorApplication::all();

    return view('creator-application-overview', [
        'creatorApplications' => $creatorApplications,
        
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::get('/company-application-overview', function() {
    $companyApplications = CompanyApplication::all();

    return view('company-application-overview', [
        'companyApplications' => $companyApplications,
        
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::get('/company-application', function() {
    $companies = Company::all();

    return view('apply-company', [
        
        'companies' => $companies,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::get('/creator-application', function() {
    $creatorApplication = CreatorApplication::where('user_id', Auth::id())->first();

    return view('apply-creator', [
        'creatorApplication' => $creatorApplication,
        'parameter' => 'general',
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::get('/creator-stripe-account', function() {
    $creatorApplication = CreatorApplication::where('user_id', Auth::id())->first();

    return view('apply-creator', [
        'creatorApplication' => $creatorApplication,
        'parameter' => 'stripe',
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::post('/projects/apply', function(Request $request) {
    $creatorApplication = new CreatorApplication;

    $creatorApplication->description = $request->input('description');
    $creatorApplication->user_id = Auth::id();
    $creatorApplication->status = "pending";

    $creatorApplication->save();

    if($request->file('file-1')) {

        for($fileCounter = 0; $fileCounter < count($request->file('file-1')); $fileCounter++) {

            $creatorApplicationFile = new CreatorApplicationFile;

            $creatorApplicationFile->title = $request->file('file-1')[$fileCounter]->getClientOriginalName();
            $creatorApplicationFile->url = Storage::disk('gcs')->put('/assets', $request->file('file-1')[$fileCounter], 'public');
            $creatorApplicationFile->mime_type = $request->file('file-1')[$fileCounter]->getMimeType();
            $creatorApplicationFile->creator_application_id = $creatorApplication->id;

            $creatorApplicationFile->save();
        }
    }

    return redirect('/creator-application')->with('success', 'Your application has been submitted. We will get back to you shortly.');
});

Route::get('/attempt/others', function() {
    $role = Role::where('slug', 'others')->first();

    return view('attempt.others', [
        
        'role' => $role,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('/learn', function() {
    // $role = Role::where('slug', 'business-analyst')->first();

    return view('learn.index', [
        
        'parameter' => 'learn',
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});


Route::post('/profile/save', function(Request $request) {

    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required'
    ]);

    if($validator->fails()) {
        return redirect('/settings')
                    ->withErrors($validator)
                    ->withInput();
    } else {
        $user = Auth::user();

        if (Input::has('name')) { $user->name = Input::get('name'); }
        if (Input::has('email')) { $user->email = Input::get('email'); }
        if (Input::has('website')) { $user->website = Input::get('website'); }
        if (Input::has('facebook')) { $user->facebook = Input::get('facebook'); }
        if (Input::has('linkedin')) { $user->linkedin = Input::get('linkedin'); }
        if (Input::has('twitter')) { $user->twitter = Input::get('twitter'); }
        if (Input::has('description')) { $user->description = Input::get('description'); }

        if(Input::has('avatar')) {
            $user->avatar = Storage::disk('gcs')->put('/avatars', $request->file('avatar'), 'public');
        }

        $user->save();

        return redirect('/settings')->with('success', 'Password updated.');
    }
})->middleware('auth');

Route::get('/profile', function() {
    $user = Auth::user();

    $reviewedExercisesCount = AnsweredExercise::where('user_id', $user->id)->where('status', 'Reviewed')->where('visible', 1)->count();

    return view('profile', [
        'user' => $user,
        'showMessage' => false,
        'reviewedExercisesCount' => $reviewedExercisesCount,
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::get('/about-us', function() {
    return view('about-us', [
        
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::post('contact-us', function(Request $request) {
    $contactMessage = new ContactMessage;

    $contactMessage->name = $request->input('name');
    $contactMessage->description = $request->input('description');
    $contactMessage->email = $request->input('email');

    $contactMessage->save();

    Mail::to('thetalentail@gmail.com')->send(new SendContactMail($contactMessage));

    return redirect('/contact-us')->with('contactStatus', 'Thank you for your enquiry. We will reply you at the provided email the soonest.');
});

Route::get('/contact-us', function() {
    return view('contact-us', [
        
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

// Route::get('/notifications', function() {
//     return view('notifications');
// });

Route::get('/faq', function() {
    return view('faq', [
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('/file-upload', function() {
    return view('file-upload');
});

Route::post('/exercises/{exerciseSlug}/toggle-visibility', function(Request $request) {
    $routeParameters = Route::getCurrentRoute()->parameters();
    $exercise = Exercise::where('slug', $routeParameters['exerciseSlug'])->first();
    $exercise->visible = !$exercise->visible;
    $exercise->save();

    return redirect('/exercises/'.$routeParameters['exerciseSlug']);
})->middleware('auth');

Route::get('/exercises/create', function() {
    $tasks = Task::all();

    return view('exercises.create', [
        'tasks' => $tasks,
        'parameter' => 'task',
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('/exercises/{exerciseSlug}/{userId}', function() {
    $routeParameters = Route::getCurrentRoute()->parameters();

    if(Auth::user()->admin) {
        $exercise = Exercise::where('slug', $routeParameters['exerciseSlug'])->first();

        // check whether attempted or not

        $answeredExercise = AnsweredExercise::where('user_id', $routeParameters['userId'])->where('exercise_id', $exercise->id)->first();

        return view('exercises.review', [
            'exercise' => $exercise,
            'parameter' => 'task',
            'answeredExercise' => $answeredExercise,
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    } else {
        return redirect('/exercises/'.$routeParameters['exerciseSlug']);
    }

    
})->middleware('auth');

Route::get('/exercises/{exerciseSlug}', function() {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $exercise = Exercise::where('slug', $routeParameters['exerciseSlug'])->first();

    // check whether attempted or not

    $answeredExercise = AnsweredExercise::where('user_id', Auth::id())->where('exercise_id', $exercise->id)->first();

    if($answeredExercise) {
        return view('exercises.attempt', [
            'exercise' => $exercise,
            'parameter' => 'task',
            'answeredExercise' => $answeredExercise,
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    }

    return view('exercises.show', [
        'exercise' => $exercise,
        'parameter' => 'task',
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::post('/categories/save-category', function(Request $request) {

    $validator = Validator::make($request->all(), [
        'title' => 'required|unique:categories'
    ]);

    if($validator->fails()) {
        return redirect('tasks/create')
                    ->withErrors($validator)
                    ->withInput();
    }

    $category = new Category;

    $category->title = $request->input('title');
    $category->description = $request->input('description');
    $category->slug = str_slug($request->input('title'), '-');

    $category->save();

    $category->roles()->attach($request->input('role'));

    return redirect('/categories/'.$category->slug);
});

Route::post('/tasks/{taskSlug}/save-task', function(Request $request) {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $task = Task::where('slug', $routeParameters['taskSlug'])->first();

    if(!$task->title == $request->title) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:tasks'
        ]);

        if($validator->fails()) {
            return redirect('tasks/create')
                        ->withErrors($validator)
                        ->withInput();
        }
    }

    $task->title = $request->input('title');
    $task->description = $request->input('description');
    $task->slug = str_slug($request->input('title'), '-');

    $task->save();

    return redirect('/tasks/'.$task->slug);
});

Route::post('/tasks/save-task', function(Request $request) {

    $validator = Validator::make($request->all(), [
        'title' => 'required|unique:tasks'
    ]);

    if($validator->fails()) {
        return redirect('tasks/create')
                    ->withErrors($validator)
                    ->withInput();
    }

    $task = new Task;

    $task->title = $request->input('title');
    $task->description = $request->input('description');
    $task->slug = str_slug($request->input('title'), '-');

    $task->save();

    return redirect('/tasks/'.$task->slug);
});

Route::post('/exercises/{exerciseSlug}/save-exercise', function(Request $request) {
    $routeParameters = Route::getCurrentRoute()->parameters();

    $validator = Validator::make($request->all(), [
        'title' => 'required|unique:tasks'
    ]);

    if($validator->fails()) {
        return redirect('exercises/create')
                    ->withErrors($validator)
                    ->withInput();
    }

    $exercise = Exercise::where('slug', $routeParameters['exerciseSlug'])->first();

    $exercise->description = $request->input('description');

    if($exercise->solution_title != $request->input('solution-title')) {
        $exercise->slug = str_slug($request->input('solution-title'), '-') . '-' . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 10);
    }
    $exercise->title = $request->input('title');
    $exercise->brief = $request->input('brief');
    $exercise->task_id = $request->input('task');
    $exercise->solution_title = $request->input('solution-title');
    $exercise->solution_description = $request->input('solution-description');
    $exercise->duration = $request->input('duration');

    if($request->file('thumbnail')) {
        $exercise->thumbnail = $request->file('thumbnail')->getClientOriginalName();
        $exercise->url = Storage::disk('gcs')->put('/thumbnails', $request->file('thumbnail'), 'public');
    }

    $exercise->save();

    if($request->file('file')) {
        for($fileCounter = 0; $fileCounter < count($request->file('file')); $fileCounter++) {

            $exerciseFile = new ExerciseFile;

            $exerciseFile->title = $request->file('file')[$fileCounter]->getClientOriginalName();
            $exerciseFile->size = $request->file('file')[$fileCounter]->getSize();
            $exerciseFile->url = Storage::disk('gcs')->put('/assets', $request->file('file')[$fileCounter], 'public');
            $exerciseFile->mime_type = $request->file('file')[$fileCounter]->getMimeType();
            $exerciseFile->exercise_id = $exercise->id;

            $exerciseFile->save();
        }
    }

    if($request->file('answerFile')) {
        for($fileCounter = 0; $fileCounter < count($request->file('answerFile')); $fileCounter++) {

            $answerFile = new AnswerFile;

            $answerFile->title = $request->file('answerFile')[$fileCounter]->getClientOriginalName();
            $answerFile->size = $request->file('answerFile')[$fileCounter]->getSize();
            $answerFile->url = Storage::disk('gcs')->put('/assets', $request->file('answerFile')[$fileCounter], 'public');
            $answerFile->mime_type = $request->file('answerFile')[$fileCounter]->getMimeType();
            $answerFile->exercise_id = $exercise->id;

            $answerFile->save();
        }
    }

    $removedExerciseFilesIdArray = $request->input('files-deleted');
    $removedAnswerFilesIdArray = $request->input('answer-files-deleted');

    if($removedExerciseFilesIdArray != null) {
        $removedExerciseFilesIdArray = explode(",",$removedExerciseFilesIdArray);

        foreach($exercise->exercise_files as $exerciseFile) {
            if(in_array($exerciseFile->id, $removedExerciseFilesIdArray)) {
                ExerciseFile::destroy($exerciseFile->id);
            }
        }
    }

    if($removedAnswerFilesIdArray != null) {
        $removedAnswerFilesIdArray = explode(",",$removedAnswerFilesIdArray);

        foreach($exercise->answer_files as $answerFile) {
            if(in_array($answerFile->id, $removedAnswerFilesIdArray)) {
                AnswerFile::destroy($answerFile->id);
            }
        }
    }

    return redirect('/exercises/'.$exercise->slug);
});

Route::post('/exercises/save-exercise', function(Request $request) {
    $validator = Validator::make($request->all(), [
        'title' => 'required|unique:tasks'
    ]);

    if($validator->fails()) {
        return redirect('exercises/create')
                    ->withErrors($validator)
                    ->withInput();
    }

    $exercise = new Exercise;

    $exercise->title = $request->input('title');
    $exercise->description = $request->input('description');
    $exercise->slug = str_slug($request->input('solution-title'), '-') . '-' . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 10);
    $exercise->brief = $request->input('brief');
    $exercise->task_id = $request->input('task');
    $exercise->solution_title = $request->input('solution-title');
    $exercise->solution_description = $request->input('solution-description');
    $exercise->duration = $request->input('duration');

    if($request->file('thumbnail')) {
        $exercise->thumbnail = $request->file('thumbnail')->getClientOriginalName();
        $exercise->url = Storage::disk('gcs')->put('/thumbnails', $request->file('thumbnail'), 'public');
    }

    $exercise->save();

    if($request->file('file')) {
        for($fileCounter = 0; $fileCounter < count($request->file('file')); $fileCounter++) {

            $exerciseFile = new ExerciseFile;

            $exerciseFile->title = $request->file('file')[$fileCounter]->getClientOriginalName();
            $exerciseFile->size = $request->file('file')[$fileCounter]->getSize();
            $exerciseFile->url = Storage::disk('gcs')->put('/assets', $request->file('file')[$fileCounter], 'public');
            $exerciseFile->mime_type = $request->file('file')[$fileCounter]->getMimeType();
            $exerciseFile->exercise_id = $exercise->id;

            $exerciseFile->save();
        }
    }

    if($request->file('answerFile')) {
        for($fileCounter = 0; $fileCounter < count($request->file('answerFile')); $fileCounter++) {

            $answerFile = new AnswerFile;

            $answerFile->title = $request->file('answerFile')[$fileCounter]->getClientOriginalName();
            $answerFile->size = $request->file('answerFile')[$fileCounter]->getSize();
            $answerFile->url = Storage::disk('gcs')->put('/assets', $request->file('answerFile')[$fileCounter], 'public');
            $answerFile->mime_type = $request->file('answerFile')[$fileCounter]->getMimeType();
            $answerFile->exercise_id = $exercise->id;

            $answerFile->save();
        }
    }

    return redirect('/exercises/'.$exercise->slug);
});

Route::get('/tasks/select-category', function() {
    if(request('category') != null) {
        $categoryId = request('category');
        if($categoryId == "Nil") {
            return redirect('/tasks/select-category')->with('selectCategorySelected', 'Please select a category.');
        }
        session(['selectedCategory' => $categoryId]);

        return redirect('/tasks/create')->with('selectedCategory', session('selectedCategory'));
    }
    $categories = Category::orderBy('title', 'asc')->get();

    return view('tasks.selectCategory', [
        'categories' => $categories,
        'parameter' => 'task',
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::post('/tasks/select-category', function() {
    if(request('category') != null) {
        $categoryId = request('category');
        if($categoryId == "Nil") {
            return redirect('/tasks/select-category')->with('selectCategorySelected', 'Please select a category.');
        }
        session(['selectedCategory' => $categoryId]);

        return redirect('/tasks/create')->with('selectedCategory', session('selectedCategory'));
    }
    $categories = Category::orderBy('title', 'asc')->get();

    return view('tasks.selectCategory', [
        'categories' => $categories,
        'parameter' => 'task',
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
});

Route::get('/projects/select-role', 'ProjectsController@selectRole');
Route::post('/projects/select-role', 'ProjectsController@selectRole');

Route::post('/settings/authentication', function(Request $request) {
    $user = Auth::user();

    $validator = Validator::make($request->all(), [
        'password-current' => 'required',
        'password-new' => 'required',
        'password-new-confirm' => 'required'
    ]);


    if($validator->fails()) {
        return redirect('/settings/authentication')
                    ->withErrors($validator)
                    ->withInput();
    } else {
        $userdata = array(
            'email'     => $user->email,
            'password'  => Input::get('password-current')
        );

        if(Auth::attempt($userdata)) {
            $newPassword = Input::get('password-new');
            $newPasswordConfirm = Input::get('password-new-confirm');

            if($newPassword == $newPasswordConfirm) {
                $user->password = Hash::make($newPassword);
                $user->save();

                return redirect('settings/authentication')->with('success', 'Password updated.');
            } else {
                return redirect('settings/authentication')->with('error', 'The new password and the new password confirmation do not match.');
            }
        } else {
            return redirect('settings/authentication')->with('error', 'The username and current password entered do not match.');
        }
    }
})->middleware('auth');

Route::get('/settings/authentication', function() {
    $user = Auth::user();

    return view('settings.authentication', [
        'user' => $user,
        
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::get('/settings', function() {
    $user = Auth::user();

    return view('settings.profile', [
        'user' => $user,
        
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
    ]);
})->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('ajaxRequest', 'HomeController@ajaxRequest');

Route::post('ajaxRequest', 'HomeController@ajaxRequestPost');

Route::get('/ola', function() {
    $pusher = App::make('pusher');

    $pusher->trigger('purchases_1', 'new-purchase', array('username' => 'Shazwi', 'message' => 'just purchased your project: blah blah'));
});

Route::get('/messages/{userId}/projects/{projectId}', 'MessagesController@showIndividualProjectChannel');

Route::get('/messages/{userId}', 'MessagesController@showIndividualChannel');

Route::get('/roles/{roleSlug}/projects/{projectSlug}/{userId}/review', 'ReviewsController@leaveReview');
Route::get('/roles/{roleSlug}/projects/{projectSlug}/review', 'ReviewsController@leaveReview');

Route::post('/roles/{roleSlug}/projects/{projectSlug}/{userId}/review', 'ReviewsController@submitReview');
Route::post('/roles/{roleSlug}/projects/{projectSlug}/review', 'ReviewsController@submitReview');

Route::get('/roles/{roleSlug}/projects/{projectSlug}/tasks', 'ProjectsController@showTasks');
Route::get('/roles/{roleSlug}/projects/{projectSlug}/workspace/{workspacePostId}', 'ProjectsController@showWorkspacePost');
Route::get('/roles/{roleSlug}/projects/{projectSlug}/workspace', 'ProjectsController@showWorkspace');
Route::get('/roles/{roleSlug}/projects/{projectSlug}/{userId}/workspace/{workspacePostId}', 'ProjectsController@showIndividualWorkspacePost');
Route::get('/roles/{roleSlug}/projects/{projectSlug}/{userId}/workspace', 'ProjectsController@showIndividualWorkspace');
Route::post('/roles/{roleSlug}/projects/{projectSlug}/{userId}/workspace/{workspacePostId}', 'ProjectsController@submitWorkspacePost');
Route::post('/roles/{roleSlug}/projects/{projectSlug}/{userId}/workspace', 'ProjectsController@submitWorkspacePost');
Route::post('/roles/{roleSlug}/projects/{projectSlug}/workspace/{workspacePostId}', 'ProjectsController@submitWorkspacePost');
Route::post('/roles/{roleSlug}/projects/{projectSlug}/workspace', 'ProjectsController@submitWorkspacePost');
Route::get('/roles/{roleSlug}/projects/{projectSlug}/files', 'ProjectsController@showFiles');
Route::get('/roles/{roleSlug}/projects/{projectSlug}/competencies', 'ProjectsController@showCompetencies');

Route::post('/projects/publish-project', 'ProjectsController@publishProject');
Route::post('/projects/save-project', 'ProjectsController@saveProject');
Route::post('/roles/{roleSlug}/projects/{projectSlug}/clone', 'ProjectsController@cloneProject');
Route::post('/roles/{roleSlug}/projects/{projectSlug}/toggle-visibility-project', 'ProjectsController@toggleVisibilityProject');
Route::post('/roles/{roleSlug}/projects/{projectSlug}/submit-project-attempt', 'ProjectsController@submitProjectAttempt');
Route::post('/roles/{roleSlug}/projects/{projectSlug}/purchase-project', 'ProjectsController@purchaseProject');
Route::post('/roles/{roleSlug}/projects/{projectSlug}/add-project-to-inventory', 'ProjectsController@addProjectToInventory')->middleware('auth');
Route::post('/roles/{roleSlug}/projects/{projectSlug}/save-project', 'ProjectsController@saveChanges');
Route::get('/roles/{roleSlug}/projects/{projectSlug}/edit', 'ProjectsController@edit')->middleware('auth');
Route::get('/roles/{roleSlug}/projects/{projectSlug}/attempt', 'ProjectsController@attempt')->middleware('auth');
Route::post('/roles/{roleSlug}/projects/{projectSlug}/{userId}/tasks', 'ProjectsController@submitTasksReview')->middleware('auth');
Route::post('/roles/{roleSlug}/projects/{projectSlug}/{userId}/competencies', 'ProjectsController@submitCompetenciesReview')->middleware('auth');


Route::get('/roles/{roleSlug}/projects/{projectSlug}/{userId}/tasks', 'ProjectsController@reviewTasks')->middleware('auth');
Route::get('/roles/{roleSlug}/projects/{projectSlug}/{userId}/files', 'ProjectsController@reviewFiles')->middleware('auth');
Route::get('/roles/{roleSlug}/projects/{projectSlug}/{userId}/competencies', 'ProjectsController@reviewCompetencies')->middleware('auth');
Route::get('/roles/{roleSlug}/projects/{projectSlug}/{userId}', 'ProjectsController@review')->middleware('auth');


Route::get('/roles/{roleSlug}/projects/{projectSlug}', 'ProjectsController@show');

    
Route::post('/notifications/notify', 'NotificationController@postNotify');

Route::get('/companies/{companySlug}/add-opportunity', 'OpportunitiesController@create');

Route::get('/companies/{companySlug}/edit', function() {
    if(Auth::user() && Auth::user()->admin) {
        $routeParameters = Route::getCurrentRoute()->parameters();

        $company = Company::where('slug', $routeParameters['companySlug'])->first();

        return view('companies.edit', [
            'company' => $company,
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    } else {
        return redirect('/companies/'.$routeParameters['companySlug']);
    }
})->middleware('auth');

Route::resources([
    'companies' => 'CompaniesController',
    'roles' => 'RolesController',
    'messages' => 'MessagesController',
    'projects' => 'ProjectsController',
    'notifications' => 'NotificationController',
]);

Route::get('/templates/upload', 'TemplatesController@upload');
Route::get('/templates/{templateId}', 'TemplatesController@show');
Route::post('/templates/upload', 'TemplatesController@uploadFile');
Route::get('/templates', 'TemplatesController@index');

Route::post('/', function(Request $request) {
    if($request->input('attemptedProjectId')) {
        $attemptedProject = AttemptedProject::find($request->input('attemptedProjectId'));

        $attemptedProject->added = !$attemptedProject->added;

        $attemptedProject->save();

        return redirect('/');
    }
});

Route::get('/', function() {

    return view('index', [
        'roles' => Role::all(),
        'parameter' => 'index',
        'parameter' => 'none',
        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
    ]);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
