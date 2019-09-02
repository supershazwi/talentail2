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
  <title>Talentail | Forgot password</title>
  <body class="d-flex align-items-center bg-auth">

    <!-- CONTENT
    ================================================== -->
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-md-5 col-xl-4 my-5">
          
          @if (session('status'))
          <div class="alert alert-primary" role="alert" style="text-align: center;">
            <h4 class="alert-heading" style="margin-bottom: 0;">{{session('status')}}</h4>
          </div>
          @endif

          @if (session('sent'))
          <div class="alert alert-primary" role="alert" style="text-align: center;">
            <h4 class="alert-heading" style="margin-bottom: 0;">{{session('sent')}}</h4>
          </div>
          @endif

          @if (session('error'))
          <div class="alert alert-warning" role="alert" style="text-align: center;">
            <h4 class="alert-heading" style="margin-bottom: 0;">{{session('error')}}</h4>
          </div>
          @endif
          <!-- Subheading -->
          <p class="text-center mb-5" style="font-size: 2rem; margin-bottom: 0.25rem !important;">
            😬
          </p>

          <!-- Heading -->
          <h1 class="display-4 text-center mb-3" style="margin-bottom: 2.25rem !important;">
            Let's get you back on the road.
          </h1>
          
          
          <!-- Form -->
          <form method="POST" action="/password/send-email" aria-label="{{ __('Reset Password') }}">
            @csrf

            <!-- Email address -->
            <div class="form-group">

              <!-- Label -->
              <label>Email Address</label>

              <!-- Input -->
              <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Name@address.com" required autofocus>

              @if ($errors->has('email'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('email') }}</strong>
                  </span>
              @endif

            </div>

            <!-- Submit -->
            <button class="btn btn-lg btn-block btn-primary mb-3" type="submit">
              Send password reset link
            </button>
            
          </form>

        </div>
      </div> <!-- / .row -->
    </div> <!-- / .container -->

    <!-- JAVASCRIPT
    ================================================== -->
    @include('scripts.javascript')

  </body>
</html>