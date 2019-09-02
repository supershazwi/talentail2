@extends ('layouts.main')

@section ('content')
<div class="header">
  <div class="container">
    @if(session('saved'))
      <div class="alert alert-success" style="margin-top: 1.5rem; text-align: center;" id="reviewSaved">
        <h4 style="margin-bottom: 0;">{{session('saved')}}</h4>
      </div>
      @endif
    @if($attemptedProject->status == "Completed")
    <div class="alert alert-primary" style="margin-top: 1.5rem; text-align: center;">
      <h4>This project has been completed by <a href="/profile/{{$answeredTasks[0]->user_id}}">{{$answeredTasks[0]->user->name}}</a>. Please review the following:</h4>
      <ul style="margin-bottom: 0; list-style: none;">
        @foreach($competencyAndTaskMessages as $competencyAndTaskMessage)
          <li style="color: white !important;">{{$competencyAndTaskMessage}}</li>
        @endforeach
      </ul>
    </div>
    @else
      @if($attemptedProject->user_id != Auth::id())
        @if($attemptedProject->status == "Assessed")
        <div class="alert alert-primary" style="margin-top: 1.5rem; text-align: center;">
          <h4 style="margin-bottom: 0;">This project has been reviewed. {{$attemptedProject->user->name}} has been notified. 
            @if(!$reviewLeftByCreator)
            <a href="/roles/{{$role->slug}}/projects/{{$project->slug}}/{{$reviewedUserId}}/review" class="pull-right">Leave an overall review</a></h4>
            @endif
        </div>
        @else
        <div class="alert alert-primary" style="margin-top: 1.5rem; text-align: center;">
          <h4 style="margin-bottom: 0;">This project has been reviewed. {{$attemptedProject->user->name}} has been notified.</h4>
        </div>
        @endif
      @else
        @if($attemptedProject->status == "Assessed")
        <div class="alert alert-primary" style="margin-top: 1.5rem; text-align: center;">
          <h4 style="margin-bottom: 0;">This project has been reviewed by {{$project->user->name}}. 
            @if(!$reviewLeftByApplicant)
              <a href="/roles/{{$role->slug}}/projects/{{$project->slug}}/review" class="pull-right">Leave an overall review</a>
            @endif
          </h4>
        </div>
        @else
        <div class="alert alert-primary" style="margin-top: 1.5rem; text-align: center;">
          <h4 style="margin-bottom: 0;">This project has been reviewed by {{$project->user->name}}.
            @if(!$reviewLeftByApplicant)
              <a href="/roles/{{$role->slug}}/projects/{{$project->slug}}/review" class="pull-right">Leave an overall review</a>
            @endif
          </h4>
        </div>
        @endif
      @endif
    @endif

    <input type="hidden" id="answeredTasksArray" value="{{implode(',', $answeredTasksArray)}}" />
    <!-- Body -->
    <div class="header-body">
      <div class="row align-items-center">
        <div class="col-auto">
          
          <!-- Avatar group -->
          <div class="avatar-group">
            @if(Auth::id() == $project->user->id)
            <a href="/profile" class="avatar">
            @else
            <a href="/profile/{{$project->user->id}}" class="avatar">
            @endif


            @if($project->user->avatar)
            <img src="https://storage.googleapis.com/talentail-123456789/{{$project->user->avatar}}" alt="..." class="avatar-img rounded-circle">
            @else
            <img src="/img/avatar.png" alt="..." class="avatar-img rounded-circle">
            @endif
            </a>
          </div>

          <!-- Button -->
          @if(Auth::id() == $project->user->id)
          <a href="/profile" style="margin-left: 0.5rem !important;">
            {{$project->user->name}}
          </a>
          @else
          <a href="/profile/{{$project->user->id}}" style="margin-left: 0.5rem !important;">
            {{$project->user->name}}
          </a>
          @endif

        </div>
      </div>
      <div class="row align-items-top" style="margin-top: 1.5rem;">
          <div class="col-auto">

            <!-- Avatar -->
            <div class="avatar avatar-lg avatar-4by3">
              @if($project->url)
              <img src="https://storage.googleapis.com/talentail-123456789/{{$project->url}}" alt="..." class="avatar-img rounded">
              @else
              <img src="/img/avatars/projects/project-1.jpg" alt="..." class="avatar-img rounded">
              @endif
            </div>

          </div>
          <div class="col ml--3 ml-md--2">
          
            <!-- Title -->
            <h1 class="header-title">
              {{$project->title}}
            </h1>

            <p style="margin-bottom: 0.5rem;">{{$project->description}}</p>
            <span class="badge badge-warning">{{$project->industry->title}}</span>

          </div>
        </div> <!-- / .row -->
      <div class="row align-items-center">
        <div class="col">
          
          <!-- Nav -->
          <ul class="nav nav-tabs nav-overflow header-tabs">
            <li class="nav-item">
              @if($parameter == 'overview')
                @if($reviewedUserId == 0)
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}" class="nav-link active">
                  Overview
                </a>
                @else
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/{{$attemptedProject->user_id}}" class="nav-link active">
                  Overview
                </a>
                @endif
              @else
                @if($reviewedUserId == 0)
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}" class="nav-link">
                  Overview
                </a>
                @else
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/{{$attemptedProject->user_id}}" class="nav-link">
                  Overview
                </a>
                @endif
              @endif
            </li>
            <li class="nav-item">
              @if($parameter == 'task') 
                @if($reviewedUserId == 0)
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/tasks" class="nav-link active">
                  Tasks
                </a>
                @else
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/{{$attemptedProject->user_id}}/tasks" class="nav-link active">
                  Tasks
                  @if($tasksReviewed)
                  <sup>Reviewed</sup>
                  @else
                  <sup>To Review</sup>
                  @endif
                </a>
                @endif
              @else
                @if($reviewedUserId == 0)
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/tasks" class="nav-link">
                  Tasks
                </a>
                @else
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/{{$attemptedProject->user_id}}/tasks" class="nav-link">
                  Tasks
                  @if($tasksReviewed)
                  <sup>Reviewed</sup>
                  @else
                  <sup>To Review</sup>
                  @endif
                </a>
                @endif
              @endif
            </li>
            <li class="nav-item">
              @if($parameter == 'file') 
                @if($reviewedUserId == 0)
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/files" class="nav-link active">
                  Files
                </a>
                @else
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/{{$attemptedProject->user_id}}/files" class="nav-link active">
                  Files
                </a>
                @endif
              @else
                @if($reviewedUserId == 0)
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/files" class="nav-link">
                  Files
                </a>
                @else
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/{{$attemptedProject->user_id}}/files" class="nav-link">
                  Files
                </a>
                @endif
              @endif
            </li>
            <li class="nav-item">
              @if($parameter == 'competency') 
                @if($reviewedUserId == 0)
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/competencies" class="nav-link active">
                  Competencies
                </a>
                @else
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/{{$attemptedProject->user_id}}/competencies" class="nav-link active">
                  Competencies
                  @if($competenciesReviewed)
                  <sup>Reviewed</sup>
                  @else
                  <sup>To Review</sup>
                  @endif
                </a>
                @endif
              @else
                @if($reviewedUserId == 0)
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/competencies" class="nav-link">
                  Competencies
                </a>
                @else
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/{{$attemptedProject->user_id}}/competencies" class="nav-link">
                  Competencies
                  @if($competenciesReviewed)
                  <sup>Reviewed</sup>
                  @else
                  <sup>To Review</sup>
                  @endif
                </a>
                @endif
              @endif
            </li>
          </ul>

        </div>
      </div>
    </div>
  </div>
