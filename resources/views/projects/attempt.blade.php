@extends ('layouts.main')

@section ('content')
@if($parameter == 'task') 
  <input type="hidden" name="tasksArray" value={{$tasksArray}} id="tasksArray" />
@endif
  <div class="header">
    <div class="container">
      @if(session('saved'))
      <div class="alert alert-success" style="margin-top: 1.5rem; text-align: center;" id="projectSaved">
        <h4 style="margin-bottom: 0;">{{session('saved')}}</h4>
      </div>
      @endif
      <!-- <div class="alert alert-light" style="margin-top: 1.5rem; text-align: center;">
        <h4 style="margin-bottom: 0;">Project Deadline: {{date('d M Y, h:i a', strtotime($attemptedProject->deadline))}}.</h4>
      </div> -->
      <!-- Body -->
      <div class="header-body" style="margin-top: 1.5rem; border-bottom: 0px;">
        <div class="row align-items-top">
          <div class="col-auto">

            <!-- Avatar -->
            <div class="avatar avatar-lg avatar-4by3">
              @if($project->url)
              <img src="https://storage.googleapis.com/talentail-123456789/{{$project->url}}" alt="..." class="avatar-img rounded">
              @else
              <img src="/img/avatars/projects/project-1.jpg" alt="..." class="avatar-img rounded">
              @endif
            </div>

          </div>
          <div class="col ml--3 ml-md--2">

            <!-- Title -->
            <h1 class="header-title">
              {{$project->title}}
            </h1>

            <p style="margin-bottom: 0.5rem;">{{$project->description}}</p>
            <span class="badge badge-warning">{{$project->industry->title}}</span>

          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-9">
          <div class="header-body" style="padding-top: 0rem; margin-bottom: 2rem;">
            <div class="row">
              <div class="col">
                <!-- Nav -->
                <ul class="nav nav-tabs nav-overflow header-tabs">
                  <li class="nav-item">
                    @if($parameter == 'overview')
                    <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}" class="nav-link active" style="padding-top: 0rem;">
                      Overview
                    </a>
                    @else
                    <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}" class="nav-link" style="padding-top: 0rem;">
                      Overview
                    </a>
                    @endif
                  </li>
                  <li class="nav-item">
                    @if($parameter == 'task') 
                    <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/tasks" class="nav-link active" style="padding-top: 0rem;">
                      Tasks
                    </a>
                    @else
                    <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/tasks" class="nav-link" style="padding-top: 0rem;">
                      Tasks
                    </a>
                    @endif
                  </li>
                  <li class="nav-item">
                    @if($parameter == 'file') 
                    <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/files" class="nav-link active" style="padding-top: 0rem;">
                      Files
                    </a>
                    @else
                    <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/files" class="nav-link" style="padding-top: 0rem;">
                      Files
                    </a>
                    @endif
                  </li>
                  <li class="nav-item">
                    @if($parameter == 'competency') 
                    <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/competencies" class="nav-link active" style="padding-top: 0rem;">
                      Competencies
                    </a>
                    @else
                    <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/competencies" class="nav-link" style="padding-top: 0rem;">
                      Competencies
                    </a>
                    @endif
                  </li>
                </ul>
              </div>
            </div>
          </div>
          @if($parameter == 'overview')
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body role-brief">
                  @parsedown($project->brief)
                </div> <!-- / .card-body -->
              </div>
            </div>
          </div>
          @elseif($parameter == 'task')
            <form id="attemptForm" method="POST" action="/roles/{{$role->slug}}/projects/{{$project->slug}}/submit-project-attempt" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="project_id" value="{{$project->id}}" />
        <input type="hidden" name="role_slug" value="{{$project->role->slug}}" />
        <input type="hidden" name="project_slug" value="{{$project->slug}}" />
      @foreach($answeredTasks as $key=>$answeredTask)
        @if($answeredTask->task->mcq)
          <input type="hidden" name="task-type_{{$key+1}}" value="mcq" />
          @if($answeredTask->task->multiple_select)
            <input type="hidden" name="multiple-select_{{$key+1}}" value="true" />
          @else
            <input type="hidden" name="multiple-select_{{$key+1}}" value="false" />
          @endif
        @elseif($answeredTask->task->open_ended)
          <input type="hidden" name="task-type_{{$key+1}}" value="open_ended" />
        @elseif($answeredTask->task->na)
          <input type="hidden" name="task-type_{{$key+1}}" value="na" />
        @endif

        @if($answeredTask->task->file_upload)
          <input type="hidden" name="file-upload_{{$key+1}}" value="true" />
        @else
          <input type="hidden" name="file-upload_{{$key+1}}" value="false" />
        @endif

        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body" style="padding-bottom: 0.5rem;">
                <p style="font-weight: bold;">{{$key+1}}. {{$answeredTask->task->title}}</p>
                <input type="hidden" name="task_{{$key+1}}" value="{{$answeredTask->task->id}}" />
                <p>{{$answeredTask->task->description}}</p>
                @if($answeredTask->task->mcq) 
                  @if($answeredTask->task->multiple_select)
                    @foreach($answeredTask->task->answers as $answer) 
                      @if(!$loop->last)
                            <div class="row align-items-center" style="margin-bottom: 0.5rem;">
                        @else
                            <div class="row align-items-center" style="margin-bottom: 1rem;">
                        @endif
                          <div class="col-auto">
                            <div class="custom-control custom-checkbox-toggle">
                              @if(in_array($answer->title, $answeredTask->answer))
                              <input type="checkbox" class="custom-control-input" name="answer_{{$key+1}}[]" value="{{$answer->title}}" id="answer_{{$answeredTask->task->id}}_{{$answer->id}}" checked>
                              @else
                              <input type="checkbox" class="custom-control-input" name="answer_{{$key+1}}[]" value="{{$answer->title}}" id="answer_{{$answeredTask->task->id}}_{{$answer->id}}">
                              @endif
                              <label class="custom-control-label" for="answer_{{$answeredTask->task->id}}_{{$answer->id}}" id="answer_{{$answeredTask->task->id}}_{{$answer->id}}"></label>
                            </div>
                          </div>
                          <div class="col">
                            <span>{{$answer->title}}</span>
                          </div>
                        </div>
                    @endforeach
                  @else
                    <div class="btn-group-toggle" data-toggle="buttons" style="display: inline-grid; margin-bottom: 1rem;">
                    @foreach($answeredTask->task->answers as $key=>$answer) 
                      @if($loop->last)
                        @if($answeredTask->answer == $answer->title)
                        <label class="btn btn-white active" style="text-align: left;">
                          <input type="radio" name="answer_{{$answeredTask->task->id}}" id="answer_{{$answeredTask->task->id}}_{{$answer->id}}" value="{{$answer->title}}" id="option{{$key}}"> <i class="fe fe-check-circle"></i> {{$answer->title}}
                        </label>
                        @else
                        <label class="btn btn-white" style="text-align: left;">
                          <input type="radio" name="answer_{{$answeredTask->task->id}}" id="answer_{{$answeredTask->task->id}}_{{$answer->id}}" value="{{$answer->title}}" id="option{{$key}}"> <i class="fe fe-check-circle"></i> {{$answer->title}}
                        </label>
                        @endif
                      @else
                        @if($answeredTask->answer == $answer->title)
                        <label class="btn btn-white active" style="text-align: left; margin-bottom: 0.5rem;">
                          <input type="radio" name="answer_{{$answeredTask->task->id}}" id="answer_{{$answeredTask->task->id}}_{{$answer->id}}" value="{{$answer->title}}" id="option{{$key}}"> <i class="fe fe-check-circle"></i> {{$answer->title}}
                        </label>
                        @else
                        <label class="btn btn-white" style="text-align: left; margin-bottom: 0.5rem;">
                          <input type="radio" name="answer_{{$answeredTask->task->id}}" id="answer_{{$answeredTask->task->id}}_{{$answer->id}}" value="{{$answer->title}}" id="option{{$key}}"> <i class="fe fe-check-circle"></i> {{$answer->title}}
                        </label>
                        @endif
                      @endif


                    @endforeach
                    </div>
                  @endif
                @elseif($answeredTask->task->open_ended)
                  <textarea class="form-control" name="answer_{{$answeredTask->task->id}}" id="answer_{{$answeredTask->task->id}}" rows="5" placeholder="Enter your answer here" style="margin-bottom: 1rem;">{{$answeredTask->answer}}</textarea>
                @endif

                @if($answeredTask->task->file_upload) 
                  <div class="box">
                    <input type="file" name="file_{{$answeredTask->task->id}}[]" id="file_{{$answeredTask->task->id}}" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple style="visibility: hidden; background-color: #076BFF;"/>
                    <label for="file_{{$answeredTask->task->id}}" style="position: absolute; left: 0; margin-left: 1.5rem; margin-bottom: 1.5rem;  border-radius: 0.25rem !important; padding: 0.5rem 1rem 0.5rem 1rem; background: #2c7be5; color: white;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17" fill="white"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span style="font-size: 1rem;">Choose Files</span></label>
                  </div>
                  <div id="selectedFiles_{{$answeredTask->task->id}}" style="margin-top: 1.5rem; margin-bottom: 0.5rem;"></div>
                  @if(count($answeredTask->answered_task_files) > 0)
                  <div style="margin-bottom: 0.5rem;">
                    @foreach($answeredTask->answered_task_files as $answeredTaskFile)
                    <div id="file-group_{{$answeredTaskFile->id}}">
                      <a href="https://storage.googleapis.com/talentail-123456789/{{$answeredTaskFile->url}}">{{$answeredTaskFile->title}}</a> <span id="delete-file_{{$answeredTask->id}}_{{$answeredTaskFile->id}}" class="remove-file" onclick="deleteFile()" style="border-color: transparent; margin-right: 0px; padding: 0px;"><i class="fas fa-times-circle" id="span_{{$answeredTask->id}}_{{$answeredTaskFile->id}}"></i></span><br/>
                    </div>
                    @endforeach
                  </div>
                  @endif
                @endif
              </div> <!-- / .card-body -->
            </div>
          </div>
        </div>

        <input type="hidden" name="files-deleted_{{$answeredTask->id}}" id="files-deleted_{{$answeredTask->id}}" />
      @endforeach
        <input type="hidden" name="submissionType" id="submissionType" />
        <button type="submit" class="btn btn-primary btn-block" id="saveProjectAttempt">Save Project</button>
        <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}" class="btn btn-default btn-block">Cancel</a>
      </form>
          @elseif($parameter == 'file')
            <div class="row">
        <div class="col-lg-12">
          <div class="card" data-toggle="lists" data-lists-values='["name"]'>
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col">
                  
                  <!-- Title -->
                  <h4 class="card-header-title">
                    Files
                  </h4>

                </div>
                <div class="col-auto">
                  
                  <!-- Dropdown -->
                  <div class="dropdown">

                    <!-- Toggle -->
                    <a href="#!" class="small text-muted dropdown-toggle" data-toggle="dropdown">
                      Sort order
                    </a>

                    <!-- Menu -->
                    <div class="dropdown-menu">
                      <a class="dropdown-item sort" data-sort="name" href="#!">
                        Asc
                      </a>
                      <a class="dropdown-item sort" data-sort="name" href="#!">
                        Desc
                      </a>
                    </div>

                  </div>
          
                </div>
              </div> <!-- / .row -->
            </div>
            <div class="card-body">

              <!-- List -->
              <ul class="list-group list-group-lg list-group-flush list my--4">
                @if(count($project->project_files))
                @foreach($project->project_files as $projectFile) 
                  <li class="list-group-item px-0">
                  <div class="row align-items-center">
                    <div class="col">
                      <h4 class="card-title mb-1 name">
                        {{$projectFile->title}}
                      </h4>
                    </div>
                    <div class="col-auto">
                      <a href="https://storage.googleapis.com/talentail-123456789/{{$projectFile->url}}" download="{{$projectFile->title}}" class="btn btn-sm btn-white d-none d-md-inline-block">
                        Download
                      </a>
                    </div>
                  </div>
                </li>
                @endforeach 
                @else
                <li class="list-group-item px-0">
                  <div class="row align-items-center">
                    <div class="col">
                      <p style="margin-bottom: 0;">No files attached to this project yet.</p>
                    </div>
                  </div>
                </li>
                @endif
              </ul>

            </div>
          </div>
        </div>
      </div>
          @else
            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-body" style="padding-bottom: 0.5rem;">
                    @if(count($project->competencies))
                      @foreach($project->competencies as $competency)
                      <div class="form-group" style="margin-bottom: 0rem;">
                            <span style="float: left;">🌟</span>
                            <p style="margin-left: 2rem;">
                              {{$competency->title}}
                            </p>
                      </div>
                    @endforeach
                    @else
                      <p>No competencies tagged to this project yet.</p>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          @endif
        </div>
        <div class="col-lg-3">
          <div class="card">
            <div class="card-body">
                <p style="font-weight: bold;">Project Workspace</p>
                <ul style="margin-left: -1.4rem;">
                  <li>Clarify your doubts with respect to the project</li>
                  <li>Request more files where applicable</li>
                </ul>
                <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/workspace" class="btn btn-block btn-primary">
                  Project Workspace
                </a>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
                <p style="font-weight: bold;">Useful Links</p>
                <ul style="margin-left: -1.4rem;">
                  <li><a href="#">xxx</a></li>
                </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    var tasksArray = document.getElementById("tasksArray").value.split(",");

    var selDiv = "";
    
    document.addEventListener("DOMContentLoaded", init, false);
    
    function init() {
      var selectedFile = 'selectedFiles_';

      for(var l=0; l<tasksArray.length; l++) {
        var taskId = tasksArray[l];
        document.querySelector('#file_' + taskId).addEventListener('change', handleFileSelect, false);
      }
    }
    
    function handleFileSelect(e) {
      console.log("handleFileSelect");
      if(!e.target.files) return;

      var idString = e.target.id.split("_");
      var idFromString = idString[1];

      document.getElementById('selectedFiles_' + idFromString).innerHTML = "";
      var files = e.target.files;
      for(var i=0; i<files.length; i++) {
        var f = files[i];
        document.getElementById('selectedFiles_' + idFromString).innerHTML += f.name + "<br/>";
      }
    }

    function purchaseProject() {
      document.getElementById("purchaseProjectButton").click();
    }

    function submitProjectAttempt() {
      document.getElementById("submissionType").value = "Submit";
      document.getElementById("submitProjectAttempt").click();
    }

    function saveProjectAttempt() {
      document.getElementById("submissionType").value = "Save";
      document.getElementById("submitProjectAttempt").click();
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

    if(document.getElementById("projectSaved") != null) {
      setTimeout(function(){ document.getElementById("projectSaved").style.display = "none" }, 3000);
    }

  </script>
@endsection

@section ('footer')
@endsection