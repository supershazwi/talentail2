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
                  Create a new company
                </h1>

              </div>
            </div> <!-- / .row -->
          </div>
        </div>

        <!-- Form -->
          <form method="POST" action="/companies" enctype="multipart/form-data">
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
            <textarea class="form-control" name="description" id="description" rows="5" placeholder="Enter description">{{ old('description') }}</textarea>
          </div>

          <div class="form-group">
            <label>
              Website
            </label>
            <input type="text" name="website" class="form-control" id="website" placeholder="Enter website" value="{{ old('website') }}">
          </div>

          <div class="form-group">
            <label>
              Facebook
            </label>
            <input type="text" name="facebook" class="form-control" id="facebook" placeholder="Enter facebook" value="{{ old('facebook') }}">
          </div>
          <div class="form-group">
            <label>
              Twitter
            </label>
            <input type="text" name="twitter" class="form-control" id="twitter" placeholder="Enter twitter" value="{{ old('twitter') }}">
          </div>
          <div class="form-group">
            <label>
              LinkedIn
            </label>
            <input type="text" name="linkedin" class="form-control" id="linkedin" placeholder="Enter linkedin" value="{{ old('linkedin') }}">
          </div>
          <div class="form-group">
            <label>
              Email
            </label>
            <input type="text" name="email" class="form-control" id="email" placeholder="Enter email" value="{{ old('email') }}">
          </div>
          <div class="form-group">
            <label>
              Avatar
            </label>
            <div class="box">
              <input type="file" name="avatar" id="avatar" class="inputfile inputfile-1" style="visibility: hidden; margin-bottom: 1.5rem;"/>
              <label for="avatar" style="position: absolute; left: 0; margin-left: 12px; margin-bottom: 1.5rem;  border-radius: 0.25rem !important; padding: 0.5rem 1rem 0.5rem 1rem; background: #2c7be5; color: white;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17" fill="white"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span style="font-size: 1rem;">Choose avatar</span></label>
            </div>
            <div id="selectedAvatar"></div>
          </div>

          <!-- Buttons -->
          <button type="submit" class="btn btn-block btn-primary">
            Save company
          </button>
          <a href="/companies" class="btn btn-block btn-link text-muted">
            Cancel
          </a>

        </form>
        

      </div>
    </div> <!-- / .row -->
  </div>
  <script type="text/javascript">

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    var selDiv = "";
    
    document.addEventListener("DOMContentLoaded", init, false);
    
    function init() {
      document.querySelector('#avatar').addEventListener('change', handleThumbnailSelect, false);
      selDiv = document.querySelector("#selectedAvatar");
    }

    function handleThumbnailSelect(e) {
      if(!e.target.files) return;
      selDiv.innerHTML = "";
      
      var files = e.target.files;
      for(var i=0; i<files.length; i++) {
        var f = files[i];
        
        selDiv.innerHTML += f.name + "<br/>";
      }
    }
  </script>
@endsection

@section ('footer')
@endsection