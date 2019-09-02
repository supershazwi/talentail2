<!doctype html>
<html lang="en">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">

  <!-- Libs CSS -->
  <!-- build:css /fonts/feather/feather.min.css -->
  <link rel="stylesheet" href="/fonts/feather/feather.css">
  <!-- endbuild -->
  <link rel="stylesheet" href="/highlight.js/styles/vs2015.css">
  <link rel="stylesheet" href="/quill/dist/quill.core.css">
  <link rel="stylesheet" href="/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="/flatpickr/dist/flatpickr.min.css">

  <!-- Theme CSS -->
  <!-- build:css /css/theme.min.css -->
  <link rel="stylesheet" href="/css/theme.css" id="stylesheetLight">
  <!-- endbuild -->

  <script>var colorScheme = 'light';</script>
  <title>Talentail | Register</title>
  <body class="d-flex align-items-center bg-auth">

    <!-- CONTENT
    ================================================== -->
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-md-5 col-xl-4 my-5">
          <!-- Subheading -->
          <p class="text-center mb-5" style="font-size: 2rem; margin-bottom: 0.25rem !important;">
            🚙
          </p>

          <!-- Heading -->
          <h1 class="display-4 text-center mb-3" style="margin-bottom: 2.25rem !important;">
            Begin your journey. 
          </h1>
          
          
          <!-- Form -->
          <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
            @csrf
            <input type="hidden" name="referral-link" value="{{Session::get('referral-link')}}" />
            <!-- Name -->
            <div class="form-group">
                <label>Name</label>

                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="Name" required autofocus>

                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>

            <!-- Email address -->
            <div class="form-group">
              <!-- Label -->
              <label>Email Address</label>

              <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Name@address.com" required autofocus>

              @if ($errors->has('email'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('email') }}</strong>
                  </span>
              @endif
            </div>

            <!-- Password -->
            <div class="form-group">

              <label>Password</label>

              <!-- Input group -->
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>

                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">

              <label>Confirm Password</label>

              <!-- Input group -->
               <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
            </div>

            <!-- Submit -->
            <button class="btn btn-lg btn-block btn-primary mb-3" type="submit">
              Register
            </button>

            <!-- Link -->
            <div class="text-center">
                <small class="text-muted text-center">
                  By clicking 'Create Account' you agree to our <a href="/terms-and-conditions">Terms of Service</a>.
                </small>
              <small class="text-muted text-center">
                Already have an account? <a href="/login">Login</a>.
              </small>
            </div>
            
          </form>

        </div>
      </div> <!-- / .row -->
    </div> <!-- / .container -->

    <!-- JAVASCRIPT
    ================================================== -->
    @include('scripts.javascript')

  </body>
</html>