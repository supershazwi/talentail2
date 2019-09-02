@extends ('layouts.main')

@section ('content')
<div class="header">
  <div class="container">
    @if (session('status'))
    <div class="alert alert-primary" role="alert" id="successAlert" style="text-align: center; margin-top: 1.5rem;">
      <h4 class="alert-heading" style="margin-bottom: 0;">{{session('status')}}</h4>
    </div>
    @endif
    <div class="row" style="margin-top: 3rem;">
      <div class="col-lg-9">
          <h1>Exercise Instructions</h1>
          @if($answeredExercise->status == "Attempted")
          <form id="attemptForm" method="POST" action="/exercises/{{$exercise->slug}}/save-attempt" enctype="multipart/form-data">
          @else
          <form id="recallAttemptForm" method="POST" action="/exercises/{{$exercise->slug}}/recall-attempt">
          @endif
            @csrf

            <div class="card">
              <div class="card-body" style="padding-bottom: 0.5rem;">
                <h3>{{$exercise->solution_title}}</h3>
                <p>{{$exercise->solution_description}}</p>
                
                @if($answeredExercise->status == "Attempted")
                <div class="box">
                  <input type="file" name="file[]" id="file" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple="" style="visibility: hidden; background-color: #076BFF;">
                  <label for="file" style="position: absolute; left: 0; margin-left: 1.5rem; margin-bottom: 1.5rem;  border-radius: 0.25rem !important; padding: 0.5rem 1rem 0.5rem 1rem; background: #2c7be5; color: white;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17" fill="white"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg> <span style="font-size: 1rem;">Choose Files</span></label>
                </div>
                @endif
                <div id="selectedFiles" style="margin-top: 1.5rem; margin-bottom: 0.5rem;"></div>
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

            <input type="hidden" name="answeredExerciseId" value="{{$answeredExercise->id}}" />
            <input type="hidden" name="files-deleted_{{$answeredExercise->id}}" id="files-deleted_{{$answeredExercise->id}}" />
            <input type="hidden" name="status" id="status" value="" />

            @if($answeredExercise->status == "Attempted")
            <button type="submit" class="btn btn-primary btn-block" id="saveExerciseAttempt">Save Exercise</button>
            <!-- <a class="btn btn-warning btn-block" id="submitForReview" onclick="submitForReview()">Submit For Review</a> -->
            <a href="/exercises/{{$exercise->slug}}" class="btn btn-block btn-link text-muted">
              Cancel
            </a>
            @else
              @if($answeredExercise->status == "Submitted For Review")
              <button type="submit" class="btn btn-primary btn-block" id="recallAttempt">Recall Submission</button>
              @endif
            @endif
          </form>
          <div class="row">
            <div class="col-lg-12">
              @if($answeredExercise->status == "Competent" || $answeredExercise->status == "Needs Improvement")
                <h1>Review</h1>
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
            <p>{{$exercise->description}}</p>
            <p class="card-text small text-muted" style="margin-bottom: 0;">Estimated time taken</p>
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

            @if(Auth::id() && Auth::user()->admin)
              <a href="/exercises/{{$exercise->slug}}/edit" class="btn btn-primary btn-block">Edit Exercise</a>
            @endif

            <a href="/exercises/{{$exercise->slug}}/feedback" class="btn btn-block btn-link">Feedback</a>
          </div>
        </div>
        @if(count($exercise->answer_files) > 0)
        <div class="card">
          <div class="card-body" style="padding-bottom: 0.5rem;">
            <h3>Answers</h3>
            <ul style="margin-left: -1.4rem;">
              @foreach($exercise->answer_files->sortBy('title') as $answerFile) 
                <li><a href="https://storage.googleapis.com/talentail-123456789/{{$answerFile->url}}">{{$answerFile->title}}</a></li>
              @endforeach
            </ul>
          </div>
        </div>
        @endif
        @if(count($answeredExercise->exercise->opportunities) > 0)
        <div class="card">
          <div class="card-body">
            <h3>Job Opportunities Requiring This Competency</h3>
            <ul style="margin-left: -1.4rem; margin-bottom: 0rem;">
              @foreach($answeredExercise->exercise->opportunities as $opportunity)
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
  setTimeout(function(){ document.getElementById("successAlert").style.display = "none" }, 3000);
  
  var selDiv = "";
  
  document.addEventListener("DOMContentLoaded", init, false);
  
  function init() {
    var selectedFile = 'selectedFiles';
    document.querySelector('#file').addEventListener('change', handleFileSelect, false);
  }

  function handleFileSelect(e) {
    if(!e.target.files) return;
    document.getElementById('selectedFiles').innerHTML = "";
    
    var files = e.target.files;
    for(var i=0; i<files.length; i++) {
      var f = files[i];
      
      document.getElementById('selectedFiles').innerHTML += f.name + "<br/>";
    }
  }

  function submitForReview() {
    event.preventDefault();

    document.getElementById("status").value = "submitForReview";
    document.getElementById("saveExerciseAttempt").click();
  }

  function deleteFile() {
    let fileIdString = event.target.id.split("_");
    let answeredExerciseId = fileIdString[1];
    let answeredExerciseFileId = fileIdString[2];

    if(document.getElementById("files-deleted_"+answeredExerciseId).value == "") {
      document.getElementById("files-deleted_"+answeredExerciseId).value += answeredExerciseFileId;
    } else {
      document.getElementById("files-deleted_"+answeredExerciseId).value += ", " + answeredExerciseFileId;
    }

    let elem = document.getElementById("file-group_"+answeredExerciseFileId);
    elem.parentNode.removeChild(elem);
  }
</script>
@endsection

@section ('footer')   
@endsection