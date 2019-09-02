@extends ('layouts.main')

@section ('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8">
      
      <!-- Header -->
      <div class="header mt-md-5">
        @if (session('success'))
        <div class="alert alert-success" role="alert" id="successAlert" style="text-align: center;">
          <h4 class="alert-heading" style="margin-bottom: 0;">{{session('success')}}</h4>
        </div>
        @endif

        <div class="header-body">

          <h6 class="header-pretitle">
            Company Application Status
          </h6>

          <!-- Title -->
          <h1 class="header-title">
            {{$companyApplication->user->name}}
          </h1>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <strong>Status:</strong>
          <p><span class="badge badge-warning">{{$companyApplication->status}}</span></p>
          <strong>Description:</strong> 
          <p>{{$companyApplication->description}}</p>
          <strong>Company:</strong>
          <p style="margin-bottom: 0;">{{$companyApplication->company->title}}</p>
        </div>
      </div>

    </div>
  </div> <!-- / .row -->
</div>

<script type="text/javascript">

  setTimeout(function(){ document.getElementById("successAlert").style.display = "none" }, 3000);

</script>

@endsection

@section ('footer')

@endsection