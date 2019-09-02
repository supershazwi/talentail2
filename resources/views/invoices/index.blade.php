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
                  Invoices
                </h1>

              </div>
            </div>

            <!-- Card -->
            @if(sizeof($invoices) == 0)
            <div class="card">
              <div class="card-body">
                <div class="row justify-content-center" style="margin-top:1rem;">
                  <div class="col-12 col-md-5 col-xl-4 my-5">
                    <p class="text-center mb-5" style="font-size: 2rem; margin-bottom: 0.25rem !important; -webkit-transform: scaleX(-1); transform: scaleX(-1);">😐</p>
                    <h2 class="text-center mb-3" style="margin-bottom: 2.25rem !important;">Once customers purchase your projects, your invoices will appear here.
                    </h2>
                  </div>
                </div>
              </div>
            </div>
            @else
            <div class="card">
                <table class="table table-nowrap" style="margin-bottom: 0;">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Invoice</th>
                      <th scope="col">Total Value</th>
                      <th scope="col">Payout</th>
                      <th scope="col">Date</th>
                      <th scope="col">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($invoices as $key=>$invoice)
                      <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td><a href="/invoices/{{$invoice->id}}">{{$invoice->id}}</a></td>
                        <td>${{$invoice->total}}</td>
                        <td>${{number_format($invoice->total * 0.8, 2)}}</td>
                        <td>{{$invoice->created_at}}</td>
                        <td><span class="badge badge-primary">{{$invoice->status}}</span></td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
            @endif
          </div>
        </div> <!-- / .row -->
      </div>
@endsection

@section ('footer')
    
    

@endsection