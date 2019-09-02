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
                  Portfolio Management
                </h6>

                <!-- Title -->
                <h1 class="header-title">
                  Manage portfolio - {{$portfolio->role->title}}
                </h1>

              </div>
            </div> <!-- / .row -->
          </div>
        </div>

        <form action="/portfolios/{{$portfolio->id}}/save" method="POST" class="mb-4" enctype="multipart/form-data">
        @csrf

        @if(count($answeredExercises) > 0)
            
          <div class="container">
            <div class="row align-items-center" style="margin-bottom: 0.5rem;">
              <div class="col-auto" style="padding-left: 0px;">
                <h1 style="color: #3e3e3c; margin-bottom: 0.5rem; font-size: 1.5rem;">
                  All Attempted Exercises
                </h1>
                <p>* Exercises have to be <span style="border-bottom: 2.5px solid #0984e3;">submitted and reviewed</span> before companies get to see them.</p>
              </div>
              <div class="col">

              </div>
            </div>
            <div class="row">
              <div class="col-12 col-xl-12" style="padding-left: 0; padding-right: 0;">
                <div class="card">  
                    <table class="table" style="margin-bottom: 0;">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Exercise</th>
                          <th scope="col">Status</th>
                          <th scope="col">Visible to Company</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach($answeredExercises as $key=>$answeredExercise)
                          <tr>
                            <th scope="row">{{$key+1}}</th>
                            <td><a href="/exercises/{{$answeredExercise->exercise->slug}}">{{$answeredExercise->exercise->solution_title}}</a></td>
                            <td>
                              @if($answeredExercise->status == "Submitted For Review")
                              <span class="badge badge-warning">{{$answeredExercise->status}}</span>
                              @elseif($answeredExercise->status == "Competent")
                              <span class="badge badge-success">{{$answeredExercise->status}}</span>
                              @elseif($answeredExercise->status == "Needs Improvement")
                              <span class="badge badge-danger">{{$answeredExercise->status}}</span>
                              @elseif($answeredExercise->status == "Attempted")
                              <span class="badge badge-dark">{{$answeredExercise->status}}</span>
                              @else
                              <span class="badge badge-light">{{$answeredExercise->status}}</span>
                              @endif
                            </td>
                            <td>
                              <div class="custom-control custom-checkbox-toggle">
                                @if($answeredExercise->visible)
                                <input type="checkbox" class="custom-control-input" name="answeredExercise[]" id="answeredExercise_{{$answeredExercise->id}}" value="{{$answeredExercise->id}}" checked>
                                @else
                                @if($answeredExercise->status == "Reviewed")
                                <input type="checkbox" class="custom-control-input" name="answeredExercise[]" id="answeredExercise_{{$answeredExercise->id}}" value="{{$answeredExercise->id}}">
                                @else
                                <input type="checkbox" class="custom-control-input" name="answeredExercise[]" id="answeredExercise_{{$answeredExercise->id}}" value="{{$answeredExercise->id}}" disabled>
                                @endif
                                @endif
                                <label class="custom-control-label" for="answeredExercise_{{$answeredExercise->id}}" id="answeredExercise_{{$answeredExercise->id}}"></label>
                              </div>
                            </td>
                          </tr>
                          @endforeach
                      </tbody>
                    </table>
                </div>
              </div>
            </div>
          </div>


        <hr style="margin-bottom: 2.5rem;">
        @else
          <div class="form-group">
            
            <div class="container">
              <div class="row align-items-center">
                <div class="col-auto" style="padding-left: 0px;">
                  <h2>
                    All Attempted Exercises
                  </h2>
                </div>
                <div class="col">

                </div>
              </div>
              <div class="row align-items-center" id="talentailBox">
                <div class="col-lg-12" style="padding: 0rem !important;  margin-top: 1rem;">
                  <div class="card">
                    <div class="card-body">
                      <div class="row justify-content-center" style="margin-top:1rem;">
                        <div class="col-12 col-md-5 col-xl-4 my-5">
                          <p class="text-center mb-5" style="font-size: 2rem; margin-bottom: 0.25rem !important; -webkit-transform: scaleX(-1); transform: scaleX(-1);">😀</p>
                          <p class="text-center mb-3" style="margin-bottom: 2.25rem !important;">Exercises have been created and adapted from actual work engagements. Exercises that have been attempted and reviewed will appear here. <a href="/roles/business-analyst">Discover tasks</a>.
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <hr style="margin-bottom: 2.5rem;">
        @endif

          <button type="submit" class="btn btn-block btn-primary">
            Save portfolio
          </button>
          <a href="/portfolios/{{$portfolio->id}}" class="btn btn-block btn-link text-muted">
            Cancel
          </a>

          <input type="hidden" name="files-deleted" value="" id="files-deleted" />
          <input type="hidden" name="projects-deleted" value="" id="projects-deleted" />
          <input type="hidden" name="endorsers-deleted" value="" id="endorsers-deleted" />
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    let cardLength = document.querySelectorAll('.project-card').length;

    for (var i = 1; i <= cardLength; i++) {
      document.querySelector('#file_' + i).addEventListener('change', handleFileSelect, false);
    }

    function handleFileSelect(e) {
      let fileId = e.path[0].id.split('_'); // #file_1
      if(!e.target.files) return;
      document.getElementById('selectedFiles_'+fileId[1]).innerHTML = "";
      
      var files = e.target.files;
      for(var i=0; i<files.length; i++) {
        var f = files[i];
        
        document.getElementById('selectedFiles_'+fileId[1]).innerHTML += f.name + "<br/>";
      }
    }

    function addProject() {
      event.preventDefault();

      if(document.getElementById("externalBox") != null) {
        document.getElementById("externalBox").style.display = "none";
      }
      
      let cardCounter = document.querySelectorAll('.project-card').length + 1;

      document.getElementById("projectsList_" + cardCounter).innerHTML += "<div class='card' id='projectsList_" + cardCounter + "'><div class='card-body project-card' id='card_" + cardCounter + "'><div class='row'><div class='col-12 col-md-12'><div class='form-group'><label class='project-title'>Project #" + cardCounter + " Title</label><input type='text' name='project-title_" + cardCounter + "' class='form-control project-title-input' id='project-title-input_" + cardCounter + "' placeholder='Enter title'></div></div></div><div class='row'><div class='col-12 col-md-12'><div class='form-group'><label class='project-description'>Project #" + cardCounter + " Description</label><input type='text' name='project-description_" + cardCounter + "' class='form-control project-description-input' id='project-description-input_" + cardCounter + "' placeholder='Enter description'></div></div></div><div class='row'><div class='col-12 col-md-12'><div class='form-group'><label class='mb-1'>Select industry</label><select class='form-control' data-toggle='select' name='industry_" + cardCounter + "' id='industry_" + cardCounter + "'><option value='Nil'>Select industry</option>@foreach($industries as $industry)<option value='{{$industry->id}}'>{{$industry->title}}</option>@endforeach</select></div></div></div><div class='row'><div class='col-12 col-md-12'><div class='form-group'><label class='mb-1'>Supporting files</label><small class='form-text text-muted'>Upload files pertaining to this project.</small><div class='box'><input type='file' name='file_" + cardCounter + "[]' id='file_" + cardCounter + "' class='inputfile inputfile_" + cardCounter + "' multiple style='visibility: hidden; margin-bottom: 1.5rem;'/><label id='file-label_" + cardCounter + "' for='file_" + cardCounter + "' style='position: absolute; left: 0; margin-left: 12px; margin-bottom: 1.5rem;  border-radius: 0.25rem !important; padding: 0.5rem 1rem 0.5rem 1rem; background: #2c7be5; color: white;'><svg xmlns='http://www.w3.org/2000/svg' width='20' height='17' viewBox='0 0 20 17' fill='white'><path d='M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z'/></svg> <span style='font-size: 1rem;'>Choose Files</span></label></div><div id='selectedFiles_" + cardCounter + "'></div></div></div></div><div class='row'><div class='col-12 col-md-12'><div class='form-group'><label class='project-endorsers'>Endorsers</label><small class='form-text text-muted'>Separate each endorser by a comma i.e. (aaa@gmail.com, bbb@hotmail.com, ccc@yahoo.com)</small><input type='text' name='project-endorsers_" + cardCounter + "' class='form-control project-endorsers-input' id='project-endorsers-input_" + cardCounter + "' placeholder='Enter endorsers'></div></div></div><div class='row align-items-center'><div class='col-auto'></div><div class='col'></div><div class='col-auto'><button class='btn btn-danger delete-project' id='delete-project_" + cardCounter + "' onclick='deleteProject()'>Delete Project</button></div></div></div></div>";

      document.getElementById("projectsList_" + cardCounter).insertAdjacentHTML('afterend', "<div class='project-accordion' id='projectsList_" + (cardCounter+1) + "'></div>");

      document.querySelector('#file_' + cardCounter).addEventListener('change', handleFileSelect, false);
    }

    function deleteProject() {
      event.preventDefault();

      let projectIdString = event.target.id.split("_");
      let projectsListId = "projectsList_"+projectIdString[1];

      if(document.getElementById("project-id_"+projectIdString[1]) != null) {
        if(document.getElementById("projects-deleted").value == "") {
          document.getElementById("projects-deleted").value += document.getElementById("project-id_"+projectIdString[1]).value;
        } else {
          document.getElementById("projects-deleted").value += ", " + document.getElementById("project-id_"+projectIdString[1]).value;
        }
      }

      // find total number of answers first
      let projectCount = document.getElementsByClassName("project-card").length;

      let elem = document.getElementById(projectsListId);
      elem.parentNode.removeChild(elem);

      if(projectCount == 1) {
          document.getElementById("externalBox").style.display = "block";
      }

      // need to recalculate all the ids
      // task-card
      let x = document.getElementsByClassName("project-card");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "card_"+(i+1);
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

      // project-title
      x = document.getElementsByClassName("project-title");
      for (i = 0; i < x.length; i++) {        
          x[i].innerHTML = "Project #"+(i+1)+" Title";
      }

      // project-title-input
      x = document.getElementsByClassName("project-title-input");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "project-title-input_"+(i+1);     
          x[i].name = "project-title-input_"+(i+1);
      }

      // project-description
      x = document.getElementsByClassName("project-description");
      for (i = 0; i < x.length; i++) {        
          x[i].innerHTML = "Project #"+(i+1)+" Description";
      }

      // project-description-input
      x = document.getElementsByClassName("project-description-input");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "project-description-input_"+(i+1);  
          x[i].name = "project-description-input_"+(i+1);
      }

      // delete-project
      x = document.getElementsByClassName("delete-project");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "delete-project_"+(i+1);
      }

      // project-accordion
      x = document.getElementsByClassName("project-accordion");
      for (i = 0; i < x.length; i++) {        
          x[i].id = "projectsList_"+(i+1);
      }

      projectId = parseInt(projectIdString[1]);

      for (i = projectId; i < projectCount; i++) {
        x = document.getElementById('file_' + (i + 1));
        x.id = "file_" + i;
        x.name = "file_" + i;
        x.className = "inputfile inputfile_" + i;

        x = document.getElementById('file-label_' + (i + 1));
        x.id = 'file-label_' + i;
        x.htmlFor = 'file_' + i;

        x = document.getElementById('selectedFiles_' + (i + 1));
        x.id = 'selectedFiles_' + i;

        x = document.getElementById('industry_' + (i + 1));
        x.id = 'industry_' + i;
        x.name = 'industry_' + i;

        x = document.getElementById('project-endorsers-input_' + (i + 1));
        x.id = 'project-endorsers-input_' + i;
        x.name = 'project-endorsers_' + i;

        x = document.getElementById('project-id_' + (i + 1));
        x.id = 'project-id_' + i;
        name.id = 'project-id_' + i;
      }
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

    function deleteEndorser() {
      let fileIdString = event.target.id.split("_");
      let fileId = fileIdString[1];

      if(document.getElementById("endorsers-deleted").value == "") {
        document.getElementById("endorsers-deleted").value += fileId;
      } else {
        document.getElementById("endorsers-deleted").value += ", " + fileId;
      }

      let elem = document.getElementById("endorser-group_"+fileId);
      elem.parentNode.removeChild(elem);
    }
  </script>

@endsection

@section ('footer')
@endsection