@extends ('layouts.main')

@section ('content')
<div class="container">
	<div class="row" style="margin-top: 5rem;">
	  <div class="col-12 col-md-6 offset-xl-2 offset-md-1 order-md-2 mb-5 mb-md-0">
	    <div class="text-center">
	      <img src="/img/illustrations/scale.svg" alt="..." class="img-fluid">
	    </div>
	  </div>
	  <div class="col-12 col-md-5 col-xl-4 order-md-1 my-5">
	    <h1 class="display-4 mb-3">
	      <a href="/discover" style="border-bottom: 5px solid #0984e3;">Browse</a> Projects
	    </h1>
	    <h1 style="color: #777d7f;">What better way to secure an interview and job offer than to prove your mettle by attempting projects.</h1>
	  </div>
	</div>
	<!-- <hr style="margin-top: 5rem;"/> -->
	<div class="row justify-content-center">
	  <div class="col-12 col-lg-12">
	    
	    <!-- Header -->
	    <div class="header mt-md-5">
	      <div class="header-body">
	        <div class="row align-items-center">
	          <div class="col">
	            
	            <!-- Pretitle -->
	            <h6 class="header-pretitle">
	              Overview
	            </h6>

	            <!-- Title -->
	            <h1 class="header-title">
	              Projects
	            </h1>

	          </div>
	        </div> <!-- / .row -->
	        <div class="row align-items-center">
	          <div class="col">
	            
	            <!-- Nav -->
	            <ul class="nav nav-tabs nav-overflow header-tabs">
	              <li class="nav-item">
	                <a href="/discover" class="nav-link active">
	                  Business Analyst
	                </a>
	              </li>
	              <!-- <li class="nav-item">
	                <a href="/attempt/others" class="nav-link">
	                  Others
	                </a>
	              </li> -->
	            </ul>

	          </div>
	        </div>
	      </div>
	    </div>
	  </div>
	</div> <!-- / .row -->

	<div class="row">
		@foreach($projects as $project)
		@if($project->published)
		<div class="col-12 col-md-6 col-xl-4">
		  <div class="card">
		    <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}">

	        @if($project->url)
	        <img src="https://storage.googleapis.com/talentail-123456789/{{$project->url}}" alt="..." class="card-img-top">
	        @else
	        <img src="https://images.unsplash.com/photo-1482440308425-276ad0f28b19?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=95f938199a2d20d027c2e16195089412&auto=format&fit=crop&w=1050&q=80" alt="..." class="card-img-top">
	        @endif

		    </a>
		    <div class="card-body">
		      <div class="row align-items-center">
		        <div class="col">

		          <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}"><h2 class="card-title mb-2 name">{{$project->title}}</h2></a>
		          <span class="badge badge-warning">{{$project->industry->title}}</span>

		          <p style="margin-top: 0.75rem; margin-bottom: 0;">
		            {{$project->description}}
		          </p>

		        </div>
		      </div> <!-- / .row -->

		    </div> <!-- / .card-body -->
		  </div>
		</div>
		@endif
		@endforeach
	</div>
	<div class="row">
		<div class="col-lg-12" style="justify-content: center;">
			{{ $projects->links() }}
		</div>
	</div>
</div>
<!-- Start of HubSpot Embed Code -->
  <!-- Start of Async Drift Code -->
<!-- End of Async Drift Code -->
<!-- End of HubSpot Embed Code --> 
@endsection

@section ('footer')    
@endsection