</div>

<div class="container">
    @if($parameter == 'overview')
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body role-brief">
            @parsedown($project->brief)
          </div> <!-- / .card-body -->
        </div>
      </div>
    </div>
    @elseif($parameter == 'task')
      <form id="reviewProject" method="POST" action="/roles/{{$role->slug}}/projects/{{$project->slug}}/{{$reviewedUserId}}/tasks" enctype="multipart/form-data">
      @csrf
      @foreach($answeredTasks as $key=>$answeredTask)
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body" style="padding-bottom: 1.5rem;">
                <p>{{$key+1}}. {{$answeredTask->task->title}}</p>
                <p>{{$answeredTask->task->description}}</p>
                @if(!$answeredTask->task->na)
                <strong>Submitted Answer:</strong> 
                @endif
                <p>{{$answeredTask->answer}}</p>

                @if($answeredTask->task->file_upload)
                  @if(count($answeredTask->answered_task_files) > 0)
                  <strong>Submitted Files:</strong> 
                  <br/>
                  @endif
                    @foreach($answeredTask->answered_task_files as $answered_task_file)
                      @if($loop->last)
                      <p><a href="https://storage.googleapis.com/talentail-123456789/{{$answered_task_file->url}}">{{$answered_task_file->title}}</a></p>
                      @else
                      <p style="margin-bottom: 0rem;"><a href="https://storage.googleapis.com/talentail-123456789/{{$answered_task_file->url}}">{{$answered_task_file->title}}</a></p>
                      @endif
                    @endforeach 
                @endif
                @if($attemptedProject->status=="Completed")
                  @if($tasksReviewed)
                  <strong>Your Response:</strong>
                  @if(count($answeredTask->reviewed_answered_task_files) > 0)
                    <p>{{$answeredTask->response}}</p>
                  @else
                    <p style="margin-bottom: 0rem;">{{$answeredTask->response}}</p>
                  @endif
                  @else
                  <strong>Your Response:</strong>
                  <textarea name="response_{{$answeredTask->id}}" class="form-control" placeholder="Type your response" rows="8">{{$answeredTask->response}}</textarea>
                  <div class="box" style="margin-top: 1.5rem;">
                    <input type="file" name="file_{{$answeredTask->id}}[]" id="file_{{$answeredTask->id}}" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple style="visibility: hidden; background-color: #076BFF;"/>
                    <label for="file_{{$answeredTask->id}}" style="position: absolute; left: 0; margin-left: 1.5rem; margin-bottom: 1.5rem;  border-radius: 0.25rem !important; padding: 0.5rem 1rem 0.5rem 1rem; background: #2c7be5; color: white;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17" fill="white"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span style="font-size: 1rem;">Choose Files</span></label>
                  </div>
                  <div id="selectedFiles_{{$answeredTask->id}}" style="margin-top: 1.5rem; margin-bottom: 0rem;"></div>
                  @endif
                @else
                <strong>Creator's Response:</strong>
                @if(count($answeredTask->reviewed_answered_task_files) > 0)
                <p>{{$answeredTask->response}}</p>
                @else
                <p style="margin-bottom: 0;">{{$answeredTask->response}}</p>
                @endif
                @endif

                @if(count($answeredTask->reviewed_answered_task_files) > 0)
                  <strong style="margin-top: 0.5rem;">Creator's Submitted Files:</strong> 
                  <br/>
                    @foreach($answeredTask->reviewed_answered_task_files as $reviewed_answered_task_file)
                    <div id="file-group_{{$reviewed_answered_task_file->id}}">
                      <a href="https://storage.googleapis.com/talentail-123456789/{{$reviewed_answered_task_file->url}}">{{$reviewed_answered_task_file->title}}</a> 

                      @if(!$attemptedProject->competency_and_task_review->tasks_reviewed)
                      <span id="delete-file_{{$answeredTask->id}}_{{$reviewed_answered_task_file->id}}" class="remove-file" onclick="deleteFile()" style="border-color: transparent; margin-right: 0px; padding: 0px;"><i class="fas fa-times-circle" id="span_{{$answeredTask->id}}_{{$reviewed_answered_task_file->id}}"></i></span>
                      @endif
                      <br/>
                    </div>
                    @endforeach
                @endif
              </div> <!-- / .card-body -->
            </div>
          </div>
        </div>
        <input type="hidden" name="files-deleted_{{$answeredTask->id}}" id="files-deleted_{{$answeredTask->id}}" />
      @endforeach
      <input type="hidden" id="loggedInUserId" value="{{Auth::id()}}" />
      <input type="hidden" name="submissionType" id="submissionType" />
      <input type="submit" style="display: none;" id="submitProjectReview" />
      </form>
    @elseif($parameter == 'file')
      <div class="row">
        <div class="col-lg-12">
          <div class="card" data-toggle="lists" data-lists-values='["name"]'>
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col">
                  
                  <!-- Title -->
                  <h4 class="card-header-title">
                    Files
                  </h4>

                </div>
                <div class="col-auto">
                  
                  <!-- Dropdown -->
                  <div class="dropdown">

                    <!-- Toggle -->
                    <a href="#!" class="small text-muted dropdown-toggle" data-toggle="dropdown">
                      Sort order
                    </a>

                    <!-- Menu -->
                    <div class="dropdown-menu">
                      <a class="dropdown-item sort" data-sort="name" href="#!">
                        Asc
                      </a>
                      <a class="dropdown-item sort" data-sort="name" href="#!">
                        Desc
                      </a>
                    </div>

                  </div>
          
                </div>
              </div> <!-- / .row -->
            </div>
            <div class="card-body">

              <!-- List -->
              <ul class="list-group list-group-lg list-group-flush list my--4">
                @if(count($project->project_files))
                @foreach($project->project_files as $projectFile) 
                  <li class="list-group-item px-0">
                  <div class="row align-items-center">
                    <div class="col">
                      <h4 class="card-title mb-1 name">
                        <a href="#!">{{$projectFile->title}}</a>
                      </h4>
                    </div>
                    <div class="col-auto">
                      <a href="https://storage.googleapis.com/talentail-123456789/{{$projectFile->url}}" download="{{$projectFile->title}}" class="btn btn-sm btn-white d-none d-md-inline-block">
                        Download
                      </a>
                    </div>
                  </div>
                </li>
                @endforeach 
                @else
                <li class="list-group-item px-0">
                  <div class="row align-items-center">
                    <div class="col">
                      <p style="margin-bottom: 0;">No files attached to this project yet.</p>
                    </div>
                  </div>
                </li>
                @endif
              </ul>

            </div>
          </div>
        </div>
      </div>
    @else
      <form id="reviewProject" method="POST" action="/roles/{{$role->slug}}/projects/{{$project->slug}}/{{$reviewedUserId}}/competencies">
      @csrf
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body" style="padding-bottom: 0.5rem;">
                @if(count($project->competencies))
                  @if($competenciesReviewed)
                    @foreach($attemptedProject->competency_scores as $competencyScore)
                    <div class="form-group">
                      <span style="float: left;">🌟</span>
                      <p style="margin-left: 2rem;">
                        {{$competencyScore->competency->title}}
                      </p>
                      <div class="btn-group-toggle" style="margin-bottom: 1rem;">
                        @if($competencyScore->score == 1)
                        <label class="btn btn-white active focus" id="label_poor" onclick="poor()">
                          <input type="radio" value="Poor" id="poor" onclick="poor()" disabled> 
                          <i class="far fa-tired"></i> Poor - 1
                        </label>
                        @else
                        <label class="btn btn-white" id="label_poor" onclick="poor()">
                          <input type="radio" value="Poor" id="poor" onclick="poor()" disabled> 
                          <i class="far fa-tired"></i> Poor - 1
                        </label>
                        @endif
                        @if($competencyScore->score == 2)
                        <label class="btn btn-white active focus" id="label_fair" onclick="fair()">
                          <input type="radio" value="Fair" id="fair" onclick="fair()" disabled> 
                          <i class="far fa-frown"></i> Fair - 2
                        </label>
                        @else
                        <label class="btn btn-white" id="label_fair" onclick="fair()">
                          <input type="radio" value="Fair" id="fair" onclick="fair()" disabled> 
                          <i class="far fa-frown"></i> Fair - 2
                        </label>
                        @endif
                        @if($competencyScore->score == 3)
                        <label class="btn btn-white active focus" id="label_average" onclick="average()">
                          <input type="radio" value="Average" id="average" onclick="average()" disabled> 
                          <i class="far fa-meh"></i> Average - 3
                        </label>
                        @else
                        <label class="btn btn-white" id="label_average" onclick="average()">
                          <input type="radio" value="Average" id="average" onclick="average()" disabled> 
                          <i class="far fa-meh"></i> Average - 3
                        </label>
                        @endif
                        @if($competencyScore->score == 4)
                        <label class="btn btn-white active focus" id="label_good" onclick="good()">
                          <input type="radio" value="Good" id="good" onclick="good()" disabled> 
                          <i class="far fa-smile"></i> Good - 4
                        </label>
                        @else
                        <label class="btn btn-white" id="label_good" onclick="good()">
                          <input type="radio" value="Good" id="good" onclick="good()" disabled> 
                          <i class="far fa-smile"></i> Good - 4
                        </label>
                        @endif
                        @if($competencyScore->score == 5)
                        <label class="btn btn-white focus active" id="label_excellent" onclick="excellent()">
                          <input type="radio" value="Excellent" id="excellent" onclick="excellent()" disabled> 
                          <i class="far fa-grin-stars"></i> Excellent - 5
                        </label>
                        @else
                        <label class="btn btn-white" id="label_excellent" onclick="excellent()">
                          <input type="radio" value="Excellent" id="excellent" onclick="excellent()" disabled> 
                          <i class="far fa-grin-stars"></i> Excellent - 5
                        </label>
                        @endif
                      </div>
                    </div>
                    @endforeach
                  @else
                    @foreach($attemptedProject->competency_scores as $competencyScore)
                    <div class="form-group">
                      <span style="float: left;">🌟</span>
                      <p style="margin-left: 2rem;">
                        {{$competencyScore->competency->title}}
                      </p>
                      <div class="btn-group-toggle" data-toggle="buttons" style="margin-bottom: 1rem;">
                        @if($competencyScore->score == 1)
                        <label class="btn btn-white active" id="label_poor" onclick="poor()">
                        @else
                        <label class="btn btn-white" id="label_poor" onclick="poor()">
                        @endif
                          <input type="radio" name="rating_{{$competencyScore->id}}" value="Poor" id="poor" onclick="poor()"> 
                          <i class="far fa-tired"></i> Poor - 1
                        </label>
                        @if($competencyScore->score == 2)
                        <label class="btn btn-white active" id="label_fair" onclick="fair()">
                        @else
                        <label class="btn btn-white" id="label_fair" onclick="fair()">
                        @endif
                          <input type="radio" name="rating_{{$competencyScore->id}}" value="Fair" id="fair" onclick="fair()"> 
                          <i class="far fa-frown"></i> Fair - 2
                        </label>
                        @if($competencyScore->score == 3)
                        <label class="btn btn-white active" id="label_average" onclick="average()">
                        @else
                        <label class="btn btn-white" id="label_average" onclick="average()">
                        @endif
                          <input type="radio" name="rating_{{$competencyScore->id}}" value="Average" id="average" onclick="average()"> 
                          <i class="far fa-meh"></i> Average - 3
                        </label>
                        @if($competencyScore->score == 4)
                        <label class="btn btn-white active" id="label_good" onclick="good()">
                        @else
                        <label class="btn btn-white" id="label_good" onclick="good()">
                        @endif
                          <input type="radio" name="rating_{{$competencyScore->id}}" value="Good" id="good" onclick="good()"> 
                          <i class="far fa-smile"></i> Good - 4
                        </label>
                        @if($competencyScore->score == 5)
                        <label class="btn btn-white active" id="label_excellent" onclick="excellent()">
                        @else
                        <label class="btn btn-white" id="label_excellent" onclick="excellent()">
                        @endif
                          <input type="radio" name="rating_{{$competencyScore->id}}" value="Excellent" id="excellent" onclick="excellent()"> 
                          <i class="far fa-grin-stars"></i> Excellent - 5
                        </label>
                      </div>
                    </div>
                    @endforeach
                  @endif
                @else
                  <p>No competencies tagged to this project yet.</p>
                @endif
              </div>
            </div>
          </div>
        </div>
      <input type="hidden" id="loggedInUserId" value="{{Auth::id()}}" />
      <input type="hidden" name="attemptedProjectId" value="{{$attemptedProject->id}}" />
      <input type="hidden" name="submissionType" id="submissionType" />
      <input type="submit" style="display: none;" id="submitCompetencyReview" />
      </form>
    @endif
    @if($attemptedProject->status == "Completed")
      @if($parameter == 'task' && !$tasksReviewed)
      <button class="btn btn-light" onclick="saveProjectReview()">Save Review</button>
      <button class="btn btn-primary" onclick="submitProjectReview()" style="margin-left: 0.5rem;">Submit Review</button>
      @endif
      @if($parameter == 'competency' && !$competenciesReviewed)
      <button class="btn btn-light" onclick="saveCompetencyReview()">Save Review</button>
      <button class="btn btn-primary" onclick="submitCompetencyReview()" style="margin-left: 0.5rem;">Submit Review</button>
      @endif
    @endif
  </div>

  <script type="text/javascript">
    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });

    function keyPress() {
        var key = window.event.keyCode;

        if (key === 13) {
            var messageText = document.getElementById("chat-input").value;
            var data = {message_text: messageText, clickedUserId: document.getElementById("clickedUserId").value, messageChannel: document.getElementById("messageChannel").value, projectId: document.getElementById("projectId").value};
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
               type:'POST',
               url:'/messages/'+document.getElementById("clickedUserId").value,
               data: data,
               success:function(data){

               }
            });
        }
    }

    if(document.getElementById("clickedUserId") != null) {
        var pusher = new Pusher("5491665b0d0c9b23a516", {
          cluster: 'ap1',
          forceTLS: true,
          auth: {
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              }
        });

        var channel = pusher.subscribe(document.getElementById("messageChannel").value);
        channel.bind('new-message', function(data) {
            console.log(data);
            if(data.avatar == "") {
              document.getElementById("newMessagesDiv").insertAdjacentHTML("beforeend", "<div class='media chat-item'><img alt='" + data.username + "' src='/img/avatar.png' class='avatar'><div class='media-body' style='padding: 0.7rem 1rem;'><div class='chat-item-title'><span class='chat-item-author SPAN-filter-by-text' data-filter-by='text'>" + data.username + "</span><span data-filter-by='text' class='SPAN-filter-by-text'>Just now</span></div><div class='chat-item-body DIV-filter-by-text' data-filter-by='text'><p>" + data.text + "</p></div></div></div>");
            } else {
              document.getElementById("newMessagesDiv").insertAdjacentHTML("beforeend", "<div class='media chat-item'><img alt='" + data.username + "' src='https://storage.googleapis.com/talentail-123456789/" + data.avatar + "' class='avatar'><div class='media-body' style='padding: 0.7rem 1rem;'><div class='chat-item-title'><span class='chat-item-author SPAN-filter-by-text' data-filter-by='text'>" + data.username + "</span><span data-filter-by='text' class='SPAN-filter-by-text'>Just now</span></div><div class='chat-item-body DIV-filter-by-text' data-filter-by='text'><p>" + data.text + "</p></div></div></div>");
            }
            
            document.getElementById("newMessagesDiv").scrollTop = document.getElementById("newMessagesDiv").scrollHeight;
            
            document.getElementById("chat-input").value = "";
        }); 
    }

    var selDiv = "";
    
    document.addEventListener("DOMContentLoaded", init, false);
  
    function init() {
      var answeredTasksArray = document.getElementById("answeredTasksArray").value.split(",");

      answeredTasksArray.forEach(function (item, index) {
        if(document.querySelector('#file_' + item)) {
          document.querySelector('#file_' + item).addEventListener('change', handleFileSelect, false);
        } 
      })
    }
    
    function handleFileSelect(e) {
      if(!e.target.files) return;

      var idString = e.target.id.split("_");
      var idFromString = idString[1];

      document.getElementById('selectedFiles_' + idFromString).innerHTML = "";
      var files = e.target.files;
      for(var i=0; i<files.length; i++) {
        var f = files[i];
        document.getElementById('selectedFiles_' + idFromString).innerHTML += f.name + "<br/>";
      }
    }

    function submitProjectReview() {
      document.getElementById("submissionType").value = "Submit";
      document.getElementById("submitProjectReview").click();
    }

    function saveProjectReview() {
      document.getElementById("submissionType").value = "Save";
      document.getElementById("submitProjectReview").click();
    }

    function submitCompetencyReview() {
      document.getElementById("submissionType").value = "Submit";
      document.getElementById("submitCompetencyReview").click();
    }

    function saveCompetencyReview() {
      document.getElementById("submissionType").value = "Save";
      document.getElementById("submitCompetencyReview").click();
    }

    function highlightButtons() {
      document.getElementById("circleChat").style.background = "#0156cf";
      document.getElementById("circleChat").style.borderColor = "#0156cf";
      document.getElementById("rectangleChat").style.background = "#0156cf";
      document.getElementById("rectangleChat").style.borderColor = "#0156cf";
    }

    function unhighlightButtons() {
      document.getElementById("circleChat").style.background = "#076bff";
      document.getElementById("circleChat").style.borderColor = "#076bff";
      document.getElementById("rectangleChat").style.background = "#076bff";
      document.getElementById("rectangleChat").style.borderColor = "#076bff";
    }

    function deleteFile() {
      let fileIdString = event.target.id.split("_");
      let answeredTaskId = fileIdString[1];
      let answeredTaskFileId = fileIdString[2];

      if(document.getElementById("files-deleted_"+answeredTaskId).value == "") {
        document.getElementById("files-deleted_"+answeredTaskId).value += answeredTaskFileId;
      } else {
        document.getElementById("files-deleted_"+answeredTaskId).value += ", " + answeredTaskFileId;
      }

      let elem = document.getElementById("file-group_"+answeredTaskFileId);
      elem.parentNode.removeChild(elem);
    }

    setTimeout(function(){ document.getElementById("reviewSaved").style.display = "none" }, 3000);

  </script>

  <script type="text/javascript">
      $(function () {
          var pusher = new Pusher("5491665b0d0c9b23a516", {
            cluster: 'ap1',
            forceTLS: true,
            auth: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }
          });

          toastr.options = {
              positionClass: 'toast-bottom-right'
          };     

          if(document.getElementById('loggedInUserId').value == document.getElementById('projectOwner').value) {
            var messageChannel = pusher.subscribe('messages_' + document.getElementById('loggedInUserId').value);
            messageChannel.bind('new-message', function(data) {
                toastr.options.onclick = function () {
                    window.location.replace(data.url);
                };

                toastr.info("<strong>" + data.username + "</strong><br />" + data.message); 
            });
          }

          var purchaseChannel = pusher.subscribe('purchases_' + document.getElementById('loggedInUserId').value);
          purchaseChannel.bind('new-purchase', function(data) {
              toastr.success(data.username + ' ' + data.message); 
          });
      })
  </script>
@endsection

@section ('footer')
@endsection