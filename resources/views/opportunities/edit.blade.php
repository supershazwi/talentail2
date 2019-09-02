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
                  Opportunity Managmement
                </h6>

                <!-- Title -->
                <h1 class="header-title">
                  Edit Opportunity
                </h1>

              </div>
            </div> <!-- / .row -->
          </div>
        </div>

        <!-- Form -->
          <form method="POST" action="/opportunities/{{$opportunity->slug}}/save-opportunity" enctype="multipart/form-data">
          {{ csrf_field() }}

          <!-- Project name -->
          <div class="form-group">
            <label>
              Title
            </label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Enter title" value="{{ $opportunity->title }}" autofocus>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="mb-1">
                  Company
                </label>
                <select class="form-control" data-toggle="select" name="company">
                  <option value="Nil">Select company</option>
                  @foreach($companies as $company)
                  @if($company->id == $opportunity->company_id)
                  <option value="{{$company->id}}" selected>{{$company->title}}</option>
                  @else
                  <option value="{{$company->id}}">{{$company->title}}</option>
                  @endif
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="mb-1">
                  Select role
                </label>
                <select class="form-control" data-toggle="select" name="role">
                  <option value="Nil">Select role</option>
                  @foreach($roles as $role)
                  @if($role->id == $opportunity->role_id)
                  <option value="{{$role->id}}" selected>{{$role->title}}</option>
                  @else
                  <option value="{{$role->id}}">{{$role->title}}</option>
                  @endif
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="mb-1">
                  Posted at
                </label>
                <input type="text" name="posted_at" class="form-control" id="posted_at" placeholder="Enter posted location" value="{{ $opportunity->posted_at }}">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="mb-1">
                  Link
                </label>
                <input type="text" name="link" class="form-control" id="link" placeholder="Enter link" value="{{ $opportunity->link }}">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label>
              Description
            </label>
            <div id="test-editormd3" style="border-radius: 0.5rem;">
                <textarea style="display:none;" name="description"></textarea>
                <input type="hidden" id="storedDescription" value="{{$opportunity->description}}" />
            </div>
          </div>

          <div class="row">
            <div class="col-lg-4">
              <div class="form-group">
                <label class="mb-1">
                  Type
                </label>
                <select class="form-control" data-toggle="select" name="type">
                  <option value="Nil">Select type</option>
                  @if($opportunity->type == "Permanent")
                  <option value="Permanent" selected>Permanent</option>
                  @else
                  <option value="Permanent">Permanent</option>
                  @endif
                  @if($opportunity->type == "Contract")
                  <option value="Contract" selected>Contract</option>
                  @else
                  <option value="Contract">Contract</option>
                  @endif
                  @if($opportunity->type == "Part-Time")
                  <option value="Part-Time" selected>Part-Time</option>
                  @else
                  <option value="Part-Time">Part-Time</option>
                  @endif
                </select>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group">
                <label class="mb-1">
                  Seniority Level
                </label>
                <select class="form-control" data-toggle="select" name="level">
                  <option value="Nil">Select level</option>
                  @if($opportunity->level == "Entry Level")
                  <option value="Entry Level" selected>Entry Level</option>
                  @else
                  <option value="Entry Level">Entry Level</option>
                  @endif
                  @if($opportunity->level == "Associate")
                  <option value="Associate" selected>Associate</option>
                  @else
                  <option value="Associate">Associate</option>
                  @endif
                  @if($opportunity->level == "Junior")
                  <option value="Junior" selected>Junior</option>
                  @else
                  <option value="Junior">Junior</option>
                  @endif
                  @if($opportunity->level == "Senior")
                  <option value="Senior" selected>Senior</option>
                  @else
                  <option value="Senior">Senior</option>
                  @endif
                </select>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group">
                <label class="mb-1">
                  Location
                </label>
                <input type="text" name="location" class="form-control" id="location" placeholder="Enter location" value="{{ $opportunity->location }}">
              </div>
            </div>
          </div>

          <!-- Buttons -->
          <button type="submit" class="btn btn-block btn-primary">
            Save Opportunity
          </button>
          <a href="#" onclick="deleteOpportunity()" class="btn btn-block btn-danger">
            Delete Opportunity
          </a>
          <a href="/opportunities" class="btn btn-block btn-link text-muted">
            Cancel
          </a>

        </form>
        <form method="POST" action="/opportunities/{{$opportunity->slug}}/delete-opportunity">
          @csrf
          <button type="submit" style="display: none;" id="deleteOpportunityButton" />
        </form>

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

    var editor2 = editormd({
        id   : "test-editormd3",
        path : "/lib/",
        height: 640,
        placeholder: "Write the job brief description...",
        onload : function() {
            //this.watch();
            //this.setMarkdown("###test onloaded");
            //testEditor.setMarkdown("###Test onloaded");
            // editor2.insertValue(document.getElementById("brief-info").innerHTML);
            editor2.insertValue(document.getElementById("storedDescription").value);
        }
    });

    function deleteOpportunity() {
      event.preventDefault();
      document.getElementById("deleteOpportunityButton").click();
    }

    function toggleCheckboxes() {
      let checkboxIdString = event.target.id.split("_");

      var array = document.getElementsByClassName("task_" + checkboxIdString[1]);

      var checked = document.getElementById("task_" + checkboxIdString[1]).checked;

      for(var ii = 0; ii < array.length; ii++)
      {

         if(array[ii].className == "custom-control-input task_" + checkboxIdString[1])
         {
          array[ii].checked = checked;
         }
      }
    }

    function toggleIndividualCheckboxes() {
      let checkboxIdString = event.target.id.split("_");

      let taskId = checkboxIdString[1];
      let exerciseId = checkboxIdString[2];

      if(document.getElementById("exercise_"+taskId+"_"+exerciseId).checked == false) {
        document.getElementById("task_"+taskId).checked = false;
      }
    }

  </script>
@endsection

@section ('footer')
@endsection