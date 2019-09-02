@extends ('layouts.main')

@section ('content')
  <div class="container">
    <div class="row" style="margin-top: 1.5rem;">
      <div class="col-12 col-lg-9">
        
        <!-- Header -->
        <div class="header mt-md-5" style="margin-top: 0rem !important;">
          <div class="header-body">
            <div class="row align-items-center">
              <div class="col">
                
                <!-- Pretitle -->
                <h6 class="header-pretitle">
                  {{$community->title}}
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
          <form action="/communities/{{$community->slug}}/create-post" method="POST" class="mb-4" enctype="multipart/form-data">

          @csrf

          <div class="form-group">
            <label>
              Post title
            </label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Enter title" value="{{ old('title') }}" autofocus>
          </div>

          <div class="form-group">
            <label class="mb-1">
              Post content
            </label>

            <div id="test-editormd3" style="border-radius: 0.5rem;">
                <textarea style="display:none;" name="description"></textarea>
            </div>
            <div id="old-description" style="display: none;">{{ old('description') }}</div>
          </div>

          <!-- Starting files -->
          <div class="form-group">
            <label class="mb-1">
              Supporting files
            </label>
            <div class="box">
              <input type="file" name="file[]" id="file" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple style="visibility: hidden; margin-bottom: 1.5rem;"/>
              <label for="file" style="position: absolute; left: 0; margin-left: 12px; margin-bottom: 1.5rem;  border-radius: 0.25rem !important; padding: 0.5rem 1rem 0.5rem 1rem; background: #2c7be5; color: white;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17" fill="white"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span style="font-size: 1rem;">Choose Files</span></label>
            </div>
            <div id="selectedFiles"></div>
          </div>
         
          <hr class="mt-5 mb-5">

          <!-- Buttons -->
        <button type="submit" class="btn btn-block btn-primary">
          Submit Post
        </button>
        <a href="/communities/{{$community->slug}}" class="btn btn-block btn-link text-muted">
          Cancel
        </a>
        </form>
      </div>
      <div class="col-lg-3">
        <div class="card">
          <div class="card-body">
            <h3>{{$community->title}}</h3>
            <p>{{$community->description}}</p>

            @if($subscribed)
              <button class="btn btn-primary btn-block" id="subscribed" disabled>Subscribed</button>
            @else
            <form id="subscribeForm" method="POST" action="/communities/{{$community->slug}}/subscribe" enctype="multipart/form-data">
              @csrf
              <button type="submit" class="btn btn-primary btn-block" id="subscribe">Subscribe</button>
            </form>
            @endif
          </div>
        </div>
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
      document.querySelector('#file').addEventListener('change', handleFileSelect, false);
      selDiv = document.querySelector("#selectedFiles");

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

    var editor2 = editormd({
        id   : "test-editormd3",
        path : "/lib/",
        height: 640,
        placeholder: "Start writing your post...",
        onload : function() {
            //this.watch();
            //this.setMarkdown("###test onloaded");
            //testEditor.setMarkdown("###Test onloaded");
            // editor2.insertValue(document.getElementById("brief-info").innerHTML);
            editor2.insertValue(document.getElementById("old-brief").innerHTML);
        }
    });

  </script>
  <script type="text/javascript">
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