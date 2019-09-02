@extends ('layouts.main')

@section ('content')
<div class="header">
  <div class="container">
    <div class="row" style="margin-top: 3rem;">
      <div class="col-lg-9">
        <div class="row">
          <div class="col-lg-12">
            <h1>Task Brief</h1>
            <div class="card">
              <div class="card-body task-brief">
                @parsedown($task->brief)
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <h1>Your Solution</h1>
            <form id="attemptForm" method="POST" action="/categories/{{$task->category->slug}}/tasks/{{$task->slug}}/save-task" enctype="multipart/form-data">
              @csrf

              <div class="card">
                <div class="card-body" style="padding-bottom: 0.5rem;">
                  <h3>{{$task->solution_title}}</h3>
                  <input type="hidden" name="task_1" value="107">
                  <p>{{$task->solution_description}}</p>
                   
                  <div class="box">
                    <input type="file" name="file[]" id="file" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple="" style="visibility: hidden; background-color: #076BFF;">
                    <label for="file" style="position: absolute; left: 0; margin-left: 1.5rem; margin-bottom: 1.5rem;  border-radius: 0.25rem !important; padding: 0.5rem 1rem 0.5rem 1rem; background: #2c7be5; color: white;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17" fill="white"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg> <span style="font-size: 1rem;">Choose Files</span></label>
                  </div>
                  <div id="selectedFiles" style="margin-top: 1.5rem; margin-bottom: 0.5rem;"></div>
                  @if(count($answeredTask->answered_task_files) > 0)
                  <div style="margin-bottom: 0.5rem;">
                    @foreach($answeredTask->answered_task_files as $answeredTaskFile)
                    <div id="file-group_{{$answeredTaskFile->id}}">
                      <a href="https://storage.googleapis.com/talentail-123456789/{{$answeredTaskFile->url}}">{{$answeredTaskFile->title}}</a> <span id="delete-file_{{$answeredTask->id}}_{{$answeredTaskFile->id}}" class="remove-file" onclick="deleteFile()" style="border-color: transparent; margin-right: 0px; padding: 0px;"><i class="fas fa-times-circle" id="span_{{$answeredTask->id}}_{{$answeredTaskFile->id}}"></i></span><br/>
                    </div>
                    @endforeach
                  </div>
                  @endif
                </div>
              </div>

              <input type="hidden" name="answeredTaskId" value="{{$answeredTask->id}}" />
              <input type="hidden" name="files-deleted_{{$answeredTask->id}}" id="files-deleted_{{$answeredTask->id}}" />

              <button type="submit" class="btn btn-primary btn-block" id="saveTaskAttempt">Save Task</button>
              <a href="#" class="btn btn-block btn-link text-muted">
                Cancel
              </a>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card">
          <div class="card-body">
            <h3>{{$task->title}}</h3>
            <p>{{$task->description}}</p>
            <p class="card-text small text-muted" style="margin-bottom: 0;">Estimated time taken</p>
            <p>{{$task->duration}}</p>
            <p class="card-text small text-muted" style="margin-bottom: 0;">Attempts</p>
            <p>{{$task->attempts}}</p>
            <p class="card-text small text-muted" style="margin-bottom: 0;">Job Opportunities</p>
            <p style="margin-bottom: 0;">{{$task->opportunities}}</p>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h3>Job Opportunities Requiring This Competency</h3>
            <ul style="margin-left: -1.4rem; margin-bottom: 0rem;">
              <li><a href="#">Business Analyst, Capgemini</a></li>
              <li><a href="#">Solution Analyst, Accenture</a></li>
              <li><a href="#">Business Analyst, Dimension Data</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
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

  function deleteFile() {
    let fileIdString = event.target.id.split("_");
    let answeredTaskId = fileIdString[1];
    let answeredTaskFileId = fileIdString[2];

    if(document.getElementById("files-deleted_"+answeredTaskId).value == "") {
      document.getElementById("files-deleted_"+answeredTaskId).value += answeredTaskFileId;
    } else {
      document.getElementById("files-deleted_"+answeredTaskId).value += ", " + answeredTaskFileId;
    }

    let elem = document.getElementById("file-group_"+answeredTaskFileId);
    elem.parentNode.removeChild(elem);
  }
</script>
@endsection

@section ('footer')   
@endsection