@extends ('layouts.main')

@section ('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8">
      
      <!-- Header -->
      <div class="header mt-md-5">
        <div class="header-body">
          <div class="row align-items-center">
            <div class="col">
              
              <!-- Pretitle -->
              <h6 class="header-pretitle">
                Detail
              </h6>

              <!-- Title -->
              <h1 class="header-title">
                Shopping Cart {{$shoppingCart->id}}
              </h1>

            </div>
          </div> <!-- / .row -->
        </div>
      </div>

      <!-- Content -->
      <div class="card card-body p-5">
        <div class="row">
          <div class="col text-right">

            <!-- Badge -->
            <div class="badge badge-primary">
              {{$shoppingCart->status}}
            </div>

          </div>
        </div> <!-- / .row -->
        <div class="row">
        </div> <!-- / .row -->
        <div class="row">
          <div class="col-12">
            
            <!-- Table -->
            <div class="table-responsive">
              <table class="table my-4" style="margin-bottom: 0rem !important;">
                <thead>
                  <tr>
                    <th class="px-0 bg-transparent border-top-0">
                      <span class="h6">Item</span>
                    </th>
                    <th class="px-0 bg-transparent border-top-0 text-right">
                      <span class="h6">Price</span>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($shoppingCart->shopping_cart_line_items as $shoppingCartLineItem)
                    @if($shoppingCartLineItem->project_id)
                    <tr>
                      <td class="px-0">
                        <a href="/roles/{{$shoppingCartLineItem->project->role->slug}}/projects/{{$shoppingCartLineItem->project->slug}}">{{$shoppingCartLineItem->project->title}}</a>
                      </td>
                      <td class="px-0 text-right">
                        ${{$shoppingCartLineItem->project->amount}}
                      </td>
                    </tr>
                    @endif
                  @endforeach
                  <tr>
                    <td style="border-top: 0px;" class="px-0">
                     <strong>Total amount paid</strong>
                    </td>
                    <td colspan="2" class="px-0 text-right" style="border-top: 0px;">
                      <span class="h3">
                        ${{$shoppingCart->total}}
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <hr class="my-5">
            
            <!-- Title -->
            <h6 class="text-uppercase">
              Notes
            </h6>

            <!-- Text -->
            <p class="text-muted mb-0">
              Thank you for taking a shot at the projects on Talentail. We are here to help you get to your destination quicker without compromising on quality. We would be glad to help you at every step of this journey.
            </p>

          </div>
        </div> <!-- / .row -->
      </div>

    </div>
  </div> <!-- / .row -->
</div>
@endsection

@section ('footer')
    
    

@endsection