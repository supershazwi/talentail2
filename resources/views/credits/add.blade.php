@extends ('layouts.main')

@section ('content')

<form id="projectForm" method="POST" action="/credits/add-credits-to-cart">
  @csrf
  <input type="hidden" name="type" value="" id="creditType" />
  <button type="submit" style="display: none;" id="purchaseCreditsButton">Submit</button>
</form>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8">
      
      <!-- Header -->
      <div class="header mt-md-5">
        @if (session('success'))
        <div class="alert alert-success" role="alert" id="successAlert" style="text-align: center;">
          <h4 class="alert-heading" style="margin-bottom: 0;">Credits added to cart!</h4>
        </div>
        @endif
        <div class="header-body">

          <h6 class="header-pretitle">
            Credits
          </h6>
          <!-- Title -->
          <h1 class="header-title">
            Add Credits
          </h1>

        </div>
      </div>

      <!-- Card -->
    </div>
  </div> <!-- / .row -->
  <div class="row justify-content-center">
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          
          <!-- Title -->
          <h6 class="text-uppercase text-center text-muted my-4">
            Basic 
          </h6>
          
          <!-- Price -->
          <div class="row no-gutters align-items-center justify-content-center">
            <div class="col-auto">
              <div class="h2 mb-0">$</div>
            </div>
            <div class="col-auto">
              <div class="display-2 mb-0">25</div>
            </div>
          </div> <!-- / .row -->
          
          <br/>

          <div class="mb-3">
            <ul class="list-group list-group-flush">
              <li class="list-group-item d-flex align-items-center justify-content-between px-0">
                <small>25 credits @ $1.0/credit</small> <i class="fe fe-check-circle text-success"></i>
              </li>
              <li class="list-group-item d-flex align-items-center justify-content-between px-0">
                <small>Highlight profile</small> <i class="fe fe-check-circle text-success"></i>
              </li>
            </ul>
          </div>

          
          <!-- Button -->
          <a href="#!" class="btn btn-block btn-light" onclick="addBasicCreditsToCart()">
            Add to Cart
          </a>

        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          
          <!-- Title -->
          <h6 class="text-uppercase text-center text-muted my-4" style="margin-bottom: 0.5rem !important;">
            Intermediate
          </h6>
          <div style="width: 100%; text-align: center; margin-bottom: 1.5rem !important;">
          <span class="badge badge-warning" style="text-align: center;">Most Popular</span>
          </div>
          <!-- Price -->
          <div class="row no-gutters align-items-center justify-content-center">
            <div class="col-auto">
              <div class="h2 mb-0">$</div>
            </div>
            <div class="col-auto">
              <div class="display-2 mb-0">100</div>
            </div>
          </div> <!-- / .row -->
          
          <br/>

          <div class="mb-3">
            <ul class="list-group list-group-flush">
              <li class="list-group-item d-flex align-items-center justify-content-between px-0">
                <small>111 credits @ $0.9/credit</small> <i class="fe fe-check-circle text-success"></i>
              </li>
              <li class="list-group-item d-flex align-items-center justify-content-between px-0">
                <small>Highlight profile</small> <i class="fe fe-check-circle text-success"></i>
              </li>
              <li class="list-group-item d-flex align-items-center justify-content-between px-0">
                <small>Attempt at least 1 project</small> <i class="fe fe-check-circle text-success"></i>
              </li>
            </ul>
          </div>
          

          <!-- Button -->
          <a href="#!" class="btn btn-block btn-primary" onclick="addIntermediateCreditsToCart()">
            Add to Cart
          </a>

        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          
          <!-- Title -->
          <h6 class="text-uppercase text-center text-muted my-4">
            Expert
          </h6>
          
          <!-- Price -->
          <div class="row no-gutters align-items-center justify-content-center">
            <div class="col-auto">
              <div class="h2 mb-0">$</div>
            </div>
            <div class="col-auto">
              <div class="display-2 mb-0">500</div>
            </div>
          </div> <!-- / .row -->
          
          
          <br/>

          <div class="mb-3">
            <ul class="list-group list-group-flush">
              <li class="list-group-item d-flex align-items-center justify-content-between px-0">
                <small>625 credits @ $0.8/credit</small> <i class="fe fe-check-circle text-success"></i>
              </li>
              <li class="list-group-item d-flex align-items-center justify-content-between px-0">
                <small>Highlight profile</small> <i class="fe fe-check-circle text-success"></i>
              </li>
              <li class="list-group-item d-flex align-items-center justify-content-between px-0">
                <small>Attempt at least 6 projects</small> <i class="fe fe-check-circle text-success"></i>
              </li>
            </ul>
          </div>
          

          <!-- Button -->
          <a href="#!" class="btn btn-block btn-light" onclick="addExpertCreditsToCart()">
            Add to Cart
          </a>

        </div>
      </div>
    </div>
  </div>
  <hr/>
  <div class="row justify-content-center" style="margin-top: 5rem; display: block; text-align: center;">
    <h1 class="display-4 mb-3">
        Refer your friend and gain credits
      </h1>
    <a href="/referrals" class="btn btn-lg btn-primary mb-3">
        Refer a friend
    </a>
  </div>
</div>

<script type="text/javascript">
  function addBasicCreditsToCart() {
    document.getElementById("creditType").value = "basic";
    document.getElementById("purchaseCreditsButton").click();
  } 

  function addIntermediateCreditsToCart() {
    document.getElementById("creditType").value = "intermediate";
    document.getElementById("purchaseCreditsButton").click();
  } 

  function addExpertCreditsToCart() {
    document.getElementById("creditType").value = "expert";
    document.getElementById("purchaseCreditsButton").click();
  }  

  setTimeout(function(){ document.getElementById("successAlert").style.display = "none" }, 3000);
</script>
@endsection

@section ('footer')
    
    

@endsection