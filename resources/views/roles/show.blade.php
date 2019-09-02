@extends ('layouts.main')

@section ('content')
<div class="container">
  <div class="row" style="margin-top: 3rem;">
      <div class="col-lg-12" style="text-align: center; margin-bottom: 2.5rem;">
        <h1 style="font-size: 1.5rem;">{{$role->title}} Tasks</h1>
        <p>Complete exercises under each listed tasks below</p>
      </div>
    @foreach($tasks as $task)
      @if(count($task->exercises) > 0)
      <div class="col-12 col-md-6 col-xl-4">
        <div class="card">
          <div class="card-body">
            <!-- Title -->
            <a href="/tasks/{{$task->slug}}"><h2 class="card-title text-center mb-3">
              {{$task->title}}
            </h2></a>

            <!-- Text -->

            <p class="card-text text-center mb-4" style="margin-bottom: 0rem !important; overflow: hidden; text-overflow: ellipsis;display: -webkit-box; max-height: 72px; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
              {{$task->description}}
            </p>  

            <!-- Divider -->
            <hr>

            <div class="row align-items-center" style="text-align: center;">
              <div class="col">
                
                <p class="card-text small text-muted" style="margin-bottom: 0;">Exercises</p>
                <p style="margin-bottom: 0;">{{count($task->exercises)}}</p>

              </div>

              <div class="col">
                
                <p class="card-text small text-muted" style="margin-bottom: 0;">Opportunities</p>
                <p style="margin-bottom: 0;">{{count($task->opportunities)}}</p>

              </div>

              <div class="col">
                
                <p class="card-text small text-muted" style="margin-bottom: 0;">Attempts</p>
                <p style="margin-bottom: 0;">{{count($task->answered_exercises)}}</p>

              </div>
            </div> 
          </div>
        </div>
      </div>
      @endif
    @endforeach
  </div>
</div>
@endsection

@section ('footer')   
@endsection