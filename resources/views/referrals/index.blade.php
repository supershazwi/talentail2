@extends ('layouts.main')

@section ('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8">
      
      <!-- Header -->
      <div class="header mt-md-5">
        <div class="header-body">

          <h6 class="header-pretitle">
            Overview
          </h6>
          <!-- Title -->
          <h1 class="header-title">
            Referrals
          </h1>

        </div>
      </div>

      <!-- Card -->
      <div class="row" style="margin-bottom: 1.5rem;">
        <div class="col-lg-12">
          <div class="input-group input-group-lg mb-3">
            <input type="text" class="form-control referral-link" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{URL::to('/')}}/?r={{Auth::user()->referral_link}}" disabled id="link">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary js-linkcopybutton" type="button" id="button-addon2">Copy Link</button>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12 col-lg-6 col-xl">
          
          <!-- Card -->
          <div class="card">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col">

                  <!-- Title -->
                  <h6 class="card-title text-uppercase text-muted mb-2">
                    Step 1
                  </h6>
                  
                  <!-- Heading -->
                  <span class="h2 mb-0">
                    Send Referral Link & User Registers
                  </span>

                  <span class="badge badge-secondary mt--1">
                    Pending
                  </span>

                </div>
              </div> <!-- / .row -->

            </div>
          </div>
        </div>
        <div class="col-12 col-lg-6 col-xl">
          
          <!-- Card -->
          <div class="card">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col">

                  <!-- Title -->
                  <h6 class="card-title text-uppercase text-muted mb-2">
                    Step 2
                  </h6>
                  
                  <!-- Heading -->
                  <span class="h2 mb-0">
                    User Verifies Account
                  </span>

                  <span class="badge badge-secondary mt--1">
                    Registered
                  </span>

                </div>
              </div> <!-- / .row -->

            </div>
          </div>
        </div>
        <div class="col-12 col-lg-6 col-xl">
          <div class="card">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col">

                  <!-- Title -->
                  <h6 class="card-title text-uppercase text-muted mb-2">
                    Step 3
                  </h6>
                  
                  <!-- Heading -->
                  <span class="h2 mb-0">
                    User Purchases Project
                  </span>

                  <span class="badge badge-secondary mt--1">
                    Purchased
                  </span>

                </div>
              </div> <!-- / .row -->

            </div>
          </div>
        </div>

        <div class="col-12 col-lg-6 col-xl">
          <!-- Card -->
          <div class="card">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col">

                  <!-- Title -->
                  <h6 class="card-title text-uppercase text-muted mb-2">
                    Step 4
                  </h6>
                  
                  <!-- Heading -->
                  <span class="h2 mb-0">
                    You and Your Friend Receive $5 
                  </span>
                  <span class="icon" data-toggle="tooltip" data-placement="top" title="" data-original-title="Your friend has to purchase a project for both of you to receive this reward.">
                    <i class="fe fe-help-circle"></i>
                  </span>

                  <span class="badge badge-primary mt--1">
                    Successful
                  </span>

                </div>
              </div> <!-- / .row -->

            </div>
          </div>
        </div>

        @if(sizeof($referred) > 0)
          <div class="col-12 col-lg-6 col-xl">
            <div class="card">
              <table class="table table-nowrap" style="margin-bottom: 0rem;">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Member</th>
                    <th scope="col">Date Referred</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($referred as $refer)
                  <tr>
                    <td scope="col">{{$refer->id}}</td>
                    <td scope="col"><a href="/profile/{{$refer->referred->id}}">{{$refer->referred->name}}</a></td>
                    <td scope="col">{{$refer->created_at}}</td>
                    <td scope="col"><span class="badge badge-secondary mt--1">
                      {{$refer->status}}
                    </span></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        @endif
      </div>

      @if(sizeof($referred) == 0) 
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="row justify-content-center" style="margin-top:1rem;">
                  <div class="col-12 col-md-5 col-xl-4 my-5">
                    <p class="text-center mb-5" style="font-size: 2rem; margin-bottom: 0.25rem !important; -webkit-transform: scaleX(-1); transform: scaleX(-1);">😕</p>
                    <h1 class="display-4 text-center mb-3" style="margin-bottom: 2.25rem !important;"> You have not referred anyone.
                    </h1>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endif

    </div>
  </div> <!-- / .row -->
</div>

<script type="text/javascript">
    var copyLinkButton = document.querySelector('.js-linkcopybutton');  
    copyLinkButton.addEventListener('click', function(event) {  
      // Select the email link anchor text  
      var link = document.querySelector('.referral-link');  
      var range = document.createRange();  
      range.selectNode(link);  
      window.getSelection().addRange(range);  

      try {  
        // Now that we've selected the anchor text, execute the copy command  
        var successful = document.execCommand('copy');  
        var msg = successful ? 'successful' : 'unsuccessful';  

        if(msg == "successful") {
          document.getElementById("button-addon2").innerHTML = "Copied!";

          setTimeout(function(){ document.getElementById("button-addon2").innerHTML = "Copy Link" }, 1500);
        }

      } catch(err) {  

      }  

      // Remove the selections - NOTE: Should use
      // removeRange(range) when it is supported  
      window.getSelection().removeAllRanges();  
    });
</script>
@endsection

@section ('footer')
    
    

@endsection