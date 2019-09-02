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
            <img src="/img/gray-avatar.png" alt="..." class="avatar-img rounded-circle border border-4 border-body">
          </div>

        </div>
        <div class="col mb-3 ml--3 ml-md--2">
          
          <!-- Pretitle -->
          <h6 class="header-pretitle">
            @if($user->creator)
                Guide
            @else
                Traveller
            @endif
          </h6>

          <!-- Title -->
          <h1 class="header-title">
            {{$user->name}}
          </h1>

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
        <div class="col-12 col-md-auto mt-2 mt-md-0 mb-md-3" style="margin-bottom: 0rem !important;">
          
          <!-- Button -->
          <a href="#!" class="btn btn-primary d-block d-md-inline-block">
            Message
          </a>

        </div>
      </div> <!-- / .row -->
      <div class="row align-items-center">
        <div class="col">
          
          <!-- Nav -->
          <ul class="nav nav-tabs nav-overflow header-tabs">
            <li class="nav-item">
              @if(Auth::id() == $user->id)
              <a href="/profile" class="nav-link">
              Work Experience
              </a>
              @else
              <a href="/profile/{{$user->id}}" class="nav-link">
              Work Experience
              </a>
              @endif
            </li>
            <li class="nav-item">
                @if(Auth::id() == $user->id)
                <a href="/profile/lessons" class="nav-link active">
                Lessons
                </a>
                @else
                <a href="/profile/{{$user->id}}/lessons" class="nav-link active">
                Lessons
                </a>
                @endif
            </li>
            <li class="nav-item">
                @if(Auth::id() == $user->id)
                <a href="/profile/projects" class="nav-link">
                Projects
                </a>
                @else
                <a href="/profile/{{$user->id}}/projects" class="nav-link">
                Projects
                </a>
                @endif
            </li>
            <li class="nav-item">
                @if(Auth::id() == $user->id)
                <a href="/profile/interviews" class="nav-link">
                Interviews
                </a>
                @else
                <a href="/profile/{{$user->id}}/interviews" class="nav-link">
                Interviews
                </a>
                @endif
            </li>
            <li class="nav-item">
              @if(Auth::id() == $user->id)
              <a href="/profile/reviews" class="nav-link">
              Reviews
              </a>
              @else
              <a href="/profile/{{$user->id}}/reviews" class="nav-link">
              Reviews
              </a>
              @endif
            </li>
          </ul>

        </div>
      </div>
    </div> <!-- / .header-body -->

  </div>
</div>
<div class="container">
  <div class="row">
    
  </div> <!-- / .row -->
</div>
@endsection

@section ('footer')
@endsection