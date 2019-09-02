@extends ('layouts.main')

@section ('content')

<form method="POST" action="/company-applications/update-status" type="hidden">
  @csrf
  <input type="hidden" name="status" id="status"/>
  <input type="hidden" name="company_application_id" value="{{$companyApplication->id}}" />
  <button type="submit" style="display: none;" id="updateCompanyApplicationStatus">Submit</button>
</form>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8">
      
      <!-- Header -->
      <div class="header mt-md-5">
        <div class="header-body">

          <h6 class="header-pretitle">
            Company Application
          </h6>

          <!-- Title -->
          <a href="/profile/{{$companyApplication->user->id}}"><h1 class="header-title">
            {{$companyApplication->user->name}}
          </h1></a>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <strong>Description:</strong> 
          <p>{{$companyApplication->description}}</p>
          <strong>Company:</strong> 
          <p>{{$companyApplication->company->title}}</p>
        </div>
      </div>

      <button class="btn btn-light" role="button" onclick="rejectApplication()">
          Reject Application
      </button>
      <button class="btn btn-primary" role="button" onclick="approveApplication()">
          Approve Application
      </button>

    </div>
  </div> <!-- / .row -->
</div>

<script type="text/javascript">
  function rejectApplication() {
    document.getElementById("status").value = "rejected";
    document.getElementById("updateCompanyApplicationStatus").click();
  }

  function approveApplication() {
    document.getElementById("status").value = "approved";
    document.getElementById("updateCompanyApplicationStatus").click();
  }
</script>

@endsection

@section ('footer')

@endsection