@extends ('layouts.main')

@section ('content')

<form method="POST" action="/connect-paypal" id="connectPaypal">
  @csrf
  <input type="hidden" name="paypal_email" id="paypalEmailHidden" />
  <button type="submit" style="display: none;" id="connectPaypalButton">Submit</button>
</form>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8">
      
      <!-- Header -->
      <div class="header mt-md-5">
        @if (session('paypal-success'))
        <div class="alert alert-success" role="alert" id="successAlert" style="text-align: center;">
          <h4 class="alert-heading" style="margin-bottom: 0;">{{session('paypal-success')}}</h4>
        </div>
        @endif
        @if (session('success'))
        <div class="alert alert-success" role="alert" id="successAlert" style="text-align: center;">
          <h4 class="alert-heading" style="margin-bottom: 0;">Your application has been submitted. We will get back to you shortly.</h4>
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
                Apply to be a Creator
              </h1>

            </div>
          </div> <!-- / .row -->
          <div class="row align-items-center">
            <div class="col">
              
              <!-- Nav -->
              <ul class="nav nav-tabs nav-overflow header-tabs">
                <li class="nav-item">
                  @if($parameter == 'general')
                  <a href="/creator-application" class="nav-link active">
                  @else
                  <a href="/creator-application" class="nav-link">
                  @endif
                    Part 1: General Information
                    @if($creatorApplication == null || $creatorApplication->status == "pending")
                      <sup>Pending Review</sup>
                    @elseif($creatorApplication->status == "approved1")
                      <sup>Approved</sup>
                    @elseif($creatorApplication->status == "connected")
                      <sup>Approved</sup>
                    @endif
                  </a>
                </li>
                <li class="nav-item">
                  @if($parameter == 'stripe')
                  <a href="/creator-stripe-account" class="nav-link active">
                  @else
                  <a href="/creator-stripe-account" class="nav-link">
                  @endif
                    Part 2: Connect Paypal Account
                    @if($creatorApplication == null || $creatorApplication->status == "approved1")
                      <sup>Pending Connection</sup>
                    @elseif($creatorApplication->status == "connected")
                      <sup>Connected</sup>
                    @endif
                  </a>
                </li>
              </ul>

            </div>
          </div>
        </div>
      </div>

      <p>Creators are given the responsibility of creating gateways for applicants to their dream careers. Creators are encouraged to model projects based upon their real world experiences without compromising confidential information.</p>
      <p>We place high importance on the quality of projects that are available on the platform. This ensures that applicants get the value from the dollars and cents that they part with and that companies can rely on the projects as a pre-filtering mechanism of applicants without losing quality.</p>

      @if($parameter == 'general')
      <!-- Card -->
        @if($creatorApplication == null)
          <form method="POST" action="/projects/apply" enctype="multipart/form-data">
            @csrf
            <div class="card" style="margin-top: 1.5rem;">
              <div class="card-body">
                <div class="form-group">
                  <label class="mb-1">
                    Please provide a brief description of the projects that you would like to create
                  </label>
                  <textarea class="form-control" name="description" id="description" rows="5" placeholder="Enter description" style="margin-bottom: 0 !important;"></textarea>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                  <label class="mb-1">
                    Attach some of your work
                  </label>
                  <div class="box">
                    <input type="file" name="file-1[]" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple style="visibility: hidden; margin-bottom: 1.5rem;"/>
                    <label for="file-1" style="position: absolute; left: 0; margin-left: 1.5rem; margin-bottom: 1.5rem;  border-radius: 0.25rem !important; padding: 0.5rem 1rem 0.5rem 1rem; background: #2c7be5; color: white;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17" fill="white"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span style="font-size: 1rem;">Choose Files</span></label>
                  </div>
                  <div id="selectedFiles"></div>
                </div>
              </div>
            </div>

            <button class="btn btn-primary" role="button" type="submit">
                Submit Application
            </button>
          </form>
          @else 
          <div class="card">
            <div class="card-body">
              <strong>Description:</strong> 
              <p>{{$creatorApplication->description}}</p>
              <strong>Submitted Files:</strong> 
              @foreach($creatorApplication->creator_application_files as $file) 
                @if($loop->last)
                <p style="margin-bottom: 0;"><a href="#">{{$file->title}}</a></p>
                @else
                <p><a href="#">{{$file->title}}</a></p>
                @endif
              @endforeach
            </div>
          </div>
        @endif
      @else
        @if($creatorApplication == null || $creatorApplication->status == "pending")
        <div class="card">
          <div class="card-body">
            <div class="row justify-content-center" style="margin-top:1rem;">
              <div class="col-12 col-md-5 col-xl-4 my-5">
                <p class="text-center mb-5" style="font-size: 2rem; margin-bottom: 0.25rem !important; -webkit-transform: scaleX(-1); transform: scaleX(-1);">😬</p>
                <h2 class="text-center mb-3" style="margin-bottom: 2.25rem !important;"> Please be patient while we review your application from Part 1. Don't worry, it'll be ready in a jiffy.
                </h2>
              </div>
            </div>
          </div>
        </div>
        @elseif($creatorApplication->status == "approved1")
        <div class="row">
          <div class="col-lg-12">
            <div class="card" data-toggle="lists" data-lists-values='["name"]'>
              <div class="card-header">
                <div class="row align-items-center">
                  <div class="col">
                    
                    <!-- Title -->
                    <h4 class="card-header-title">
                      Connect an email that you would be using to login to Paypal to receive payments
                    </h4>

                  </div>
                </div> 
              </div>
              <div class="card-body">
                <ul class="list-group list-group-lg list-group-flush list my--4">
                  <li class="list-group-item px-0">
                    <div class="row align-items-center">
                      <div class="col-lg-8">
                        <h4 class="card-title mb-1 name">
                          <img src="/img/paypal.svg" style="width: 10rem;"/>
                        </h4>
                        <p class="card-text small text-muted mb-1" style="margin-top: 0.5rem;">
                          At Talentail, we use Paypal to process all our payments and handle payouts to our creators. You can use an existing PayPal account or provide a new one. You would be prompted to create a new PayPal account once we send you payments.
                        </p>
                      </div>
                      <div class="col-lg-4" style="text-align: right;">
                        <div id="change" style="display: none;">
                          <div class="form-group">
                            <div class="input-group">
                              <input type="text" name="email" class="form-control" id="paypalEmail" placeholder="Enter PayPal email" value="{{Auth::user()->email}}">
                              <div class="input-group-append" style="height: 40px;">
                                <button class="btn btn-sm btn-primary" onclick="savePaypalEmail()">Save</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div id="connect">
                          <span id="email">{{Auth::user()->email}}</span> <a href="#" onclick="editPaypalEmail()">edit</a>
                          <br/>
                          <a href="#" style="margin-top: 0.5rem;" onclick="submitPaypalConnect()">
                            Connect
                          </a>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
          </div>  
        </div>
        @elseif($creatorApplication->status == "connected")
        <div class="row">
          <div class="col-lg-12">
            <div class="card" data-toggle="lists" data-lists-values='["name"]'>
              <div class="card-header">
                <div class="row align-items-center">
                  <div class="col">
                    
                    <!-- Title -->
                    <h4 class="card-header-title">
                      Connect an email that you would be using to login to Paypal to receive payments
                    </h4>

                  </div>
                </div> 
              </div>
              <div class="card-body">
                <ul class="list-group list-group-lg list-group-flush list my--4">
                  <li class="list-group-item px-0">
                    <div class="row align-items-center">
                      <div class="col-lg-8">
                        <h4 class="card-title mb-1 name">
                          <img src="/img/paypal.svg" style="width: 10rem;"/>
                        </h4>
                        <p class="card-text small text-muted mb-1" style="margin-top: 0.5rem;">
                          At Talentail, we use Paypal to process all our payments and handle payouts to our creators. You can use an existing PayPal account or provide a new one. You would be prompted to create a new PayPal account once we send you payments.
                        </p>
                      </div>
                      <div class="col-lg-4" style="text-align: right;">
                        <div id="change" style="display: none;">
                          <div class="form-group">
                            <div class="input-group">
                              <input type="text" name="email" class="form-control" id="paypalEmail" placeholder="Enter PayPal email" value="{{Auth::user()->email}}">
                              <div class="input-group-append" style="height: 40px;">
                                <button class="btn btn-sm btn-primary" onclick="savePaypalEmail()">Save</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div id="connect">
                          <span id="email">{{Auth::user()->email}}</span>
                          <br/>
                          <button class="btn btn-link" style="margin-top: 0rem; padding: 0rem;" disabled>
                            Connected
                          </button>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
          </div>  
        </div>
        @endif
      @endif


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
    document.querySelector('#file-1').addEventListener('change', handleFileSelect, false);
    selDiv = document.querySelector("#selectedFiles");

  }
  
  function handleFileSelect(e) {
    if(!e.target.files) return;
    selDiv.innerHTML = "";
    
    var files = e.target.files;
    for(var i=0; i<files.length; i++) {
      var f = files[i];
      
      selDiv.innerHTML += f.name + "<br/>";
    }
  }

  function editPaypalEmail() {
    event.preventDefault();

    document.getElementById("connect").style.display = "none";
    document.getElementById("change").style.display = "block";
  }

  function savePaypalEmail() {
    event.preventDefault();

    document.getElementById("email").innerHTML = document.getElementById("paypalEmail").value;

    document.getElementById("connect").style.display = "block";
    document.getElementById("change").style.display = "none";
  }

  function submitPaypalConnect() {
    event.preventDefault();

    document.getElementById("paypalEmailHidden").value = document.getElementById("email").innerHTML;

    document.getElementById("connectPaypalButton").click();
  }

  setTimeout(function(){ document.getElementById("successAlert").style.display = "none" }, 3000);

</script>
@endsection

@section ('footer')

@endsection