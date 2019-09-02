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
          <h1 class="header-title">
            Projects
          </h1>

          <div class="row align-items-center">
            <div class="col">
              
              <!-- Nav -->
              <ul class="nav nav-tabs nav-overflow header-tabs">
                @if(Auth::user()->creator)
                <li class="nav-item">
                  <a href="/projects-overview" class="nav-link">
                    Created Projects
                  </a>
                </li>
                @endif
                <li class="nav-item">
                  <a href="/projects-overview/attempted" class="nav-link active">
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
    @foreach($attemptedProjects as $attemptedProject)
    <div class="col-12 col-md-6 col-xl-4">
      <div class="card">
        <a href="/roles/{{$attemptedProject->project->role->slug}}/projects/{{$attemptedProject->project->slug}}">
          @if($attemptedProject->project->url)
          <img src="https://storage.googleapis.com/talentail-123456789/{{$attemptedProject->project->url}}" alt="..." class="card-img-top">
          @else
          <img src="https://images.unsplash.com/photo-1482440308425-276ad0f28b19?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=95f938199a2d20d027c2e16195089412&auto=format&fit=crop&w=1050&q=80" alt="..." class="card-img-top">
          @endif
        </a>
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col">
          
              <!-- Title -->
              
              <a href="/roles/{{$attemptedProject->project->role->slug}}/projects/{{$attemptedProject->project->slug}}"><h2 class="card-title mb-2 name">{{$attemptedProject->project->title}}</h2></a>
              
              <div class="avatar-group" style="margin-top: 0.25rem;">
                @if(Auth::id() == $attemptedProject->project->user->id)
                <a href="/profile" class="avatar avatar-xs">
                @else
                <a href="/profile/{{$attemptedProject->project->user->id}}" class="avatar avatar-xs">
                @endif


                @if($attemptedProject->project->user->avatar)
                <img src="https://storage.googleapis.com/talentail-123456789/{{$attemptedProject->project->user->avatar}}" alt="..." class="avatar-img rounded-circle">
                @else
                <img src="/img/avatar.png" alt="..." class="avatar-img rounded-circle">
                @endif
                </a>
              </div>

              <!-- Button -->
              @if(Auth::id() == $attemptedProject->project->user->id)
              <a href="/profile" style="margin-left: 0.5rem !important;">
                {{$attemptedProject->project->user->name}}
              </a>
              @else
              <a href="/profile/{{$attemptedProject->project->user->id}}" style="margin-left: 0.5rem !important;">
                {{$attemptedProject->project->user->name}}
              </a>
              @endif

              <!-- Subtitle -->
              <p style="margin-top: 1.25rem;">
                {{$attemptedProject->project->description}}
              </p>

            </div>
          </div> <!-- / .row -->

          <!-- Divider -->
          <hr>

          <div class="row align-items-center">
            <div class="col">
              
              <!-- Time -->
              <p class="card-text small text-muted" style="margin-bottom: 0;">Last Updated</p>
              <p class="card-text small text-muted">
                {{$attemptedProject->project->created_at->diffForHumans()}}
              </p>

            </div>
            <div class="col-auto">
              
              <!-- Avatar group -->
              <p class="card-text small text-muted" style="margin-bottom: 0;">Attempted by</p>
              <div class="avatar-group">
                <a href="profile-posts.html" class="avatar avatar-xs" data-toggle="tooltip" title="" data-original-title="">
                  <img alt="Image" src="/img/avatars/profiles/avatar-female-2.jpg" class="avatar-img rounded-circle"/>
                </a>
                <a href="profile-posts.html" class="avatar avatar-xs" data-toggle="tooltip" title="" data-original-title="">
                  <img alt="Image" src="/img/avatars/profiles/avatar-female-2.jpg" class="avatar-img rounded-circle"/>
                </a>
                <a href="profile-posts.html" class="avatar avatar-xs" data-toggle="tooltip" title="" data-original-title="">
                  <img alt="Image" src="/img/avatars/profiles/avatar-female-1.jpg" class="avatar-img rounded-circle"/>
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