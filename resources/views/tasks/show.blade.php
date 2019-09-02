@extends ('layouts.main')

@section ('content')
<div class="container">
  <div class="row" style="margin-top: 3rem;">
      <div class="col-lg-12" style="text-align: center; margin-bottom: 2.5rem;">
        <h1 style="font-size: 1.5rem;">{{$task->title}}</h1>
        <p>Each exercise may be mapped to one or more job opportunities</p>
      </div>
    @foreach($task->exercises as $exercise)
      @if($exercise->visible)
      <div class="col-12 col-md-6 col-xl-4">
        <div class="card">
          <!-- <a href="/exercises/{{$exercise->slug}}">

            @if($exercise->url)
            <img src="https://storage.googleapis.com/talentail-123456789/{{$exercise->url}}" alt="..." class="card-img-top">
            @else
            <img src="https://images.unsplash.com/photo-1482440308425-276ad0f28b19?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=95f938199a2d20d027c2e16195089412&auto=format&fit=crop&w=1050&q=80" alt="..." class="card-img-top">
            @endif

          </a> -->
          <div class="card-body">
            <!-- Title -->
            <a href="/exercises/{{$exercise->slug}}"><h2 class="card-title text-center mb-3">
              {{$exercise->solution_title}}
            </h2></a>

            <!-- Text -->

            <p class="card-text text-center mb-4" style="margin-bottom: 1rem !important;">
              {{$exercise->title}}
            </p>  

            <p class="card-text text-center text-muted mb-4">
              {{$exercise->duration}}
            </p>

            <!-- Divider -->
            <hr>

            <div class="row align-items-center" style="text-align: center;">

              <div class="col">
                
                <p class="card-text small text-muted" style="margin-bottom: 0;">Opportunities</p>
                <p style="margin-bottom: 0;">{{count($exercise->opportunities)}}</p>

              </div>

              <div class="col">
                
                <p class="card-text small text-muted" style="margin-bottom: 0;">Attempts</p>
                <p style="margin-bottom: 0;">{{count($exercise->answered_exercises)}}</p>

              </div>

              @if(Auth::id() && Auth::user()->admin)
              	<div class="col">
              	  
              	  <p class="card-text small text-muted" style="margin-bottom: 0;">Answers</p>
              	  <p style="margin-bottom: 0;">{{count($exercise->answer_files)}}</p>

              	</div>
              @endif
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