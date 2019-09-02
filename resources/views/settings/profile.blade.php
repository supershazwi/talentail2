@extends ('layouts.main')

@section ('content')    
<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8">
      <!-- Header -->
      <div class="header mt-md-5">
        @if (session('success'))
        <div class="alert alert-success" role="alert" id="successAlert" style="text-align: center;">
          <h4 class="alert-heading" style="margin-bottom: 0;">Profile successfully updated!</h4>
        </div>
        @endif
        @if (session('error'))
          <div class="alert alert-danger" style="text-align: center;">
            <h4 class="alert-heading" style="margin-bottom: 0;">{{session('error')}}</h4>
          </div>
        @endif
        <div class="header-body">
          <div class="row align-items-center">
            <div class="col">
              
              <!-- Pretitle -->
              <h6 class="header-pretitle">
                Overview
              </h6>

              <!-- Title -->
              <h1 class="header-title">
                Settings
              </h1>

            </div>
          </div> <!-- / .row -->
          <div class="row align-items-center">
            <div class="col">
              
              <!-- Nav -->
              <ul class="nav nav-tabs nav-overflow header-tabs">
                <li class="nav-item">
                  <a href="/settings" class="nav-link active">
                    Personal Information
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/settings/authentication" class="nav-link">
                    Authentication
                  </a>
                </li>
              </ul>

            </div>
          </div>
        </div>
      </div>

      <!-- Form -->
      <form class="mb-4" method="POST" action="/profile/save" enctype="multipart/form-data">
      @csrf
        <div class="row">
          <div class="col-12 col-md-12">
            
            <!-- First name -->
            <div class="form-group">

              <!-- Label -->
              <label>
                Avatar
              </label>

              <br/>

              @if(Auth::user()->avatar)
                <img src="https://storage.googleapis.com/talentail-123456789/{{$user->avatar}}" alt="..." class="avatar-img rounded" style="width: 5rem;">
              @else
                <img src="/img/avatar.png" alt="..." class="avatar-img rounded" style="width: 5rem;">
              @endif

              <div class="box" style="margin-top: 1rem;">
                <input type="file" name="avatar" id="avatar" class="inputfile inputfile-1" style="visibility: hidden; margin-bottom: 1.5rem;"/>
                <label for="avatar" style="position: absolute; left: 0; margin-left: 12px; margin-bottom: 1.5rem;  border-radius: 0.25rem !important; padding: 0.5rem 1rem 0.5rem 1rem; background: #2c7be5; color: white;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17" fill="white"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span style="font-size: 1rem;">Choose Avatar</span></label>
              </div>
              <div id="selectedAvatar">
              </div>
            </div>

          </div>
          <div class="col-12 col-md-12">
            
            <!-- First name -->
            <div class="form-group">

              <!-- Label -->
              <label>
                Name
              </label>

              <!-- Input -->
              <input type="text" name="name" class="form-control" id="name" placeholder="Enter your full name (e.g. Johnie Orange)" value="{{$user->name}}">

            </div>

          </div>
          <div class="col-12">
            
            <!-- Email address -->
            <div class="form-group">

              <!-- Label -->
              <label class="mb-1">
                Email address
              </label>

              <!-- Form text -->
              <small class="form-text text-muted">
                This will be used to log onto the platform.
              </small>

              <!-- Input -->
              <input type="text" name="email" class="form-control" id="email" placeholder="Enter your email (e.g. j.orange@gmail.com)" value="{{$user->email}}">

            </div>

          </div>
          <div class="col-12 col-md-6">
            
            <!-- Phone -->
            <div class="form-group">

              <!-- Label -->
              <label>
                Website
              </label>

              <!-- Input -->
              <input type="text" name="website" class="form-control" id="website" placeholder="Enter your website link (e.g. https://johnieorange.com)" value="{{$user->website}}">

            </div>
          </div>
          <div class="col-12 col-md-6">
            
            <!-- Birthday -->
            <div class="form-group">

              <!-- Label -->
              <label>
                LinkedIn
              </label>

              <!-- Input -->
              <input type="text" name="linkedin" class="form-control" id="linkedin" placeholder="Enter your LinkedIn profile link (e.g. https://www.linkedin.com/in/jorange.007)" value="{{$user->linkedin}}">

            </div>
          </div>
          <div class="col-12 col-md-6">
            
            <!-- Phone -->
            <div class="form-group">

              <!-- Label -->
              <label>
                Facebook
              </label>

              <!-- Input -->
              <input type="text" name="facebook" class="form-control" id="facebook" placeholder="Enter your Facebook profile link (e.g. https://www.facebook.com/jorange.007)" value="{{$user->facebook}}">

            </div>
          </div>
          <div class="col-12 col-md-6">
            
            <!-- Birthday -->
            <div class="form-group">

              <!-- Label -->
              <label>
                Twitter
              </label>

              <!-- Input -->
              <input type="text" name="twitter" class="form-control" id="twitter" placeholder="Enter your Twitter profile link (e.g. https://www.twitter.com/jorange.007)" value="{{$user->twitter}}">
              
            </div>
          </div>

          <div class="col-12">
            
            <!-- Email address -->
            <div class="form-group">

              <!-- Label -->
              <label class="mb-1">
                Description
              </label>

              <!-- Input -->
              <textarea type="text" placeholder="Tell us a little about yourself" name="description" id="description" class="form-control" rows="5" style="margin-bottom: 1.5rem;">{{$user->description}}</textarea>

            </div>

            <button type="submit" class="btn btn-primary">
              Update profile
            </button>

          </div>
        </div> <!-- / .row -->
      </form>

    </div>
  </div> <!-- / .row -->
</div>

<script type="text/javascript">
  setTimeout(function(){ document.getElementById("successAlert").style.display = "none" }, 3000);

  var selAvatarDiv = "";
  
  document.addEventListener("DOMContentLoaded", init, false);
  
  function init() {
    document.querySelector('#avatar').addEventListener('change', handleAvatarSelect, false);
    selAvatarDiv = document.querySelector("#selectedAvatar");
  }

  function handleAvatarSelect(e) {
    if(!e.target.files) return;
    selAvatarDiv.innerHTML = "";
    
    var files = e.target.files;
    for(var i=0; i<files.length; i++) {
      var f = files[i];
      
      selAvatarDiv.innerHTML += f.name + "<br/>";
    }
  }
</script>

@endsection

@section ('footer')
@endsection