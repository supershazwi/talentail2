@extends ('layouts.main')

@section ('content')
  <form method="POST" action="/roles/{{$role->slug}}/projects/{{$project->slug}}/purchase-project" id="purchaseProject">
    @csrf
    <input type="hidden" name="project_id" value="{{$project->id}}" />
    <input type="hidden" name="role_slug" value="{{$project->role->slug}}" />
    <input type="hidden" name="project_slug" value="{{$project->slug}}" />
    <button type="submit" style="display: none;" id="purchaseProjectButton">Submit</button>
  </form>

  <form method="POST" action="/roles/{{$role->slug}}/projects/{{$project->slug}}/add-project-to-inventory" id="addProjectToInventory">
    @csrf
    <input type="hidden" name="project_id" value="{{$project->id}}" />
    <input type="hidden" name="role_slug" value="{{$project->role->slug}}" />
    <input type="hidden" name="project_slug" value="{{$project->slug}}" />
    <button type="submit" style="display: none;" id="addProjectToInventoryButton">Submit</button>
  </form>

  <form method="POST" action="/roles/{{$role->slug}}/projects/{{$project->slug}}/toggle-visibility-project" id="toggleVisibilityProject">
    @csrf
    <input type="hidden" name="project_id" value="{{$project->id}}" />
    <input type="hidden" name="title" value="{{$project->title}}" />
    <input type="hidden" name="competency" value="{{$project->competencies}}" />
    <input type="hidden" name="description" value="{{$project->description}}" />
    <input type="hidden" name="brief" value="{{$project->brief}}" />
    <input type="hidden" name="price" value="{{$project->amount}}" />
    <input type="hidden" name="hours" value="{{$project->hours}}" />
    <input type="hidden" name="role_slug" value="{{$project->role->slug}}" />
    <input type="hidden" name="project_slug" value="{{$project->slug}}" />
    <button type="submit" style="display: none;" id="toggleVisibilityProjectButton">Submit</button>
  </form>

  <div class="header">
    <div class="container">

      <!-- Body -->
      <div class="header-body" style="border-bottom: 0px;">
        @if(!$project->published)
          <div class="alert alert-warning" style="text-align: center;">
            <h4 class="alert-heading" style="margin-bottom: 0;">This project is private. Publish it to make it public.</h4>
          </div>
        @endif
        <!-- <div class="row align-items-center">
          <div class="col-auto">

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
          <div class="col">

          </div>
        </div> -->
        <div class="row align-items-top" style="margin-top: 1.5rem;">
          <div class="col-auto">

            <!-- Avatar -->
            <div class="avatar avatar-lg avatar-4by3">
              @if($project->url)
              <img src="https://storage.googleapis.com/talentail-123456789/{{$project->url}}" alt="..." class="avatar-img rounded">
              @else
              <img src="https://images.unsplash.com/photo-1482440308425-276ad0f28b19?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=95f938199a2d20d027c2e16195089412&auto=format&fit=crop&w=1050&q=80" alt="..." class="avatar-img rounded">
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
      </div>

      <div class="row">
        <div class="col-lg-9">
          <div class="header-body" style="padding-top: 0rem; margin-bottom: 2rem;">
            <div class="row">
              <div class="col">
                <!-- Nav -->
                <ul class="nav nav-tabs nav-overflow header-tabs">
                  <li class="nav-item">
                    @if($parameter == 'overview')
                    <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}" class="nav-link active" style="padding-top: 0rem;">
                      Overview
                    </a>
                    @else
                    <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}" class="nav-link" style="padding-top: 0rem;">
                      Overview
                    </a>
                    @endif
                  </li>
                  <li class="nav-item">
                    @if($parameter == 'task') 
                    <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/tasks" class="nav-link active" style="padding-top: 0rem;">
                      Tasks
                    </a>
                    @else
                    <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/tasks" class="nav-link" style="padding-top: 0rem;">
                      Tasks
                    </a>
                    @endif
                  </li>
                  <li class="nav-item">
                    @if($parameter == 'file') 
                    <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/files" class="nav-link active" style="padding-top: 0rem;">
                      Files
                    </a>
                    @else
                    <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/files" class="nav-link" style="padding-top: 0rem;">
                      Files
                    </a>
                    @endif
                  </li>
                  <li class="nav-item">
                    @if($parameter == 'competency') 
                    <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/competencies" class="nav-link active" style="padding-top: 0rem;">
                      Competencies
                    </a>
                    @else
                    <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/competencies" class="nav-link" style="padding-top: 0rem;">
                      Competencies
                    </a>
                    @endif
                  </li>
                </ul>
              </div>
            </div>
          </div>
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
            @foreach($project->tasks as $key=>$task)
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body" style="padding-bottom: 0.5rem;">
                      <p style="font-weight: bold;">{{$key+1}}. {{$task->title}}</p>
                      <p>{{$task->description}}</p>
                    </div> <!-- / .card-body -->
                  </div>
                </div>
              </div>
            @endforeach
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
                              {{$projectFile->title}}
                            </h4>
                          </div>
                          <div class="col-auto">
                            <a href="#!" class="btn btn-sm btn-white d-none d-md-inline-block">
                              Attempt Project to Download
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
        <div class="col-lg-3">
          <div class="card">
            <div class="card-body">
              @if($project->user_id != Auth::id())
                <p>What you'll be getting from this project:</p>
                <ul style="margin-left: -1.4rem;">
                  <li>Practical work experience</li>
                  <li>A well constructed business case to add to your <a href="/profile">portfolio</a></li>
                  <li>A workspace to post any enquiry related to the project</li>
                  <li>A better shot at landing that interview and job offer</li>
                </ul>
                @if($addedToInventory) 
                <button class="btn btn-block btn-primary" disabled>
                  Project in Progress
                </button>
                @else
                <button class="btn btn-block btn-primary" onclick="addProjectToInventory()">
                  Attempt Project
                </button>
                @endif
              @else
                <a href="/roles/{{$role->slug}}/projects/{{$project->slug}}/edit" class="btn btn-block btn-primary">Edit Project</a>
                @if($project->published)
                  <button onclick="toggleVisibilityProject()" class="btn btn-block btn-light">Make Private</button>
                @else
                  <button onclick="toggleVisibilityProject()" class="btn btn-block btn-light">Publish Project</button>
                @endif
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    function purchaseProject() {
      document.getElementById("purchaseProjectButton").click();
    }

    function addProjectToInventory() {
      document.getElementById("addProjectToInventoryButton").click();
    }

    function toggleVisibilityProject() {
      document.getElementById("toggleVisibilityProjectButton").click();
    }
  </script>

  <!-- Start of HubSpot Embed Code -->
    <!-- Start of Async Drift Code -->
<!-- End of Async Drift Code -->
  <!-- End of HubSpot Embed Code --> 
@endsection

@section ('footer')
@endsection