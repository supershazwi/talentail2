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
            Well this didn't age well!
          </h1>
          
          <p class="text-center">I've decided to put a stop on pursuing Talentail as I have not managed to turn this into a self-sustaining creature.</p>
          
          <p class="text-center">You can find me on <a href="https://www.linkedin.com/in/shazwi/">LinkedIn</a> & <a href="https://twitter.com/supershazwi">Twitter</a>.</p>

          <!-- Form -->
          

        </div>
      </div> <!-- / .row -->
    </div> <!-- / .container -->

    <!-- JAVASCRIPT
    ================================================== -->
    @include('scripts.javascript')

  </body>
</html>