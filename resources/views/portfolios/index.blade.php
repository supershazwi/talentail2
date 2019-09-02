@extends ('layouts.main')

@section ('content')
<div class="container">
	<div class="row" style="margin-top: 5rem;">
	  <div class="col-12 col-md-6 offset-xl-2 offset-md-1 order-md-2 mb-5 mb-md-0">
	    <div class="text-center">
	      <img src="/img/illustrations/scale.svg" alt="..." class="img-fluid" style="height: 15rem !important;">
	    </div>
	  </div>
	  <div class="col-12 col-md-5 col-xl-4 order-md-1 my-5">
	    <h1 class="display-4 mb-3">
	      <span style="border-bottom: 5px solid #0984e3;">Showcase</span> & <span style="border-bottom: 5px solid #0984e3;">explore</span> work portfolios endorsed by our experts
	    </h1>
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
	              Browse
	            </h6>

	            <!-- Title -->
	            <h1 class="header-title">
	              Portfolios
	            </h1>

	          </div>
	        </div> <!-- / .row -->
	      </div>
	    </div>
	  </div>
	</div> <!-- / .row -->

	<div class="row">
		<div class="col-12 col-md-6 col-xl-4">
		  <div class="card">
		    <div class="card-body">
		      <div class="text-center">
		        <a href="/portfolios/0" class="card-avatar avatar avatar-lg mx-auto">
					<img src="/img/gray-avatar.png" alt="..." class="avatar-img rounded">
		        </a>
		      </div>

		      <!-- Title -->
		      <a href="/portfolios/0"><h2 class="card-title text-center mb-3">
		        Shazwi Suwandi
		      </h2></a>

		      <div class="text-center" style="margin-bottom: 0.75rem;">
		      	<span class="badge badge-secondary">Sample Portfolio</span>
			  </div>

		      <p class="text-center" style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical;">Shazwi has been working as a tech consultant since graduating from National University of Singapore and has gained significant experience in digital transformation projects. He likes to overthink in his everyday life and sometimes land himself onto problems that he wants to solve. When push comes to shove, he will roll up his sleeves, his pants, tie up his hair and sit tight till a solution is found. He still can't afford his own bat signal yet, so he can only be contactable on the other channels below.</p>

		      <div class="text-center" style="margin-bottom: 0.75rem;">
			      <span class="badge badge-primary">Business Analyst</span>
			  </div>

		      <div class="text-center" style="margin-bottom: 1.2rem;">
			      <span class="badge badge-warning">Food & Beverages</span>
			      <span class="badge badge-warning">E-Commerce</span>
			  </div>

		      <!-- Divider -->
		      <hr>

		      <div class="row align-items-right">
		        <div class="col">
		        	<p class="card-text small text-muted" style="margin-bottom: 0;">Completed projects</p>
		        	<p style="margin-bottom: 0;">2</p>
		        </div>
		        <div class="col-auto">
		          
		          <!-- Avatar group -->
		          <p class="card-text small text-muted" style="margin-bottom: 0;">Endorsed by</p>
		          <div class="avatar-group">
		            <a href="/profile/16" class="avatar avatar-xs" data-toggle="tooltip" title="" data-original-title="Steve McIntosh">
		            	<img src="https://storage.googleapis.com/talentail-123456789/avatars/pTzOJNAKBA85qGI9B4c9gictjkWTbRYaBZbyU3Zt.jpeg" alt="..." class="avatar-img rounded-circle"/>
		            </a>
		            <a href="/profile/18" class="avatar avatar-xs" data-toggle="tooltip" title="" data-original-title="Roshan Satpute">
		            	<img src="https://storage.googleapis.com/talentail-123456789/avatars/JKyKhb7wRRQxgMDwC7waREJ1TKy0pNiqLSczL1Ih.jpeg" alt="..." class="avatar-img rounded-circle"/>
		            </a>
		          </div>

		        </div>
		      </div> <!-- / .row -->
		    </div> <!-- / .card-body -->
		  </div>
		</div>
		@foreach($portfolios as $portfolio)
		<div class="col-12 col-md-6 col-xl-4">
		  <div class="card">
		    <div class="card-body">
		      <div class="text-center">
		        <a href="/portfolios/{{$portfolio->id}}" class="card-avatar avatar avatar-lg mx-auto">
					@if($portfolio->user->avatar)
					 <img src="https://storage.googleapis.com/talentail-123456789/{{Auth::user()->avatar}}" alt="" class="avatar-img rounded">
					@else
					<img src="/img/avatar.png" alt="..." class="avatar-img rounded">
					@endif
		        </a>
		      </div>

		      <!-- Title -->
		      <a href="/portfolios/{{$portfolio->id}}"><h2 class="card-title text-center mb-3">
		        {{$portfolio->user->name}}
		      </h2></a>

		      <p class="text-center" style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical;">{{$portfolio->user->description}}</p>

		      <div class="text-center" style="margin-bottom: 0.75rem;">
			    <span class="badge badge-primary">{{$portfolio->role->title}}</span>
			  </div>

		      <div class="text-center" style="margin-bottom: 1.2rem;">
		      	@foreach($portfolio->industries as $industry)
			      <span class="badge badge-warning">{{$industry->title}}</span>
			     @endforeach
			  </div>

		      <!-- Divider -->
		      <hr>

		      <div class="row align-items-right">
		        <div class="col">
		        	<p class="card-text small text-muted" style="margin-bottom: 0;">Completed projects</p>
		        	<p style="margin-bottom: 0;">{{count($portfolio->attempted_projects)}}</p>
		        </div>
		        <div class="col-auto">
		          
		          <!-- Avatar group -->
		          <p class="card-text small text-muted" style="margin-bottom: 0;">Endorsed by</p>
		          <div class="avatar-group">
		          	@foreach($portfolio->attempted_projects as $attemptedProject)
		            <a href="/profile/{{$attemptedProject->project->user_id}}" class="avatar avatar-xs" data-toggle="tooltip" title="" data-original-title="{{$attemptedProject->project->user->name}}">
		            	@if($attemptedProject->project->user->avatar)
		            	 <img src="https://storage.googleapis.com/talentail-123456789/{{$attemptedProject->project->user->avatar}}" alt="..." class="avatar-img rounded-circle"/>
		            	@else
		            	<img src="/img/avatar.png" alt="..." class="avatar-img rounded-circle"/>
		            	@endif
		            </a>
		            @endforeach
		          </div>

		        </div>
		      </div> <!-- / .row -->
		    </div> <!-- / .card-body -->
		  </div>
		</div>
		@endforeach
		<div class="col-12 col-md-6 col-xl-4">
		  <div class="card" style="height: 404.11px !important;">
		    <div class="card-body text-center" style="margin-top: 150px;">
		    	<h1><i class="far fa-plus-square"></i></h1>
		    	<a href="/portfolios/select-role">
		    		<h2 class="card-title text-center mb-3" style="">
		        		Add Portfolio
		      		</h2>
		      	</a>
		      	<p style="margin-top: 80px !important; margin-bottom: 0;">No material to build a portfolio?</p>
		      	<a href="/discover">Discover projects</a>
		    </div> 
		  </div>
		</div>
	</div>

	<!-- <div class="row justify-content-center">
		<div class="col-12 col-lg-12">
			<nav aria-label="Page navigation example">
	            <ul class="pagination" style="float: right;">
	              <li class="page-item"><a class="page-link" href="#!">1</a></li>
	              <li class="page-item"><a class="page-link" href="#!">2</a></li>
	              <li class="page-item"><a class="page-link" href="#!">3</a></li>
	              <li class="page-item"><a class="page-link" href="#!">Next</a></li>
	            </ul>
	          </nav>
		</div>
	</div> -->
</div>
@endsection

@section ('footer')    
@endsection