@extends ('layouts.main')

@section ('content')
<div class="container">
  <div class="row">
    <div class="col-12 col-lg-12 col-xl-12">
      
      <!-- Header -->
      <div class="header mt-md-5">
        <div class="header-body">

          <h6 class="header-pretitle">
            Overview
          </h6>

          <!-- Title -->
          <h1 class="header-title" style="display: inline-block; height: 100%; margin-top: 5px;">
            Projects
          </h1>
          @if(Auth::user()->creator)
          <a href="/projects/select-role" class="btn btn-primary d-block d-md-inline-block" style="float: right; display: inline-block;">
            Add Project
          </a>
          @endif

          <div class="row align-items-center">
            <div class="col">
              
              <!-- Nav -->
              <ul class="nav nav-tabs nav-overflow header-tabs">
                <li class="nav-item">
                  <a href="/projects-overview" class="nav-link active">
                    Created Projects
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/projects-overview/attempted" class="nav-link">
                    Attempted Projects
                  </a>
                </li>
              </ul>

            </div>
          </div>

        </div>
      </div>

      <!-- Card -->

    </div>
  </div> <!-- / .row -->
  <div class="row">
    @foreach($projects as $project)
    <div class="col-12 col-md-6 col-xl-4">
      <div class="card">
        <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}">
          @if($project->url)
          <img src="https://storage.googleapis.com/talentail-123456789/{{$project->url}}" alt="..." class="card-img-top">
          @else
          <img src="https://images.unsplash.com/photo-1482440308425-276ad0f28b19?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=95f938199a2d20d027c2e16195089412&auto=format&fit=crop&w=1050&q=80" alt="..." class="card-img-top">
          @endif
        </a>
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col">
          
              <!-- Title -->
              
              <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}"><h2 class="card-title mb-2 name">{{$project->title}}</h2></a>
              

              <!-- Subtitle -->
              <p style="margin-top: 1.25rem;">
                {{$project->description}}
              </p>

            </div>
          </div> <!-- / .row -->

          <!-- Divider -->
          <hr>

          <div class="row align-items-center">
            <div class="col">
              
              <!-- Time -->
              <p class="card-text small text-muted">
                {{$project->created_at->diffForHumans()}}
              </p>

            </div>
            <div class="col-auto">
              
              <!-- Avatar group -->
              <div class="avatar-group">
                <a href="profile-posts.html" class="avatar avatar-xs" data-toggle="tooltip" title="" data-original-title="Ab Hadley">
                  <img src="/img/avatars/profiles/avatar-2.jpg" alt="..." class="avatar-img rounded-circle">
                </a>
                <a href="profile-posts.html" class="avatar avatar-xs" data-toggle="tooltip" title="" data-original-title="Adolfo Hess">
                  <img src="/img/avatars/profiles/avatar-3.jpg" alt="..." class="avatar-img rounded-circle">
                </a>
                <a href="profile-posts.html" class="avatar avatar-xs" data-toggle="tooltip" title="" data-original-title="Daniela Dewitt">
                  <img src="/img/avatars/profiles/avatar-4.jpg" alt="..." class="avatar-img rounded-circle">
                </a>
                <a href="profile-posts.html" class="avatar avatar-xs" data-toggle="tooltip" title="" data-original-title="Miyah Myles">
                  <img src="/img/avatars/profiles/avatar-5.jpg" alt="..." class="avatar-img rounded-circle">
                </a>
              </div>

            </div>
          </div> <!-- / .row -->
        </div> <!-- / .card-body -->
      </div>
    </div>
    @endforeach
  </div> <!-- / .row -->
</div>

@endsection

@section ('footer')
    
    

@endsection