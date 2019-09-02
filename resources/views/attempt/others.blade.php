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
	      Step 2: <a href="/attempt" style="border-bottom: 5px solid #0984e3;">Attempt</a>
	    </h1>
	    <h1 style="color: #777d7f;">In today's day and age, learning is never enough. Attempt projects to apply the knowledge you have learned and show what you're made of.</h1>
	  </div>
	</div>
	<hr style="margin-top: 5rem;"/>
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
	                <a href="/attempt" class="nav-link">
	                  Business Analyst
	                </a>
	              </li>
	              <li class="nav-item">
	                <a href="/attempt/others" class="nav-link active">
	                  Others
	                </a>
	              </li>
	            </ul>

	          </div>
	        </div>
	      </div>
	    </div>
	  </div>
	</div> <!-- / .row -->

	<div class="row">
		@foreach($role->projects as $project)
		<div class="col-12 col-md-6 col-xl-4">
		  <div class="card">
		    <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}">
		      <img src="/img/avatars/projects/project-1.jpg" alt="..." class="card-img-top">
		    </a>
		    <div class="card-body">
		      <div class="row align-items-center">
		        <div class="col">
		      
		          <!-- Title -->
		          
		          <a href="/roles/{{$project->role->slug}}/projects/{{$project->slug}}"><h4 class="card-title mb-2 name">{{$project->title}}</h4></a>
		          

		          <!-- Subtitle -->
		          <p style="margin-top: 1.25rem;">
		            {{$project->description}}
		          </p>

		        </div>
		      </div> <!-- / .row -->

		      <!-- Divider -->
		      <hr>

		      <div class="row align-items-center">
		        <div class="col">
		          
		          <!-- Time -->
		          <p class="card-text small text-muted">
		            {{$project->created_at->diffForHumans()}}
		          </p>

		        </div>
		        <div class="col-auto">
		          
		          <!-- Avatar group -->
		          <div class="avatar-group">
		            <a href="profile-posts.html" class="avatar avatar-xs" data-toggle="tooltip" title="" data-original-title="Ab Hadley">
		              <img src="/img/avatars/profiles/avatar-2.jpg" alt="..." class="avatar-img rounded-circle">
		            </a>
		            <a href="profile-posts.html" class="avatar avatar-xs" data-toggle="tooltip" title="" data-original-title="Adolfo Hess">
		              <img src="/img/avatars/profiles/avatar-3.jpg" alt="..." class="avatar-img rounded-circle">
		            </a>
		            <a href="profile-posts.html" class="avatar avatar-xs" data-toggle="tooltip" title="" data-original-title="Daniela Dewitt">
		              <img src="/img/avatars/profiles/avatar-4.jpg" alt="..." class="avatar-img rounded-circle">
		            </a>
		            <a href="profile-posts.html" class="avatar avatar-xs" data-toggle="tooltip" title="" data-original-title="Miyah Myles">
		              <img src="/img/avatars/profiles/avatar-5.jpg" alt="..." class="avatar-img rounded-circle">
		            </a>
		          </div>

		        </div>
		      </div> <!-- / .row -->
		    </div> <!-- / .card-body -->
		  </div>
		</div>
		@endforeach
	</div>
</div>
@endsection

@section ('footer')    
@endsection