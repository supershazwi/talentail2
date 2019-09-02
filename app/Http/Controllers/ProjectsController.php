<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use App\Project;
use App\Review;
use App\AttemptedProject;
use App\AnsweredTask;
use App\AnsweredTaskFile;
use App\Task;
use App\Answer;
use App\WorkspacePost;
use App\WorkspacePostFile;
use App\CommentFile;
use App\Comment;
use App\ProjectFile;
use App\Role;
use App\Industry;
use App\RoleGained;
use App\ShoppingCart;
use App\ShoppingCartLineItem;
use App\Competency;
use App\CompetencyScore;
use App\Message;
use App\User;
use App\CompetencyAndTaskReview;
use App\Notification;
use App\ReviewedAnsweredTaskFile;

use App\Mail\SendProjectSubmittedMail;
use App\Mail\SendProjectReviewedMail;
use Illuminate\Support\Facades\Mail;

use Validator;

class ProjectsController extends Controller
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

    public function index() {
        $role = Role::where('slug', 'business-analyst')->first();
        $projects = Project::orderBy('updated_at', 'desc')->paginate(10);

        return view('attempt.index', [
            
            'parameter' => 'discover',
            'projects' => $projects,
            'role' => $role,
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    }

    public function showWorkspace() {
        $loggedInUserId = Auth::id();

        $routeParameters = Route::getCurrentRoute()->parameters();
        $role = Role::select('id', 'title', 'slug')->where('slug', $routeParameters['roleSlug'])->get()[0];
        $project = Project::where([['slug', '=', $routeParameters['projectSlug']], ['role_id', '=', $role->id]])->get()[0];

        $attemptedProject = AttemptedProject::where('user_id', Auth::id())->where('project_id', $project->id)->first();

        $workspacePosts = WorkspacePost::where('attempted_project_id', $attemptedProject->id)->orderBy('created_at', 'desc')->get();

        $workspacePostArray = array();

        foreach($workspacePosts as $workspacePost) {
            array_push($workspacePostArray, $workspacePost->id);
        }

        return view('projects.workspace', [
            'workspacePostArray' => implode(",", $workspacePostArray),
            'project' => $project,
            'role' => $role,
            'workspacePosts' => $workspacePosts,
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    }

    public function showWorkspacePost() {
        $routeParameters = Route::getCurrentRoute()->parameters();
        $role = Role::select('id', 'title', 'slug')->where('slug', $routeParameters['roleSlug'])->get()[0];
        $project = Project::where([['slug', '=', $routeParameters['projectSlug']], ['role_id', '=', $role->id]])->get()[0];

        $attemptedProject = AttemptedProject::where('user_id', Auth::id())->where('project_id', $project->id)->first();

        $workspacePost = WorkspacePost::find($routeParameters['workspacePostId']);

        return view('projects.workspacePost', [
            'project' => $project,
            'workspacePost' => $workspacePost,
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    }

    public function showIndividualWorkspacePost() {
        $routeParameters = Route::getCurrentRoute()->parameters();
        $role = Role::select('id', 'title', 'slug')->where('slug', $routeParameters['roleSlug'])->get()[0];
        $project = Project::where([['slug', '=', $routeParameters['projectSlug']], ['role_id', '=', $role->id]])->get()[0];

        $attemptedProject = AttemptedProject::where('user_id', $routeParameters['userId'])->where('project_id', $project->id)->first();

        $workspacePost = WorkspacePost::find($routeParameters['workspacePostId']);

        return view('projects.individualWorkspacePost', [
            'project' => $project,
            'attemptedProject' => $attemptedProject,
            'workspacePost' => $workspacePost,
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    }

    public function showIndividualWorkspace() {
        $routeParameters = Route::getCurrentRoute()->parameters();
        $role = Role::select('id', 'title', 'slug')->where('slug', $routeParameters['roleSlug'])->get()[0];
        $project = Project::where([['slug', '=', $routeParameters['projectSlug']], ['role_id', '=', $role->id]])->get()[0];

        $attemptedProject = AttemptedProject::where('user_id', $routeParameters['userId'])->where('project_id', $project->id)->first();

        $workspacePosts = WorkspacePost::where('attempted_project_id', $attemptedProject->id)->orderBy('created_at', 'desc')->get();

        $workspacePostArray = array();

        foreach($workspacePosts as $workspacePost) {
            array_push($workspacePostArray, $workspacePost->id);
        }

        return view('projects.showIndividualWorkspace', [
            'attemptedProject' => $attemptedProject,
            'workspacePostArray' => implode(",", $workspacePostArray),
            'project' => $project,
            'role' => $role,
            'workspacePosts' => $workspacePosts,
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    }

    public function submitWorkspacePost(Request $request) {
        $loggedInUserId = Auth::id();

        $routeParameters = Route::getCurrentRoute()->parameters();
        $role = Role::select('id', 'title', 'slug')->where('slug', $routeParameters['roleSlug'])->get()[0];
        $project = Project::where([['slug', '=', $routeParameters['projectSlug']], ['role_id', '=', $role->id]])->get()[0];

        if(!empty($routeParameters['userId'])) {
            $attemptedProject = AttemptedProject::where('user_id', $routeParameters['userId'])->where('project_id', $project->id)->first();
        } else {
            $attemptedProject = AttemptedProject::where('user_id', Auth::id())->where('project_id', $project->id)->first();
        }

        if($request->input('type') == "comment") {
            $commentLatestId = Comment::where('workspace_post_id', $request->input('workspacePostId'))->orderBy('id', 'desc')->first();
        
            $comment = new Comment;

            $comment->content = $request->input('content');
            $comment->user_id = Auth::id();
            $comment->workspace_post_id = $request->input('workspacePostId');

            $comment->save();

            $workspacePosts = WorkspacePost::where('attempted_project_id', $attemptedProject->id)->get();

            foreach($workspacePosts as $workspacePost) {
                if($request->file('workspacePost_'.$workspacePost->id)) {
                    for($fileCounter = 0; $fileCounter < count($request->file('workspacePost_'.$workspacePost->id)); $fileCounter++) {

                        $commentFile = new CommentFile;

                        $commentFile->title = $request->file('workspacePost_'.$workspacePost->id)[$fileCounter]->getClientOriginalName();
                        $commentFile->size = $request->file('workspacePost_'.$workspacePost->id)[$fileCounter]->getSize();
                        $commentFile->url = Storage::disk('gcs')->put('/assets', $request->file('workspacePost_'.$workspacePost->id)[$fileCounter], 'public');
                        $commentFile->mime_type = $request->file('workspacePost_'.$workspacePost->id)[$fileCounter]->getMimeType();
                        $commentFile->workspace_post_id = $request->input('workspacePostId');
                        $commentFile->comment_id = $comment->id;
                        $commentFile->attempted_project_id = $attemptedProject->id;
                        $commentFile->user_id = Auth::id();

                        $commentFile->save();
                    }
                }
            }

            // if i own the post
            $notification = new Notification;
            $notification->message = "commented on the post: " . $comment->workspace_post->content;
            if(!empty($routeParameters['userId'])) {
                $notification->recipient_id = $comment->workspace_post->user_id;
                $notification->url = "/roles/" . $attemptedProject->project->role->slug . "/projects/" . $attemptedProject->project->slug ."/workspace/" . $request->input('workspacePostId');
            } else {
                $notification->recipient_id = 1;
                $notification->url = "/roles/" . $attemptedProject->project->role->slug . "/projects/" . $attemptedProject->project->slug . "/" . $attemptedProject->user_id . "/workspace/" . $request->input('workspacePostId');
            }
            $notification->user_id = Auth::id();
            $notification->save();
        } else {
            $workspacePostLatestId = WorkspacePost::where('attempted_project_id', $attemptedProject->id)->orderBy('id', 'desc')->first();

            $workspacePost = new WorkspacePost;

            $workspacePost->content = $request->input('content');
            $workspacePost->user_id = Auth::id();
            $workspacePost->attempted_project_id = $attemptedProject->id;

            if($workspacePostLatestId == null) {
                $workspacePost->url = '/roles/'.$project->role->slug.'/projects/'.$project->slug.'/workspace/1';
            } else {
                $workspacePost->url = '/roles/'.$project->role->slug.'/projects/'.$project->slug.'/workspace/'.($workspacePostLatestId->id+1);
            }

            $workspacePost->save();

            if($request->file('file-1')) {
                for($fileCounter = 0; $fileCounter < count($request->file('file-1')); $fileCounter++) {

                    $workspacePostFile = new WorkspacePostFile;

                    $workspacePostFile->title = $request->file('file-1')[$fileCounter]->getClientOriginalName();
                    $workspacePostFile->size = $request->file('file-1')[$fileCounter]->getSize();
                    $workspacePostFile->url = Storage::disk('gcs')->put('/assets', $request->file('file-1')[$fileCounter], 'public');
                    $workspacePostFile->mime_type = $request->file('file-1')[$fileCounter]->getMimeType();
                    $workspacePostFile->workspace_post_id = $workspacePost->id;
                    $workspacePostFile->attempted_project_id = $attemptedProject->id;
                    $workspacePostFile->user_id = Auth::id();

                    $workspacePostFile->save();
                }
            }

            $notification = new Notification;
            $notification->message = "submitted a post: " . $workspacePost->content;
            if(!empty($routeParameters['userId'])) {
                $notification->recipient_id = $comment->workspace_post->user_id;
                $notification->url = "/roles/" . $attemptedProject->project->role->slug . "/projects/" . $attemptedProject->project->slug ."/workspace/" . $workspacePost->id;
            } else {
                $notification->recipient_id = 1;
                $notification->url = "/roles/" . $attemptedProject->project->role->slug . "/projects/" . $attemptedProject->project->slug . "/" . $attemptedProject->user_id . "/workspace/" . $workspacePost->id;
            }
            $notification->user_id = Auth::id();
            $notification->save();
        }

        if(!empty($routeParameters['userId'])) {
            if(!empty($routeParameters['workspacePostId'])) {
                return redirect('/roles/'.$project->role->slug.'/projects/'.$project->slug.'/'.$attemptedProject->user_id.'/workspace/'.$routeParameters['workspacePostId']);
            } else {
                return redirect('/roles/'.$project->role->slug.'/projects/'.$project->slug.'/'.$attemptedProject->user_id.'/workspace');
            }
        } else {
            if(!empty($routeParameters['workspacePostId'])) {
                return redirect('/roles/'.$project->role->slug.'/projects/'.$project->slug.'/workspace/'.$routeParameters['workspacePostId']);
            } else {
                return redirect('/roles/'.$project->role->slug.'/projects/'.$project->slug.'/workspace');
            }
        }
    }

    public function submitTasksReview(Request $request) {
        $loggedInUserId = Auth::id();

        $routeParameters = Route::getCurrentRoute()->parameters();
        $role = Role::select('id', 'title', 'slug')->where('slug', $routeParameters['roleSlug'])->get()[0];
        $project = Project::where([['slug', '=', $routeParameters['projectSlug']], ['role_id', '=', $role->id]])->get()[0];

        // check if role already gained
        $roleHasBeenGained = RoleGained::where('role_id', $role->id)->where('user_id', $routeParameters['userId'])->first();

        if(!$roleHasBeenGained) {
            $roleGained = new RoleGained;

            $roleGained->role_id = $role->id;
            $roleGained->user_id = $routeParameters['userId'];
            $roleGained->project_id = $project->id;

            $roleGained->save();
        }

        $answeredTasks = AnsweredTask::where('project_id', $project->id)->where('user_id', $routeParameters['userId'])->orderBy('task_id', 'asc')->get();

        $answeredTasksArray = $answeredTasks->toArray();

        foreach($answeredTasksArray as $key=>$answeredTask) {
            $answeredTaskToReview = AnsweredTask::find($answeredTask['id']);

            $answeredTaskToReview->response = $request->input("response_" . $answeredTask['id']);
            $answeredTaskToReview->save();

            if($request->file('file_' . $answeredTask['id'])) {
                for($fileCounter = 0; $fileCounter < count($request->file('file_' . $answeredTask['id'])); $fileCounter++) {

                    $reviewedAnsweredTaskFile = new ReviewedAnsweredTaskFile;

                    $reviewedAnsweredTaskFile->title = $request->file('file_' . $answeredTask['id'])[$fileCounter]->getClientOriginalName();
                    $reviewedAnsweredTaskFile->size = $request->file('file_' . $answeredTask['id'])[$fileCounter]->getSize();
                    $reviewedAnsweredTaskFile->url = Storage::disk('gcs')->put('/assets', $request->file('file_' . $answeredTask['id'])[$fileCounter], 'public');
                    $reviewedAnsweredTaskFile->mime_type = $request->file('file_' . $answeredTask['id'])[$fileCounter]->getMimeType();
                    $reviewedAnsweredTaskFile->answered_task_id = $answeredTask['id'];
                    $reviewedAnsweredTaskFile->project_id = $project->id;
                    $reviewedAnsweredTaskFile->user_id = Auth::id();

                    $reviewedAnsweredTaskFile->save();
                }
            }

            // check if any files deleted
            $removedFilesIdArray = $request->input('files-deleted_'.$answeredTask['id']);

            if($removedFilesIdArray != null) {
                $removedFilesIdArray = explode(",",$removedFilesIdArray);
                foreach($removedFilesIdArray as $removedFileId) {
                    ReviewedAnsweredTaskFile::destroy($removedFileId);
                }
            }

            $answeredTasksArray[$key] = $answeredTask['id'];
        }

        // check if both tasks and competencies are reviewed
        $attemptedProject = AttemptedProject::where('project_id', $project->id)->where('user_id', $routeParameters['userId'])->first();

        if($request->input('submissionType') == "Submit") {
            $competencyAndTaskReview = CompetencyAndTaskReview::where('attempted_project_id', $attemptedProject->id)->first();
            $competencyAndTaskReview->tasks_reviewed = 1;
            $competencyAndTaskReview->save();

            if($competencyAndTaskReview->tasks_reviewed && $competencyAndTaskReview->competencies_reviewed) {
                // update attempted project

                $attemptedProject->status = "Assessed";

                $attemptedProject->save();

                $notification = new Notification;

                $notification->message = "submitted reviews to your answers for project: " . $attemptedProject->project->title;
                $notification->recipient_id = $attemptedProject->user_id;
                $notification->user_id = Auth::id();
                $notification->url = "/roles/" . $attemptedProject->project->role->slug . "/projects/" . $attemptedProject->project->slug;

                $notification->save();

                $message = [
                    'text' => e("submitted reviews to your answers for project: " . $attemptedProject->project->title),
                    'username' => Auth::user()->name,
                    'avatar' => Auth::user()->avatar,
                    'timestamp' => (time()*1000),
                    'projectId' => $attemptedProject->project->id,
                    'url' => '/notifications'
                ];

                $this->pusher->trigger('notifications_' . $attemptedProject->user_id, 'new-notification', $message);

                Mail::to($attemptedProject->user->email)->send(new SendProjectReviewedMail(Auth::user()->name, $attemptedProject->project->user->name, $attemptedProject->project->title, "https://talentail.com/roles/" . $attemptedProject->project->role->slug . "/projects/" . $attemptedProject->project->slug));

                return redirect('/roles/'.$project->role->slug.'/projects/'.$project->slug.'/'.$routeParameters['userId']);
            } else {
                return redirect('/roles/'.$project->role->slug.'/projects/'.$project->slug.'/'.$routeParameters['userId'].'/tasks')->with('saved', "Review saved!");
            }
        } else {
            return redirect('/roles/'.$project->role->slug.'/projects/'.$project->slug.'/'.$routeParameters['userId'].'/tasks')->with('saved', "Review saved!");
        }
    }

    public function submitCompetenciesReview(Request $request) {

        $loggedInUserId = Auth::id();

        $routeParameters = Route::getCurrentRoute()->parameters();
        $role = Role::select('id', 'title', 'slug')->where('slug', $routeParameters['roleSlug'])->get()[0];
        $project = Project::where([['slug', '=', $routeParameters['projectSlug']], ['role_id', '=', $role->id]])->get()[0];

        // role gained
        $roleHasBeenGained = RoleGained::where('role_id', $role->id)->where('user_id', $routeParameters['userId'])->first();

        if(!$roleHasBeenGained) {
            $roleGained = new RoleGained;

            $roleGained->role_id = $role->id;
            $roleGained->user_id = $routeParameters['userId'];
            $roleGained->project_id = $project->id;

            $roleGained->save();
        }

        $attemptedProject = AttemptedProject::find($request->input('attemptedProjectId'));

        foreach($attemptedProject->competency_scores as $competencyScore) {
            if($request->input('rating_' . $competencyScore->id) != null) {
                if($request->input('rating_' . $competencyScore->id) == "Poor") {
                    $competencyScore->score = 1;
                } elseif($request->input('rating_' . $competencyScore->id) == "Fair") {
                    $competencyScore->score = 2;
                } elseif($request->input('rating_' . $competencyScore->id) == "Average") {
                    $competencyScore->score = 3;
                } elseif($request->input('rating_' . $competencyScore->id) == "Good") {
                    $competencyScore->score = 4;
                } else {
                    $competencyScore->score = 5;
                }
                $competencyScore->save();
            }
        }

        if($request->input('submissionType') == "Submit") {
            $competencyAndTaskReview = CompetencyAndTaskReview::where('attempted_project_id', $attemptedProject->id)->first();

            $competencyAndTaskReview->competencies_reviewed = 1;
            $competencyAndTaskReview->save();

            if($competencyAndTaskReview->tasks_reviewed && $competencyAndTaskReview->competencies_reviewed) {
                // update attempted project

                $attemptedProject->status = "Assessed";

                $attemptedProject->save();

                $notification = new Notification;

                $notification->message = "submitted reviews to your answers for project: " . $attemptedProject->project->title;
                $notification->recipient_id = $attemptedProject->user_id;
                $notification->user_id = Auth::id();
                $notification->url = "/roles/" . $attemptedProject->project->role->slug . "/projects/" . $attemptedProject->project->slug;

                $notification->save();

                $message = [
                    'text' => e("submitted reviews to your answers for project: " . $attemptedProject->project->title),
                    'username' => Auth::user()->name,
                    'avatar' => Auth::user()->avatar,
                    'timestamp' => (time()*1000),
                    'projectId' => $attemptedProject->project->id,
                    'url' => '/notifications'
                ];

                $this->pusher->trigger('notifications_' . $attemptedProject->user_id, 'new-notification', $message);

                Mail::to($attemptedProject->user->email)->send(new SendProjectReviewedMail(Auth::user()->name, $attemptedProject->project->user->name, $attemptedProject->project->title, "https://talentail.com/roles/" . $attemptedProject->project->role->slug . "/projects/" . $attemptedProject->project->slug));

                return redirect('/roles/'.$project->role->slug.'/projects/'.$project->slug.'/'.$routeParameters['userId']);
            } else {
                return redirect('/roles/'.$project->role->slug.'/projects/'.$project->slug.'/'.$routeParameters['userId'].'/competencies')->with('saved', "Review saved!");
            }
        } else {
            return redirect('/roles/'.$project->role->slug.'/projects/'.$project->slug.'/'.$routeParameters['userId'].'/competencies')->with('saved', "Review saved!");
        }
    }

    public function reviewFiles() {
        $loggedInUserId = Auth::id();

        $routeParameters = Route::getCurrentRoute()->parameters();

        if(Auth::id() == $routeParameters['userId']) {
            return redirect('/roles/'.$project->role->slug.'/projects/'.$project->slug);
        } else {
            $role = Role::select('id', 'title', 'slug')->where('slug', $routeParameters['roleSlug'])->get()[0];
            $project = Project::where([['slug', '=', $routeParameters['projectSlug']], ['role_id', '=', $role->id]])->get()[0];

            $clickedUserId = $project->user_id;

            $subscribeString;

            if($loggedInUserId < $clickedUserId) {
                $subscribeString = $loggedInUserId . "_" . $clickedUserId;
            } else {
                $subscribeString = $clickedUserId . "_" . $loggedInUserId;   
            }

            $messages1 = Message::where('sender_id', $loggedInUserId)->where('recipient_id', $clickedUserId)->where('project_id', $project->id)->get();
            $messages2 = Message::where('sender_id', $clickedUserId)->where('recipient_id', $loggedInUserId)->where('project_id', $project->id)->get();
            $messages3 = $messages1->merge($messages2);

            $messages3 = $messages3->sortBy('created_at');

            $answeredTasks = AnsweredTask::where('project_id', $project->id)->where('user_id', $routeParameters['userId'])->orderBy('task_id', 'asc')->get();

            $answeredTasksArray = $answeredTasks->toArray();

            $attemptedProject = AttemptedProject::where('project_id', $project->id)->where('user_id', $routeParameters['userId'])->first();

            $competencyScores = CompetencyScore::where('role_gained_id', $role->id)->where('project_id', $project->id)->where('user_id', $routeParameters['userId'])->get();

            foreach($answeredTasksArray as $key=>$answeredTask) {
                $answeredTasksArray[$key] = $answeredTask['id'];
            }

            $competencyAndTaskReview = CompetencyAndTaskReview::where('attempted_project_id', $attemptedProject->id)->first();

            $competencyAndTaskMessages = array();

            $tasksReviewed = false;
            $competenciesReviewed = false;

            if(!$competencyAndTaskReview->competencies_reviewed) {
                array_push($competencyAndTaskMessages, 'Competencies');
            } else {
                $competenciesReviewed = true;
            }

            if(!$competencyAndTaskReview->tasks_reviewed) {
                array_push($competencyAndTaskMessages, 'Tasks');
            } else {
                $tasksReviewed = true;
            }

            $reviewLeftByCreator = Review::where('project_id', $project->id)->where('sender_id', $project->user_id)->first();

            return view('projects.review', [
                'project' => $project,
                'role' => $role,
                'tasksReviewed' => $tasksReviewed,
                'reviewLeftByCreator' => $reviewLeftByCreator,
                'competenciesReviewed' => $competenciesReviewed,
                'messages' => $messages3,
                'competencyAndTaskMessages' => $competencyAndTaskMessages,
                'parameter' => 'file',
                'attemptedProject' => $attemptedProject,
                'answeredTasks' => $answeredTasks,
                'answeredTasksArray' => $answeredTasksArray,
                'competencyScores' => $competencyScores,
                'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                'clickedUserId' => $clickedUserId,
                'reviewedUserId' => $routeParameters['userId'],
                'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
            ]);
        }
    }

    public function reviewCompetencies() {
        $loggedInUserId = Auth::id();

        $routeParameters = Route::getCurrentRoute()->parameters();

        if(Auth::id() == $routeParameters['userId']) {
            return redirect('/roles/'.$project->role->slug.'/projects/'.$project->slug);
        } else {
            $role = Role::select('id', 'title', 'slug')->where('slug', $routeParameters['roleSlug'])->get()[0];
            $project = Project::where([['slug', '=', $routeParameters['projectSlug']], ['role_id', '=', $role->id]])->get()[0];

            $clickedUserId = $project->user_id;

            $subscribeString;

            if($loggedInUserId < $clickedUserId) {
                $subscribeString = $loggedInUserId . "_" . $clickedUserId;
            } else {
                $subscribeString = $clickedUserId . "_" . $loggedInUserId;   
            }

            $messages1 = Message::where('sender_id', $loggedInUserId)->where('recipient_id', $clickedUserId)->where('project_id', $project->id)->get();
            $messages2 = Message::where('sender_id', $clickedUserId)->where('recipient_id', $loggedInUserId)->where('project_id', $project->id)->get();
            $messages3 = $messages1->merge($messages2);

            $messages3 = $messages3->sortBy('created_at');

            $answeredTasks = AnsweredTask::where('project_id', $project->id)->where('user_id', $routeParameters['userId'])->orderBy('task_id', 'asc')->get();

            $answeredTasksArray = $answeredTasks->toArray();

            $attemptedProject = AttemptedProject::where('project_id', $project->id)->where('user_id', $routeParameters['userId'])->first();

            $competencyScores = CompetencyScore::where('role_gained_id', $role->id)->where('project_id', $project->id)->where('user_id', $routeParameters['userId'])->get();

            foreach($answeredTasksArray as $key=>$answeredTask) {
                $answeredTasksArray[$key] = $answeredTask['id'];
            }

            $competencyAndTaskReview = CompetencyAndTaskReview::where('attempted_project_id', $attemptedProject->id)->first();

            $competencyAndTaskMessages = array();

            $tasksReviewed = false;
            $competenciesReviewed = false;

            if(!$competencyAndTaskReview->competencies_reviewed) {
                array_push($competencyAndTaskMessages, 'Competencies');
            } else {
                $competenciesReviewed = true;
            }

            if(!$competencyAndTaskReview->tasks_reviewed) {
                array_push($competencyAndTaskMessages, 'Tasks');
            } else {
                $tasksReviewed = true;
            }

            $reviewLeftByCreator = Review::where('project_id', $project->id)->where('sender_id', $project->user_id)->first();

            return view('projects.review', [
                
                'project' => $project,
                'role' => $role,
                'tasksReviewed' => $tasksReviewed,
                'reviewLeftByCreator' => $reviewLeftByCreator,
                'competenciesReviewed' => $competenciesReviewed,
                'competencyAndTaskMessages' => $competencyAndTaskMessages,
                'messages' => $messages3,
                'parameter' => 'competency',
                'attemptedProject' => $attemptedProject,
                'answeredTasks' => $answeredTasks,
                'answeredTasksArray' => $answeredTasksArray,
                'competencyScores' => $competencyScores,
                'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                'clickedUserId' => $clickedUserId,
                'reviewedUserId' => $routeParameters['userId'],
                'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
            ]);
        }
    }

    public function reviewTasks() {
        $loggedInUserId = Auth::id();

        $routeParameters = Route::getCurrentRoute()->parameters();

        if(Auth::id() == $routeParameters['userId']) {
            return redirect('/roles/'.$project->role->slug.'/projects/'.$project->slug);
        } else {
            $role = Role::select('id', 'title', 'slug')->where('slug', $routeParameters['roleSlug'])->get()[0];
            $project = Project::where([['slug', '=', $routeParameters['projectSlug']], ['role_id', '=', $role->id]])->get()[0];

            $clickedUserId = $project->user_id;

            $subscribeString;

            if($loggedInUserId < $clickedUserId) {
                $subscribeString = $loggedInUserId . "_" . $clickedUserId;
            } else {
                $subscribeString = $clickedUserId . "_" . $loggedInUserId;   
            }

            $messages1 = Message::where('sender_id', $loggedInUserId)->where('recipient_id', $clickedUserId)->where('project_id', $project->id)->get();
            $messages2 = Message::where('sender_id', $clickedUserId)->where('recipient_id', $loggedInUserId)->where('project_id', $project->id)->get();
            $messages3 = $messages1->merge($messages2);

            $messages3 = $messages3->sortBy('created_at');

            $answeredTasks = AnsweredTask::where('project_id', $project->id)->where('user_id', $routeParameters['userId'])->orderBy('task_id', 'asc')->get();

            $answeredTasksArray = $answeredTasks->toArray();

            $attemptedProject = AttemptedProject::where('project_id', $project->id)->where('user_id', $routeParameters['userId'])->first();

            $competencyScores = CompetencyScore::where('role_gained_id', $role->id)->where('project_id', $project->id)->where('user_id', $routeParameters['userId'])->get();

            foreach($answeredTasksArray as $key=>$answeredTask) {
                $answeredTasksArray[$key] = $answeredTask['id'];
            }

            $competencyAndTaskReview = CompetencyAndTaskReview::where('attempted_project_id', $attemptedProject->id)->first();

            $competencyAndTaskMessages = array();

            $tasksReviewed = false;
            $competenciesReviewed = false;

            if(!$competencyAndTaskReview->competencies_reviewed) {
                array_push($competencyAndTaskMessages, 'Competencies');
            } else {
                $competenciesReviewed = true;
            }

            if(!$competencyAndTaskReview->tasks_reviewed) {
                array_push($competencyAndTaskMessages, 'Tasks');
            } else {
                $tasksReviewed = true;
            }

            $reviewLeftByCreator = Review::where('project_id', $project->id)->where('sender_id', $project->user_id)->first();

            return view('projects.review', [
                
                'project' => $project,
                'role' => $role,
                'reviewLeftByCreator' => $reviewLeftByCreator,
                'tasksReviewed' => $tasksReviewed,
                'competenciesReviewed' => $competenciesReviewed,
                'messages' => $messages3,
                'competencyAndTaskMessages' => $competencyAndTaskMessages,
                'parameter' => 'task',
                'attemptedProject' => $attemptedProject,
                'answeredTasks' => $answeredTasks,
                'answeredTasksArray' => $answeredTasksArray,
                'competencyScores' => $competencyScores,
                'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                'clickedUserId' => $clickedUserId,
                'reviewedUserId' => $routeParameters['userId'],
                'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
            ]);
        }
    }

    public function review() {
        $routeParameters = Route::getCurrentRoute()->parameters();

        if(Auth::id() == $routeParameters['userId']) {
            return redirect('/roles/'.$project->role->slug.'/projects/'.$project->slug);
        } else {
            $loggedInUserId = Auth::id();

            $role = Role::select('id', 'title', 'slug')->where('slug', $routeParameters['roleSlug'])->get()[0];
            $project = Project::where([['slug', '=', $routeParameters['projectSlug']], ['role_id', '=', $role->id]])->get()[0];

            $clickedUserId = $project->user_id;

            // check whether user has submitted answers
            $projectHasBeenCompleted = AttemptedProject::where('user_id', $routeParameters['userId'])->where('project_id', $project->id)->where('status', '!=', 'Attempting')->first();

            $subscribeString;

            if($loggedInUserId < $clickedUserId) {
                $subscribeString = $loggedInUserId . "_" . $clickedUserId;
            } else {
                $subscribeString = $clickedUserId . "_" . $loggedInUserId;   
            }

            $messages1 = Message::where('sender_id', $loggedInUserId)->where('recipient_id', $clickedUserId)->where('project_id', $project->id)->get();
            $messages2 = Message::where('sender_id', $clickedUserId)->where('recipient_id', $loggedInUserId)->where('project_id', $project->id)->get();
            $messages3 = $messages1->merge($messages2);

            $messages3 = $messages3->sortBy('created_at');

            $attemptedProject = AttemptedProject::where('project_id', $project->id)->where('user_id', $routeParameters['userId'])->first();

            if($projectHasBeenCompleted) {

                $answeredTasks = AnsweredTask::where('project_id', $project->id)->where('user_id', $routeParameters['userId'])->orderBy('task_id', 'asc')->get();

                $answeredTasksArray = $answeredTasks->toArray();

                $competencyScores = CompetencyScore::where('role_gained_id', $role->id)->where('project_id', $project->id)->where('user_id', $routeParameters['userId'])->get();

                foreach($answeredTasksArray as $key=>$answeredTask) {
                    $answeredTasksArray[$key] = $answeredTask['id'];
                }

                $competencyAndTaskReview = CompetencyAndTaskReview::where('attempted_project_id', $attemptedProject->id)->first();

                $competencyAndTaskMessages = array();

                $tasksReviewed = false;
                $competenciesReviewed = false;

                if(!$competencyAndTaskReview->competencies_reviewed) {
                    array_push($competencyAndTaskMessages, 'Competencies');
                } else {
                    $competenciesReviewed = true;
                }

                if(!$competencyAndTaskReview->tasks_reviewed) {
                    array_push($competencyAndTaskMessages, 'Tasks');
                } else {
                    $tasksReviewed = true;
                }

                $reviewLeftByCreator = Review::where('project_id', $project->id)->where('sender_id', $project->user_id)->first();

                return view('projects.review', [
                    
                    'project' => $project,
                    'role' => $role,
                    'reviewLeftByCreator' => $reviewLeftByCreator,
                    'competenciesReviewed' => $competenciesReviewed,
                    'tasksReviewed' => $tasksReviewed,
                    'competencyAndTaskMessages' => $competencyAndTaskMessages,
                    'messages' => $messages3,
                    'parameter' => 'overview',
                    'attemptedProject' => $attemptedProject,
                    'answeredTasks' => $answeredTasks,
                    'answeredTasksArray' => $answeredTasksArray,
                    'competencyScores' => $competencyScores,
                    'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                    'clickedUserId' => $clickedUserId,
                    'reviewedUserId' => $routeParameters['userId'],
                    'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                ]);
            } else {
                return view('projects.inProgress', [
                    'project' => $project,
                    'attemptedProject' => $attemptedProject,
                    'role' => $role,
                    'parameter' => 'overview',
                    'messages' => $messages3,
                    'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                    'clickedUserId' => $clickedUserId,
                    'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                ]); 
            }
        }
    }

    public function submitProjectAttempt(Request $request) {
        // dd($request);
        $taskCounter = 1;

        while($request->input('task_' . $taskCounter) != null) {

            $answeredTask = AnsweredTask::where('task_id', $request->input('task_'.$taskCounter))->where('user_id', Auth::id())->where('project_id', $request->input('project_id'))->first();

            if($request->input('multiple-select_' . $taskCounter) == "true" && $request->input('answer_' . $taskCounter) != null) {
                $answeredTask->answer = implode(', ', $request->input('answer_' . $taskCounter));
            } else {
                if($request->input('answer_' . $request->input('task_' . $taskCounter))) {
                    $answeredTask->answer = $request->input('answer_' . $request->input('task_' . $taskCounter));
                } else {
                    $answeredTask->answer = "";
                }
            }
            $answeredTask->response = "";
            $answeredTask->user_id = Auth::id();
            $answeredTask->task_id = $request->input('task_' . $taskCounter);
            $answeredTask->project_id = $request->input('project_id');

            $answeredTask->save();

            $attemptedProject = AttemptedProject::where('project_id', $request->input('project_id'))->where('user_id', Auth::id())->first();

            // check if file upload is enabled
            if($request->input('file-upload_' . $taskCounter) == "true") {
                if($request->file('file_' . $request->input('task_' . $taskCounter))) {
                    for($fileCounter = 0; $fileCounter < count($request->file('file_' . $request->input('task_' . $taskCounter))); $fileCounter++) {

                        $answeredTaskFile = new AnsweredTaskFile;

                        $answeredTaskFile->title = $request->file('file_' . $request->input('task_' . $taskCounter))[$fileCounter]->getClientOriginalName();
                        $answeredTaskFile->size = $request->file('file_' . $request->input('task_' . $taskCounter))[$fileCounter]->getSize();
                        $answeredTaskFile->url = Storage::disk('gcs')->put('/assets', $request->file('file_' . $request->input('task_' . $taskCounter))[$fileCounter], 'public');
                        $answeredTaskFile->mime_type = $request->file('file_' . $request->input('task_' . $taskCounter))[$fileCounter]->getMimeType();
                        $answeredTaskFile->answered_task_id = $answeredTask->id;
                        $answeredTaskFile->project_id = $request->input('project_id');
                        $answeredTaskFile->attempted_project_id = $attemptedProject->id;
                        $answeredTaskFile->user_id = Auth::id();

                        $answeredTaskFile->save();
                    }
                }
            }

            // check if any files deleted
            $removedFilesIdArray = $request->input('files-deleted_'.$answeredTask->id);

            if($removedFilesIdArray != null) {
                $removedFilesIdArray = explode(",",$removedFilesIdArray);
                foreach($removedFilesIdArray as $removedFileId) {
                    AnsweredTaskFile::destroy($removedFileId);
                }
            }

            $taskCounter++;
        }

        if($request->input('submissionType') == "Submit") {
            $attemptedProject->status = "Completed";

            $attemptedProject->save();

            $notification = new Notification;

            $notification->message = "submitted answers for project: " . $attemptedProject->project->title;
            $notification->recipient_id = $attemptedProject->project->user_id;
            $notification->user_id = Auth::id();
            $notification->url = "/roles/" . $attemptedProject->project->role->slug . "/projects/" . $attemptedProject->project->slug . "/" . Auth::id();

            $notification->save();

            $message = [
                'text' => e("submitted answers for project: " . $attemptedProject->project->title),
                'username' => Auth::user()->name,
                'avatar' => Auth::user()->avatar,
                'timestamp' => (time()*1000),
                'projectId' => $attemptedProject->project->id,
                'url' => '/notifications'
            ];

            $this->pusher->trigger('notifications_' . $attemptedProject->project->user_id, 'new-notification', $message);

            Mail::to($attemptedProject->project->user->email)->send(new SendProjectSubmittedMail(Auth::user()->name, $attemptedProject->project->user->name, $attemptedProject->project->title, "https://talentail.com/roles/" . $attemptedProject->project->role->slug . "/projects/" . $attemptedProject->project->slug . "/" . Auth::id()));

            $competencyAndTaskReview = new CompetencyAndTaskReview;

            $competencyAndTaskReview->attempted_project_id = $attemptedProject->id;
            $competencyAndTaskReview->tasks_reviewed = 0;
            $competencyAndTaskReview->competencies_reviewed = 0;

            $competencyAndTaskReview->save();

            return redirect('/roles/'.$request->input('role_slug').'/projects/'.$request->input('project_slug').'/tasks');
        } else {
            return redirect('/roles/'.$request->input('role_slug').'/projects/'.$request->input('project_slug').'/tasks')->with('saved', 'Project saved!');
        }
        
    }

    public function toggleVisibilityProject(Request $request) {
        $project = Project::find($request->input('project_id'));

        // if it is not published and i want to publish it, i need to
        // check that all fields are in

        if(!$project->published) {
            // i need to validate all fields are in

            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'description' => 'required',
                'brief' => 'required',
                'hours' => 'required',
                'price' => 'required',
                'competency' => 'required',
            ]);


            if($validator->fails()) {
                return redirect('/roles/'.$request->input('role_slug').'/projects/'.$request->input('project_slug'))
                            ->withErrors($validator)
                            ->withInput();
            } else {
                $project->published = !($project->published);
                $project->save();

                return redirect('/roles/'.$request->input('role_slug').'/projects/'.$request->input('project_slug'));
            }
        } else {
            // i just need to make it private, that's all

            $project->published = !($project->published);
            $project->save();

            return redirect('/roles/'.$request->input('role_slug').'/projects/'.$request->input('project_slug'));
        }
    }

    public function cloneProject(Request $request) {
        $routeParameters = Route::getCurrentRoute()->parameters();
        $role = Role::select('id', 'title', 'slug', 'description')->where('slug', $routeParameters['roleSlug'])->get()[0];
        $project = Project::where([['slug', '=', $routeParameters['projectSlug']], ['role_id', '=', $role->id]])->get()[0];

        $competencyIdArray = $project->competencies->toArray();
        foreach($competencyIdArray as $key=>$competencyArray) {
            $competencyIdArray[$key] = $competencyArray['id'];
        }

        return redirect('/roles/' . $role->slug . '/projects/' . $project->slug . '/edit');
    }

    public function showTasks($slug) {
        $loggedInUserId = Auth::id();

        $routeParameters = Route::getCurrentRoute()->parameters();
        $role = Role::select('id', 'title', 'slug')->where('slug', $routeParameters['roleSlug'])->get()[0];
        $project = Project::where([['slug', '=', $routeParameters['projectSlug']], ['role_id', '=', $role->id]])->get()[0];

        $clickedUserId = $project->user_id;

        $subscribeString;

        if($loggedInUserId < $clickedUserId) {
            $subscribeString = $loggedInUserId . "_" . $clickedUserId;
        } else {
            $subscribeString = $clickedUserId . "_" . $loggedInUserId;   
        }

        $messages1 = Message::where('sender_id', $loggedInUserId)->where('recipient_id', $clickedUserId)->where('project_id', $project->id)->get();
        $messages2 = Message::where('sender_id', $clickedUserId)->where('recipient_id', $loggedInUserId)->where('project_id', $project->id)->get();
        $messages3 = $messages1->merge($messages2);

        $messages3 = $messages3->sortBy('created_at');

        $attemptedProject = AttemptedProject::where('project_id', $project->id)->where('user_id', Auth::id())->first();


        if($attemptedProject) {

            //here
            $answeredTasks = AnsweredTask::where('project_id', $project->id)->where('user_id', Auth::id())->orderBy('task_id', 'asc')->get();

            $answeredTasksArray = $answeredTasks->toArray();

            foreach($answeredTasksArray as $key=>$answeredTask) {
                $answeredTasksArray[$key] = $answeredTask['id'];
            }

            if($attemptedProject->status == "Completed") {
                $answeredTasks = AnsweredTask::where('project_id', $project->id)->where('user_id', Auth::id())->orderBy('task_id', 'asc')->get();

                return view('projects.completed', [
                    
                    'project' => $project,
                    'role' => $role,
                    'parameter' => 'task',
                    'messages' => $messages3,
                    'answeredTasks' => $answeredTasks,
                    'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                    'clickedUserId' => $clickedUserId,
                    'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                ]);
            } elseif($attemptedProject->status == "Assessed") {

                $answeredTasks = AnsweredTask::where('project_id', $project->id)->where('user_id', Auth::id())->orderBy('task_id', 'asc')->get();

                $competencyScores = CompetencyScore::where('project_id', $project->id)->where('user_id', Auth::id())->get();

                if(Auth::id() != $project->user_id) {
                    $reviewLeftByApplicant = Review::where('project_id', $project->id)->where('sender_id', Auth::id())->first();

                    return view('projects.review', [
                        
                        'project' => $project,
                        'role' => $role,
                        'parameter' => 'task',
                        'reviewLeftByApplicant' => $reviewLeftByApplicant,
                        'messages' => $messages3,
                        'attemptedProject' => $attemptedProject,
                        'answeredTasksArray' => $answeredTasksArray,
                        'answeredTasks' => $answeredTasks,
                        'competencyScores' => $competencyScores,
                        'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                        'clickedUserId' => $clickedUserId,
                        'reviewedUserId' => 0,
                        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                    ]);
                } else {
                    return view('projects.review', [
                        
                        'project' => $project,
                        'role' => $role,
                        'parameter' => 'task',
                        'messages' => $messages3,
                        'attemptedProject' => $attemptedProject,
                        'answeredTasksArray' => $answeredTasksArray,
                        'answeredTasks' => $answeredTasks,
                        'competencyScores' => $competencyScores,
                        'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                        'clickedUserId' => $clickedUserId,
                        'reviewedUserId' => 0,
                        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                    ]);
                }
            } elseif($attemptedProject->status == "Reviewed") {
                $answeredTasks = AnsweredTask::where('project_id', $project->id)->where('user_id', Auth::id())->orderBy('task_id', 'asc')->get();

                $competencyScores = CompetencyScore::where('project_id', $project->id)->where('user_id', Auth::id())->get();

                if(Auth::id() != $project->user_id) {
                    $reviewLeftByApplicant = Review::where('project_id', $project->id)->where('sender_id', Auth::id())->first();

                    return view('projects.review', [
                        
                        'project' => $project,
                        'role' => $role,
                        'parameter' => 'task',
                        'reviewLeftByApplicant' => $reviewLeftByApplicant,
                        'messages' => $messages3,
                        'attemptedProject' => $attemptedProject,
                        'answeredTasksArray' => $answeredTasksArray,
                        'answeredTasks' => $answeredTasks,
                        'competencyScores' => $competencyScores,
                        'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                        'clickedUserId' => $clickedUserId,
                        'reviewedUserId' => 0,
                        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                    ]);
                } else {
                    return view('projects.review', [
                        
                        'project' => $project,
                        'role' => $role,
                        'parameter' => 'task',
                        'messages' => $messages3,
                        'attemptedProject' => $attemptedProject,
                        'answeredTasksArray' => $answeredTasksArray,
                        'answeredTasks' => $answeredTasks,
                        'competencyScores' => $competencyScores,
                        'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                        'clickedUserId' => $clickedUserId,
                        'reviewedUserId' => 0,
                        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                    ]);
                }
            } else {
                // candidate saved all come here

                $tasksArray = array();

                foreach($attemptedProject->project->tasks as $task) {
                    if($task->file_upload) {
                        array_push($tasksArray, $task->id);
                    }
                }

                foreach($answeredTasks as $answeredTask) {
                    if($answeredTask->task->multiple_select) {
                        $answeredTask->answer = explode(",", $answeredTask->answer);

                        $trimmedArray = array();

                        foreach($answeredTask->answer as $answer) {
                            array_push($trimmedArray, trim($answer));
                        }

                        $answeredTask->answer = $trimmedArray;
                    }
                }

                return view('projects.attempt', [
                    
                    'attemptedProject' => AttemptedProject::where('project_id', $project->id)->where('user_id', Auth::id())->first(),
                    'project' => $project,
                    'tasksArray' => implode(",", $tasksArray),
                    'role' => $role,
                    'answeredTasks' => $answeredTasks,
                    'parameter' => 'task',
                    'messages' => $messages3,
                    'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                    'clickedUserId' => $clickedUserId,
                    'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                ]);
            }
        } else {
            if($project->published == 0 && $project->user_id != Auth::id()) {
                if(Auth::user()->admin) {
                    return view('projects.show', [
                        
                        'project' => $project,
                        'role' => $role,
                        'parameter' => 'task',
                        'messages' => $messages3,
                        'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                        'clickedUserId' => $clickedUserId,
                        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                    ]); 
                } else {
                    return redirect('/roles/' . $routeParameters['roleSlug']);
                }
            } else {
                // check whether added to inventory

                $addedToInventory = AttemptedProject::where('project_id', $project->id)->where('user_id', Auth::id())->first();

                return view('projects.show', [
                    
                    'project' => $project,
                    'role' => $role,
                    'parameter' => 'task',
                    'messages' => $messages3,
                    'addedToInventory' => $addedToInventory,
                    'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                    'clickedUserId' => $clickedUserId,
                    'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                ]); 
            }
        }
    }

    public function showFiles($slug) {
        $loggedInUserId = Auth::id();

        $routeParameters = Route::getCurrentRoute()->parameters();
        $role = Role::select('id', 'title', 'slug')->where('slug', $routeParameters['roleSlug'])->get()[0];
        $project = Project::where([['slug', '=', $routeParameters['projectSlug']], ['role_id', '=', $role->id]])->get()[0];

        $clickedUserId = $project->user_id;

        $subscribeString;

        if($loggedInUserId < $clickedUserId) {
            $subscribeString = $loggedInUserId . "_" . $clickedUserId;
        } else {
            $subscribeString = $clickedUserId . "_" . $loggedInUserId;   
        }

        $messages1 = Message::where('sender_id', $loggedInUserId)->where('recipient_id', $clickedUserId)->where('project_id', $project->id)->get();
        $messages2 = Message::where('sender_id', $clickedUserId)->where('recipient_id', $loggedInUserId)->where('project_id', $project->id)->get();
        $messages3 = $messages1->merge($messages2);

        $messages3 = $messages3->sortBy('created_at');

        $attemptedProject = AttemptedProject::where('project_id', $project->id)->where('user_id', Auth::id())->first();


        if($attemptedProject) {
            //here
            $answeredTasks = AnsweredTask::where('project_id', $project->id)->where('user_id', Auth::id())->orderBy('task_id', 'asc')->get();

            $answeredTasksArray = $answeredTasks->toArray();

            foreach($answeredTasksArray as $key=>$answeredTask) {
                $answeredTasksArray[$key] = $answeredTask['id'];
            }

            if($attemptedProject->status == "Completed") {

                $answeredTasks = AnsweredTask::where('project_id', $project->id)->where('user_id', Auth::id())->orderBy('task_id', 'asc')->get();

                return view('projects.completed', [
                    
                    'project' => $project,
                    'role' => $role,
                    'parameter' => 'file',
                    'messages' => $messages3,
                    'answeredTasks' => $answeredTasks,
                    'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                    'clickedUserId' => $clickedUserId,
                    'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                ]);
            } elseif($attemptedProject->status == "Assessed") {
                $answeredTasks = AnsweredTask::where('project_id', $project->id)->where('user_id', Auth::id())->orderBy('task_id', 'asc')->get();

                $competencyScores = CompetencyScore::where('project_id', $project->id)->where('user_id', Auth::id())->get();

                if(Auth::id() != $project->user_id) {
                    $reviewLeftByApplicant = Review::where('project_id', $project->id)->where('sender_id', Auth::id())->first();

                    return view('projects.review', [
                        
                        'project' => $project,
                        'role' => $role,
                        'parameter' => 'file',
                        'reviewLeftByApplicant' => $reviewLeftByApplicant,
                        'messages' => $messages3,
                        'attemptedProject' => $attemptedProject,
                        'answeredTasksArray' => $answeredTasksArray,
                        'answeredTasks' => $answeredTasks,
                        'competencyScores' => $competencyScores,
                        'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                        'clickedUserId' => $clickedUserId,
                        'reviewedUserId' => 0,
                        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                    ]);
                } else {
                    return view('projects.review', [
                        
                        'project' => $project,
                        'role' => $role,
                        'parameter' => 'file',
                        'messages' => $messages3,
                        'attemptedProject' => $attemptedProject,
                        'answeredTasksArray' => $answeredTasksArray,
                        'answeredTasks' => $answeredTasks,
                        'competencyScores' => $competencyScores,
                        'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                        'clickedUserId' => $clickedUserId,
                        'reviewedUserId' => 0,
                        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                    ]);
                }
            } elseif($attemptedProject->status == "Reviewed") {
                $answeredTasks = AnsweredTask::where('project_id', $project->id)->where('user_id', Auth::id())->orderBy('task_id', 'asc')->get();

                $competencyScores = CompetencyScore::where('project_id', $project->id)->where('user_id', Auth::id())->get();

                if(Auth::id() != $project->user_id) {
                    $reviewLeftByApplicant = Review::where('project_id', $project->id)->where('sender_id', Auth::id())->first();

                    return view('projects.review', [
                        
                        'project' => $project,
                        'role' => $role,
                        'parameter' => 'file',
                        'reviewLeftByApplicant' => $reviewLeftByApplicant,
                        'messages' => $messages3,
                        'attemptedProject' => $attemptedProject,
                        'answeredTasksArray' => $answeredTasksArray,
                        'answeredTasks' => $answeredTasks,
                        'competencyScores' => $competencyScores,
                        'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                        'clickedUserId' => $clickedUserId,
                        'reviewedUserId' => 0,
                        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                    ]);
                } else {
                    return view('projects.review', [
                        
                        'project' => $project,
                        'role' => $role,
                        'parameter' => 'file',
                        'messages' => $messages3,
                        'attemptedProject' => $attemptedProject,
                        'answeredTasksArray' => $answeredTasksArray,
                        'answeredTasks' => $answeredTasks,
                        'competencyScores' => $competencyScores,
                        'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                        'clickedUserId' => $clickedUserId,
                        'reviewedUserId' => 0,
                        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                    ]);
                }
            } else {
                return view('projects.attempt', [
                    
                    'attemptedProject' => AttemptedProject::where('project_id', $project->id)->where('user_id', Auth::id())->first(),
                    'project' => $project,
                    'role' => $role,
                    'parameter' => 'file',
                    'messages' => $messages3,
                    'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                    'clickedUserId' => $clickedUserId,
                    'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                ]);
            }
        } else {
            if($project->published == 0 && $project->user_id != Auth::id()) {
                if(Auth::user()->admin) {
                    return view('projects.show', [
                        
                        'project' => $project,
                        'role' => $role,
                        'parameter' => 'file',
                        'messages' => $messages3,
                        'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                        'clickedUserId' => $clickedUserId,
                        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                    ]); 
                } else {
                    return redirect('/roles/' . $routeParameters['roleSlug']);
                }
            } else {
                // check whether added to cart

                $addedToInventory = AttemptedProject::where('project_id', $project->id)->where('user_id', Auth::id())->first();

                return view('projects.show', [
                    
                    'project' => $project,
                    'role' => $role,
                    'parameter' => 'file',
                    'messages' => $messages3,
                    'addedToInventory' => $addedToInventory,
                    'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                    'clickedUserId' => $clickedUserId,
                    'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                ]); 
            }
        }
    }

    public function showCompetencies($slug) {
        $loggedInUserId = Auth::id();

        $routeParameters = Route::getCurrentRoute()->parameters();
        $role = Role::select('id', 'title', 'slug')->where('slug', $routeParameters['roleSlug'])->get()[0];
        $project = Project::where([['slug', '=', $routeParameters['projectSlug']], ['role_id', '=', $role->id]])->get()[0];

        $clickedUserId = $project->user_id;

        $subscribeString;

        if($loggedInUserId < $clickedUserId) {
            $subscribeString = $loggedInUserId . "_" . $clickedUserId;
        } else {
            $subscribeString = $clickedUserId . "_" . $loggedInUserId;   
        }

        $messages1 = Message::where('sender_id', $loggedInUserId)->where('recipient_id', $clickedUserId)->where('project_id', $project->id)->get();
        $messages2 = Message::where('sender_id', $clickedUserId)->where('recipient_id', $loggedInUserId)->where('project_id', $project->id)->get();
        $messages3 = $messages1->merge($messages2);

        $messages3 = $messages3->sortBy('created_at');

        $attemptedProject = AttemptedProject::where('project_id', $project->id)->where('user_id', Auth::id())->first();


        if($attemptedProject) {
            //here
            $answeredTasks = AnsweredTask::where('project_id', $project->id)->where('user_id', Auth::id())->orderBy('task_id', 'asc')->get();

            $answeredTasksArray = $answeredTasks->toArray();

            foreach($answeredTasksArray as $key=>$answeredTask) {
                $answeredTasksArray[$key] = $answeredTask['id'];
            }

            $competencyAndTaskReview = CompetencyAndTaskReview::where('attempted_project_id', $attemptedProject->id)->first();

            $competencyAndTaskMessages = array();

            $tasksReviewed = false;
            $competenciesReviewed = false;

            if(!$competencyAndTaskReview->competencies_reviewed) {
                array_push($competencyAndTaskMessages, 'Competencies');
            } else {
                $competenciesReviewed = true;
            }

            if(!$competencyAndTaskReview->tasks_reviewed) {
                array_push($competencyAndTaskMessages, 'Tasks');
            } else {
                $tasksReviewed = true;
            }

            if($attemptedProject->status == "Completed") {

                $answeredTasks = AnsweredTask::where('project_id', $project->id)->where('user_id', Auth::id())->orderBy('task_id', 'asc')->get();

                return view('projects.completed', [
                    
                    'project' => $project,
                    'role' => $role,
                    'tasksReviewed' => $tasksReviewed,
                    'competenciesReviewed' => $competenciesReviewed,
                    'parameter' => 'competency',
                    'messages' => $messages3,
                    'answeredTasks' => $answeredTasks,
                    'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                    'clickedUserId' => $clickedUserId,
                    'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                ]);
            } elseif($attemptedProject->status == "Assessed") {
                $answeredTasks = AnsweredTask::where('project_id', $project->id)->where('user_id', Auth::id())->orderBy('task_id', 'asc')->get();

                $competencyScores = CompetencyScore::where('project_id', $project->id)->where('user_id', Auth::id())->get();

                if(Auth::id() != $project->user_id) {
                    $reviewLeftByApplicant = Review::where('project_id', $project->id)->where('sender_id', Auth::id())->first();

                    return view('projects.review', [
                        
                        'project' => $project,
                        'role' => $role,
                        'parameter' => 'competency',
                        'tasksReviewed' => $tasksReviewed,
                        'competenciesReviewed' => $competenciesReviewed,
                        'reviewLeftByApplicant' => $reviewLeftByApplicant,
                        'messages' => $messages3,
                        'attemptedProject' => $attemptedProject,
                        'answeredTasksArray' => $answeredTasksArray,
                        'answeredTasks' => $answeredTasks,
                        'competencyScores' => $competencyScores,
                        'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                        'clickedUserId' => $clickedUserId,
                        'reviewedUserId' => 0,
                        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                    ]);
                } else {
                    return view('projects.review', [
                        
                        'project' => $project,
                        'role' => $role,
                        'parameter' => 'competency',
                        'messages' => $messages3,
                        'attemptedProject' => $attemptedProject,
                        'answeredTasksArray' => $answeredTasksArray,
                        'answeredTasks' => $answeredTasks,
                        'competencyScores' => $competencyScores,
                        'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                        'clickedUserId' => $clickedUserId,
                        'reviewedUserId' => 0,
                        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                    ]);
                }
            } elseif($attemptedProject->status == "Reviewed") {
                $answeredTasks = AnsweredTask::where('project_id', $project->id)->where('user_id', Auth::id())->orderBy('task_id', 'asc')->get();

                $competencyScores = CompetencyScore::where('project_id', $project->id)->where('user_id', Auth::id())->get();

                if(Auth::id() != $project->user_id) {
                    $reviewLeftByApplicant = Review::where('project_id', $project->id)->where('sender_id', Auth::id())->first();

                    return view('projects.review', [
                        
                        'project' => $project,
                        'role' => $role,
                        'parameter' => 'competency',
                        'tasksReviewed' => $tasksReviewed,
                        'competenciesReviewed' => $competenciesReviewed,
                        'reviewLeftByApplicant' => $reviewLeftByApplicant,
                        'messages' => $messages3,
                        'attemptedProject' => $attemptedProject,
                        'answeredTasksArray' => $answeredTasksArray,
                        'answeredTasks' => $answeredTasks,
                        'competencyScores' => $competencyScores,
                        'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                        'clickedUserId' => $clickedUserId,
                        'reviewedUserId' => 0,
                        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                    ]);
                } else {
                    return view('projects.review', [
                        
                        'project' => $project,
                        'role' => $role,
                        'parameter' => 'competency',
                        'messages' => $messages3,
                        'attemptedProject' => $attemptedProject,
                        'answeredTasksArray' => $answeredTasksArray,
                        'answeredTasks' => $answeredTasks,
                        'competencyScores' => $competencyScores,
                        'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                        'clickedUserId' => $clickedUserId,
                        'reviewedUserId' => 0,
                        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                    ]);
                }
            } else {
                return view('projects.attempt', [
                    'attemptedProject' => AttemptedProject::where('project_id', $project->id)->where('user_id', Auth::id())->first(),
                    'project' => $project,
                    'role' => $role,
                    'tasksReviewed' => $tasksReviewed,
                    'competenciesReviewed' => $competenciesReviewed,
                    'parameter' => 'competency',
                    'messages' => $messages3,
                    'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                    'clickedUserId' => $clickedUserId,
                    'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                ]);
            }
        } else {
            if($project->published == 0 && $project->user_id != Auth::id()) {
                if(Auth::user()->admin) {
                    return view('projects.show', [
                        
                        'project' => $project,
                        'role' => $role,
                        'parameter' => 'competency',
                        'messages' => $messages3,
                        'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                        'clickedUserId' => $clickedUserId,
                        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                    ]); 
                } else {
                    return redirect('/roles/' . $routeParameters['roleSlug']);
                }
            } else {
                // check whether added to cart

                $addedToInventory = AttemptedProject::where('project_id', $project->id)->where('user_id', Auth::id())->first();

                return view('projects.show', [
                    
                    'project' => $project,
                    'role' => $role,
                    'parameter' => 'competency',
                    'messages' => $messages3,
                    'addedToInventory' => $addedToInventory,
                    'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                    'clickedUserId' => $clickedUserId,
                    'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                ]); 
            }
        }
    }

    public function show($slug) {
        $loggedInUserId = Auth::id();

        $routeParameters = Route::getCurrentRoute()->parameters();
        $role = Role::select('id', 'title', 'slug')->where('slug', $routeParameters['roleSlug'])->get()[0];
        $project = Project::where([['slug', '=', $routeParameters['projectSlug']], ['role_id', '=', $role->id]])->get()[0];

        $clickedUserId = $project->user_id;

        $subscribeString;

        if($loggedInUserId < $clickedUserId) {
            $subscribeString = $loggedInUserId . "_" . $clickedUserId;
        } else {
            $subscribeString = $clickedUserId . "_" . $loggedInUserId;   
        }

        $messages1 = Message::where('sender_id', $loggedInUserId)->where('recipient_id', $clickedUserId)->where('project_id', $project->id)->get();
        $messages2 = Message::where('sender_id', $clickedUserId)->where('recipient_id', $loggedInUserId)->where('project_id', $project->id)->get();
        $messages3 = $messages1->merge($messages2);

        $messages3 = $messages3->sortBy('created_at');

        $attemptedProject = AttemptedProject::where('project_id', $project->id)->where('user_id', Auth::id())->first();

        if($attemptedProject) {
            //here
            $answeredTasks = AnsweredTask::where('project_id', $project->id)->where('user_id', Auth::id())->orderBy('task_id', 'asc')->get();

            $answeredTasksArray = $answeredTasks->toArray();

            foreach($answeredTasksArray as $key=>$answeredTask) {
                $answeredTasksArray[$key] = $answeredTask['id'];
            }

            if($attemptedProject->status == "Completed") {

                $answeredTasks = AnsweredTask::where('project_id', $project->id)->where('user_id', Auth::id())->orderBy('task_id', 'asc')->get();

                return view('projects.completed', [
                    
                    'project' => $project,
                    'role' => $role,
                    'parameter' => 'overview',
                    'messages' => $messages3,
                    'answeredTasks' => $answeredTasks,
                    'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                    'clickedUserId' => $clickedUserId,
                    'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                ]);
            } elseif($attemptedProject->status == "Assessed") {
                $answeredTasks = AnsweredTask::where('project_id', $project->id)->where('user_id', Auth::id())->orderBy('task_id', 'asc')->get();

                $competencyScores = CompetencyScore::where('project_id', $project->id)->where('user_id', Auth::id())->get();

                if(Auth::id() != $project->user_id) {
                    $reviewLeftByApplicant = Review::where('project_id', $project->id)->where('sender_id', Auth::id())->first();

                    return view('projects.review', [
                        
                        'project' => $project,
                        'role' => $role,
                        'parameter' => 'overview',
                        'reviewLeftByApplicant' => $reviewLeftByApplicant,
                        'messages' => $messages3,
                        'attemptedProject' => $attemptedProject,
                        'answeredTasksArray' => $answeredTasksArray,
                        'answeredTasks' => $answeredTasks,
                        'competencyScores' => $competencyScores,
                        'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                        'clickedUserId' => $clickedUserId,
                        'reviewedUserId' => 0,
                        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                    ]);
                } else {
                    return view('projects.review', [
                        
                        'project' => $project,
                        'role' => $role,
                        'parameter' => 'overview',
                        'messages' => $messages3,
                        'attemptedProject' => $attemptedProject,
                        'answeredTasksArray' => $answeredTasksArray,
                        'answeredTasks' => $answeredTasks,
                        'competencyScores' => $competencyScores,
                        'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                        'clickedUserId' => $clickedUserId,
                        'reviewedUserId' => 0,
                        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                    ]);
                }
            } elseif($attemptedProject->status == "Reviewed") {
                $answeredTasks = AnsweredTask::where('project_id', $project->id)->where('user_id', Auth::id())->orderBy('task_id', 'asc')->get();

                $competencyScores = CompetencyScore::where('project_id', $project->id)->where('user_id', Auth::id())->get();

                if(Auth::id() != $project->user_id) {
                    $reviewLeftByApplicant = Review::where('project_id', $project->id)->where('sender_id', Auth::id())->first();

                    return view('projects.review', [
                        
                        'project' => $project,
                        'role' => $role,
                        'parameter' => 'overview',
                        'reviewLeftByApplicant' => $reviewLeftByApplicant,
                        'messages' => $messages3,
                        'attemptedProject' => $attemptedProject,
                        'answeredTasksArray' => $answeredTasksArray,
                        'answeredTasks' => $answeredTasks,
                        'competencyScores' => $competencyScores,
                        'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                        'clickedUserId' => $clickedUserId,
                        'reviewedUserId' => 0,
                        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                    ]);
                } else {
                    return view('projects.review', [
                        
                        'project' => $project,
                        'role' => $role,
                        'parameter' => 'overview',
                        'messages' => $messages3,
                        'attemptedProject' => $attemptedProject,
                        'answeredTasksArray' => $answeredTasksArray,
                        'answeredTasks' => $answeredTasks,
                        'competencyScores' => $competencyScores,
                        'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                        'clickedUserId' => $clickedUserId,
                        'reviewedUserId' => 0,
                        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                    ]);
                }
            } else {
                return view('projects.attempt', [
                    'attemptedProject' => AttemptedProject::where('project_id', $project->id)->where('user_id', Auth::id())->first(),
                    'project' => $project,
                    'role' => $role,
                    'parameter' => 'overview',
                    'messages' => $messages3,
                    'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                    'clickedUserId' => $clickedUserId,
                    'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                ]);
            }
        } else {
            if($project->published == 0 && $project->user_id != Auth::id()) {
                if(Auth::user()->admin) {
                    return view('projects.show', [
                        
                        'project' => $project,
                        'role' => $role,
                        'parameter' => 'overview',
                        'messages' => $messages3,
                        'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                        'clickedUserId' => $clickedUserId,
                        'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                        'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                    ]); 
                } else {
                    return redirect('/roles/' . $routeParameters['roleSlug']);
                }
            } else {
                // check whether added to cart

                $addedToInventory = AttemptedProject::where('project_id', $project->id)->where('user_id', Auth::id())->first();

                return view('projects.show', [
                    
                    'project' => $project,
                    'role' => $role,
                    'parameter' => 'overview',
                    'messages' => $messages3,
                    'addedToInventory' => $addedToInventory,
                    'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                    'clickedUserId' => $clickedUserId,
                    'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                    'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
                ]); 
            }
        }
    }

    public function edit($roleSlug, $projectSlug) {
        $routeParameters = Route::getCurrentRoute()->parameters();
        $role = Role::select('id', 'title', 'slug', 'description')->where('slug', $routeParameters['roleSlug'])->get()[0];
        $project = Project::where([['slug', '=', $routeParameters['projectSlug']], ['role_id', '=', $role->id]])->get()[0];

        $competencyIdArray = $project->competencies->toArray();
        foreach($competencyIdArray as $key=>$competencyArray) {
            $competencyIdArray[$key] = $competencyArray['id'];
        }

        $customCount = Competency::whereIn('id', $competencyIdArray)->where('user_id' , '!=', 0)->count();

        // dd($customCount);

        $customCompetencies = Competency::where('role_id', $role->id)->where('user_id', Auth::id());

        return view('projects.edit', [
            'industries' => Industry::all(),
            'project' => $project,
            'role' => $role,
            'customCount' => $customCompetencies->count()+1,
            'customCompetencies' => $customCompetencies->get(),
            'competencyIdArray' => $competencyIdArray,
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    }

    public function create() {
        // check whether or not the user is a creator
        $user = Auth::user();

        if($user->creator) {
            if(session('selectedRole')) {
                $selectedRole = Role::find(session('selectedRole')); 
            }

            $customCompetencies = Competency::where('role_id', $selectedRole->id)->where('user_id', Auth::id());

            return view('projects.create', [
                'industries' => Industry::all(),
                'selectedRole' => $selectedRole,
                'customCount' => $customCompetencies->count()+1,
                'customCompetencies' => $customCompetencies->get(),
                'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
            ]);
        } else {
            return view('projects.apply', [
                
                'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
            ]);
        }
    }

    public function attempt() {
        $loggedInUserId = Auth::id();

        $routeParameters = Route::getCurrentRoute()->parameters();
        $role = Role::select('id', 'title', 'slug')->where('slug', $routeParameters['roleSlug'])->get()[0];
        $project = Project::where([['slug', '=', $routeParameters['projectSlug']], ['role_id', '=', $role->id]])->get()[0];

        $clickedUserId = $project->user_id;

        $subscribeString;

        if($loggedInUserId < $clickedUserId) {
            $subscribeString = $loggedInUserId . "_" . $clickedUserId;
        } else {
            $subscribeString = $clickedUserId . "_" . $loggedInUserId;   
        }

        $messages1 = Message::where('sender_id', $loggedInUserId)->where('recipient_id', $clickedUserId)->where('project_id', $project->id)->get();
        $messages2 = Message::where('sender_id', $clickedUserId)->where('recipient_id', $loggedInUserId)->where('project_id', $project->id)->get();
        $messages3 = $messages1->merge($messages2);

        $messages3 = $messages3->sortBy('created_at');

        if(Auth::id() != $project->user->id) {
            return view('projects.attempt', [
                
                'project' => $project,
                'role' => $role,
                'messages' => $messages3,
                'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                'clickedUserId' => $clickedUserId,
                'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
            ]);
        } else {
            return view('projects.show', [
                
                'project' => $project,
                'role' => $role,
                'messages' => $messages3,
                'messageChannel' => 'messages_'.$subscribeString.'_projects_'.$project->id,
                'clickedUserId' => $clickedUserId,
                'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
                'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
                'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
            ]);
        }
    }

    public function addProjectToInventory(Request $request) {
        $project = Project::find($request->input('project_id'));

        $attemptedProject = new AttemptedProject;

        $attemptedProject->project_id = $project->id;
        $attemptedProject->user_id = Auth::id();
        $attemptedProject->status = "Attempting";
        $attemptedProject->deadline = date("Y-m-d H:i:s", time() + ($project->hours * 60 * 60));
        $attemptedProject->creator_id = $project->user_id;

        $attemptedProject->save();

        foreach($project->tasks as $task) {
            $answeredTask = new AnsweredTask;
            $answeredTask->answer = "";
            $answeredTask->response = "";
            $answeredTask->user_id = Auth::id();
            $answeredTask->task_id = $task->id;
            $answeredTask->project_id = $project->id;

            $answeredTask->save();
        }

        foreach($project->competencies as $competency) {
            // create new competencyscore for each

            $competencyScore = new CompetencyScore;

            $competencyScore->competency_id = $competency->id;
            $competencyScore->role_gained_id = $project->role_id;
            $competencyScore->score = 0;
            $competencyScore->user_id = Auth::id();
            $competencyScore->project_id = $project->id;
            $competencyScore->attempted_project_id = $attemptedProject->id;

            $competencyScore->save();
        }

        $competencyAndTaskReview = new CompetencyAndTaskReview;

        $competencyAndTaskReview->attempted_project_id = $attemptedProject->id;
        $competencyAndTaskReview->tasks_reviewed = 0;
        $competencyAndTaskReview->competencies_reviewed = 0;

        $competencyAndTaskReview->save();

        return redirect('/roles/' . $project->role->slug . "/projects/" . $project->slug);

        // $project = Project::find($request->input('project_id'));

        // // find whether or not there is an existing shopping cart
        // $shoppingCart = ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first();

        // if($shoppingCart) {
        //     // already has a shopping cart
        // } else {
        //     // no shopping cart, create new one

        //     $shoppingCart = new ShoppingCart;

        //     $shoppingCart->status = "pending";
        //     $shoppingCart->total = 0;
        //     $shoppingCart->no_of_items = 0;
        //     $shoppingCart->user_id = Auth::id();
        // }

        // $shoppingCart->no_of_items = $shoppingCart->no_of_items + 1;
        // $shoppingCart->total = $shoppingCart->total + $project->amount;

        // $shoppingCart->save();

        // $shoppingCartLineItem = new ShoppingCartLineItem;

        // $shoppingCartLineItem->project_id = $project->id;
        // $shoppingCartLineItem->shopping_cart_id = $shoppingCart->id;

        // $shoppingCartLineItem->save();

        // return redirect('/roles/' . $project->role->slug . "/projects/" . $project->slug);
    }

    public function purchaseProjects(Request $request) {
        $projectsArray = $request->input('projectsArray');
        $interviewsArray = $request->input('interviewsArray');
        $lessonsArray = $request->input('lessonsArray');

        if($projectsArray != null) {
            $projectsArray = explode(",", $projectsArray);
            if(sizeof($projectsArray) > 0) {
                foreach($projectsArray as $projectId) {
                    $project = Project::find($projectId);

                    $attemptedProject = new AttemptedProject;

                    $attemptedProject->project_id = $projectId;
                    $attemptedProject->user_id = Auth::id();
                    $attemptedProject->status = "Attempting";
                    $attemptedProject->creator_id = $project->user_id;

                    // calculate the deadline of the project by adding project hours to current date
                    $attemptedProject->deadline = date("Y-m-d H:i:s", time() + ($project->hours * 60 * 60));

                    $attemptedProject->save();

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

                    $this->pusher->trigger('notifications_' . $project->user_id, 'new-notification', $message);
                }
            }
        }
        $interviewsArray = explode(",", $interviewsArray);
        $lessonsArray = explode(",", $lessonsArray);

        $shoppingCart = ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first();

        $shoppingCart->status = "Paid";

        $shoppingCart->save();
    }

    public function purchaseProject(Request $request) {
        // if(Auth::id()) {
            $project = Project::find($request->input('project_id'));

            $attemptedProject = new AttemptedProject;

            $attemptedProject->project_id = $request->input('project_id');
            $attemptedProject->user_id = Auth::id();
            $attemptedProject->status = "Attempting";
            $attemptedProject->creator_id = $project->user_id;

            // calculate the deadline of the project by adding project hours to current date
            $attemptedProject->deadline = date("Y-m-d H:i:s", time() + ($project->hours * 60 * 60));

            $attemptedProject->save();

            foreach($project->tasks as $task) {
                $answeredTask = new AnsweredTask;
                $answeredTask->answer = "";
                $answeredTask->response = "";
                $answeredTask->user_id = Auth::id();
                $answeredTask->task_id = $task->id;
                $answeredTask->project_id = $project->id;

                $answeredTask->save();
            }

            // create invoice and change shopping cart to done
            $shoppingCart = ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first();
            $shoppingCart->status = "Paid";

            $shoppingCart->save();

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

            $this->pusher->trigger('notifications_' . $project->user_id, 'new-notification', $message);

            // return redirect('/roles/'.$request->input('role_slug').'/projects/'.$request->input('project_slug'));  
        // }
    }

    public function selectRole() {
        // dd()
        if(request('role') != null) {
            $roleId = request('role');
            if($roleId == "Nil") {
                return redirect('/projects/select-role')->with('selectRoleSelected', 'Please select a role.');
            }
            session(['selectedRole' => $roleId]);

            return redirect()->action('ProjectsController@create');
        }
        $roles = Role::select('id', 'title')->orderBy('title', 'asc')->get();

        return view('projects.selectRole', [
            
            'roles' => $roles,
            'messageCount' => Message::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'notificationCount' => Notification::where('recipient_id', Auth::id())->where('read', 0)->count(),
            'shoppingCartActive' => ShoppingCart::where('user_id', Auth::id())->where('status', 'pending')->first()['status']=='pending',
        ]);
    }

    public function publishProject(Request $request) {

        // need to validate inputs first before trying to store to database
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:projects',
            'description' => 'required',
            'brief' => 'required',
            'hours' => 'required',
            'price' => 'required',
            'competency' => 'required'
        ]);

        if($validator->fails()) {
            return redirect('projects/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $project = new Project;

        $project->title = $request->input('title');
        $project->description = $request->input('description');
        $project->brief = $request->input('brief');
        $project->slug = str_slug($request->input('title'), '-');
        $project->role_id = session('selectedRole');
        $project->user_id = Auth::id();
        $project->industry_id = $request->input('industry');
        $project->hours = $request->input('hours');
        $project->amount = $request->input('price');
        $project->published = true;

        $project->save();

        $competencies = Competency::find($request->input('competency'));
        $project->competencies()->attach($competencies);

        $taskCounter = 1;
        while($request->input('todo-title_'.$taskCounter) != null || $request->input('todo-description_'.$taskCounter) != null || $request->input('todo_'.$taskCounter) != null) {

            $task = new Task;

            $task->title = $request->input('todo-title_'.$taskCounter);
            $task->description = $request->input('todo-description_'.$taskCounter);

            if($request->input('todo_'.$taskCounter) == "mcq") {
                $task->mcq = true;
            } else if($request->input('todo_'.$taskCounter) == "open-ended") {
                $task->open_ended = true;
            } else if($request->input('todo_'.$taskCounter) == "na") {
                $task->na = true;
            }

            if($request->input('checkbox-file-upload_'.$taskCounter) != null) {
                $task->file_upload = true;
            }

            if($request->input('checkbox-multiple-select_'.$taskCounter) != null) {
                $task->multiple_select = true;
            }

            $task->project_id = $project->id;

            $task->save();

            if($request->input('todo_'.$taskCounter) == 'mcq') {
                $answerCounter = 1;

                while($request->input('answer_'.$taskCounter.'_'.$answerCounter) != null) {
                    $answer = new Answer;

                    $answer->title = $request->input('answer_'.$taskCounter.'_'.$answerCounter);
                    $answer->task_id = $task->id;

                    $answer->save();

                    $answerCounter++;
                }
            }

            $taskCounter++;
        }

        if($request->file('file-1')) {
            for($fileCounter = 0; $fileCounter < count($request->file('file-1')); $fileCounter++) {

                $projectFile = new ProjectFile;

                $projectFile->title = $request->file('file-1')[$fileCounter]->getClientOriginalName();
                $projectFile->size = $request->file('file-1')[$fileCounter]->getSize();
                $projectFile->url = Storage::disk('gcs')->put('/assets', $request->file('file-1')[$fileCounter], 'public');
                $projectFile->mime_type = $request->file('file-1')[$fileCounter]->getMimeType();
                $projectFile->project_id = $project->id;

                $projectFile->save();
            }
        }

        $roleSlug = Role::find(session('selectedRole'))->slug;

        return redirect('/roles/'.$roleSlug.'/projects/'.$project->slug);
    }

    public function saveProject(Request $request) {

        // dd($request);
        // need to validate inputs first before trying to store to database
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:projects'
        ]);

        if($validator->fails()) {
            return redirect('projects/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $project = new Project;

        $project->title = $request->input('title');
        $project->description = $request->input('description');
        $project->brief = $request->input('brief');
        $project->slug = str_slug($request->input('title'), '-');
        $project->role_id = session('selectedRole');
        $project->user_id = Auth::id();
        $project->hours = $request->input('hours');
        $project->amount = $request->input('price');
        $project->industry_id = $request->input('industry');
        $project->published = false;

        if($request->file('thumbnail')) {
            $project->thumbnail = $request->file('thumbnail')->getClientOriginalName();
            $project->url = Storage::disk('gcs')->put('/thumbnails', $request->file('thumbnail'), 'public');
        }

        $project->save();

        $competencies = Competency::find($request->input('competency'));
        $project->competencies()->attach($competencies);

        // need to create new custom competencies before attaching
        if($request->input('custom-competency')) {
            $newCompetencyArray = array();
            $customCompetencies = $request->input('custom-competency');

            foreach($customCompetencies as $customCompetency) {
                $newCompetency = new Competency;

                $newCompetency->title = $customCompetency;
                $newCompetency->role_id = $project->role_id;
                $newCompetency->user_id = Auth::id();

                $newCompetency->save();
                array_push($newCompetencyArray, $newCompetency->id);
            }

            $newCompetencies = Competency::find($newCompetencyArray);
            $project->competencies()->attach($newCompetencies);
        }

        $taskCounter = 1;
        while($request->input('todo-title_'.$taskCounter) != null || $request->input('todo-description_'.$taskCounter) != null || $request->input('todo_'.$taskCounter) != null) {

            $task = new Task;

            $task->title = $request->input('todo-title_'.$taskCounter);
            $task->description = $request->input('todo-description_'.$taskCounter);

            if($request->input('todo_'.$taskCounter) == "mcq") {
                $task->mcq = true;
            } else if($request->input('todo_'.$taskCounter) == "open-ended") {
                $task->open_ended = true;
            } else if($request->input('todo_'.$taskCounter) == "na") {
                $task->na = true;
            }

            if($request->input('checkbox-file-upload_'.$taskCounter) != null) {
                $task->file_upload = true;
            }

            if($request->input('checkbox-multiple-select_'.$taskCounter) != null) {
                $task->multiple_select = true;
            }

            $task->project_id = $project->id;

            $task->save();

            if($request->input('todo_'.$taskCounter) == 'mcq') {
                $answerCounter = 1;

                while($request->input('answer_'.$taskCounter.'_'.$answerCounter) != null) {
                    $answer = new Answer;

                    $answer->title = $request->input('answer_'.$taskCounter.'_'.$answerCounter);
                    $answer->task_id = $task->id;

                    $answer->save();

                    $answerCounter++;
                }
            }

            $taskCounter++;
        }

        if($request->file('file-1')) {

            for($fileCounter = 0; $fileCounter < count($request->file('file-1')); $fileCounter++) {

                $projectFile = new ProjectFile;

                $projectFile->title = $request->file('file-1')[$fileCounter]->getClientOriginalName();
                $projectFile->size = $request->file('file-1')[$fileCounter]->getSize();
                $projectFile->url = Storage::disk('gcs')->put('/assets', $request->file('file-1')[$fileCounter], 'public');
                $projectFile->mime_type = $request->file('file-1')[$fileCounter]->getMimeType();
                $projectFile->project_id = $project->id;

                $projectFile->save();
            }
        }

        $roleSlug = Role::find(session('selectedRole'))->slug;

        return redirect('/roles/'.$roleSlug.'/projects/'.$project->slug);
    }

    public function saveChanges(Request $request) {
        $project = Project::find($request->input('id'));

        $routeParameters = Route::getCurrentRoute()->parameters();
        
        if($project->sample) {
            $validator = Validator::make($request->all(), [
                'title' => 'required|unique:projects'
            ]);

            if($validator->fails()) {
                return redirect('/roles/' . $routeParameters['roleSlug'] . '/projects/' . $routeParameters['projectSlug'] . '/edit')
                            ->withErrors($validator)
                            ->withInput();
            }
            
            $newProject = new Project;

            $newProject->title = $request->input('title');
            $newProject->description = $request->input('description');
            $newProject->brief = $request->input('brief');
            $newProject->slug = str_slug($request->input('title'), '-');
            $newProject->role_id = session('selectedRole');
            $newProject->user_id = Auth::id();
            $newProject->hours = $request->input('hours');
            $newProject->amount = $request->input('price');
            $newProject->industry_id = $request->input('industry');
            $newProject->published = false;

            $newProject->save();

            $competencies = Competency::find($request->input('competency'));
            $newProject->competencies()->attach($competencies);

            if($request->input('custom-competency')) {
                $newCompetencyArray = array();
                $customCompetencies = $request->input('custom-competency');

                foreach($customCompetencies as $customCompetency) {
                    $newCompetency = new Competency;

                    $newCompetency->title = $customCompetency;
                    $newCompetency->role_id = $project->role_id;
                    $newCompetency->user_id = Auth::id();

                    $newCompetency->save();
                    array_push($newCompetencyArray, $newCompetency->id);
                }

                $newCompetencies = Competency::find($newCompetencyArray);
                $project->competencies()->attach($newCompetencies);
            }

            $taskCounter = 1;
            while($request->input('todo-title_'.$taskCounter) != null || $request->input('todo-description_'.$taskCounter) != null || $request->input('todo_'.$taskCounter) != null) {

                $task = new Task;

                $task->title = $request->input('todo-title_'.$taskCounter);
                $task->description = $request->input('todo-description_'.$taskCounter);

                if($request->input('todo_'.$taskCounter) == "mcq") {
                    $task->mcq = true;
                } else if($request->input('todo_'.$taskCounter) == "open-ended") {
                    $task->open_ended = true;
                } else if($request->input('todo_'.$taskCounter) == "na") {
                    $task->na = true;
                }

                if($request->input('checkbox-file-upload_'.$taskCounter) != null) {
                    $task->file_upload = true;
                }

                if($request->input('checkbox-multiple-select_'.$taskCounter) != null) {
                    $task->multiple_select = true;
                }

                $task->project_id = $project->id;

                $task->save();

                if($request->input('todo_'.$taskCounter) == 'mcq') {
                    $answerCounter = 1;

                    while($request->input('answer_'.$taskCounter.'_'.$answerCounter) != null) {
                        $answer = new Answer;

                        $answer->title = $request->input('answer_'.$taskCounter.'_'.$answerCounter);
                        $answer->task_id = $task->id;

                        $answer->save();

                        $answerCounter++;
                    }
                }

                $taskCounter++;
            }

            if($request->file('file-1')) {
                for($fileCounter = 0; $fileCounter < count($request->file('file-1')); $fileCounter++) {

                    $projectFile = new ProjectFile;

                    $projectFile->title = $request->file('file-1')[$fileCounter]->getClientOriginalName();
                    $projectFile->size = $request->file('file-1')[$fileCounter]->getSize();
                    $projectFile->url = Storage::disk('gcs')->put('/assets', $request->file('file-1')[$fileCounter], 'public');
                    $projectFile->mime_type = $request->file('file-1')[$fileCounter]->getMimeType();
                    $projectFile->project_id = $project->id;

                    $projectFile->save();
                }
            }

            $roleSlug = Role::find(session('selectedRole'))->slug;

            return redirect('/roles/'.$roleSlug.'/projects/'.$project->slug);
        } else {
            // dd($request->input('thumbnail-deleted'));


            $validator = Validator::make($request->all(), [
                'title' => [
                    'required',
                    Rule::unique('projects')->ignore($project->id),
                ],
            ]);

            if($validator->fails()) {
                return redirect('/roles/' . $routeParameters['roleSlug'] . '/projects/' . $routeParameters['projectSlug'] . '/edit')
                            ->withErrors($validator)
                            ->withInput();
            }

            $project->title = $request->input('title');
            $project->description = $request->input('description');
            $project->brief = $request->input('brief');
            $project->industry_id = $request->input('industry');
            $project->slug = str_slug($request->input('title'), '-');
            if(!Auth::user()->admin) {
                $project->user_id = Auth::id();
            }
            $project->hours = $request->input('hours');
            $project->amount = $request->input('price');

            // detach all competencies so that i can reattach the new ones
            $project->competencies()->detach();
            $competencies = Competency::find($request->input('competency'));

            $project->competencies()->attach($competencies);

            if($request->input('custom-competency')) {
                $newCompetencyArray = array();
                $customCompetencies = $request->input('custom-competency');

                foreach($customCompetencies as $customCompetency) {
                    $newCompetency = new Competency;

                    $newCompetency->title = $customCompetency;
                    $newCompetency->role_id = $project->role_id;
                    $newCompetency->user_id = Auth::id();

                    $newCompetency->save();
                    array_push($newCompetencyArray, $newCompetency->id);
                }

                $newCompetencies = Competency::find($newCompetencyArray);
                $project->competencies()->attach($newCompetencies);
            }

            // dd($request->input('thumbnail-deleted'));

            if($request->input('thumbnail-deleted') != "false") {
                if($request->file('thumbnail')) {
                    $project->thumbnail = $request->file('thumbnail')->getClientOriginalName();
                    $project->url = Storage::disk('gcs')->put('/thumbnails', $request->file('thumbnail'), 'public');
                } else {
                    $project->thumbnail = "";
                    $project->url = "";
                }
            } 

            if($request->file('thumbnail')) {
                $project->thumbnail = $request->file('thumbnail')->getClientOriginalName();
                $project->url = Storage::disk('gcs')->put('/thumbnails', $request->file('thumbnail'), 'public');
            }

            $project->save();

            // remove tasks if any
            $removedTasksIdArray = $request->input('tasks-deleted');

            if($removedTasksIdArray != null) {
                $removedTasksIdArray = explode(",",$removedTasksIdArray);
                foreach($removedTasksIdArray as $removedTaskId) {
                    Task::destroy($removedTaskId);
                    Answer::where('task_id', $removedTaskId)->delete();
                }
            }

            // go through each task so that the updated ones are in
            $taskCounter = 1;
            while($request->input('todo-title_'.$taskCounter) != null || $request->input('todo-description_'.$taskCounter) != null || $request->input('todo_'.$taskCounter) != null) {

                // need to check the remaining tasks
                // some are existing tasks that we do not want to change its id
                // some are new tasks that need to be saved

                // this is to check whether or not there is an existing id
                if($request->input('task-id_'.$taskCounter)) {
                    // this means that this task exists
                    // need to update
                    $task = Task::find($request->input('task-id_'.$taskCounter));
                } else {
                    $task = new Task;
                }

                $task->title = $request->input('todo-title_'.$taskCounter);
                $task->description = $request->input('todo-description_'.$taskCounter);

                if($request->input('todo_'.$taskCounter) == "mcq") {
                    $task->mcq = true;
                    $task->open_ended = false;
                    $task->na = false;
                } else if($request->input('todo_'.$taskCounter) == "open-ended") {
                    $task->open_ended = true;
                    $task->mcq = false;
                    $task->na = false;
                } else if($request->input('todo_'.$taskCounter) == "na") {
                    $task->na = true;
                    $task->mcq = false;
                    $task->open_ended = false;
                }

                if($request->input('checkbox-file-upload_'.$taskCounter) != null) {
                    $task->file_upload = true;
                } else {
                    $task->file_upload = false;
                }

                if($request->input('checkbox-multiple-select_'.$taskCounter) != null) {
                    $task->multiple_select = true;
                } else {
                    $task->multiple_select = false;
                }

                $task->project_id = $project->id;

                $task->save();

                // remove answers if any
                $removedAnswersIdArray = $request->input('answers-deleted');

                if($removedAnswersIdArray != null) {
                    $removedAnswersIdArray = explode(",",$removedAnswersIdArray);
                    foreach($removedAnswersIdArray as $removedAnswerId) {
                        Answer::destroy($removedAnswerId);
                    }
                }

                // add answers if any
                if($request->input('todo_'.$taskCounter) == 'mcq') {
                    // need to check whether the answer we are looping already exist
                    // get the id, if there is, that means answer exist, so just update
                    // if no id, create new answer

                    $answerCounter = 1;
                    
                    while($request->input('answer_'.$taskCounter.'_'.$answerCounter) != null) {

                        if($request->input('deleted-answer-id_'.$taskCounter.'_'.$answerCounter) != null) {
                            $answer = Answer::find($request->input('deleted-answer-id_'.$taskCounter.'_'.$answerCounter));
                        } else {
                            $answer = new Answer;
                        }

                        $answer->title = $request->input('answer_'.$taskCounter.'_'.$answerCounter);
                        $answer->task_id = $task->id;

                        $answer->save();

                        $answerCounter++;
                    }
                }

                $taskCounter++;
            }

            // dissociate all removed files
            $removedFilesIdArray = $request->input('files-deleted');

            if($removedFilesIdArray != null) {
                $removedFilesIdArray = explode(",",$removedFilesIdArray);
                foreach($removedFilesIdArray as $removedFileId) {
                    ProjectFile::destroy($removedFileId);
                }
            }

            // dd($request->file('file-1'));

            if($request->file('file-1')) {
                for($fileCounter = 0; $fileCounter < count($request->file('file-1')); $fileCounter++) {

                    $projectFile = new ProjectFile;

                    $projectFile->title = $request->file('file-1')[$fileCounter]->getClientOriginalName();
                    $projectFile->size = $request->file('file-1')[$fileCounter]->getSize();
                    $projectFile->url = Storage::disk('gcs')->put('/assets', $request->file('file-1')[$fileCounter], 'public');
                    $projectFile->mime_type = $request->file('file-1')[$fileCounter]->getMimeType();
                    $projectFile->project_id = $project->id;

                    $projectFile->save();
                }
            }

            $roleSlug = Role::find($project->role_id)->slug;

            return redirect('/roles/'.$roleSlug.'/projects/'.$project->slug);
        }
    }
}
