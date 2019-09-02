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
                  New project
                </h6>

                <!-- Title -->
                <h1 class="header-title">
                  Create a new project
                </h1>

              </div>
            </div> <!-- / .row -->
          </div>
        </div>

        <!-- Form -->
          <form id="projectForm" method="POST" class="mb-4" enctype="multipart/form-data">

          @csrf

          <!-- Project name -->
          <div class="form-group">
            <label>
              Project title
            </label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Enter title" value="{{ old('title') }}" autofocus>
          </div>

          <!-- Project description -->
          <div class="form-group">
            <label class="mb-1">
              Project short description
            </label>

            <textarea class="form-control" name="description" id="description" maxlength="280" rows="5" placeholder="Enter description" style="resize: none;" onkeypress="keyDescription()">{{ old('description') }}</textarea>
            <p class="text-small" style="float: right; color: #8F9194 !important;" id="charactersLeft">280 characters left</p>
          </div>

          <div class="form-group">
              <label class="mb-1">
                Select industry
              </label>
              <select class="form-control" data-toggle="select" name="industry">
                <option value="Nil">Select industry</option>
                @foreach($industries as $industry)
                  <option value="{{$industry->id}}">{{$industry->title}}</option>
                @endforeach
              </select>
            </div>

          <div class="form-group">
            <label class="mb-1">
              Project full description & role brief
            </label>

            <div id="test-editormd3" style="border-radius: 0.5rem;">
                <textarea style="display:none;" name="brief"></textarea>
            </div>
            <div id="old-brief" style="display: none;">{{ old('brief') }}</div>
          </div>

          <!-- Divider -->
          <hr class="mt-4 mb-5">

          <div class="form-group">
            

            
            <div class="container">
              <div class="row align-items-center">
                <div class="col-auto" style="padding-left: 0px;">
                  <label class="mb-1">
                    Tasks
                  </label>
                </div>
                <div class="col">

                </div>
                <div class="col-auto mr--3">
                  <button class="btn btn-primary" style="margin-bottom: 0.1875rem !important;" onclick="addTask()" id="addTask">Add Task</button>
                </div>
              </div>
            </div>
            <div class="content-list-body">
              <div class="task-accordion" id="tasksList_1">
              </div>
            </div>
          </div>


          <hr class="mt-4 mb-5">
          <!-- Project cover -->
          <div class="form-group">
            <label class="mb-1">
              Project thumbnail
            </label>
            <small class="form-text text-muted">
              An ideal thumbnail is 600px * 450px 
            </small>
            <div class="box">
              <input type="file" name="thumbnail" id="thumbnail" class="inputfile inputfile-1" style="visibility: hidden; margin-bottom: 1.5rem;"/>
              <label for="thumbnail" style="position: absolute; left: 0; margin-left: 12px; margin-bottom: 1.5rem;  border-radius: 0.25rem !important; padding: 0.5rem 1rem 0.5rem 1rem; background: #2c7be5; color: white;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17" fill="white"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span style="font-size: 1rem;">Choose Thumbnail</span></label>
            </div>
            <div id="selectedThumbnail"></div>
          </div>

          <!-- Divider -->
          <hr class="mt-5 mb-5">

          <!-- Starting files -->
          <div class="form-group">
            <label class="mb-1">
              Supporting files
            </label>
            <small class="form-text text-muted">
              Upload any files you want to start the project with.
            </small>
            <div class="box">
              <input type="file" name="file-1[]" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple style="visibility: hidden; margin-bottom: 1.5rem;"/>
              <label for="file-1" style="position: absolute; left: 0; margin-left: 12px; margin-bottom: 1.5rem;  border-radius: 0.25rem !important; padding: 0.5rem 1rem 0.5rem 1rem; background: #2c7be5; color: white;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17" fill="white"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span style="font-size: 1rem;">Choose Files</span></label>
            </div>
            <div id="selectedFiles"></div>
          </div>

          <!-- Divider -->
          <hr class="mt-5 mb-5">

          <div class="form-group">
            <div class="container">
              <div class="row align-items-center">
                <div class="col-auto" style="padding-left: 0px;">
                  <label class="mb-1">
                    Competencies
                  </label>
                </div>
                <div class="col">

                </div>
              </div>
            </div>

            @foreach($selectedRole->competencies as $key=>$competency)
              @if($competency->user_id == 0)
                @if(!$loop->last)
                    <div class="row align-items-center" style="margin-bottom: 1rem;">
                @else
                    <div class="row align-items-center">
                @endif
                  <div class="col-auto">
                    <div class="custom-control custom-checkbox-toggle">
                      <input type="checkbox" class="custom-control-input" name="competency[]" id="competency_{{$competency->id}}" value="{{$competency->id}}">
                      <label class="custom-control-label" for="competency_{{$competency->id}}" id="competency_{{$competency->id}}"></label>
                    </div>
                  </div>
                  <div class="col">
                    <span>{{$competency->title}}</span>
                  </div>
                </div>
              @endif
            @endforeach

            @foreach($customCompetencies as $key=>$customCompetency)
              @if($key==0) 
                <h3 id="defaultCustomCompetencyHeading">Custom Competencies</h3>
              @endif
              @if($customCompetency->user_id != 0)

              @if(!$loop->last)
                  <div class="row align-items-center custom-competency-row" style="margin-bottom: 1rem;">
              @else
                  <div class="row align-items-center custom-competency-row">
              @endif
                <div class="col-auto">
                  <div class="custom-control custom-checkbox-toggle">
                    <input type="checkbox" class="custom-control-input" name="custom-competency[]" id="competency_{{$customCompetency->id}}" value="{{$competency->id}}">
                    <label class="custom-control-label" for="competency_{{$customCompetency->id}}" id="competency_{{$customCompetency->id}}"></label>
                  </div>
                </div>
                <div class="col">
                  <span>{{$competency->title}}</span>
                </div>
              </div>
              @endif
            @endforeach
            <h3 style="display: none;" id="customCompetencyHeading">Custom Competencies</h3>
            <div id="competenciesList_{{$customCount}}">
            </div>
            <input type="hidden" id="customCount" value="{{$customCount}}" />
          </div>

          <hr class="mt-5 mb-5">

          <!-- Buttons -->
          <button class="btn btn-primary" id="createProject" type="submit" style="float: right; display: none;">Create Project</button>
          <button class="btn btn-default" id="saveProject" type="submit" style="float: right; margin-right: 0.5rem; display: none;">Save</button>
          <button class="btn btn-default" onclick="cancel()" style="float: right; margin-right: 0.5rem; display: none;">Cancel</button>

        </form>
        <button onclick="saveProject()" id="saveProjectButton" class="btn btn-block btn-primary">
          Save Project
        </button>
        <a href="#" class="btn btn-block btn-link text-muted">
          Cancel
        </a>

      </div>
    </div> <!-- / .row -->
  </div>

  <script type="text/javascript" src="/js/editormd.js"></script>
  <script src="/js/languages/en.js"></script>
  <script type="text/javascript">

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    var selDiv = "";
    var selThumbnailDiv = "";
    
    document.addEventListener("DOMContentLoaded", init, false);
    
    function init() {
      document.querySelector('#file-1').addEventListener('change', handleFileSelect, false);
      // selDiv = document.querySelector("#selectedFiles");

      document.querySelector('#thumbnail').addEventListener('change', handleThumbnailSelect, false);
      selThumbnailDiv = document.querySelector("#selectedThumbnail");
    }
    
    function handleFileSelect(e) {
      console.log(e);
      if(!e.target.files) return;
      selDiv.innerHTML = "";
      
      var files = e.target.files;
      for(var i=0; i<files.length; i++) {
        var f = files[i];
        
        selDiv.innerHTML += f.name + "<br/>";
      }
    }

    function handleThumbnailSelect(e) {
      if(!e.target.files) return;
      selThumbnailDiv.innerHTML = "";
      
      var files = e.target.files;
      for(var i=0; i<files.length; i++) {
        var f = files[i];
        
        selThumbnailDiv.innerHTML += f.name + "<br/>";
      }
    }

    var editor2 = editormd({
        id   : "test-editormd3",
        path : "/lib/",
        height: 640,
        placeholder: "Start creating your project full description & role brief...",
        onload : function() {
            //this.watch();
            //this.setMarkdown("###test onloaded");
            //testEditor.setMarkdown("###Test onloaded");
            // editor2.insertValue(document.getElementById("brief-info").innerHTML);
            editor2.insertValue(document.getElementById("old-brief").innerHTML);
        }
    });

    function addTask() {
      event.preventDefault();
      let cardCounter = document.querySelectorAll('.task-card').length + 1;

      document.getElementById("tasksList_" + cardCounter).innerHTML += "<div class='card' id='tasksList_" + cardCounter + "'><div class='card-body task-card' id='card_" + cardCounter + "'><div class='row'><div class='col-12 col-md-12'><div class='form-group'><label class='todo-title'>To-do #" + cardCounter + " Title</label><input type='text' name='todo-title_" + cardCounter + "' class='form-control todo-title-input' id='todo-title-input_" + cardCounter + "' placeholder='Enter title'></div></div></div><div class='row'><div class='col-12 col-md-12'><div class='form-group'><label class='todo-description'>To-do #" + cardCounter + " Description</label><input type='text' name='todo-description_" + cardCounter + "' class='form-control todo-description-input' id='todo-description-input_" + cardCounter + "' placeholder='Enter description'></div></div></div><div class='row'><div class='col-12 col-md-12'><div class='form-group'><div class='btn-group-toggle' data-toggle='buttons'><label class='btn btn-white radio-mcq-label' onclick='launchMcq()' id='radio-mcq_" + cardCounter + "'><input type='radio' name='todo_" + cardCounter + "' value='mcq' class='radio-mcq' id='radio-mcq_" + cardCounter + "'> <i class='fe fe-check-circle check-mcq' id='radio-mcq-check_" + cardCounter + "'></i> Multiple Choice Question</label><label class='btn btn-white radio-open-ended-label' onclick='removeMcq()' id='radio-open-ended_" + cardCounter + "'><input type='radio' name='todo_" + cardCounter + "' value='open-ended' class='radio-open-ended' id='radio-open-ended_" + cardCounter + "'> <i class='fe fe-check-circle check-open-ended' id='radio-open-ended-check_" + cardCounter + "'></i> Open-ended</label><label class='btn btn-white radio-na-label' onclick='removeMcq()' id='radio-na_" + cardCounter + "'><input type='radio' name='todo_" + cardCounter + "' value='na' class='radio-na' id='radio-na_" + cardCounter + "'> <i class='fe fe-check-circle check-na' id='radio-na-check_" + cardCounter + "'></i> Not Applicable</label></div></div></div></div><div class='accordion answer-accordion answer-accordion_" + cardCounter + "' id='answersList_" + cardCounter + "_1' ></div><div id='mcq-buttons_" + cardCounter + "' style='display: none;'><div class='row align-items-center'><div class='col-auto'><div class='custom-control custom-checkbox-toggle'><input type='checkbox' class='custom-control-input' id='checkbox-multiple-select_" + cardCounter + "' name='checkbox-multiple-select_" + cardCounter + "'><label class='custom-control-label' id='checkbox-multiple-select-label_" + cardCounter + "' for='checkbox-multiple-select_" + cardCounter + "'></label></div></div><div class='col'><span>Enable Multiple Select</span></div><div class='col-auto'><button class='btn btn-primary add-task' style='float: right;' id='add-task_" + cardCounter + "' onclick='addAnswer()'>Add Answer</button></div></div><hr/></div><div class='row align-items-center'><div class='col-auto'><div class='custom-control custom-checkbox-toggle'><input type='checkbox' class='custom-control-input' id='checkbox-file-upload_" + cardCounter + "' name='checkbox-file-upload_" + cardCounter + "'><label class='custom-control-label' id='checkbox-file-upload-label_" + cardCounter + "' for='checkbox-file-upload_" + cardCounter + "'></label></div></div><div class='col'><span>Allow user to upload file</span></div><div class='col-auto'><button class='btn btn-danger delete-task' id='delete-task_" + cardCounter + "' onclick='deleteTask()'>Delete Task</button></div></div></div></div>";

      document.getElementById("tasksList_" + cardCounter).insertAdjacentHTML('afterend', "<div class='task-accordion' id='tasksList_" + (cardCounter+1) + "'></div>");
    }

    function deleteTask() {
      let taskIdString = event.target.id.split("_");
      let tasksListId = "tasksList_"+taskIdString[1];

      // find total number of answers first
      let taskCount = document.getElementsByClassName("task-card").length;

      let elem = document.getElementById(tasksListId);
      elem.parentNode.removeChild(elem);

      // need to recalculate all the ids
      // task-card
      let x = document.getElementsByClassName("task-card");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "card_"+(i+1);
      }

      x = document.getElementsByClassName("check-mcq");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "radio-mcq-check_"+(i+1);
      }

      x = document.getElementsByClassName("check-open-ended");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "radio-open-ended-check_"+(i+1);
      }

      x = document.getElementsByClassName("check-na");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "radio-na-check_"+(i+1);
      }

      x = document.getElementsByClassName("card");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "card_"+(i+1);
      }

      // card-header
      x = document.getElementsByClassName("card-header");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "heading_"+(i+1);
      }

      // todo-title
      x = document.getElementsByClassName("todo-title");
      for (i = 0; i < x.length; i++) {        
          x[i].innerHTML = "To-do #"+(i+1)+" Title";
      }

      // todo-title-input
      x = document.getElementsByClassName("todo-title-input");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "todo-title-input_"+(i+1);     
          x[i].name = "todo-title-input_"+(i+1);
      }

      // todo-description
      x = document.getElementsByClassName("todo-description");
      for (i = 0; i < x.length; i++) {        
          x[i].innerHTML = "To-do #"+(i+1)+" Description";
      }

      // todo-description-input
      x = document.getElementsByClassName("todo-description-input");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "todo-description-input_"+(i+1);  
          x[i].name = "todo-description-input_"+(i+1);
      }

      // radio-mcq
      x = document.getElementsByClassName("radio-mcq");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "radio-mcq_"+(i+1);   
          x[i].name = "todo_"+(i+1);
      }

      x = document.getElementsByClassName("radio-mcq-label");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "radio-mcq_"+(i+1);   
      }

      // radio-open-ended
      x = document.getElementsByClassName("radio-open-ended");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "radio-open-ended_"+(i+1);   
          x[i].name = "todo_"+(i+1);
      }

      x = document.getElementsByClassName("radio-open-ended-label");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "radio-open-ended_"+(i+1);   
      }


      // radio-na
      x = document.getElementsByClassName("radio-na");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "radio-na_"+(i+1);   
          x[i].name = "todo_"+(i+1);
      }

      x = document.getElementsByClassName("radio-na-label");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "radio-na_"+(i+1);   
      }

      // delete-task
      x = document.getElementsByClassName("delete-task");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "delete-task_"+(i+1);
      }

      // task-accordion
      x = document.getElementsByClassName("task-accordion");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "tasksList_"+(i+1);
      }

      taskId = parseInt(taskIdString[1]);

      // loop through tasks
      for (i = taskId; i < taskCount; i++) {  
          // loop through answersList
          let counter = 1;
          while(document.getElementById("answersList_" + (i + 1) + "_" + counter) != null) {
            let a = document.getElementById("answersList_" + (i + 1) + "_" + counter);
            if(a != null) {
              a.id = "answersList_" + i + "_" + counter;
              a.className = "accordion answer-accordion answer-accordion_" + i;
            }

            a = document.getElementById("radio-mcq_")

            a = document.getElementById("todo-answer-input_" + (i + 1) + "_" + counter);
            if(a != null) {
              a.id = "todo-answer-input_" + i + "_" + counter;
              a.name = "answer_" + i + "_" + counter;
              a.className = "form-control todo-answer-input_" + i;
            }

            a = document.getElementById("delete-answer_" + (i+1) + "_" + counter);
            if(a != null) {
              a.id = "delete-answer_" + i + "_" + counter;
            }

            a = document.getElementById("span_" + (i+1) + "_" + counter);
            if(a != null) {
              a.id = "span_" + i + "_" + counter;
            }

            a = document.getElementById("mcq-buttons_" + (i+1));
            if(a != null) {
              a.id = "mcq-buttons_" + i;
            }

            a = document.getElementById("checkbox-file-upload_" + (i+1));
            if(a != null) {
              a.id = "checkbox-file-upload_" + i;
              a.name = "checkbox-file-upload_" + i;
            }

            a = document.getElementById("checkbox-file-upload-label_" + (i+1));
            if(a != null) {
              a.id = "checkbox-file-upload-label_" + i;
              $("#checkbox-file-upload-label_"+i).attr('for', 'checkbox-file-upload_'+i);
            }

            a = document.getElementById("checkbox-multiple-select_" + (i+1));
            if(a != null) {
              a.id = "checkbox-multiple-select_" + i;
              a.name = "checkbox-multiple-select_" + i;
            }

            a = document.getElementById("checkbox-multiple-select-label_" + (i+1));
            if(a != null) {
              a.id = "checkbox-multiple-select-label_" + i;
              $("#checkbox-multiple-select-label_"+i).attr('for', 'checkbox-multiple-select_'+i);
            }

            a = document.getElementById("add-task_" + (i+1));
            if(a != null) {
              a.id = "add-task_" + i;
            }

            counter++;
          }
        let z = document.getElementById("answersList_" + (i+1) + "_" + counter);
        if(z != null) {
          z.id = "answersList_" + i + "_" + counter;
        }
      }
    }

    function addAnswer() {
      event.preventDefault();
      // find out which add answer button was clicked
      let taskIdString = event.target.id.split("_");
      let taskId = taskIdString[1];
      let answerId = document.querySelectorAll('.todo-answer-input_' + taskId).length + 1; 

      document.getElementById("answersList_" + taskId + "_" + answerId).innerHTML += "<div class='row'><div class='col-12 col-md-12'><div class='form-group'><div class='input-group'><input type='text' name='answer_" + taskId + "_" + answerId + "' class='form-control todo-answer-input_" + taskId + "' id='todo-answer-input_" + taskId + "_" + answerId + "' placeholder='Enter answer " + answerId + "'><div class='input-group-append' style='height: 40px;'><span class='input-group-text remove-answer' id='delete-answer_" + taskId + "_" + answerId + "' onclick='deleteAnswer()'><i class='fas fa-times-circle' id='span_" + taskId + "_" + answerId + "'></i></span></div></div></div></div></div>";

      document.getElementById("answersList_" + taskId + "_" + answerId).insertAdjacentHTML('afterend', "<div class='accordion answer-accordion answer-accordion_" + taskId + "' id='answersList_" + taskId + "_" + (answerId+1) + "'></div>");
    }

    function deleteAnswer() {
      let answerIdString = event.target.id.split("_");
      let taskId = answerIdString[1];
      let answerId = parseInt(answerIdString[2]);
      let answersListId = "answersList_" + taskId + "_" + answerId;

      // find total number of answers first
      let answerCount = document.getElementsByClassName("todo-answer-input_" + taskId).length;

      let elem = document.getElementById(answersListId);
      elem.parentNode.removeChild(elem);

      // need to recalculate all the ids
      // start with answerslist
      let x = document.getElementsByClassName("todo-answer-input_" + taskId);

      for (i = answerId; i < answerCount; i++) {  
          let x = document.getElementById("todo-answer-input_" + taskId + "_" + (parseInt(i) + 1));      
          x.className = "form-control todo-answer-input_" + taskId;
          x.name = "answer_" + taskId + "_" + i;
          x.id = "todo-answer-input_" + taskId + "_" + i;
          x.placeholder = "Enter answer " + i;

          let y = document.getElementById("answersList_" + taskId + "_" + (i+1));
          y.id = "answersList_" + taskId + "_" + i;

          let u = document.getElementById("delete-answer_" + taskId + "_" + (i+1));
          u.id = "delete-answer_" + taskId + "_" + i;

          let v = document.getElementById("span_" + taskId + "_" + (i+1));
          v.id = "span_" + taskId + "_" + i;
      }

      let z = document.getElementById("answersList_" + taskId + "_" + (answerCount+1));
      z.id = "answersList_" + taskId + "_" + answerCount;
    }

    function launchMcq() {
      let idString = event.target.id.split("_");
      let mcqButtons = document.getElementById("mcq-buttons_" + idString[1]);
      mcqButtons.style.display = "block";

      let answers = document.getElementsByClassName("answer-accordion_" + idString[1]);

      var arrayLength = answers.length;
      for (var i = 0; i < arrayLength; i++) {
          answers[i].style.display = "block";
      }
    }

    function removeMcq() {
      let idString = event.target.id.split("_");
      let mcqButtons = document.getElementById("mcq-buttons_" + idString[1]);
      mcqButtons.style.display = "none";

      let answers = document.getElementsByClassName("answer-accordion_" + idString[1]);

      var arrayLength = answers.length;
      for (var i = 0; i < arrayLength; i++) {
          answers[i].style.display = "none";
      }
    }

    function addCompetency() {
      // adding of competencies is only for the one who created the competency
      // it is not shared across other creators
      event.preventDefault();
      if(document.getElementById("defaultCustomCompetencyHeading") == null) {
        document.getElementById('customCompetencyHeading').style.display = 'block';
      }

      let competencyCounter = document.querySelectorAll('.custom-competency-row').length + 1;

      document.getElementById("competenciesList_" + competencyCounter).innerHTML += "<div class='row align-items-center custom-competency-row' style='margin-bottom: 1rem;'><div class='col-auto'><div class='custom-control custom-checkbox-toggle'><input type='checkbox' class='custom-control-input' name='custom-competency[]' id='custom-competency-checkbox_" + competencyCounter + "'><label class='custom-control-label' for='custom-competency-checkbox_" + competencyCounter + "' id='custom-competency-label_" + competencyCounter + "'></label></div></div><div class='col'><div class='input-group'><input type='text' class='form-control custom-competency added-custom-competency' id='custom-competency-input_" + competencyCounter + "' placeholder='Enter custom competency " + competencyCounter + "'><div class='input-group-append' style='height: 40px;'><span class='input-group-text remove-competency' id='delete-competency_" + competencyCounter + "' onclick='deleteCompetency()'><i class='fas fa-times-circle' id='span_" + competencyCounter + "'></i></span></div></div></div></div>";

      document.getElementById("competenciesList_" + competencyCounter).insertAdjacentHTML('afterend', "<div id='competenciesList_" + (competencyCounter+1) + "'></div>");
    }

    function deleteCompetency() {
      let competencyIdString = event.target.id.split("_");
      let competencyId = competencyIdString[1];
      let competenciesListId = "competenciesList_" + competencyId;

      // find total number of custom competencies first
      let competencyCount = document.getElementsByClassName("custom-competency").length;

      let elem = document.getElementById(competenciesListId);
      elem.parentNode.removeChild(elem);

      // need to recalculate all the ids
      // start with competenciesList
      let x = document.getElementsByClassName("custom-competency");

      for (i = competencyId; i < competencyCount; i++) {  
          i = parseInt(i);

          let x = document.getElementById("custom-competency-checkbox_" + (i + 1));
          x.id = "custom-competency-checkbox_" + i;

          let a = document.getElementById("custom-competency-label_" + (i + 1));
          a.id = "custom-competency-label_" + i;
          a.htmlFor = "custom-competency-checkbox_" + i;

          let y = document.getElementById("custom-competency-input_" + (i + 1));
          y.id = "custom-competency-input_" + i;
          y.placeholder = "Enter custom competency " + i;

          let u = document.getElementById("delete-competency_" + (i+1));
          u.id = "delete-competency_" + i;

          let v = document.getElementById("span_" + (i+1));
          v.id = "span_" + i;

          let z = document.getElementById("competenciesList_" + (i+1));
          z.id = "competenciesList_" + i;
      }

      let z = document.getElementById("competenciesList_" + (competencyCount+1));
      z.id = "competenciesList_" + competencyCount;

      if(competencyCount == 1) {
        document.getElementById("customCompetencyHeading").style.display="none";
      }
    }

    function saveProject() {
      event.preventDefault();

      let competencyCount = document.getElementsByClassName("custom-competency").length;

      for (i = 1; i <= competencyCount; i++) {  
          i = parseInt(i);

          let x = document.getElementById("custom-competency-checkbox_" + i);
          x.value = document.getElementById("custom-competency-input_" + i).value;
      }

      document.getElementById("projectForm").action = "/projects/save-project";
      document.getElementById("saveProject").click();
    }

    function cancel() {
        window.location.replace('/projects/select-role');
    }

    function keyDescription() {
      let descriptionLength = document.getElementById("description").value.length+1;
      if(descriptionLength != 281) {
        document.getElementById("charactersLeft").innerHTML = (280 - descriptionLength) + " characters left";
      }
    }
  </script>
  <script type="text/javascript">
    $('#addTask').click(function( event ){
        event.preventDefault();

        let cardCounter = document.querySelectorAll('.task-card').length + 1;

        document.getElementById("tasksList_" + cardCounter).innerHTML += "<div class='card' id='tasksList_" + cardCounter + "'><div class='card-body task-card' id='card_" + cardCounter + "'><div class='row'><div class='col-12 col-md-12'><div class='form-group'><label class='todo-title'>To-do #" + cardCounter + " Title</label><input type='text' name='todo-title_" + cardCounter + "' class='form-control todo-title-input' id='todo-title-input_" + cardCounter + "' placeholder='Enter title'></div></div></div><div class='row'><div class='col-12 col-md-12'><div class='form-group'><label class='todo-description'>To-do #" + cardCounter + " Description</label><input type='text' name='todo-description_" + cardCounter + "' class='form-control todo-description-input' id='todo-description-input_" + cardCounter + "' placeholder='Enter description'></div></div></div><div class='row'><div class='col-12 col-md-12'><div class='form-group'><div class='btn-group-toggle' data-toggle='buttons'><label class='btn btn-white radio-mcq-label' onclick='launchMcq()' id='radio-mcq_" + cardCounter + "'><input type='radio' name='todo_" + cardCounter + "' value='mcq' class='radio-mcq' id='radio-mcq_" + cardCounter + "'> <i class='fe fe-check-circle check-mcq' id='radio-mcq-check_" + cardCounter + "'></i> Multiple Choice Question</label><label class='btn btn-white radio-open-ended-label' onclick='removeMcq()' id='radio-open-ended_" + cardCounter + "'><input type='radio' name='todo_" + cardCounter + "' value='open-ended' class='radio-open-ended' id='radio-open-ended_" + cardCounter + "'> <i class='fe fe-check-circle check-open-ended' id='radio-open-ended-check_" + cardCounter + "'></i> Open-ended</label><label class='btn btn-white radio-na-label' onclick='removeMcq()' id='radio-na_" + cardCounter + "'><input type='radio' name='todo_" + cardCounter + "' value='na' class='radio-na' id='radio-na_" + cardCounter + "'> <i class='fe fe-check-circle check-na' id='radio-na-check_" + cardCounter + "'></i> Not Applicable</label></div></div></div></div><div class='accordion answer-accordion answer-accordion_" + cardCounter + "' id='answersList_" + cardCounter + "_1' ></div><div id='mcq-buttons_" + cardCounter + "' style='display: none;'><div class='row align-items-center'><div class='col-auto'><div class='custom-control custom-checkbox-toggle'><input type='checkbox' class='custom-control-input' id='checkbox-multiple-select_" + cardCounter + "' name='checkbox-multiple-select_" + cardCounter + "'><label class='custom-control-label' id='checkbox-multiple-select-label_" + cardCounter + "' for='checkbox-multiple-select_" + cardCounter + "'></label></div></div><div class='col'><span>Enable Multiple Select</span></div><div class='col-auto'><button class='btn btn-primary add-task' style='float: right;' id='add-task_" + cardCounter + "' onclick='addAnswer()'>Add Answer</button></div></div><hr/></div><div class='row align-items-center'><div class='col-auto'><div class='custom-control custom-checkbox-toggle'><input type='checkbox' class='custom-control-input' id='checkbox-file-upload_" + cardCounter + "' name='checkbox-file-upload_" + cardCounter + "'><label class='custom-control-label' id='checkbox-file-upload-label_" + cardCounter + "' for='checkbox-file-upload_" + cardCounter + "'></label></div></div><div class='col'><span>Allow user to upload file</span></div><div class='col-auto'><button class='btn btn-danger delete-task' id='delete-task_" + cardCounter + "' onclick='deleteTask()'>Delete Task</button></div></div></div></div>";

        document.getElementById("tasksList_" + cardCounter).insertAdjacentHTML('afterend', "<div class='task-accordion' id='tasksList_" + (cardCounter+1) + "'></div>");
    });

    $("#saveProjectButton").click(function( event ) {
      event.preventDefault();

      let competencyCount = document.getElementsByClassName("custom-competency").length;

      for (i = 1; i <= competencyCount; i++) {  
          i = parseInt(i);

          let x = document.getElementById("custom-competency-checkbox_" + i);
          x.value = document.getElementById("custom-competency-input_" + i).value;
      }

      document.getElementById("projectForm").action = "/projects/save-project";
      document.getElementById("saveProject").click();
    });
  </script>
@endsection

@section ('footer')
@endsection