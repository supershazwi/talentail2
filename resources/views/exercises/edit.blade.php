@extends ('layouts.main')

@section ('content')
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-12">
        
        <!-- Header -->
        <div class="header mt-md-5">
          <div class="header-body">
            <div class="row align-items-center">
              <div class="col">
                
                <!-- Pretitle -->
                <h6 class="header-pretitle">
                  {{$exercise->title}}
                </h6>

                <!-- Title -->
                <h1 class="header-title">
                  Edit exercise
                </h1>

              </div>
            </div> <!-- / .row -->
          </div>
        </div>

        <form id="taskForm" method="POST" class="mb-4" action="/exercises/{{$exercise->slug}}/save-exercise" enctype="multipart/form-data">

          {{ csrf_field() }}

          <div class="form-group">
            <label>
              Exercise title
            </label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Enter title" value="{{$exercise->title}}" autofocus>
          </div>

          <div class="form-group">
            <label class="mb-1">
              Exercise description
            </label>

            <input type="text" name="description" class="form-control" id="description" placeholder="Enter description" value="{{$exercise->description}}">
          </div>

          <div class="form-group">
            <label class="mb-1">
              Exercise task
            </label>

            <select class="form-control" data-toggle="select" name="task">
              <option value="Nil">Select task</option>
              @foreach($tasks as $task)
                @if($exercise->task_id == $task->id)
                <option value="{{$task->id}}" selected>{{$task->title}}</option>
                @else
                <option value="{{$task->id}}">{{$task->title}}</option>
                @endif
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label class="mb-1">
              Exercise brief
            </label>

            <div id="test-editormd3" style="border-radius: 0.5rem;">
                <textarea style="display:none;" name="brief"></textarea>
            </div>
            <div id="old-brief" style="display: none;">{{$exercise->brief}}</div>
          </div>

          <div class="form-group">
            <label>
              Exercise duration
            </label>
            <input type="text" name="duration" class="form-control" id="duration" placeholder="Enter duration" value="{{$exercise->duration}}">
          </div>

          <div class="form-group">
            <label>
              Exercise score
            </label>
            
            <input type="text" name="score" class="form-control" id="score" placeholder="Enter score" value="{{$exercise->score}}">
          </div>

          <div class="form-group">
            <label>
              Solution title
            </label>
            <input type="text" name="solution-title" class="form-control" id="solutionTitle" placeholder="Enter solution title" value="{{$exercise->solution_title}}">
          </div>

          <div class="form-group">
            <label class="mb-1">
              Solution description
            </label>

            <input type="text" name="solution-description" class="form-control" id="solutionDescription" placeholder="Enter solution description" value="{{$exercise->solution_description}}">
          </div>

          <div class="form-group">
            <label class="mb-1">
              Exercise files
            </label>

            <div class="box">
              <input type="file" name="file[]" id="file" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple="" style="visibility: hidden; background-color: #076BFF;">
              <label for="file" style="position: absolute; left: 0; margin-left: 0.75rem; margin-bottom: 1.5rem;  border-radius: 0.25rem !important; padding: 0.5rem 1rem 0.5rem 1rem; background: #2c7be5; color: white;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17" fill="white"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg> <span style="font-size: 1rem;">Choose Files</span></label>
            </div>
            @foreach($exercise->exercise_files->sortBy('title') as $exerciseFile)
            @if($loop->first)
            <div id="file-group_{{$exerciseFile->id}}" style="margin-top: 1.5rem;">
            @else
            <div id="file-group_{{$exerciseFile->id}}">
            @endif
              <a href="https://storage.googleapis.com/talentail-123456789/{{$exerciseFile->url}}">{{$exerciseFile->title}}</a> <span id="delete-file_{{$exerciseFile->id}}" class="remove-file" onclick="deleteFile()" style="border-color: transparent; margin-right: 0px; padding: 0px;"><i class="fas fa-times-circle" id="span_{{$exerciseFile->id}}"></i></span><br/>
            </div>
            @endforeach
            <div id="selectedFiles">
            </div>
            <input type="hidden" name="files-deleted" value="" id="files-deleted" />
          </div>

          <div class="form-group">
            <label class="mb-1">
              Answer files
            </label>

            <div class="box">
              <input type="file" name="answerFile[]" id="answerFile" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple="" style="visibility: hidden; background-color: #076BFF;">
              <label for="answerFile" style="position: absolute; left: 0; margin-left: 0.75rem; margin-bottom: 1.5rem;  border-radius: 0.25rem !important; padding: 0.5rem 1rem 0.5rem 1rem; background: #2c7be5; color: white;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17" fill="white"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg> <span style="font-size: 1rem;">Choose Files</span></label>
            </div>
            @foreach($exercise->answer_files->sortBy('title') as $answerFile)
            @if($loop->first)
            <div id="answer-file-group_{{$answerFile->id}}" style="margin-top: 1.5rem;">
            @else
            <div id="answer-file-group_{{$answerFile->id}}">
            @endif
              <a href="https://storage.googleapis.com/talentail-123456789/{{$answerFile->url}}">{{$answerFile->title}}</a> <span id="delete-file_{{$answerFile->id}}" class="remove-file" onclick="deleteAnswerFile()" style="border-color: transparent; margin-right: 0px; padding: 0px;"><i class="fas fa-times-circle" id="span_{{$answerFile->id}}"></i></span><br/>
            </div>
            @endforeach
            <div id="answerFiles">
            </div>
            <input type="hidden" name="answer-files-deleted" value="" id="answer-files-deleted" />
          </div>
