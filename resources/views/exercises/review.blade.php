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
              <p>{{$exercise->solution_description}}</p>
              <div style="margin-top: 1.5rem; margin-bottom: 0.5rem;"></div>
              @if(count($answeredExercise->answered_exercise_files) > 0)
              <div style="margin-bottom: 0.5rem;">
                @foreach($answeredExercise->answered_exercise_files as $answeredExerciseFile)
                <div id="file-group_{{$answeredExerciseFile->id}}">
                  <a href="https://storage.googleapis.com/talentail-123456789/{{$answeredExerciseFile->url}}">{{$answeredExerciseFile->title}}</a> 
                  @if($answeredExercise->status == "Attempted")
                  <span id="delete-file_{{$answeredExercise->id}}_{{$answeredExerciseFile->id}}" class="remove-file" onclick="deleteFile()" style="border-color: transparent; margin-right: 0px; padding: 0px;"><i class="fas fa-times-circle" id="span_{{$answeredExercise->id}}_{{$answeredExerciseFile->id}}"></i></span>
                  <br/>
                  @endif
                </div>
                @endforeach
              </div>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              @if($answeredExercise->status == "Submitted For Review")
              <form id="taskForm" method="POST" class="mb-4" action="/exercises/{{$exercise->slug}}/{{$answeredExercise->user_id}}/submit-review" enctype="multipart/form-data">
                @csrf
                <h1>Your Review</h1>
                  <div class="form-group">
                    <div id="test-editormd3" style="border-radius: 0.5rem;">
                        <textarea style="display:none;" name="response"></textarea>
                    </div>
                    <div id="old-response" style="display: none;">{{ old('response') }}</div>
                  </div>

                  <div class="form-group">
                    <label class="mb-1">
                      Status
                    </label>
                    <select class="form-control" data-toggle="select" name="status">
                      <option value="Nil">Select status</option>
                      <option value="Competent">Competent</option>
                      <option value="Needs Improvement">Needs Improvement</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label class="mb-1">
                      Review files
                    </label>

                    <div class="box">
                      <input type="file" name="file[]" id="file" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple="" style="visibility: hidden; background-color: #076BFF;">
                      <label for="file" style="position: absolute; left: 0; margin-left: 0.75rem; margin-bottom: 1.5rem;  border-radius: 0.25rem !important; padding: 0.5rem 1rem 0.5rem 1rem; background: #2c7be5; color: white;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17" fill="white"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg> <span style="font-size: 1rem;">Choose Files</span></label>
                    </div>
                    <div id="selectedFiles" style="margin-top: 1.5rem;"></div>
                  </div>
                  <input type="hidden" name="answeredExerciseId" value="{{$answeredExercise->id}}" />

                  <button type="submit" class="btn btn-block btn-primary" style=" margin-top: 0.5rem;">
                    Submit Review
                  </button>
                  <a href="/dashboard" class="btn btn-block btn-link text-muted">
                    Cancel
                  </a>
              </form>
              @else
              <h1>Your Review</h1>
              <div class="card">
                <div class="card-body">
                  @if($answeredExercise->status == "Needs Improvement")
                    <span class="badge badge-danger" style="margin-bottom: .84375rem; white-space: normal;">{{$answeredExercise->status}}</span>
                  @else
                    <span class="badge badge-success" style="margin-bottom: .84375rem; white-space: normal;">{{$answeredExercise->status}}</span>
                  @endif
                  @parsedown($answeredExercise->response)
                  @if(count($answeredExercise->response_files) > 0)
                  <hr/>
                    @foreach($answeredExercise->response_files as $responseFile)
                      <a href="#">{{$responseFile->title}}</a>
                      <br/>
                    @endforeach
                  @endif
                </div>
              </div>
              @endif
            </div>
          </div>
          <hr class="mt-4 mb-5">
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
                  <a href="/profile/1" class="avatar avatar-xs" data-toggle="tooltip" title="" data-original-title="{{$answeredExercise->user->name}}">
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
            <p class="card-text small text-muted" style="margin-bottom: 0;">{{count($exercise->answered_exercises)}}</p>
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
        @if(!empty($exercise) && count($exercise->opportunities) > 0)
        <div class="card">
          <div class="card-body">
            <h3>Job Opportunities Requiring This Competency</h3>
            <ul style="margin-left: -1.4rem; margin-bottom: 0rem;">
              @foreach($exercise->opportunities as $opportunity)
              <li><a href="/opportunities/{{$opportunity->slug}}">{{$opportunity->title}} - {{$opportunity->company->title}}, {{$opportunity->location}}</a></li>
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

<script type="text/javascript" src="/js/editormd.js"></script>
<script src="/js/languages/en.js"></script>

<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  var editor2 = editormd({
      id   : "test-editormd3",
      path : "/lib/",
      height: 640,
      placeholder: "Create exercise response...",
      onload : function() {
          //this.watch();
          //this.setMarkdown("###test onloaded");
          //testEditor.setMarkdown("###Test onloaded");
          // editor2.insertValue(document.getElementById("brief-info").innerHTML);
          editor2.insertValue(document.getElementById("old-response").innerHTML);
      }
  });

  document.addEventListener("DOMContentLoaded", init, false);
  
  function init() {
    var selectedFile = 'selectedFiles';
    document.querySelector('#file').addEventListener('change', handleFileSelect, false);
  }

  function handleFileSelect(e) {
    console.log("handleFileSelect");
    console.log(e.target.files);
    if(!e.target.files) return;
    document.getElementById('selectedFiles').innerHTML = "";
    
    var files = e.target.files;
    for(var i=0; i<files.length; i++) {
      var f = files[i];
      
      document.getElementById('selectedFiles').innerHTML += f.name + "<br/>";
    }
  }
</script>
@endsection

@section ('footer')   
@endsection