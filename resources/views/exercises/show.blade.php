@extends ('layouts.main')

@section ('content')
<div class="header">
  <div class="container">
    @if (session('feedbackSent'))
    <div class="alert alert-primary" role="alert" id="successAlert" style="text-align: center; margin-top: 1.5rem;">
      <h4 class="alert-heading" style="margin-bottom: 0;">{{session('feedbackSent')}}</h4>
    </div>
    @endif
    <div class="row" style="margin-top: 3rem;">
      <div class="col-lg-9">
        <h1>Exercise Instructions</h1>
          <div class="card">
            <div class="card-body" style="padding-bottom: 0.5rem;">
              <h3>{{$exercise->solution_title}}</h3>
              <input type="hidden" name="task_1" value="107">
              <p>{{$exercise->solution_description}}</p>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <h1>Exercise Brief</h1>
              <div class="card">
                <div class="card-body exercise-brief" style="margin-bottom: -1rem;">
                  @parsedown($exercise->brief)
                  @if(count($exercise->exercise_files) > 0)
                  <hr style="margin-top: 1.5rem; margin-bottom: 1.5rem;"/>
                  <h3>Exercise Files</h3>
                  <ul style="margin-left: -1.4rem;">
                    @foreach($exercise->exercise_files->sortBy('title') as $exerciseFile) 
                      <li><a href="https://storage.googleapis.com/talentail-123456789/{{$exerciseFile->url}}">{{$exerciseFile->title}}</a></li>
                    @endforeach
                  </ul>
                  @endif
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="col-lg-3">
        <div class="card">
          <div class="card-body">
            <h3>{{$exercise->title}}</h3>
            <span class="badge badge-soft-secondary" style="margin-bottom: .84375rem; white-space: normal;">{{$exercise->task->title}}</span>
            <p>{{$exercise->description}}</p>
            <p class="card-text small text-muted" style="margin-bottom: 0;">Estimated Time Taken</p>
            <p>{{$exercise->duration}}</p>
            <p class="card-text small text-muted" style="margin-bottom: 0;">Opportunities</p>
            <p>{{count($exercise->opportunities)}}</p>
            <p class="card-text small text-muted" style="margin-bottom: 0.25rem;">Attempts</p>
            @if(count($exercise->answered_exercises) > 0)
            <div class="row">
              <div class="col-auto mr-n3" style="margin-bottom: 1.5rem;">

                <div class="avatar-group d-none d-sm-flex">
                  @foreach($exercise->answered_exercises as $answeredExercise)
                  <a href="/profile/{{$answeredExercise->user->id}}" class="avatar avatar-xs" data-toggle="tooltip" title="" data-original-title="{{$answeredExercise->user->name}}">
                    @if($answeredExercise->user->avatar)
                     <img src="https://storage.googleapis.com/talentail-123456789/{{$answeredExercise->user->avatar}}" alt="..." class="avatar-img rounded-circle">
                    @else
                    <img src="https://api.adorable.io/avatars/150/{{$answeredExercise->user->email}}.png" alt="..." class="avatar-img rounded-circle">
                    @endif
                  </a>
                  @endforeach
                </div>
              </div>
              @if(count($exercise->answered_exercises) > 3)
              <div class="col" style="padding-left: 0rem;">
                <span class="small">+{{count($exercise->answered_exercises) - 3}} others</span>
              </div>
              @endif
            </div>
            @else
            <p>{{count($exercise->answered_exercises)}}</p>
            @endif

            <form id="attemptForm" method="POST" action="/exercises/{{$exercise->slug}}/attempt-exercise" enctype="multipart/form-data">
              @csrf

              <input type="hidden" name="exerciseId" value="{{$exercise->id}}" />
              <button type="submit" class="btn btn-primary btn-block" id="saveTaskAttempt">Attempt Exercise</button>
            </form>

            @if(Auth::id() && Auth::user()->admin)
              <a href="/exercises/{{$exercise->slug}}/edit" class="btn btn-block btn-light" style="margin-top:0.5rem;">Edit</a>
              @if($exercise->visible)
              <a href="#" class="btn btn-block btn-light" style="margin-top: 0.5rem;" onclick="toggleVisibility()">Make Private</a>
              @else
              <a href="#" class="btn btn-block btn-light" style="margin-top: 0.5rem;" onclick="toggleVisibility()">Make Public</a>
              @endif
            @endif

            <a href="/exercises/{{$exercise->slug}}/feedback" class="btn btn-block btn-link">Feedback</a>

            <form method="POST" action="/exercises/{{$exercise->slug}}/toggle-visibility">
              @csrf
              <button type="submit" style="display: none;" id="toggleExerciseButton" />
            </form>
          </div>
        </div>
        @if(count($exercise->answer_files) > 0)
        <div class="card">
          <div class="card-body" style="padding-bottom: 0.5rem;">
          	@if(Auth::id())
            <h3>Answers</h3>
            <ul style="margin-left: -1.4rem;">
              @foreach($exercise->answer_files->sortBy('title') as $answerFile) 
                <li><a href="https://storage.googleapis.com/talentail-123456789/{{$answerFile->url}}">{{$answerFile->title}}</a></li>
              @endforeach
            </ul>
            @else
            <h3>Answers - Login to download</h3>
            <ul style="margin-left: -1.4rem;">
              @foreach($exercise->answer_files->sortBy('title') as $answerFile) 
                <li>{{$answerFile->title}}</li>
              @endforeach
            </ul>
            @endif
          </div>
        </div>
        @endif
        @if(!empty($exercise) && count($exercise->opportunities) > 0)
        <div class="card">
          <div class="card-body">
            <h3>Job Opportunities Requiring This Competency</h3>
            <ul style="margin-left: -1.4rem; margin-bottom: 0rem;">
              @foreach($exercise->opportunities as $opportunity)
              <li><a href="/opportunities/{{$opportunity->role->slug}}/{{$opportunity->slug}}">{{$opportunity->title}} - {{$opportunity->company->title}}, {{$opportunity->location}}</a></li>
              @endforeach
            </ul>
          </div>
        </div>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="col-lg-9">
        
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function toggleVisibility() {
    event.preventDefault();
    document.getElementById("toggleExerciseButton").click();
  }
</script>

<script type="text/javascript">
  setTimeout(function(){ document.getElementById("successAlert").style.display = "none" }, 3000);
</script>
@endsection

@section ('footer')   
@endsection