@extends ('layouts.main')

@section ('content')    
<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8">
      <!-- Header -->
      <div class="header mt-md-5">
        @if (session('success'))
        <div class="alert alert-success" role="alert" id="successAlert" style="text-align: center;">
          <h4 class="alert-heading" style="margin-bottom: 0;">Password successfully updated!</h4>
        </div>
        @endif
        @if (session('error'))
          <div class="alert alert-primary" style="text-align: center;">
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
                  <a href="/settings" class="nav-link">
                    Personal Information
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/settings/authentication" class="nav-link active">
                    Authentication
                  </a>
                </li>
              </ul>

            </div>
          </div>
        </div>
      </div>

      <!-- Form -->
      <form class="mb-4" method="POST" action="/settings/authentication">
      @csrf

        <div class="row">
          <div class="col-12 col-md-6 order-md-2">
            
            <!-- Card -->
            <div class="card bg-light border ml-md-4">
              <div class="card-body">
                
                <p class="mb-2">
                  Password requirements
                </p>

                <p class="small text-muted mb-2">
                  Make it extremely hard for someone else to guess it! Below requirements are recommended:
                </p>

                <ul class="small text-muted pl-4 mb-0">
                  <li>
                    Minimum 8 character
                  </li>
                  <li>
                    At least one special character
                  </li>
                  <li>
                    At least one number
                  </li>
                  <li>
                  Can’t be the same as a previous password
                  </li>
                </ul>

              </div>
            </div>

          </div>
          <div class="col-12 col-md-6">

            <!-- Password -->
            <div class="form-group">

              <!-- Label -->
              <label>
                Password
              </label>

              <!-- Input -->
              @if($errors->has('password-current') && strlen($errors->first('password-current')) > 0)
            <input type="password" placeholder="Enter your current password" name="password-current" class="form-control is-invalid" />
              <div class="invalid-feedback">
                {{$errors->first('password-current')}}
              </div>
              @else
              <input type="password" placeholder="Enter your current password" name="password-current" class="form-control" />
              @endif

            </div>

            <!-- New password -->
            <div class="form-group">

              <!-- Label -->
              <label>
                New password
              </label>

              <!-- Input -->
              @if($errors->has('password-new') && strlen($errors->first('password-new')) > 0)
              <input type="password" placeholder="Enter a new password" name="password-new" class="form-control is-invalid" />
              <div class="invalid-feedback">
                {{$errors->first('password-new')}}
              </div>
              @else
              <input type="password" placeholder="Enter a new password" name="password-new" class="form-control" />
              @endif
            </div>

            <!-- Confirm new password -->
            <div class="form-group">

              <!-- Label -->
              <label>
                Confirm new password
              </label>

              <!-- Input -->
              @if($errors->has('password-new-confirm') && strlen($errors->first('password-new-confirm')) > 0)
              <input type="password" placeholder="Confirm your new password" name="password-new-confirm" class="form-control is-invalid" />
              <div class="invalid-feedback">
                {{$errors->first('password-new-confirm')}}
              </div>
              @else
              <input type="password" placeholder="Confirm your new password" name="password-new-confirm" class="form-control" />
              @endif
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary">
              Update password
            </button>
            
          </div>
        </div> <!-- / .row -->

      </form>

    </div>
  </div> <!-- / .row -->
</div>

<script type="text/javascript">
  setTimeout(function(){ document.getElementById("successAlert").style.display = "none" }, 3000);
</script>

@endsection

@section ('footer')
@endsection