@extends ('layouts.main')

@section ('content')
<div class="header">
  
  <div class="container" style="margin-top: 5rem;">

    <!-- Body -->
    <div class="header-body mt--5 mt-md--6">
      <div class="row align-items-top">
        <div class="col-auto">
          
          <!-- Avatar -->
          <div class="avatar avatar-xxl header-avatar-top">
              @if($user->avatar)
               <img src="https://storage.googleapis.com/talentail-123456789/{{$user->avatar}}" alt="..." class="avatar-img rounded-circle border border-4 border-body">
              @else
              <img src="https://api.adorable.io/avatars/150/{{$user->email}}.png" alt="..." class="avatar-img rounded-circle border border-4 border-body">
              @endif
          </div>
        </div>
        <div class="col mb-3 ml--3 ml-md--2">
          
          <!-- Pretitle -->
          <h6 class="header-pretitle">
            @if($user->creator)
                Creator
            @else
                Member
            @endif
          </h6>

          <!-- Title -->
          <h1 class="header-title">
            {{$user->name}}
          </h1>
          <p>{{$user->email}}</p>

          <p>{{$user->description}}</p>

          @if($user->website)
          <a target="_blank" href="{{$user->website}}" style="margin-right: 0.5rem;"><i class="fas fa-link"></i></a>
          @endif
          @if($user->linkedin)
          <a target="_blank" href="{{$user->linkedin}}" style="margin-right: 0.5rem;"><i class="fab fa-linkedin"></i></a>
          @endif
          @if($user->facebook)
          <a target="_blank" href="{{$user->facebook}}" style="margin-right: 0.5rem;"><i class="fab fa-facebook-square"></i></a>
          @endif
          @if($user->twitter)
          <a target="_blank" href="{{$user->twitter}}"><i class="fab fa-twitter-square"></i></a>
          @endif
        </div>
        <!-- @if($showMessage)
        <div class="col-12 col-md-auto mt-2 mt-md-0 mb-md-3" style="margin-bottom: 0rem !important;">

          <a href="/messages/{{$user->id}}" class="btn btn-primary d-block d-md-inline-block">
            Message
          </a>

        </div>
        @endif -->
      </div> <!-- / .row -->
      <div class="row align-items-center">
        <div class="col">
          
          <!-- Nav -->
          <ul class="nav nav-tabs nav-overflow header-tabs">
            <li class="nav-item">
              @if(Auth::id() == $user->id)
              <a href="/profile" class="nav-link active">
              Portfolios
              </a>
              @else
              <a href="/profile/{{$user->id}}" class="nav-link active">
              Portfolios
              </a>
              @endif
            </li>
            <!-- <li class="nav-item">
              @if(Auth::id() == $user->id)
              <a href="/profile/resume" class="nav-link">
              Resume
              </a>
              @else
              <a href="/profile/{{$user->id}}/resume" class="nav-link">
              Resume
              </a>
              @endif
            </li> -->
            <!-- @if($user->creator)
            <li class="nav-item">
                @if(Auth::id() == $user->id)
                <a href="/profile/projects" class="nav-link">
                Created Projects
                </a>
                @else
                <a href="/profile/{{$user->id}}/projects" class="nav-link">
                Created Projects
                </a>
                @endif
            </li>
            @endif -->
            <!-- <li class="nav-item">
              @if(Auth::id() == $user->id)
              <a href="/profile/reviews" class="nav-link">
              Reviews
              </a>
              @else
              <a href="/profile/{{$user->id}}/reviews" class="nav-link">
              Reviews
              </a>
              @endif
            </li> -->
          </ul>

        </div>
      </div>
    </div> <!-- / .header-body -->

  </div>
</div>
<div class="container">
  <div class="row">
    @if(count($user->portfolios) > 0)
    @foreach($user->portfolios as $portfolio)
    <div class="col-12 col-md-6 col-xl-4">
      <div class="card">
        <div class="card-body">

          <!-- Title -->
          <a href="/portfolios/{{$portfolio->id}}"><h2 class="card-title text-center mb-3">
            {{$portfolio->role->title}}
          </h2></a>

          <p style="margin-bottom: 0rem !important;">{{$portfolio->role->description}}</p>

          <!-- Divider -->
          <hr>

          <div class="row align-items-right">
            <div class="col">
              <p class="card-text small text-muted" style="margin-bottom: 0;">Reviewed Exercises</p>
              <p style="margin-bottom: 0;">{{$reviewedExercisesCount}}</p>
            </div>
            <!-- <div class="col-auto">
              <p class="card-text small text-muted" style="margin-bottom: 0;">Endorsed by</p>
              <div class="avatar-group">
                @foreach($portfolio->attempted_projects as $attemptedProject)
                <a href="/profile/{{$attemptedProject->project->user_id}}" class="avatar avatar-xs" data-toggle="tooltip" title="" data-original-title="{{$attemptedProject->project->user->name}}">
                  @if($attemptedProject->project->user->avatar)
                   <img src="https://storage.googleapis.com/talentail-123456789/{{$attemptedProject->project->user->avatar}}" alt="..." class="avatar-img rounded-circle"/>
                  @else
                  <img src="/img/avatar.png" alt="..." class="avatar-img rounded-circle"/>
                  @endif
                </a>
                @endforeach
              </div>

            </div> -->
          </div> <!-- / .row -->

        </div> <!-- / .card-body -->
      </div>
    </div>
    @endforeach
    @else
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body" style="text-align: center;">
          <h1>😃</h1>
          <p style="margin-bottom: 0;">Your portfolio will be built once you start attempting exercises.</p>
          <a href="/roles/business-analyst">Discover tasks</a>
        </div>
      </div>
    </div>
    @endif
    <!-- @if($user->id == Auth::id())
    <div class="col-12 col-md-6 col-xl-4">
      <div class="card">
        <div class="card-body text-center">
          <h1><i class="far fa-plus-square"></i></h1>
          <a href="/portfolios/select-role">
            <h2 class="card-title text-center mb-3" style="">
                Add Portfolio
              </h2>
            </a>
            <p style="margin-top: 1.5rem !important; margin-bottom: 0;">No material to build a portfolio?</p>
            <a href="/roles/business-analyst">Discover tasks</a>
        </div> 
      </div>
    </div>
    @endif -->
  </div> <!-- / .row -->
</div>

<!-- Start of HubSpot Embed Code -->
  <!-- Start of Async Drift Code -->
<!-- End of Async Drift Code -->
<!-- End of HubSpot Embed Code --> 
@endsection

@section ('footer')
@endsection