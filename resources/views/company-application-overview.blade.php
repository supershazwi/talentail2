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
            Company Applications
          </h1>
        </div>
      </div>

      <div class="card">
          <table class="table table-nowrap" style="margin-bottom: 0;">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">User</th>
                <th scope="col">Company</th>
                <th scope="col">Date</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($companyApplications as $key=>$companyApplication)
                <tr>
                  <th scope="row">{{$key+1}}</th>
                  <td><a href="/company-applications/{{$companyApplication->user_id}}">{{$companyApplication->user->name}}</a></td>
                  <td>{{$companyApplication->company->title}}</td>
                  <td>{{$companyApplication->created_at}}</td>
                  <td><span class="badge badge-primary">{{$companyApplication->status}}</span></td>
                </tr>
              @endforeach
            </tbody>
          </table>
      </div>

    </div>
  </div> <!-- / .row -->
</div>

@endsection

@section ('footer')

@endsection