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
                  Blog Overview
                </h6>

                <!-- Title -->
                <h1 class="header-title">
                  Create a new post
                </h1>

              </div>
            </div> <!-- / .row -->
          </div>
        </div>

        <!-- Form -->
          <form id="postForm" action="/blog/save" method="POST" class="mb-4" enctype="multipart/form-data">

          @csrf

          <!-- Project name -->
          <div class="form-group">
            <label>
              Title
            </label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Enter title" value="{{ old('title') }}" autofocus>
          </div>

          <div class="form-group">
            <label class="mb-1">
              Content
            </label>

            <div id="test-editormd3" style="border-radius: 0.5rem;">
                <textarea style="display:none;" name="content"></textarea>
            </div>
            <div id="old-content" style="display: none;">{{ old('content') }}</div>
          </div>

          <div class="form-group">
            <label class="mb-1">
              Notes
            </label>

            <textarea class="form-control" name="notes" id="notes" rows="5" placeholder="Enter notes" style="resize: none;">{{ old('notes') }}</textarea>
          </div>

          <hr class="mt-4 mb-5">
          <!-- Project cover -->
          <div class="form-group">
            <label class="mb-1">
              Post thumbnail
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


          <div class="form-group">
            <label>
              Tags
            </label>
            <input type="text" name="tags" class="form-control" id="tags" placeholder="Enter tags comma separated. e.g. startup, inception, hustle, ..." value="{{ old('tags') }}" autofocus>
          </div>

          <!-- Buttons -->
          <button type="submit" class="btn btn-block btn-primary">
            Save post
          </button>
          <a href="/blog/admin" class="btn btn-block btn-link text-muted">
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

    var selThumbnailDiv = "";
    
    document.addEventListener("DOMContentLoaded", init, false);
    
    function init() {
      document.querySelector('#thumbnail').addEventListener('change', handleThumbnailSelect, false);
      selThumbnailDiv = document.querySelector("#selectedThumbnail");
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
            editor2.insertValue(document.getElementById("old-content").innerHTML);
        }
    });
  </script>
@endsection

@section ('footer')
@endsection