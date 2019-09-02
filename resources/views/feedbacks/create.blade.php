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
                  New feedback
                </h6>

                <!-- Title -->
                <h1 class="header-title">
                  Create a new feedback
                </h1>

              </div>
            </div> <!-- / .row -->
          </div>
        </div>

        <form id="feedbackForm" method="POST" class="mb-4" action="/exercises/{{$exercise->slug}}/submit-feedback" enctype="multipart/form-data">

          {{ csrf_field() }}

          <div class="form-group">
            <label class="mb-1">
              Feedback
            </label>

            <textarea class="form-control" name="content" id="content" rows="10" placeholder="Enter feedback" style="resize: none;">{{ old('content') }}</textarea>
          </div>

          <div class="form-group">
            <label class="mb-1">
              Supporting files
            </label>

            <div class="box">
              <input type="file" name="file[]" id="file" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple="" style="visibility: hidden; background-color: #076BFF;">
              <label for="file" style="position: absolute; left: 0; margin-left: 0.75rem; margin-bottom: 1.5rem;  border-radius: 0.25rem !important; padding: 0.5rem 1rem 0.5rem 1rem; background: #2c7be5; color: white;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17" fill="white"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg> <span style="font-size: 1rem;">Choose Files</span></label>
            </div>
            <div id="selectedFiles" style="margin-top: 1.5rem;"></div>
          </div>

          <button type="submit" class="btn btn-block btn-primary" style=" margin-top: 0.5rem;">
            Submit Feedback
          </button>
          <a href="/exercises/{{$exercise->slug}}" class="btn btn-block btn-link text-muted">
            Cancel
          </a>

        </form>

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

    document.addEventListener("DOMContentLoaded", init, false);
    
    function init() {
      var selectedFile = 'selectedFiles';
      document.querySelector('#file').addEventListener('change', handleFileSelect, false);
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
  </script>
@endsection

@section ('footer')
@endsection