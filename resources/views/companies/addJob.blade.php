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
                  Company Managmement
                </h6>

                <!-- Title -->
                <h1 class="header-title">
                  Create a new job under {{$company->title}}
                </h1>

              </div>
            </div> <!-- / .row -->
          </div>
        </div>

        <!-- Form -->
          <form method="POST" action="/companies/{{$company->slug}}/save-job" enctype="multipart/form-data">
          {{ csrf_field() }}

          <!-- Project name -->
          <div class="form-group">
            <label>
              Title
            </label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Enter title" value="{{ old('title') }}" autofocus>
          </div>

          <div class="form-group">
            <label>
              Description
            </label>
            <div id="test-editormd3" style="border-radius: 0.5rem;">
                <textarea style="display:none;" name="description"></textarea>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="mb-1">
                  Type
                </label>
                <select class="form-control" data-toggle="select" name="type">
                  <option value="Nil">Select type</option>
                  <option value="Permanent">Full-time</option>
                  <option value="Contract">Contract</option>
                  <option value="Part-time">Part-time</option>
                </select>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="mb-1">
                  Seniority Level
                </label>
                <select class="form-control" data-toggle="select" name="type">
                  <option value="Nil">Select type</option>
                  <option value="Associate">Associate</option>
                  <option value="Junior">Junior</option>
                  <option value="Senior">Senior</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="mb-1">
                  Industry
                </label>
                <select class="form-control" data-toggle="select" name="type">
                  <option value="Nil">Select type</option>
                  <option value="Permanent">Full-time</option>
                  <option value="Contract">Contract</option>
                  <option value="Part-time">Part-time</option>
                </select>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="mb-1">
                  Location
                </label>
                <select class="form-control" data-toggle="select" name="type">
                  <option value="Nil">Select type</option>
                  <option value="Associate">Associate</option>
                  <option value="Junior">Junior</option>
                  <option value="Senior">Senior</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Buttons -->
          <button type="submit" class="btn btn-block btn-primary">
            Save job
          </button>
          <a href="/companies/{{$company->slug}}" class="btn btn-block btn-link text-muted">
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
            editor2.insertValue(document.getElementById("old-brief").innerHTML);
        }
    });

  </script>
@endsection

@section ('footer')
@endsection