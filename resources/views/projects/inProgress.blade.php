@extends ('layouts.main')

@section ('content')

  <div class="header">
    <div class="container">
      <div class="alert alert-primary" style="margin-top: 1.5rem; text-align: center;">
        <h4 style="margin-bottom: 0;">Still in progress by <a href="/profile/{{$attemptedProject->user_id}}">{{$attemptedProject->user->name}}</a>.</h4>
      </div>

      <!-- Body -->
      <div class="header-body" style="margin-top: 1.5rem; border-bottom: 0px;">
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
          <div class="col">

          </div>
        </div>
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
            
            <!-- Pretitle -->
            <h6 class="header-pretitle">
              Projects
            </h6>

            <!-- Title -->
            <h1 class="header-title">
              {{$project->title}}
            </h1>

            <p>{{$project->description}}</p>

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
                      <p>{{$key+1}}. {{$task->title}}</p>
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
                              Purchase Project to Download
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
                <p>What you'll be getting from your purchase:</p>
                <ul style="margin-left: -1.4rem;">
                  <li>Practical work experience</li>
                  <li>Assessment by a senior business analyst</li>
                  <li>An endorsed work portfolio after completion of project (<a href="/portfolios/0">See example</a>)</li>
                  <li>A better shot at landing that interview</li>
                </ul>
                @if($addedToCart) 
                <button class="btn btn-block btn-primary" disabled>
                  Added to Cart
                </button>
                @else
                <button class="btn btn-block btn-primary" onclick="addProjectToCart()">
                  Add to Cart<br/>${{$project->amount}}
                </button>
                @endif
              @else
                <a href="/roles/{{$role->slug}}/projects/{{$project->slug}}/edit" class="btn btn-block btn-primary">Edit Project</a>
                @if($project->published)
                  <button onclick="toggleVisibilityProject()" class="btn btn-block btn-light">Make Private</button>
                @else
                  <button onclick="toggleVisibilityProject()" class="btn btn-block btn-light">Publish Project</button>
                @endif
                <hr/>
                <a href="/roles/{{$role->slug}}/projects/{{$project->slug}}/{{$attemptedProject->user_id}}/workspace" class="btn btn-block btn-light">Project Workspace</a>
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

    function addProjectToCart() {
      document.getElementById("addProjectToCartButton").click();
    }

    function toggleVisibilityProject() {
      document.getElementById("toggleVisibilityProjectButton").click();
    }
  </script>
@endsection

@section ('footer')
@endsection