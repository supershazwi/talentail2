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

  <script src="https://js.pusher.com/4.3/pusher.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>


  <script>var colorScheme = 'light';</script>
  <title>Talentail</title>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-122657233-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-122657233-1');
  </script>
</head>

<body style="height: 100% !important;">
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
          
              <!-- Toggle -->
              <a href="/messages" class="text-muted" role="button">
            @if($messageCount > 0)
              <span class="icon active">
                <i class="fe fe-message-square"></i>
              </span>
            @else
              <span class="icon">
                <i class="fe fe-message-square"></i>
              </span>
            @endif
              </a>

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

            <!-- <div class="dropdown mr-4 d-none d-lg-flex">

              <a href="/shopping-cart" class="text-muted" role="button">
            @if($shoppingCartActive)
              <span class="icon active">
                <i class="fe fe-shopping-cart"></i>
              </span>
            @else
              <span class="icon">
                <i class="fe fe-shopping-cart"></i>
              </span>
            @endif
              </a>

            </div> -->



            <!-- Dropdown -->
            <div class="dropdown">
          
              <!-- Toggle -->
              <a href="#" class="avatar avatar-sm dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @if(Auth::user()->avatar)
                   <img src="https://storage.googleapis.com/talentail-123456789/{{Auth::user()->avatar}}" alt="..." class="avatar-img rounded-circle">
                  @else
                  <img src="/img/avatar.png" alt="..." class="avatar-img rounded-circle">
                  @endif
              </a>

              <!-- Menu -->
              <div class="dropdown-menu dropdown-menu-right">
                <a href="/" class="dropdown-item">Dashboard</a>
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
           <!-- <li class="nav-item">
            @if(!empty($parameter) && $parameter == "opportunity")
              <a class="nav-link active" href="/opportunities">
                Opportunities
              </a>
            @else
              <a class="nav-link" href="/opportunities">
                Opportunities
              </a>
            @endif
          </li> -->
          <li class="nav-item">
        @if(!empty($parameter) && $parameter == "discover")
          <a class="nav-link active" href="/projects">
            Projects
          </a>
        @else
          <a class="nav-link" href="/projects">
            Projects
          </a>
        @endif
          </li>
          <!-- <li class="nav-item">
              @if(!empty($parameter) && $parameter == "company")
                <a class="nav-link active" href="/companies">
                  Companies
                </a>
              @else
                <a class="nav-link" href="/companies">
                  Companies
                </a>
              @endif
            </li> -->
        </ul>
      </div>

    </div> <!-- / .container -->
  </nav>
  <div class="main-content" style="height: 100% !important;">
    <div class="container" style="margin-top: 1.5rem; height: 100% !important;">
      <div class="row" style="height: 70% !important;">
        <div class="col-12 col-lg-12 col-xl-8" style="height: 70% important;">
          <div class="card" style="height: 100% !important;">
            <div class="card-body" style="height: 70% !important; overflow-y: scroll;" id="newMessagesDiv">
              <div class="chat-module-body" style="height: 70% !important;" id="chatMessagesDiv">
                @if($messages != null && request()->route()->parameters['userId'] != null)
                @foreach($messages as $message)
                  @if($message->recipient_id == Auth::id())
                  <div class="row">
                    <div class="col-lg-12">
                      <p class="text-muted small" style="display: inline-block; margin-bottom: 0;">
                        {{$message->created_at->diffForHumans()}}
                      </p>
                      <h4 style="float: right; display: inline-block; margin-bottom: 0;">
                        {{$message->user->name}}
                      </h4>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <p style="float: right;">
                        {{$message->message}}
                      </p>
                    </div>
                  </div>
                  @else
                  <div class="row">
                    <div class="col-lg-12">
                      <h4 style="display: inline-block; margin-bottom: 0;">
                        {{$message->user->name}}
                      </h4>
                      <p class="text-muted small" style="float: right; display: inline-block; margin-bottom: 0;">
                        {{$message->created_at->diffForHumans()}}
                      </p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <p>
                        {{$message->message}}
                      </p>
                    </div>
                  </div>
                  @endif
                @endforeach
                @else
                  <div class="row justify-content-center" style="margin-top:20%;">
                    <div class="col-12 col-md-5 col-xl-4 my-5">
                      <!-- Subheading -->
                      <p class="text-center mb-5" style="font-size: 2rem; margin-bottom: 0.25rem !important;">
                        👉
                      </p>

                      <!-- Heading -->
                      <h1 class="display-4 text-center mb-3" style="margin-bottom: 2.25rem !important;">
                        Select a user to chat with.
                      </h1>
                    </div>
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-12 col-xl-4">
            <div class="card" data-toggle="lists" data-lists-values="[&quot;name&quot;]">
                <div class="card-header">
                  <div class="row align-items-center">
                    <div class="col">
                        <ul class="nav nav-pills">
                          @if(Request::route('projectId'))
                            <li class="nav-item" style="width: 100%; text-align: center;" id="user" onclick="toggleButton(this.id)">
                              <a class="nav-link" href="#" id="a_user">By User</a>
                            </li>
                            <!-- <li class="nav-item" style="width: 50%; text-align: center;" id="project" onclick="toggleButton(this.id)">
                              <a class="nav-link active" href="#" id="a_project">By Project</a>
                            </li> -->
                          @else
                            <li class="nav-item" style="width: 100%; text-align: center;" id="user" onclick="toggleButton(this.id)">
                              <a class="nav-link active" href="#" id="a_user">By User</a>
                            </li>
                            <!-- <li class="nav-item" style="width: 50%; text-align: center;" id="project" onclick="toggleButton(this.id)">
                              <a class="nav-link" href="#" id="a_project">By Project</a>
                            </li> -->
                          @endif
                          </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body" style="padding-top: 1rem; padding-bottom: 1rem;">
                @if(Request::route('projectId'))
                <ul class="list-group list-group-flush list my--3" id="ul_project">
                    @foreach($userProjectObjectArray as $key=>$userProjectObject)
                    <li class="list-group-item px-0" style="border: 0px;">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <a href="/messages/{{$userProjectObject->user->id}}/projects/{{$userProjectObject->project->id}}" class="avatar">
                                    @if($userProjectObject->user->avatar)
                                    <img alt="{{$userProjectObject->user->name}}" src="https://storage.googleapis.com/talentail-123456789/{{$userProjectObject->user->avatar}}" class="avatar-img rounded-circle" />
                                    @else
                                    <img alt="Image" src="/img/avatar.png" class="avatar-img rounded-circle" />
                                    @endif
                                </a>
                            </div>
                            <div class="col ml--2">
                                <h4 class="mb-1 name">
                                    <a href="/messages/{{$userProjectObject->user->id}}/projects/{{$userProjectObject->project->id}}">{{$userProjectObject->user->name}}</a><br/>
                                    <p class="text-muted small" style="margin-bottom: 0;">{{$userProjectObject->project->title}}</p>
                                </h4>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <ul class="list-group list-group-flush list my--3" id="ul_user" style="display: none;">
                    @foreach($users as $key=>$user)
                    <li class="list-group-item px-0" style="border: 0px;">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <a href="/messages/{{$user->id}}" class="avatar">
                                    @if($user->avatar)
                                    <img alt="{{$user->name}}" src="https://storage.googleapis.com/talentail-123456789/{{$user->avatar}}" class="avatar-img rounded-circle" />
                                    @else
                                    <img alt="Image" src="/img/avatar.png" class="avatar-img rounded-circle" />
                                    @endif
                                </a>
                            </div>
                            <div class="col ml--2">
                                <h4 class="mb-1 name">
                                    <a href="/messages/{{$user->id}}">{{$user->name}}</a>
                                </h4>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                @else
                <ul class="list-group list-group-flush list my--3" id="ul_project" style="display: none;">
                    @foreach($userProjectObjectArray as $userProjectObject)
                    <li class="list-group-item px-0" style="border: 0px;">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <a href="/messages/{{$userProjectObject->user->id}}/projects/{{$userProjectObject->project->id}}" class="avatar">
                                    @if($userProjectObject->user->avatar)
                                    <img alt="{{$userProjectObject->user->name}}" src="https://storage.googleapis.com/talentail-123456789/{{$userProjectObject->user->avatar}}" class="avatar-img rounded-circle" />
                                    @else
                                    <img alt="Image" src="/img/avatar.png" class="avatar-img rounded-circle" />
                                    @endif
                                </a>
                            </div>
                            <div class="col ml--2">
                                <h4 class="mb-1 name">
                                    <a href="/messages/{{$userProjectObject->user->id}}/projects/{{$userProjectObject->project->id}}">{{$userProjectObject->user->name}}</a>
                                    <p class="text-muted small" style="margin-bottom: 0;">{{$userProjectObject->project->title}}</p>
                                </h4>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <ul class="list-group list-group-flush list my--3" id="ul_user">
                    @foreach($users as $user)
                    <li class="list-group-item px-0" style="border: 0px;">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <a href="/messages/{{$user->id}}" class="avatar">
                                    @if($user->avatar)
                                    <img alt="{{$user->name}}" src="https://storage.googleapis.com/talentail-123456789/{{$user->avatar}}" class="avatar-img rounded-circle" />
                                    @else
                                    <img alt="Image" src="/img/avatar.png" class="avatar-img rounded-circle" />
                                    @endif
                                </a>
                            </div>
                            <div class="col ml--2">
                                <h4 class="mb-1 name">
                                    <a href="/messages/{{$user->id}}">{{$user->name}}</a>
                                </h4>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                @endif
                </div>
            </div>
        </div>
      </div> <!-- / .row -->
      @if($messages != null && request()->route()->parameters['userId'] != null)
      <div class="row" style="height: 30% !important; margin-top: 1.5rem;">
        <div class="col-12 col-lg-8">
            <form class="chat-form">
                <textarea id="chat-input" class="form-control" placeholder="Type message" rows="3" onkeypress="keyPress()" style="resize: none;"></textarea>
                <p class="text-muted" style="float: right;">Press Enter to send</p>
                <input id="userId" type="hidden" value="{{Auth::user()->id}}" />
                <input id="userName" type="hidden" value="{{Auth::user()->name}}" />
                <input id="userAvatar" type="hidden" value="{{Auth::user()->avatar}}" />
                <input id="clickedUserId" type="hidden" value="{{$clickedUserId}}" />
                <input id="messageChannel" type="hidden" value="{{$messageChannel}}" />
                @if(Request::route('projectId'))
                    <input id="projectId" type="hidden" value="{{$clickedProject->id}}" />
                @endif
            </form>
        </div>
      </div>
      @endif
    </div>
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
                        <a href="/tutorials" style="font-size: .875rem;">Tutorials</a><br />
                        <a href="/blog" style="font-size: .875rem;">Blog</a><br />
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
  <input type="hidden" id="loggedInUserId" value="{{Auth::id()}}" />
  <input type="hidden" id="currentUrl" value="{{Request::path()}}" />

  <script type="text/javascript">
      document.getElementById("newMessagesDiv").scrollTop = document.getElementById("newMessagesDiv").scrollHeight;
      $.ajaxSetup({

          headers: {

              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

          }

      });

      function toggleButton(id) {
        if(id =="project") {
          let element = document.getElementById("a_project");
          let element2 = document.getElementById("a_user");

          element.className = "nav-link active";
          element2.className = "nav-link";

          document.getElementById("ul_user").style.display = "none";
          document.getElementById("ul_project").style.display = "block";
        } else {
          let element = document.getElementById("a_user");
          let element2 = document.getElementById("a_project");

          element.className = "nav-link active";
          element2.className = "nav-link";

          document.getElementById("ul_user").style.display = "block";
          document.getElementById("ul_project").style.display = "none";
        }

      }

      function keyPress() {
          var key = window.event.keyCode;

          if (key === 13) {
              var messageText = document.getElementById("chat-input").value;
              document.getElementById("chat-input").value = "";
              var data = {message_text: messageText, clickedUserId: document.getElementById("clickedUserId").value, messageChannel: document.getElementById("messageChannel").value};
              if(document.getElementById("projectId") != null) {
                  data.projectId = document.getElementById("projectId").value;
              }
              
              var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

              $.ajax({
                 type:'POST',
                 url:'/messages/'+document.getElementById("clickedUserId").value,
                 data: data,
                 success:function(data){

                 }
              });
          }
      }

      if(document.getElementById("clickedUserId") != null) {
          var pusher = new Pusher("5491665b0d0c9b23a516", {
            cluster: 'ap1',
            forceTLS: true,
            auth: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }
          });

          var channel = pusher.subscribe(document.getElementById("messageChannel").value);
          channel.bind('new-message', function(data) {
            document.getElementById("chat-input").value = "";
              document.getElementById("chatMessagesDiv").insertAdjacentHTML("beforeend", "<div class='row'><div class='col-lg-12'><h4 style='display: inline-block; margin-bottom: 0;'>" + data.username + "</h4><p class='text-muted' style='float: right; display: inline-block; margin-bottom: 0;'>Just now</p></div></div><div class='row'><div class='col-lg-12'><p>" + data.text + "</p></div></div>");
              
              document.getElementById("newMessagesDiv").scrollTop = document.getElementById("newMessagesDiv").scrollHeight;
              
          }); 
      }
  </script>

  <!-- <script type="text/javascript" src="/js/jquery.min.js"></script> -->
  <script type="text/javascript" src="/js/autosize.min.js"></script>
  <script type="text/javascript" src="/js/popper.min.js"></script>
  <script type="text/javascript" src="/js/prism.js"></script>
  <script type="text/javascript" src="/js/draggable.bundle.legacy.js"></script>
  <script type="text/javascript" src="/js/swap-animation.js"></script>
  <script type="text/javascript" src="/js/dropzone.min.js"></script>
  <script type="text/javascript" src="/js/list.min.js"></script>
  <script type="text/javascript" src="/js/bootstrap.js"></script>
  <script type="text/javascript" src="/js/theme.js"></script>
  <!-- <script type="text/javascript" src="/js/editormd.js"></script> -->
  <script type="text/javascript" src="/js/custom-file-input.js"></script>
  <script type="text/javascript" src="/js/toastr.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

  <script type="text/javascript">
      $(function () {
          toastr.options = {
              positionClass: 'toast-bottom-right'
          }; 

          var pusher = new Pusher("5491665b0d0c9b23a516", {
            cluster: 'ap1',
            forceTLS: true,
            auth: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }
          });

          var messageChannel = pusher.subscribe('messages_' + document.getElementById('loggedInUserId').value);
          messageChannel.bind('new-message', function(data) {
              toastr.options.onclick = function () {
                  window.location.replace(data.url);
              };

              if('/' + document.getElementById('currentUrl').value != data.url) {
                  toastr.info("<strong>" + data.username + "</strong><br />" + data.text); 
              }
          });

          var purchaseChannel = pusher.subscribe('purchases_' + document.getElementById('loggedInUserId').value);
          purchaseChannel.bind('new-purchase', function(data) {
              toastr.success(data.username + ' ' + data.message); 
          });
      })
  </script> 
</body>
</html>
