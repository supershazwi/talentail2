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
            Credits
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
          <div class="row align-items-center">
            <div class="col">

              <!-- Title -->
              <h6 class="card-title text-uppercase text-muted mb-2">
                Total Credits
              </h6>
              
              <!-- Heading -->
              <span class="h2 mb-0">
                {{Auth::user()->credits}}
              </span>

            </div>
            <div class="col-auto">
              
              <!-- Icon -->
              <span class="h2 fe fe-dollar-sign text-muted mb-0"></span>

            </div>
          </div> <!-- / .row -->

        </div>
      </div>
      <a href="/credits/add" class="btn btn-primary">Add Credits</a>
    </div>
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col">

              <!-- Title -->
              <h6 class="card-title text-uppercase text-muted mb-2">
                Credits Awarded from Referrals
              </h6>
              
              <!-- Heading -->
              <span class="h2 mb-0">
                0
              </span>

            </div>
            <div class="col-auto">
              
              <!-- Icon -->
              <span class="h2 fe fe-user-plus text-muted mb-0"></span>

            </div>
          </div> <!-- / .row -->

        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section ('footer')
    
    

@endsection