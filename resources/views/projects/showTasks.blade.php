@extends ('layouts.main')

@section ('content')
  <div class="header">
    <div class="container">

      <!-- Body -->
      <div class="header-body">
        <div class="row align-items-center">
          <div class="col-12 col-md-auto mt-3 mt-md-0">
            
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
              <img src="{{$project->url}}" alt="..." class="avatar-img rounded">
              @else
              <img src="/img/avatars/projects/project-1.jpg" alt="..." class="avatar-img rounded">
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
        <div class="row align-items-center">
          <div class="col">
            
            <!-- Nav -->
            <ul class="nav nav-tabs nav-overflow header-tabs">
              <li class="nav-item">
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}" class="nav-link">
                  Overview
                </a>
              </li>
              <li class="nav-item">
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/tasks" class="nav-link active">
                  Tasks
                </a>
              </li>
              <li class="nav-item">
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/files" class="nav-link">
                  Files
                </a>
              </li>
              <li class="nav-item">
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/competencies" class="nav-link">
                  Competencies
                </a>
              </li>
            </ul>

          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    @foreach($tasks as $task)
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body role-brief">
            
          </div> <!-- / .card-body -->
        </div>
      </div>
    </div>
    @endforeach
  </div>
@endsection

@section ('footer')
@endsection