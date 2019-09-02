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
                  New exercise
                </h6>

                <!-- Title -->
                <h1 class="header-title">
                  Create a new exercise
                </h1>

              </div>
            </div> <!-- / .row -->
          </div>
        </div>

        <form id="taskForm" method="POST" class="mb-4" action="/exercises/save-exercise" enctype="multipart/form-data">

          {{ csrf_field() }}

          <div class="form-group">
            <label>
              Exercise title
            </label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Enter title" value="{{ old('title') }}" autofocus>
          </div>

          <div class="form-group">
            <label class="mb-1">
              Exercise description
            </label>

            <input type="text" name="description" class="form-control" id="description" placeholder="Enter description" value="{{ old('description') }}">
          </div>

          <div class="form-group">
            <label class="mb-1">
              Exercise task
            </label>

            <select class="form-control" data-toggle="select" name="task">
              <option value="Nil">Select task</option>
              @foreach($tasks as $task)
                <option value="{{$task->id}}">{{$task->title}}</option>
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
            <div id="old-brief" style="display: none;">{{ old('brief') }}</div>
          </div>

          <div class="form-group">
            <label>
              Exercise duration
            </label>
            <input type="text" name="duration" class="form-control" id="duration" placeholder="Enter duration" value="{{ old('duration') }}">
          </div>

          <div class="form-group">
            <label>
              Exercise score
            </label>
            <input type="text" name="score" class="form-control" id="score" placeholder="Enter score" value="{{ old('score') }}">
          </div>

          <div class="form-group">
            <label>
              Solution title
            </label>
            <input type="text" name="solution-title" class="form-control" id="solutionTitle" placeholder="Enter solution title" value="{{ old('solution-title') }}">
          </div>

          <div class="form-group">
            <label class="mb-1">
              Solution description
            </label>

            <input type="text" name="solution-description" class="form-control" id="solutionDescription" placeholder="Enter solution description" value="{{ old('solution-description') }}">
          </div>

          <div class="form-group">
            <label class="mb-1">
              Exercise files
            </label>

            <div class="box">
              <input type="file" name="file[]" id="file" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple="" style="visibility: hidden; background-color: #076BFF;">
              <label for="file" style="position: absolute; left: 0; margin-left: 0.75rem; margin-bottom: 1.5rem;  border-radius: 0.25rem !important; padding: 0.5rem 1rem 0.5rem 1rem; background: #2c7be5; color: white;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17" fill="white"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg> <span style="font-size: 1rem;">Choose Files</span></label>
            </div>
            <div id="selectedFiles" style="margin-top: 1.5rem;"></div>
          </div>

          <div class="form-group">
            <label class="mb-1">
              Answer files
            </label>

            <div class="box">
              <input type="file" name="answerFile[]" id="answerFile" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple="" style="visibility: hidden; background-color: #076BFF;">
              <label for="answerFile" style="position: absolute; left: 0; margin-left: 0.75rem; margin-bottom: 1.5rem;  border-radius: 0.25rem !important; padding: 0.5rem 1rem 0.5rem 1rem; background: #2c7be5; color: white;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17" fill="white"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg> <span style="font-size: 1rem;">Choose Files</span></label>
            </div>
            <div id="answerFiles" style="margin-top: 1.5rem;"></div>
          </div>
          

          <button class="btn btn-primary" id="createTask" type="submit" style="float: right; display: none;">Create Task</button>
          <button class="btn btn-default" id="saveTask" type="submit" style="float: right; margin-right: 0.5rem; display: none;">Save</button>
          <button class="btn btn-default" onclick="cancel()" style="float: right; margin-right: 0.5rem; display: none;">Cancel</button>
        </form>

        <button onclick="saveTask()" id="saveTaskButton" class="btn btn-block btn-primary" style=" margin-top: 0.5rem;">
          Save Exercise
        </button>
        <a href="#" class="btn btn-block btn-link text-muted">
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