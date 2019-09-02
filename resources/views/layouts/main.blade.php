<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="A platform for career newcomers or switchers to gain the necessary work experience by attempting real world projects.">

	<!-- Libs CSS -->
	<!-- build:css /fonts/feather/feather.min.css -->
	<link rel="stylesheet" href="/fonts/feather/feather.css">
	<!-- endbuild -->
	<link rel="stylesheet" href="/highlight.js/styles/vs2015.css">
	<link rel="stylesheet" href="/quill/dist/quill.core.css">
	<link rel="stylesheet" href="/select2/dist/css/select2.min.css">
	<link rel="stylesheet" href="/css/custom.css">
	<link rel="stylesheet" href="/flatpickr/dist/flatpickr.min.css">

	<link rel="stylesheet" type="text/css" href="/css/editormd.css" />

	<!-- Theme CSS -->
	<!-- build:css /css/theme.min.css -->
	<link rel="stylesheet" href="/css/theme.css" id="stylesheetLight">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	<!-- endbuild -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<meta name="csrf-token" content="{{ csrf_token() }}">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
	<script src="https://js.braintreegateway.com/web/dropin/1.8.1/js/dropin.min.js"></script>

  <meta name="google-site-verification" content="OJantCXfGuTlfFzI5XMc9vihxeFMsqGDhFqiON_qcws" />
  
	<script>var colorScheme = 'light';</script>
	<title>Talentail</title>

	<!-- Start of Async Drift Code -->
	
	<!-- End of Async Drift Code -->

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-122657233-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-122657233-1');
	</script>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-light" id="topnav">
    <div class="container">

      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Brand -->
      <a class="navbar-brand order-lg-first" href="/">
        <strong style="color: #0984e3; letter-spacing: 0.25rem;">TALENTAIL</strong>
      </a>

      
      <div class="navbar-user order-lg-last">
        @if(Auth::id())
          <div class="navbar-user">
            
            <div class="dropdown mr-4 d-none d-lg-flex">
          

              <span class="text-muted">
                {{Auth::user()->score}} Points
              </span>

            </div>

            <!-- Dropdown -->
            <div class="dropdown mr-4 d-none d-lg-flex">
          
              <!-- Toggle -->
              <a href="/notifications" class="text-muted" role="button">
                @if($notificationCount > 0)
                  <span class="icon active">
                    <i class="fe fe-bell"></i>
                  </span>
                @else
                  <span class="icon">
                    <i class="fe fe-bell"></i>
                  </span>
                @endif
              </a>

            </div>

            <!-- Dropdown -->
            <div class="dropdown">
          
              <!-- Toggle -->
              <a href="#" class="avatar avatar-sm dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @if(Auth::user()->avatar)
                   <img src="https://storage.googleapis.com/talentail-123456789/{{Auth::user()->avatar}}" alt="..." class="avatar-img rounded-circle">
                  @else
                  <img src="https://api.adorable.io/avatars/150/{{Auth::user()->email}}.png" alt="..." class="avatar-img rounded-circle border border-4 border-body">
                  @endif
              </a>

              <!-- Menu -->
              <div class="dropdown-menu dropdown-menu-right">
                <a href="/dashboard" class="dropdown-item">Dashboard</a>
                <a href="/profile" class="dropdown-item">Profile</a>
                <!-- <a href="/work-experience" class="dropdown-item">Work Experience</a> -->
                <!-- @if(Auth::user()->admin)
                <a href="/invoices" class="dropdown-item">Invoices</a>
                @endif -->
                <!-- <a href="/referrals" class="dropdown-item">Referrals</a> -->
                
                <!-- <a href="/lessons-overview" class="dropdown-item">Lessons</a> -->
                <!-- <a href="/projects-overview" class="dropdown-item">Projects</a> -->
                @if(!(Auth::user()->creator))
                <hr class="dropdown-divider">
                @endif
                @if(!Auth::user()->admin)
            <!-- @if(!Auth::user()->creator)
              @if(Auth::user()->creator_application != null && Auth::user()->creator_application->status == "pending")
                <a href="/creator-application-status" class="dropdown-item">Check Creator Application Status</a>
              @else
                <a href="/creator-application" class="dropdown-item">Apply to be a Creator</a>
              @endif
            @endif -->

            @if(!Auth::user()->company)
              @if(Auth::user()->company_application != null && Auth::user()->company_application->status == "pending")
                <a href="/company-application-status" class="dropdown-item">Check Company Application Status</a>
              @else
                <a href="/company-application" class="dropdown-item">Apply to be a Company</a>
              @endif
            @endif
                
                @endif

                <!-- @if(Auth::user()->creator)
                <hr class="dropdown-divider">
                  <a href="/creator-application" class="dropdown-item">Check Creator Application</a>
                @endif -->

                @if(Auth::user()->admin)
                <!-- <a href="/creator-application-overview" class="dropdown-item">View Creator Applications</a> -->
                <a href="/blog/admin" class="dropdown-item">Blog Admin</a> 
                <a href="/admin/companies" class="dropdown-item">Company Admin</a> 
                <!-- <a href="/company-application-overview" class="dropdown-item">View Company Applications</a> -->
                @endif
                <!-- <a href="/interviews-overview" class="dropdown-item">Interviews</a> -->
                <hr class="dropdown-divider">
                <a href="/settings" class="dropdown-item">Settings</a>
                <a href="/logout" class="dropdown-item">Logout</a>
              </div>

            </div>
          </div>
        @else
          <a class="btn btn-primary mr-auto" href="/login">
              Login
          </a>
        @endif
    </div>

      <!-- Collapse -->
      <div class="collapse navbar-collapse mr-auto" id="navbar">

        <!-- Navigation -->
        <ul class="navbar-nav mr-auto">
           <li class="nav-item">
              @if(!empty($parameter) && $parameter == "task")
                <a class="nav-link active" href="/tasks">
                  Practice
                </a>
              @else
                <a class="nav-link" href="/tasks">
                  Practice
                </a>
              @endif
          </li>

          <!-- <li class="nav-item">
              @if(!empty($parameter) && $parameter == "role")
                <a class="nav-link active" href="/roles">
                  Roles
                </a>
              @else
                <a class="nav-link" href="/roles">
                  Roles
                </a>
              @endif
          </li> -->

          <li class="nav-item">
              @if(!empty($parameter) && $parameter == "community")
                <a class="nav-link active" href="/communities">
                  Community
                </a>
              @else
                <a class="nav-link" href="/communities">
                  Community
                </a>
              @endif
          </li>

          <li class="nav-item">
              @if(!empty($parameter) && $parameter == "opportunity")
                <a class="nav-link active" href="/opportunities">
                  Opportunities
                </a>
              @else
                <a class="nav-link" href="/opportunities">
                  Opportunities
                </a>
              @endif
          </li>

          <li class="nav-item">
              @if(!empty($parameter) && $parameter == "forCompanies")
                <a class="nav-link active" href="/for-companies">
                  For Companies
                </a>
              @else
                <a class="nav-link" href="/for-companies">
                  For Companies
                </a>
              @endif
          </li>

          <!-- <li class="nav-item">
              @if(!empty($parameter) && $parameter == "enterprise")
                <a class="nav-link active" href="/enterprise">
                  Enterprise
                </a>
              @else
                <a class="nav-link" href="/enterprise">
                  Enterprise
                </a>
              @endif
          </li> -->
        </ul>
      </div>

    </div> <!-- / .container -->
  </nav>
	<!-- <div class="main-content bg-fixed-bottom" style="background-image: url(/img/illustrations/sticky.svg);"> -->
    <div class="main-content">
		@yield('content')
		<div class="container">
			<div class="row" style="margin-top: 5rem;">
			  <div class="col-12 col-lg-12">
			    
			    <!-- Card -->
			    <div class="card card-inactive">
			      <div class="card-body">
			          <div class="row">
			              <div class="col-lg-5">
			                  <h3>Talentail</h3>
			                  <p style="margin-bottom: 0; font-size: .875rem;">At Talentail, we believe that everyone should be given an equal opportunity to control their career paths and ultimately their happiness.</p>
			              </div>
			              <div class="col-lg-3">
			              		<!-- <a target="_blank" href="https://www.instagram.com/talentail/"><i class="fab fa-instagram"></i></a>
			              		<a target="_blank" href="https://fb.me/talentail" style="margin-left: 0.5rem;"><i class="fab fa-facebook"></i></a> -->
			                  <!-- <p class="" style="margin-top: .65rem; margin-bottom: 0; font-size: .875rem;">7 Temasek Boulevard</p> -->
			                  <p class="" style="margin-bottom: 0; font-size: .875rem;">7 Temasek Boulevard</p>
			                  <p class="" style="margin-bottom: 0; font-size: .875rem;">#12-07 Suntec Tower One</p>
			                  <p class="" style="margin-bottom: 0; font-size: .875rem;">Singapore 038987</p>
			              </div>
			              <div class="col-lg-2">
			                  <a href="/about-us" style="font-size: .875rem;">About Us</a><br />
			                  <a href="/contact-us" style="font-size: .875rem;">Contact Us</a><br />
			                  <a href="/faq" style="font-size: .875rem;">FAQ</a><br />
			                  <!-- <a href="/tutorials" style="font-size: .875rem;">Tutorials</a> -->
			              </div>
			              <div class="col-lg-2">
			                  <!-- <a href="/tutorials" style="font-size: .875rem;">Tutorials</a><br /> -->
			                  <!-- <a href="/blog" style="font-size: .875rem;">Blog</a><br /> -->
			                  <a href="/terms-and-conditions" style="font-size: .875rem;">Terms & Conditions</a><br />
			                  <a href="/privacy-policy" style="font-size: .875rem;">Privacy Policy</a><br />
			              </div>
			          </div>
			      </div>
			    </div>

			  </div>
			</div>
		</div>
	</div> <!-- / .main-content -->
	@include('scripts.javascript')
</body>
</html>