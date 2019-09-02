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
                  Project Management
                </h6>

                <!-- Title -->
                <h1 class="header-title">
                  Edit a Project
                </h1>

              </div>
            </div> <!-- / .row -->
          </div>
        </div>

        <!-- Form -->
          <form method="POST" action="/roles/{{$role->slug}}/projects/{{$project->slug}}/save-project" enctype="multipart/form-data">
          @csrf

          <input name="id" class="form-control" id="id" type="hidden" value="{{$project->id}}">

          <!-- Project name -->
          <div class="form-group">
            <label>
              Project title
            </label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Enter title" value="{{$project->title}}">
          </div>

          <!-- Project description -->
          <div class="form-group">
            <label class="mb-1">
              Project short description
            </label>
            <textarea class="form-control" name="description" id="description" maxlength="280" rows="5" placeholder="Enter summary" onkeypress="keyDescription()">{{$project->description}}</textarea>

            <p class="text-small" style="float: right; color: #8F9194 !important;" id="charactersLeft">{{280 - strlen($project->description)}} characters left</p>
          </div>

           <div class="form-group">
              <label class="mb-1">
                Select industry
              </label>
              <select class="form-control" data-toggle="select" name="industry">
                <option value="Nil">Select industry</option>
                @foreach($industries as $industry)
                  @if($project->industry_id == $industry->id)
                  <option value="{{$industry->id}}" selected>{{$industry->title}}</option>
                  @else
                  <option value="{{$industry->id}}">{{$industry->title}}</option>
                  @endif
                @endforeach
              </select>
            </div>

          <div class="form-group">
            <label class="mb-1">
              Project full description & role brief
            </label>

            <div id="test-editormd2" style="border-radius: 0.5rem;">
                <textarea style="display:none;" name="brief"></textarea>
            </div>
            <div id="brief-info" style="display: none;">{{$project->brief}}</div>
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
                  <button class="btn btn-primary" style="margin-bottom: 0.1875rem !important;" onclick="addTask()" id="addTaskButton">Add Task</button>
                </div>
              </div>
            </div>

            <div class="content-list-body">
              @if(sizeof($project->tasks) > 0)
              @foreach($project->tasks as $key=>$task)
                <div class="task-accordion" id="tasksList_{{$key+1}}">
                  <div class="card" id="tasksList_{{$key+1}}">
                    <div class="card-body task-card" id="card_{{$key+1}}">
                      <div class="row">
                        <div class="col-12 col-md-12">
                          <div class="form-group">
                            <label class="todo-title">To-do #{{$key+1}} Title</label>
                            <input type="text" name="todo-title_{{$key+1}}" class="form-control todo-title-input" id="todo-title-input_{{$key+1}}" placeholder="Enter title" value="{{$task->title}}">
                            <input type="hidden" name="task-id_{{$key+1}}" value="{{$task->id}}" class="task-hidden">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 col-md-12">
                          <div class="form-group">
                            <label class="todo-description">To-do #{{$key+1}} Description</label>
                            <input type="text" name="todo-description_{{$key+1}}" class="form-control todo-description-input" id="todo-description-input_{{$key+1}}" placeholder="Enter description" value="{{$task->description}}">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 col-md-12">
                          <div class="form-group">
                            <div class="btn-group-toggle" data-toggle="buttons">
                              @if($task->mcq)
                                <label class="btn btn-white radio-mcq-label active" onclick="launchMcq()" id="radio-mcq_{{$key+1}}">
                              @else
                                <label class="btn btn-white radio-mcq-label" onclick="launchMcq()" id="radio-mcq_{{$key+1}}">
                              @endif
                              <input type="radio" name="todo_{{$key+1}}" value="mcq" class="radio-mcq" id="radio-mcq_{{$key+1}}"> <i class="fe fe-check-circle check-mcq" id="radio-mcq-check_{{$key+1}}"></i> Multiple Choice Question</label>
                              @if($task->open_ended)
                                <label class="btn btn-white radio-open-ended-label active" onclick="removeMcq()" id="radio-open-ended_{{$key+1}}">
                              @else
                                <label class="btn btn-white radio-open-ended-label" onclick="removeMcq()" id="radio-open-ended_{{$key+1}}">
                              @endif
                              <input type="radio" name="todo_{{$key+1}}" value="open-ended" class="radio-open-ended" id="radio-open-ended_{{$key+1}}"> <i class="fe fe-check-circle check-open-ended" id="radio-open-ended-check_{{$key+1}}"></i> Open-ended</label>
                              @if($task->na)
                                <label class="btn btn-white radio-na-label active" onclick="removeMcq()" id="radio-na_{{$key+1}}">
                              @else
                                <label class="btn btn-white radio-na-label" onclick="removeMcq()" id="radio-na_{{$key+1}}">
                              @endif
                              <input type="radio" name="todo_{{$key+1}}" value="na" class="radio-na" id="radio-na_{{$key+1}}"> <i class="fe fe-check-circle check-na" id="radio-na-check_{{$key+1}}"></i> Not Applicable</label>
                            </div>
                          </div>
                        </div>
                      </div>
                      @if($task->mcq)
                        @foreach($task->answers as $answerKey=>$answer)
                        <div class="accordion answer-accordion answer-accordion_{{$key+1}}" id="answersList_{{$key+1}}_{{$answerKey+1}}">
                          <div class="row">
                            <div class="col-12 col-md-12">
                              <div class="form-group">
                                <div class="input-group">
                                  <input type="text" name="answer_{{$key+1}}_{{$answerKey+1}}" class="form-control todo-answer-input_{{$key+1}}" id="todo-answer-input_{{$key+1}}_{{$answerKey+1}}" placeholder="Enter answer {{$answerKey+1}}" value="{{$answer->title}}">
                                  <div class="input-group-append" style="height: 40px;">
                                    <span class="input-group-text remove-answer" id="delete-answer_{{$key+1}}_{{$answerKey+1}}" onclick="deleteAnswer()">
                                      <input type="hidden" class="deleted-answer-id" name="deleted-answer-id_{{$key+1}}_{{$answerKey+1}}" id="deleted-answer-id_{{$key+1}}_{{$answerKey+1}}" value="{{$answer->id}}" />
                                      <i class="fas fa-times-circle" id="span_{{$key+1}}_{{$answerKey+1}}"></i>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        @endforeach
                        <input type="hidden" name="answers-deleted" value="" id="answers-deleted" />
                        <div class="accordion answer-accordion answer-accordion_{{$key+1}}" id="answersList_{{$key+1}}_{{count($task->answers)+1}}"></div>
                      @else
                        <!-- <input type="hidden" name="answers-deleted" value="" id="answers-deleted" /> -->
                        <div class="accordion answer-accordion answer-accordion_{{$key+1}}" id="answersList_{{$key+1}}_{{count($task->answers)+1}}"></div>
                      @endif
                      @if($task->mcq)
                      <div id="mcq-buttons_{{$key+1}}">
                      @else
                      <div id="mcq-buttons_{{$key+1}}" style="display: none;">
                      @endif
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <div class="custom-control custom-checkbox-toggle">
                              @if($task->multiple_select)
                              <input type="checkbox" class="custom-control-input" id="checkbox-multiple-select_{{$key+1}}" name="checkbox-multiple-select_{{$key+1}}" checked>
                              @else
                              <input type="checkbox" class="custom-control-input" id="checkbox-multiple-select_{{$key+1}}" name="checkbox-multiple-select_{{$key+1}}">
                              @endif
                              <label class="custom-control-label" id="checkbox-multiple-select-label_{{$key+1}}" for="checkbox-multiple-select_{{$key+1}}"></label>
                            </div>
                          </div>
                          <div class="col">
                            <span>Enable Multiple Select</span>
                          </div>
                          <div class="col-auto">
                            <button class="btn btn-primary add-task" style="float: right;" id="add-task_{{$key+1}}" onclick="addAnswer()">Add Answer</button>
                          </div>
                        </div>
                        <hr>
                      </div>
                      <div class="row align-items-center">
                        <div class="col-auto">
                          <div class="custom-control custom-checkbox-toggle">
                            @if($task->file_upload)
                            <input type="checkbox" class="custom-control-input" id="checkbox-file-upload_{{$key+1}}" name="checkbox-file-upload_{{$key+1}}" checked>
                            @else
                            <input type="checkbox" class="custom-control-input" id="checkbox-file-upload_{{$key+1}}" name="checkbox-file-upload_{{$key+1}}">
                            @endif
                            <label class="custom-control-label" id="checkbox-file-upload-label_{{$key+1}}" for="checkbox-file-upload_{{$key+1}}"></label>
                          </div>
                        </div>
                        <div class="col">
                          <span>Allow user to upload file</span>
                        </div>
                        <div class="col-auto">
                          <button class="btn btn-danger delete-task" id="delete-task_{{$key+1}}" onclick="deleteTask()">Delete Task</button>
                          <input type="hidden" class="deleted-task-id" id="deleted-task-id_{{$key+1}}" name="deleted-task-id_{{$key+1}}" value="{{$task->id}}" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @if($loop->last)
                <div class="task-accordion" id="tasksList_{{$key+2}}">

                </div>
                @endif
              @endforeach
              @else
                <div class="task-accordion" id="tasksList_1">

                </div>
              @endif
            </div>
            <input type="hidden" name="tasks-deleted" value="" id="tasks-deleted" />
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
            @if($project->thumbnail)
            <div id="projectThumbnail">
              <a href="https://storage.googleapis.com/talentail-123456789/{{$project->url}}">{{$project->thumbnail}}</a> <span id="delete-thumbnail" class="remove-file" onclick="deleteThumbnail()" style="border-color: transparent; margin-right: 0px; padding: 0px;"><i class="fas fa-times-circle"></i></span>
            </div>
            @endif
            <div id="selectedThumbnail">
            </div>
            <input type="hidden" name="thumbnail-deleted" value="false" id="thumbnail-deleted" />
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
            @foreach($project->project_files as $projectFile)
            <div id="file-group_{{$projectFile->id}}">
              <a href="https://storage.googleapis.com/talentail-123456789/{{$projectFile->url}}">{{$projectFile->title}}</a> <span id="delete-file_{{$projectFile->id}}" class="remove-file" onclick="deleteFile()" style="border-color: transparent; margin-right: 0px; padding: 0px;"><i class="fas fa-times-circle" id="span_{{$projectFile->id}}"></i></span><br/>
            </div>
            @endforeach
            <div id="selectedFiles">
            </div>
            <input type="hidden" name="files-deleted" value="" id="files-deleted" />
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

            @foreach($role->competencies as $competency)
              @if($competency->user_id == 0)
                @if(!$loop->last)
                    <div class="row align-items-center" style="margin-bottom: 1rem;">
                @else
                    <div class="row align-items-center">
                @endif
                  <div class="col-auto">
                    <div class="custom-control custom-checkbox-toggle">
                      @if(in_array($competency->id, $competencyIdArray))
                      <input type="checkbox" class="custom-control-input" name="competency[]" id="competency_{{$competency->id}}" value="{{$competency->id}}" checked>
                      @else
                      <input type="checkbox" class="custom-control-input" name="competency[]" id="competency_{{$competency->id}}" value="{{$competency->id}}">
                      @endif
                      <label class="custom-control-label" for="competency_{{$competency->id}}" id="competency_{{$competency->id}}"></label>
                    </div>
                  </div>
                  <div class="col">
                    <span>{{$competency->title}}</span>
                  </div>
                </div>
              @endif
            @endforeach

          </div>

          <hr class="mt-5 mb-5">

          <!-- Buttons -->
          <button class="btn btn-primary" id="createProject" type="submit" style="float: right; display: none;">Create Project</button>
          <button class="btn btn-default" id="saveProject" type="submit" style="float: right; margin-right: 0.5rem; display: none;">Save</button>
          <button class="btn btn-default" onclick="cancel()" style="float: right; margin-right: 0.5rem; display: none;">Cancel</button>

        </form>
        <button onclick="saveProject()" class="btn btn-block btn-primary" id="saveProjectButton">
          Save Project
        </button>
        <a href="/roles/{{$role->slug}}/projects/{{$project->slug}}" class="btn btn-block btn-link text-muted">
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
      selDiv = document.querySelector("#selectedFiles");

      document.querySelector('#thumbnail').addEventListener('change', handleThumbnailSelect, false);
      selThumbnailDiv = document.querySelector("#selectedThumbnail");
    }
    
    function handleFileSelect(e) {
      if(!e.target.files) return;
      selDiv.innerHTML = "";
      
      var files = e.target.files;
      for(var i=0; i<files.length; i++) {
        var f = files[i];
        
        selDiv.innerHTML += f.name + "<br/>";
      }
    }

    function handleThumbnailSelect(e) {
      if(document.getElementById("projectThumbnail") != null)
        deleteThumbnail();
      if(!e.target.files) return;
      selThumbnailDiv.innerHTML = "";
      
      var files = e.target.files;
      for(var i=0; i<files.length; i++) {
        var f = files[i];
        
        selThumbnailDiv.innerHTML += f.name + "<br/>";
      }
    }

    var editor2 = editormd({
        id   : "test-editormd2",
        path : "/lib/",
        height: 640,
        placeholder: "Start creating your project full description & role brief...",
        onload : function() {
            //this.watch();
            //this.setMarkdown("###test onloaded");
            //testEditor.setMarkdown("###Test onloaded");
            editor2.insertValue(document.getElementById("brief-info").innerHTML);
        }
    });

    function addAnswer() {
      event.preventDefault();
      // find out which add answer button was clicked
      let taskIdString = event.target.id.split("_");
      let taskId = taskIdString[1];
      let answerId = document.querySelectorAll('.todo-answer-input_' + taskId).length + 1; 

      document.getElementById("answersList_" + taskId + "_" + answerId).innerHTML += "<div class='row'><div class='col-12 col-md-12'><div class='form-group'><div class='input-group'><input type='text' name='answer_" + taskId + "_" + answerId + "' class='form-control todo-answer-input_" + taskId + "' id='todo-answer-input_" + taskId + "_" + answerId + "' placeholder='Enter answer " + answerId + "'><div class='input-group-append' style='height: 40px;'><span class='input-group-text remove-answer' id='delete-answer_" + taskId + "_" + answerId + "' onclick='deleteAnswer()'><i class='fas fa-times-circle' id='span_" + taskId + "_" + answerId + "'></i></span></div></div></div></div></div>";

      document.getElementById("answersList_" + taskId + "_" + answerId).insertAdjacentHTML('afterend', "<div class='accordion answer-accordion answer-accordion_" + taskId + "' id='answersList_" + taskId + "_" + (answerId+1) + "'></div>");
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

    function addTask() {
      event.preventDefault();
      let cardCounter = document.querySelectorAll('.task-card').length + 1;

      console.log("tasksList_" + cardCounter);

      document.getElementById("tasksList_" + cardCounter).innerHTML += "<div class='card' id='tasksList_" + cardCounter + "'><div class='card-body task-card' id='card_" + cardCounter + "'><div class='row'><div class='col-12 col-md-12'><div class='form-group'><label class='todo-title'>To-do #" + cardCounter + " Title</label><input type='text' name='todo-title_" + cardCounter + "' class='form-control todo-title-input' id='todo-title-input_" + cardCounter + "' placeholder='Enter title'></div></div></div><div class='row'><div class='col-12 col-md-12'><div class='form-group'><label class='todo-description'>To-do #" + cardCounter + " Description</label><input type='text' name='todo-description_" + cardCounter + "' class='form-control todo-description-input' id='todo-description-input_" + cardCounter + "' placeholder='Enter description'></div></div></div><div class='row'><div class='col-12 col-md-12'><div class='form-group'><div class='btn-group-toggle' data-toggle='buttons'><label class='btn btn-white radio-mcq-label' onclick='launchMcq()' id='radio-mcq_" + cardCounter + "'><input type='radio' name='todo_" + cardCounter + "' value='mcq' class='radio-mcq' id='radio-mcq_" + cardCounter + "'> <i class='fe fe-check-circle'></i> Multiple Choice Question</label><label class='btn btn-white radio-open-ended-label' onclick='removeMcq()' id='radio-open-ended_" + cardCounter + "'><input type='radio' name='todo_" + cardCounter + "' value='open-ended' class='radio-open-ended' id='radio-open-ended_" + cardCounter + "'> <i class='fe fe-check-circle'></i> Open-ended</label><label class='btn btn-white radio-na-label' onclick='removeMcq()' id='radio-na_" + cardCounter + "'><input type='radio' name='todo_" + cardCounter + "' value='na' class='radio-na' id='radio-na_" + cardCounter + "'> <i class='fe fe-check-circle'></i> Not Applicable</label></div></div></div></div><div class='accordion answer-accordion answer-accordion_" + cardCounter + "' id='answersList_" + cardCounter + "_1' ></div><div id='mcq-buttons_" + cardCounter + "' style='display: none;'><div class='row align-items-center'><div class='col-auto'><div class='custom-control custom-checkbox-toggle'><input type='checkbox' class='custom-control-input' id='checkbox-multiple-select_" + cardCounter + "' name='checkbox-multiple-select_" + cardCounter + "'><label class='custom-control-label' id='checkbox-multiple-select-label_" + cardCounter + "' for='checkbox-multiple-select_" + cardCounter + "'></label></div></div><div class='col'><span>Enable Multiple Select</span></div><div class='col-auto'><button class='btn btn-primary add-task' style='float: right;' id='add-task_" + cardCounter + "' onclick='addAnswer()'>Add Answer</button></div></div><hr/></div><div class='row align-items-center'><div class='col-auto'><div class='custom-control custom-checkbox-toggle'><input type='checkbox' class='custom-control-input' id='checkbox-file-upload_" + cardCounter + "' name='checkbox-file-upload_" + cardCounter + "'><label class='custom-control-label' id='checkbox-file-upload-label_" + cardCounter + "' for='checkbox-file-upload_" + cardCounter + "'></label></div></div><div class='col'><span>Allow user to upload file</span></div><div class='col-auto'><button class='btn btn-danger delete-task' id='delete-task_" + cardCounter + "' onclick='deleteTask()'>Delete Task</button></div></div></div></div>";

      document.getElementById("tasksList_" + cardCounter).insertAdjacentHTML('afterend', "<div class='task-accordion' id='tasksList_" + (cardCounter+1) + "'></div>");
    }

    function deleteAnswer() {
      let answerIdString = event.target.id.split("_");
      let taskId = answerIdString[1];
      let answerId = parseInt(answerIdString[2]);
      let answersListId = "answersList_" + taskId + "_" + answerId;

      if(document.getElementById("answers-deleted").value == "") {
        document.getElementById("answers-deleted").value += document.getElementById("deleted-answer-id_" + taskId + "_" + answerId).value;
      } else {
        document.getElementById("answers-deleted").value += ", " + document.getElementById("deleted-answer-id_" + taskId + "_" + answerId).value;
      }

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

          let zz = document.getElementById("deleted-answer-id_" + taskId + "_" + (i+1));
          zz.id = "deleted-answer-id_" + taskId + "_" + i;
          zz.name = "deleted-answer-id_" + taskId + "_" + i;

          let v = document.getElementById("span_" + taskId + "_" + (i+1));
          v.id = "span_" + taskId + "_" + i;
      }

      let z = document.getElementById("answersList_" + taskId + "_" + (answerCount+1));
      z.id = "answersList_" + taskId + "_" + answerCount;
    }

    function deleteThumbnail() {
      document.getElementById("thumbnail-deleted").value = true;

      let elem = document.getElementById("projectThumbnail");
      elem.parentNode.removeChild(elem);
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

    function deleteTask() {
      let taskIdString = event.target.id.split("_");
      let tasksListId = "tasksList_"+taskIdString[1];

      if(document.getElementById("deleted-task-id_"+taskIdString[1]) != null) {
        if(document.getElementById("tasks-deleted").value == "") {
          document.getElementById("tasks-deleted").value += document.getElementById("deleted-task-id_"+taskIdString[1]).value;
        } else {
          document.getElementById("tasks-deleted").value += ", " + document.getElementById("deleted-task-id_"+taskIdString[1]).value;
        }
      }

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

      x = document.getElementsByClassName("task-hidden");
      for (i = 0; i < x.length; i++) {        
          x[i].name = "task-id_"+(i+1);
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

      x = document.getElementsByClassName("deleted-task-id");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "deleted-task-id_"+(i+1);     
          x[i].name = "deleted-task-id_"+(i+1);
      }

      x = document.getElementsByClassName("deleted-answer-id");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "deleted-answer-id_"+(i+1);     
          x[i].name = "deleted-answer-id_"+(i+1);
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
              console.log($("#checkbox-file-upload-label_2").attr('for'));
              $("#checkbox-file-upload-label_2").attr('for', 'checkbox-file-upload_1');
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

    function saveProject() {
      event.preventDefault();

      document.getElementById("saveProject").click();
    }

    $("#saveProjectButton").click(function( event ) {
      event.preventDefault();

      document.getElementById("saveProject").click();
    });

    $("#addTaskButton").click(function( event ) {
      event.preventDefault();
      let cardCounter = document.querySelectorAll('.task-card').length + 1;

      console.log("tasksList_" + cardCounter);

      document.getElementById("tasksList_" + cardCounter).innerHTML += "<div class='card' id='tasksList_" + cardCounter + "'><div class='card-body task-card' id='card_" + cardCounter + "'><div class='row'><div class='col-12 col-md-12'><div class='form-group'><label class='todo-title'>To-do #" + cardCounter + " Title</label><input type='text' name='todo-title_" + cardCounter + "' class='form-control todo-title-input' id='todo-title-input_" + cardCounter + "' placeholder='Enter title'></div></div></div><div class='row'><div class='col-12 col-md-12'><div class='form-group'><label class='todo-description'>To-do #" + cardCounter + " Description</label><input type='text' name='todo-description_" + cardCounter + "' class='form-control todo-description-input' id='todo-description-input_" + cardCounter + "' placeholder='Enter description'></div></div></div><div class='row'><div class='col-12 col-md-12'><div class='form-group'><div class='btn-group-toggle' data-toggle='buttons'><label class='btn btn-white radio-mcq-label' onclick='launchMcq()' id='radio-mcq_" + cardCounter + "'><input type='radio' name='todo_" + cardCounter + "' value='mcq' class='radio-mcq' id='radio-mcq_" + cardCounter + "'> <i class='fe fe-check-circle'></i> Multiple Choice Question</label><label class='btn btn-white radio-open-ended-label' onclick='removeMcq()' id='radio-open-ended_" + cardCounter + "'><input type='radio' name='todo_" + cardCounter + "' value='open-ended' class='radio-open-ended' id='radio-open-ended_" + cardCounter + "'> <i class='fe fe-check-circle'></i> Open-ended</label><label class='btn btn-white radio-na-label' onclick='removeMcq()' id='radio-na_" + cardCounter + "'><input type='radio' name='todo_" + cardCounter + "' value='na' class='radio-na' id='radio-na_" + cardCounter + "'> <i class='fe fe-check-circle'></i> Not Applicable</label></div></div></div></div><div class='accordion answer-accordion answer-accordion_" + cardCounter + "' id='answersList_" + cardCounter + "_1' ></div><div id='mcq-buttons_" + cardCounter + "' style='display: none;'><div class='row align-items-center'><div class='col-auto'><div class='custom-control custom-checkbox-toggle'><input type='checkbox' class='custom-control-input' id='checkbox-multiple-select_" + cardCounter + "' name='checkbox-multiple-select_" + cardCounter + "'><label class='custom-control-label' id='checkbox-multiple-select-label_" + cardCounter + "' for='checkbox-multiple-select_" + cardCounter + "'></label></div></div><div class='col'><span>Enable Multiple Select</span></div><div class='col-auto'><button class='btn btn-primary add-task' style='float: right;' id='add-task_" + cardCounter + "' onclick='addAnswer()'>Add Answer</button></div></div><hr/></div><div class='row align-items-center'><div class='col-auto'><div class='custom-control custom-checkbox-toggle'><input type='checkbox' class='custom-control-input' id='checkbox-file-upload_" + cardCounter + "' name='checkbox-file-upload_" + cardCounter + "'><label class='custom-control-label' id='checkbox-file-upload-label_" + cardCounter + "' for='checkbox-file-upload_" + cardCounter + "'></label></div></div><div class='col'><span>Allow user to upload file</span></div><div class='col-auto'><button class='btn btn-danger delete-task' id='delete-task_" + cardCounter + "' onclick='deleteTask()'>Delete Task</button></div></div></div></div>";

      document.getElementById("tasksList_" + cardCounter).insertAdjacentHTML('afterend', "<div class='task-accordion' id='tasksList_" + (cardCounter+1) + "'></div>");
    });
  </script>
@endsection

@section ('footer')
  
@endsection