@extends ('layouts.main')

@section ('content')
<div class="container">
  <div class="row align-items-center" style="margin-top: 7.5rem;">
    <div class="col-lg-8 offset-lg-2" style="text-align: center;">
      <h1 class="display-4 mb-3">
        <span style="border-bottom: 5px solid #0984e3; text-transform: uppercase;">{{$category->title}}</span>
      </h1>
      <h1 style="color: #3e3e3c; margin-bottom: 0rem; font-size: 1.5rem;">{{$category->description}}</h1>
    </div>
  </div>
  <hr style="margin-top: 7.5rem; margin-bottom: 2.5rem;"/>
  <div class="row">
    <div class="col-lg-12" style="text-align: center; margin-bottom: 2.5rem;">
      <h1 style="font-size: 1.5rem; margin-bottom: 0rem;">TASKS</h1>
      <!-- <p style="color: #3e3e3c; margin-bottom: 0rem;">Complete tasks and unlock job opportunities (<a href="#">Not sure how to go about this?</a>)</p> -->
    </div>
    @foreach($category->tasks as $task)
      <div class="col-12 col-md-6 col-xl-4">
        <div class="card">
          <div class="card-body">
            <!-- Title -->
            <a href="/tasks/{{$task->slug}}"><h2 class="card-title text-center mb-3">
              {{$task->title}}
            </h2></a>

            <!-- Text -->

            <p class="card-text text-center mb-4" style="margin-bottom: 1rem !important;">
              {{$task->description}}
            </p>  

            <p class="card-text text-center text-muted mb-4">
              {{$task->duration}}
            </p>

            <!-- Divider -->
            <hr>

            <div class="row align-items-center">
              <div class="col">
                
                <!-- Time -->
                <p class="card-text small text-muted" style="margin-bottom: 0;">Attempts</p>
                <p style="margin-bottom: 0;">{{$task->attempts}}</p>

              </div>
              <!-- <div class="col-auto">
                <p class="card-text small text-muted" style="margin-bottom: 0;">Job Opportunities</p>
                <p style="margin-bottom: 0;">{{$task->opportunities}}</p>
              </div> -->
            </div> <!-- / .row -->
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
<!-- Start of HubSpot Embed Code -->
  <!-- Start of Async Drift Code -->
<!-- End of Async Drift Code -->
<!-- End of HubSpot Embed Code --> 
@endsection

@section ('footer')   
@endsection