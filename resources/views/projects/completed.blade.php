@extends ('layouts.main')

@section ('content')
  <form method="POST" action="/roles/{{$role->slug}}/projects/{{$project->slug}}/toggle-visibility-project" id="toggleVisibilityProject">
    @csrf
    <input type="hidden" name="project_id" value="{{$project->id}}" />
    <input type="hidden" name="role_slug" value="{{$project->role->slug}}" />
    <input type="hidden" name="project_slug" value="{{$project->slug}}" />
    <button type="submit" style="display: none;" id="toggleVisibilityProjectButton">Submit</button>
  </form>
  <form method="POST" action="/roles/{{$role->slug}}/projects/{{$project->slug}}/purchase-project" id="purchaseProject">
    @csrf
    <input type="hidden" name="project_id" value="{{$project->id}}" />
    <input type="hidden" name="role_slug" value="{{$project->role->slug}}" />
    <input type="hidden" name="project_slug" value="{{$project->slug}}" />
    <button type="submit" style="display: none;" id="purchaseProjectButton">Submit</button>
  </form>

  <div class="header">
    <div class="container">
      <div class="alert alert-primary" style="margin-top: 1.5rem; text-align: center;">
        <h4 style="margin-bottom: 0;">This project has been completed. <a href="/profile/{{$project->user->id}}">{{$project->user->name}}</a> has been notified to review your submission.</h4>
      </div>
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
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}" class="nav-link active">
                  Overview
                </a>
                @else
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}" class="nav-link">
                  Overview
                </a>
                @endif
              </li>
              <li class="nav-item">
                @if($parameter == 'task') 
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/tasks" class="nav-link active">
                  Tasks
                </a>
                @else
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/tasks" class="nav-link">
                  Tasks
                </a>
                @endif
              </li>
              <li class="nav-item">
                @if($parameter == 'file') 
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/files" class="nav-link active">
                  Files
                </a>
                @else
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/files" class="nav-link">
                  Files
                </a>
                @endif
              </li>
              <li class="nav-item">
                @if($parameter == 'competency') 
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/competencies" class="nav-link active">
                  Competencies
                </a>
                @else
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/competencies" class="nav-link">
                  Competencies
                </a>
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
      <form id="attemptForm" method="POST" action="/roles/{{$role->slug}}/projects/{{$project->slug}}/submit-project-attempt" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="project_id" value="{{$project->id}}" />
        <input type="hidden" name="role_slug" value="{{$project->role->slug}}" />
        <input type="hidden" name="project_slug" value="{{$project->slug}}" />
      @foreach($answeredTasks as $key=>$answeredTask)
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body" style="padding-bottom: 1.5rem;">
                <p>{{$key+1}}. {{$answeredTask->task->title}}</p>
                <p>{{$answeredTask->task->description}}</p>
                @if(!$answeredTask->task->na)
                <strong>Your Answer:</strong> 
                @endif
                <p>{{$answeredTask->answer}}</p>

                @if($answeredTask->task->file_upload)
                  <strong>Your Files:</strong> 
                  <br/>
                    @foreach($answeredTask->answered_task_files as $answered_task_file)
                      <a href="https://storage.googleapis.com/talentail-123456789/{{$answered_task_file->url}}">{{$answered_task_file->title}}</a>
                      <br/>
                    @endforeach 
                @endif
              </div> <!-- / .card-body -->
            </div>
          </div>
        </div>
      @endforeach
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
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body" style="padding-bottom: 0.5rem;">
              @if(count($project->competencies))
                @foreach($project->competencies as $competency)
                <div class="form-group" style="margin-bottom: 0rem;">
                      <span style="float: left;">🌟</span>
                      <p style="margin-left: 2rem;">
                        {{$competency->title}}
                      </p>
                </div>
              @endforeach
              @else
                <p>No competencies tagged to this project yet.</p>
              @endif
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>

  <script type="text/javascript">
  </script>
@endsection

@section ('footer')
@endsection