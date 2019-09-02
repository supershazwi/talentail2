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
          <form method="POST" action="/opportunity-submissions/{{$opportunitySubmission->slug}}/save-opportunity" enctype="multipart/form-data">
          {{ csrf_field() }}

          <!-- Project name -->
          <div class="form-group">
            <label>
              Title
            </label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Enter title" value="{{ $opportunitySubmission->title }}" autofocus>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="mb-1">
                  Company
                </label>
                <input type="text" name="company" class="form-control" id="company" placeholder="Enter company" value="{{ $opportunitySubmission->company }}" >
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
                  @if($role->id == $opportunitySubmission->role_id)
                  <option value="{{$role->id}}" selected>{{$role->title}}</option>
                  @else
                  <option value="{{$role->id}}">{{$role->title}}</option>
                  @endif
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label>
              Description - We will map the relevant exercises according to the job description you provide.
            </label>
            <div id="test-editormd3" style="border-radius: 0.5rem;">
                <textarea style="display:none;" name="description"></textarea>
                <input type="hidden" id="storedDescription" value="{{$opportunitySubmission->description}}" />
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
                  @if($opportunitySubmission->type == "Permanent")
                  <option value="Permanent" selected>Permanent</option>
                  @else
                  <option value="Permanent">Permanent</option>
                  @endif
                  @if($opportunitySubmission->type == "Contract")
                  <option value="Contract" selected>Contract</option>
                  @else
                  <option value="Contract">Contract</option>
                  @endif
                  @if($opportunitySubmission->type == "Part-Time")
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
                  @if($opportunitySubmission->level == "Entry Level")
                  <option value="Entry Level" selected>Entry Level</option>
                  @else
                  <option value="Entry Level">Entry Level</option>
                  @endif
                  @if($opportunitySubmission->level == "Associate")
                  <option value="Associate" selected>Associate</option>
                  @else
                  <option value="Associate">Associate</option>
                  @endif
                  @if($opportunitySubmission->level == "Junior")
                  <option value="Junior" selected>Junior</option>
                  @else
                  <option value="Junior">Junior</option>
                  @endif
                  @if($opportunitySubmission->level == "Senior")
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
                <input type="text" name="location" class="form-control" id="location" placeholder="Enter location" value="{{ $opportunitySubmission->location }}">
              </div>
            </div>
          </div>

          <!-- Buttons -->
          <button type="submit" class="btn btn-block btn-primary">
            Save Opportunity
          </button>
          <a href="/opportunity-submissions/{{ $opportunitySubmission->slug }}" class="btn btn-block btn-link text-muted">
            Cancel
          </a>

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
            // editor2.insertValue(document.getElementById("old-brief").innerHTML);
            editor2.insertValue(document.getElementById("storedDescription").value);
        }
    });

  </script>
@endsection

@section ('footer')
@endsection