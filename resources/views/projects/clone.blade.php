@extends ('layouts.main')

@section ('content')
  @if($selectedRole != null)
  <div class="alert alert-warning" style="border-radius: 0px; padding: 0.75rem 1.5rem; text-align: center;">
    You are currently creating a project for <strong>{{$selectedRole->title}}</strong>.<a href="/projects/select-role" style="float: right;">Select different role</a>
  </div>
  @endif
  <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-11">
          <section class="py-4 py-lg-5">
              <h1 class="display-4 mb-3">Clone a Project</h1>
              <p class="lead">We have populated several sample projects to make it easier for you to create your own project. Dive into the details of the project to check whether it is similar to the project you would like to create.</p>
          </section>
          <ul class="nav nav-tabs nav-fill" style="margin-bottom: 1.5rem;">
              <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#sample" role="tab" aria-controls="sample" aria-selected="true">Sample Projects</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#created" role="tab" aria-controls="created" aria-selected="false">Your Created Projects</a>
              </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade show active" id="sample" role="tabpanel" aria-labelledby="sample-tab" data-filter-list="card-list-body">
              <div class="row content-list-head">
                  <div class="col-auto">
                      <h3>Sample Projects</h3>
                  </div>
              </div>
              <div class="content-list-body">
                @foreach($sampleProjects as $project)
                  <div class="card mb-3">
                    <div class="card-body">
                      <div class="col-lg-10" style="float: left; padding: 0px;">
                        <h5><a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}">{{$project->title}}</a></h5>
                        <p style="margin-top: 0.5rem;">{{$project->description}}</p>
                        <a href="/profile/{{$project->user->id}}" data-toggle="tooltip" data-placement="top" title="">
                          @if($project->user->avatar)
                          <img class="avatar" src="https://storage.googleapis.com/talentail-123456789/{{$project->user->avatar}}">
                          @else
                          <img class="avatar" src="/img/avatar.png">
                          @endif
                        </a>
                        <a href="/profile/{{$project->user->id}}">
                          <span style="font-size: .875rem; line-height: 1.3125rem;">{{$project->user->name}}</span>
                        </a>
                      </div>
                      <div class="col-lg-1" style="text-align: center; float: right; padding: 0px;">
                        <h5 style="float: right; color: #16a085;">${{$project->amount}}</h5>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
            <div class="tab-pane fade" id="created" role="tabpanel" aria-labelledby="created-tab" data-filter-list="card-list-body">
              <div class="row content-list-head">
                  <div class="col-auto">
                      <h3>Your Created Projects</h3>
                  </div>
              </div>
              <div class="content-list-body">
                @foreach($createdProjects as $project)
                  <div class="card mb-3">
                    <div class="card-body">
                      <div class="col-lg-10" style="float: left; padding: 0px;">
                        <h5><a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}">{{$project->title}}</a></h5>
                        <p style="margin-top: 0.5rem;">{{$project->description}}</p>
                        <a href="/profile/{{$project->user->id}}" data-toggle="tooltip" data-placement="top" title="">
                          @if($project->user->avatar)
                          <img class="avatar" src="https://storage.googleapis.com/talentail-123456789/{{$project->user->avatar}}">
                          @else
                          <img class="avatar" src="/img/avatar.png">
                          @endif
                        </a>
                        <a href="/profile/{{$project->user->id}}">
                          <span style="font-size: .875rem; line-height: 1.3125rem;">{{$project->user->name}}</span>
                        </a>
                      </div>
                      <div class="col-lg-1" style="text-align: center; float: right; padding: 0px;">
                        <h5 style="float: right; color: #16a085;">${{$project->amount}}</h5>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <script type="text/javascript" src="/js/editormd.js"></script>
  <script type="text/javascript">
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

  </script>
  <script src="/js/languages/en.js"></script>
  <script type="text/javascript">

    var selDiv = "";
    
    document.addEventListener("DOMContentLoaded", init, false);
  
    function init() {
      document.querySelector('#file-1').addEventListener('change', handleFileSelect, false);
      selDiv = document.querySelector("#selectedFiles");
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

    function saveProject() {
      event.preventDefault();
      document.getElementById("projectForm").action = "/projects/save-project";
      document.getElementById("saveProject").click();
    }

    function createProject() {
      event.preventDefault();
      document.getElementById("projectForm").action = "/projects/publish-project";
      document.getElementById("createProject").click();
    }

    function cancel() {
        window.location.replace('/projects/select-role');
    }

    function addAnswer() {
      event.preventDefault();
      // find out which add answer button was clicked
      let taskIdString = event.target.id.split("_");
      let taskId = taskIdString[1];
      let answerId = document.querySelectorAll('.todo-answer-input_' + taskId).length + 1; 

      document.getElementById("answersList_" + taskId + "_" + answerId).innerHTML += "<div class='input-group'><input type='text' name='answer_" + taskId + "_" + answerId + "' class='form-control todo-answer-input_" + taskId + "' id='todo-answer-input_" + taskId + "_" + answerId + "' placeholder='Enter answer " + answerId + "' style='margin-top: 1.5rem;'><div class='input-group-append' style='height: 40px; margin-top: 1.5rem;'><span class='input-group-text remove-answer' id='delete-answer_" + taskId + "_" + answerId + "' onclick='deleteAnswer()'><i class='fas fa-times-circle' id='span_" + taskId + "_" + answerId + "'></i></span></div></div>"

      document.getElementById("answersList_" + taskId + "_" + answerId).insertAdjacentHTML('afterend', "<div class='accordion answer-accordion' id='answersList_" + taskId + "_" + (answerId+1) + "'></div>");
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

    function addTask() {
      event.preventDefault();
      let cardCounter = document.querySelectorAll('.task-card').length + 1;

      document.getElementById("tasksList_" + cardCounter).innerHTML += "<div class='card task-card' id='card_" + cardCounter + "' style='margin-bottom: 1.5rem;'><div class='card-header' id='heading_" + cardCounter + "'><h5 class='todo-title'>To-do #" + cardCounter + " Title</h5><input type='text' name='todo-title_" + cardCounter + "' class='form-control todo-title-input' id='todo-title-input_" + cardCounter + "' placeholder='Enter title'></div><div id='collapse_" + cardCounter + "' class='collapse show collapse-heading' data-parent='#tasksList'><div class='card-body'><h5 class='todo-description'>To-do #" + cardCounter + " Description</h5><input type='text' name='todo-description_" + cardCounter + "' class='form-control todo-description-input' id='todo-description-input_" + cardCounter + "' placeholder='Enter description'><div style='margin-top: 1.5rem;'><input type='radio' name='todo_" + cardCounter + "' value='mcq' class='radio-mcq' id='radio-mcq_" + cardCounter + "' onclick='launchMcq()'> <span class='text-small'>Multiple Choice Question</span> </div><div class='accordion answer-accordion' id='answersList_" + cardCounter + "_1'></div><div style='margin-top: 1.5rem; display: none;' id='mcq-buttons_" + cardCounter + "'><input type='checkbox' name='checkbox-multiple-select_" + cardCounter + "' value='file-upload' class='checkbox-multiple-select_" + cardCounter + "' id='checkbox-multiple-select_" + cardCounter + "'><span class='text-small' style='margin-left: 0.5rem;'>Enable Multiple Select</span><button class='btn btn-primary btn-sm add-task' style='float: right;' id='add-task_" + cardCounter + "' onclick='addAnswer()'>Add Answer</button><hr></div><div> <input type='radio' name='todo_" + cardCounter + "' value='open-ended' class='radio-open-ended' id='radio-open-ended_" + cardCounter + "' onclick='removeMcq()'> <span class='text-small'>Open-ended</span></div><div><input type='radio' name='todo_" + cardCounter + "' value='na' class='radio-na' id='radio-na_" + cardCounter + "' onclick='removeMcq()'> <span class='text-small'>N.A.</span></div><hr><input type='checkbox' name='checkbox-file-upload_" + cardCounter + "' value='file-upload' class='checkbox-file-upload_" + cardCounter + "' id='checkbox-file-upload_" + cardCounter + "'><span class='text-small' style='margin-left: 0.5rem;'>File Upload</span><br><button class='btn btn-danger delete-task btn-sm' id='delete-task_" + cardCounter + "' onclick='deleteTask()' style='float: right; margin-bottom: 1.5rem;'>Delete</button></div></div></div>";

        document.getElementById("tasksList_" + cardCounter).insertAdjacentHTML('afterend', "<div class='accordion task-accordion' id='tasksList_" + (cardCounter+1) + "'></div>");
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

      // collapse-heading
      x = document.getElementsByClassName("collapse-heading");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "collapse_"+(i+1);
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

      // radio-open-ended
      x = document.getElementsByClassName("radio-open-ended");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "radio-open-ended_"+(i+1);   
          x[i].name = "todo_"+(i+1);
      }

      // radio-na
      x = document.getElementsByClassName("radio-na");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "radio-na_"+(i+1);   
          x[i].name = "todo_"+(i+1);
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
            }

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
              a.className = "checkbox-file-upload_" + i;
              a.name = "checkbox-file-upload_" + i;
            }

            a = document.getElementById("checkbox-multiple-select_" + (i+1));
            if(a != null) {
              a.id = "checkbox-multiple-select_" + i;
              a.className = "checkbox-multiple-select_" + i;
              a.name = "checkbox-multiple-select_" + i;
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

    function launchMcq() {
      let idString = event.target.id.split("_");
      let mcqButtons = document.getElementById("mcq-buttons_" + idString[1]);
      mcqButtons.style.display = "block";
    }

    function removeMcq() {
      let idString = event.target.id.split("_");
      let mcqButtons = document.getElementById("mcq-buttons_" + idString[1]);
      mcqButtons.style.display = "none";
    }

    function removeFile(event) {
      console.log(event.parentElement.parentElement.parentElement);
      let a = event.parentElement.parentElement.parentElement;
      a.parentNode.removeChild(a);
    }
  </script>
@endsection

@section ('footer')
  
@endsection