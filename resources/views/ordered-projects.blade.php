@extends ('layouts.main')

@section ('content')
<div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-lg-12">
            
            <!-- Header -->
            <div class="header mt-md-5">
              <div class="header-body">

                <h6 class="header-pretitle">
                  Overview
                </h6>
                <!-- Title -->
                <h1 class="header-title">
                  Projects Purchased by Customers
                </h1>

              </div>
            </div>

            <!-- Card -->
            @if(sizeof($orderedProjects) == 0)
            <div class="card">
              <div class="card-body">
                <div class="row justify-content-center" style="margin-top:1rem;">
                  <div class="col-12 col-md-5 col-xl-4 my-5">
                    <p class="text-center mb-5" style="font-size: 2rem; margin-bottom: 0.25rem !important; -webkit-transform: scaleX(-1); transform: scaleX(-1);">😐</p>
                    <h2 class="text-center mb-3" style="margin-bottom: 2.25rem !important;">Once customers purchase your projects, the records will appear here.
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
                      <th scope="col">Project</th>
                      <th scope="col">Profits Earned</th>
                      <th scope="col">User</th>
                      <th scope="col">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($orderedProjects as $key=>$orderedProject)
                      <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td><a href="/roles/{{$orderedProject->project->role->slug}}/projects/{{$orderedProject->project->slug}}/{{$orderedProject->user_id}}">{{$orderedProject->project->title}}</a></td>
                        <td>${{$orderedProject->project->amount}} * 0.8 = <strong style="text-decoration: underline;">${{number_format((0.8*$orderedProject->project->amount), 2, '.', '')}}</strong></td>
                        <td>{{$orderedProject->user->name}}</td>
                        @if($orderedProject->status == "Attempting")
                        <td><span class="badge badge-light">{{$orderedProject->status}}</span></td>
                        @elseif($orderedProject->status == "Completed")
                        <td><span class="badge badge-info">{{$orderedProject->status}}</span></td>
                        @elseif($orderedProject->status == "Assessed")
                        <td><span class="badge badge-primary">{{$orderedProject->status}}</span></td>
                        @elseif($orderedProject->status == "Reviewed")
                        <td><span class="badge badge-success">{{$orderedProject->status}}</span></td>
                        @endif
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