<!-- 
          <div class="form-group">
            <label class="mb-1">
              Thumbnail file
            </label>

            <div class="box">
              <input type="file" name="thumbnail" id="thumbnail" class="inputfile inputfile-1" style="visibility: hidden; background-color: #076BFF;">
              <label for="thumbnail" style="position: absolute; left: 0; margin-left: 0.75rem; margin-bottom: 1.5rem;  border-radius: 0.25rem !important; padding: 0.5rem 1rem 0.5rem 1rem; background: #2c7be5; color: white;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17" fill="white"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg> <span style="font-size: 1rem;">Choose Files</span></label>
            </div>
            <div id="selectedThumbnailFile" style="margin-top: 1.5rem;"></div>
          </div>
 -->
          <button class="btn btn-primary" id="createTask" type="submit" style="float: right; display: none;">Create Task</button>
          <button class="btn btn-default" id="saveTask" type="submit" style="float: right; margin-right: 0.5rem; display: none;">Save</button>
          <button class="btn btn-default" onclick="cancel()" style="float: right; margin-right: 0.5rem; display: none;">Cancel</button>
        </form>

        <button onclick="saveTask()" id="saveTaskButton" class="btn btn-block btn-primary" style=" margin-top: 0.5rem;">
          Save Exercise
        </button>
        <a href="/exercises/{{$exercise->slug}}" class="btn btn-block btn-link text-muted">
          Cancel
        </a>

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
        placeholder: "Create exercise brief...",
        onload : function() {
            //this.watch();
            //this.setMarkdown("###test onloaded");
            //testEditor.setMarkdown("###Test onloaded");
            // editor2.insertValue(document.getElementById("brief-info").innerHTML);
            editor2.insertValue(document.getElementById("old-brief").innerHTML);
        }
    });

    function saveTask() {
      event.preventDefault();
      document.getElementById("saveTask").click();
    }

    function deleteFile() {
      let fileIdString = event.target.id.split("_");
      let fileId = fileIdString[1];

      if(document.getElementById("files-deleted").value == "") {
        document.getElementById("files-deleted").value += fileId;
      } else {
        document.getElementById("files-deleted").value += ", " + fileId;
      }

      let elem = document.getElementById("file-group_"+fileId);
      elem.parentNode.removeChild(elem);
    }

    function deleteAnswerFile() {
      let fileIdString = event.target.id.split("_");
      let fileId = fileIdString[1];

      if(document.getElementById("answer-files-deleted").value == "") {
        document.getElementById("answer-files-deleted").value += fileId;
      } else {
        document.getElementById("answer-files-deleted").value += ", " + fileId;
      }

      let elem = document.getElementById("answer-file-group_"+fileId);
      elem.parentNode.removeChild(elem);
    }

    document.addEventListener("DOMContentLoaded", init, false);
    
    function init() {
      var selectedFile = 'selectedFiles';
      document.querySelector('#file').addEventListener('change', handleFileSelect, false);

      document.querySelector('#answerFile').addEventListener('change', handleAnswerFileSelect, false);

      document.querySelector('#thumbnail').addEventListener('change', handleThumbnailFileSelect, false);
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

    function handleAnswerFileSelect(e) {
      if(!e.target.files) return;
      document.getElementById('answerFiles').innerHTML = "";
      
      var files = e.target.files;
      for(var i=0; i<files.length; i++) {
        var f = files[i];
        
        document.getElementById('answerFiles').innerHTML += f.name + "<br/>";
      }
    }

    function handleThumbnailFileSelect(e) {
      if(!e.target.files) return;
      document.getElementById('selectedThumbnailFile').innerHTML = "";
      
      var files = e.target.files;
      for(var i=0; i<files.length; i++) {
        var f = files[i];
        
        document.getElementById('selectedThumbnailFile').innerHTML += f.name + "<br/>";
      }
    }
  </script>
@endsection

@section ('footer')
@endsection