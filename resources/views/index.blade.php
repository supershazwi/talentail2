@extends ('layouts.main')

@section ('content')
<div class="container">
  <div class="row align-items-center" style="margin-top: 5rem;">
    <div class="col-12 col-md-6 offset-xl-2 offset-md-1 order-md-2 mb-5 mb-md-0">
      <div class="text-center">
        <img src="/img/exercises.svg" alt="..." class="img-fluid">
      </div>
    </div>
    <div class="col-12 col-md-5 col-xl-4 order-md-1 my-5">
      <h1 class="display-4 mb-3">
      Practice <span style="color: #0984e3;">makes</span> perfect
      </h1>
      <h1 style="color: #777d7f;">Talentail is the only repository you need to attempt exercises adapted from real-world examples.</h1>
    </div>
  </div>
  <hr style="margin-top: 7.5rem; margin-bottom: 2.5rem;"/>
  <div class="row">
    <div class="col-lg-12" style="text-align: center; margin-bottom: 2.5rem;">
      <h1 style="font-size: 1.5rem;">Browse Tasks By Role</h1>
      <p>Tasks are grouped according to specific roles. There are several exercises grouped per task.</p>
      <!-- <p style="color: #3e3e3c; margin-bottom: 0rem;">Browse these categories and complete the respective tasks (<a href="#">Not sure how to go about this?</a>)</p> -->
    </div>
    @foreach($roles as $role)
      <div class="col-12 col-md-6 col-xl-4">
        <div class="card">
          <div class="card-body">
            <!-- Title -->
            <a href="/roles/{{$role->slug}}"><h2 class="card-title text-center mb-3">
              {{$role->title}}
            </h2></a>

            <!-- Text -->

            <p class="card-text text-center mb-4" style="margin-bottom: 0rem !important; overflow: hidden; text-overflow: ellipsis;display: -webkit-box; max-height: 72px; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
              {{$role->description}}
            </p>  


            <!-- Divider -->
            <hr>

            <div class="row align-items-center" style="text-align: center;">
              <div class="col">
                
                <p class="card-text small text-muted" style="margin-bottom: 0;">Tasks</p>
                <p style="margin-bottom: 0;">{{count($role->exercises->groupBy('task_id'))}}</p>

              </div>

              <div class="col">
                
                <p class="card-text small text-muted" style="margin-bottom: 0;">Exercises</p>
                <p style="margin-bottom: 0;">{{count($role->exercises)}}</p>

              </div>
            </div> 

          </div>
        </div>
      </div>
    @endforeach
  </div>
  <!-- <hr style="margin-top: 5rem;"/> -->
  <!-- <div class="row" style="margin-top: 5rem;">
    <div class="col-12 col-md-6 order-md-1 mb-5 mb-md-0">
      <div class="text-center">
        <img src="/img/illustrations/lost.svg" alt="..." class="img-fluid">
      </div>
    </div>
    <div class="col-12 col-md-5 col-xl-4 offset-xl-1 offset-md-1 order-md-1 my-5">
      <h1 class="display-4 mb-3">
        Common <span style="color: #e74c3c;">challenges</span> faced by new job seekers:
      </h1>
      <ul style="list-style: none;margin-left: 0;padding-left: 2.2em;text-indent: -2.2em;">
        <li><h1 style="color: #777d7f;">😫 No relevant work experience</h1></li>
        <li><h1 style="color: #777d7f;">😫 Not given an opportunity to showcase competencies</h1></li>
        <li><h1 style="color: #777d7f;">😫 Staying ahead of the competition</h1></li>
      </ul>
    </div>
  </div>
  <hr style="margin-top: 5rem;"/>
  <div class="row" style="margin-top: 5rem;">
    <div class="col-12 col-md-6 offset-xl-2 offset-md-1 order-md-2 mb-5 mb-md-0">
      <div class="text-center">
        <img src="/img/illustrations/scale.svg" alt="..." class="img-fluid">
      </div>
    </div>
    <div class="col-12 col-md-5 col-xl-4 order-md-1 my-5">
      <h1 class="display-4 mb-3">
        <span style="color: #0984e3;">Complete exercises</span> and be given a platform to:
      </h1>
      <ul style="list-style: none;margin-left: 0;padding-left: 2.2em;text-indent: -2.2em;">
        <li><h1 style="color: #777d7f;">😁 Showcase your competencies through tangible work</h1></li>
        <li><h1 style="color: #777d7f;">😁 Get first hand experience on what it takes to perform on a role</h1></li>
        <li><h1 style="color: #777d7f;">😁 Set yourself apart from other job seekers</h1></li>
      </ul>
    </div>
  </div> -->
  <!-- <hr style="margin-top: 5rem;"/>
  <div class="row" style="margin-top: 5rem;">
    <div class="col-12 col-lg-4">
      <div class="row no-gutters align-items-center justify-content-center">
        <div class="col-auto">
          <div class="display-2 mb-0">25</div>
        </div>
      </div>
      <div class="text-center">
        <h1 style="color: #777d7f; margin-bottom: 0;">Projects</h1>
      </div>
    </div>
    <div class="col-12 col-lg-4">
      <div class="row no-gutters align-items-center justify-content-center">
        <div class="col-auto">
          <div class="display-2 mb-0">15</div>
        </div>
      </div>
      <div class="text-center">
        <h1 style="color: #777d7f; margin-bottom: 0;">Porfolios Endorsed</h1>
      </div>
    </div>
    <div class="col-12 col-lg-4">
      <div class="row no-gutters align-items-center justify-content-center">
        <div class="col-auto">
          <div class="display-2 mb-0">10</div>
        </div>
      </div>
      <div class="text-center">
        <h1 style="color: #777d7f; margin-bottom: 0;">Companies</h1>
      </div>
    </div>
  </div> -->
  <!-- @if(!Auth::id())
  <hr style="margin-top: 5rem;"/>
  <div class="row justify-content-center" style="margin-top: 5rem; display: block; text-align: center;">
    <h1>
        Start practising and become<br/> the best you today
      </h1>
    <a href="/register" class="btn btn-lg btn-primary mb-3">
        Register
    </a>
  </div>
  @endif -->
</div>
@endsection

@section ('footer')   
@endsection