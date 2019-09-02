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
  <title>Talentail | Log in</title>
  <body class="d-flex align-items-center bg-auth">

    <!-- CONTENT
    ================================================== -->
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-md-5 col-xl-4 my-5">
          
          @if (session('message'))
          <div class="alert alert-primary" role="alert" style="text-align: center;">
            <h4 class="alert-heading" style="margin-bottom: 0;">{{session('message')}}</h4>
          </div>
          @endif
          @if (session('passwordResetSuccess'))
          <div class="alert alert-primary" role="alert" style="text-align: center;">
            <h4 class="alert-heading" style="margin-bottom: 0;">Your password has been successfully updated.</h4>
          </div>
          @endif
          @if (session('status'))
              <div class="alert alert-primary" style="text-align: center;">
                  {{ session('status') }}
              </div>
          @endif
          @if (session('warning'))
              <div class="alert alert-warning" style="text-align: center;">
                  {{ session('warning') }}
              </div>
          @endif
          <!-- Subheading -->
          <p class="text-center mb-5" style="font-size: 2rem; margin-bottom: 0.25rem !important;">
            😄
          </p>

          <!-- Heading -->
          <h1 class="display-4 text-center mb-3" style="margin-bottom: 2.25rem !important;">
            Welcome back!
          </h1>
          
          
          <!-- Form -->
          <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
            @csrf

            <!-- Email address -->
            <div class="form-group">

              <!-- Label -->
              <label>Email Address</label>

              <!-- Input -->
              <input type="email" name="email" class="form-control" placeholder="Name@address.com" value="{{ old('email') }}" required>

              @if ($errors->has('email'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('email') }}</strong>
                  </span>
              @endif

            </div>

            <!-- Password -->
            <div class="form-group">

              <div class="row">
                <div class="col">
                      
                  <!-- Label -->
                  <label>Password</label>

                </div>
                <div class="col-auto">
                  
                  <!-- Help text -->
                  <a href="/password/reset" class="form-text small text-muted">
                    Forgot password?
                  </a>

                </div>
              </div> <!-- / .row -->

                <!-- Input -->
                <input type="password" name="password" class="form-control form-control-appended" placeholder="Enter your password" required>

                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <!-- Submit -->
            <button class="btn btn-lg btn-block btn-primary mb-3" type="submit">
              Log in
            </button>

            <!-- Link -->
            <div class="text-center">
              <small class="text-muted text-center">
                Don't have an account yet? <a href="/register">Register</a>.
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