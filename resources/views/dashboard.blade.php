@extends ('layouts.main')

@section ('content')
	
	<div class="header">
	  <div class="container">

	    <!-- Body -->
	    <div class="header-body">
	      <div class="row align-items-end">
	        <div class="col">
	          
	          <!-- Pretitle -->
	          <h6 class="header-pretitle">
	            Overview
	          </h6>

	          <!-- Title -->
	          <h1 class="header-title">
	            Dashboard
	          </h1>

	        </div>
	      </div> <!-- / .row -->
	    </div> <!-- / .header-body -->

	  </div>
	</div> <!-- / .header -->
	<div class="container">
		@if(Auth::user()->admin)
			<div class="row align-items-center">
			  <div class="col-auto">
			    <h2>
			      Roles
			    </h2>
			  </div>
			  <div class="col">
			  	<a href="/roles/create" class="btn btn-primary" style=" margin-top: -1.25rem; float: right;">Add Role</a>
			  </div>
			</div>
			@if(count($roles) > 0)
			<div class="row">
				<div class="col-12 col-xl-12">
					<div class="card">	
					    <table class="table" style="margin-bottom: 0;">
					      <thead>
					        <tr>
					          <th scope="col">#</th>
					          <th scope="col">Role</th>
					        </tr>
					      </thead>
					      <tbody>
					      		@foreach($roles as $key=>$role)
					          <tr>
					            <th scope="row">{{$key+1}}</th>
					            <td>{{$role->title}}</td>
					          </tr>
					          @endforeach
					      </tbody>
					    </table>
					</div>
				</div>
			</div>
			@else
			<div class="row align-items-center" id="talentailBox">
			  <div class="col-lg-12">
			    <div class="card">
			      <div class="card-body">
			        <div class="row justify-content-center" style="margin-top:1rem;">
			          <div class="col-12 col-md-5 col-xl-4 my-5">
			            <p class="text-center mb-5" style="font-size: 2rem; margin-bottom: 0.25rem !important; -webkit-transform: scaleX(-1); transform: scaleX(-1);">😀</p>
			            <p class="text-center mb-3" style="margin-bottom: 2.25rem !important;">No roles added yet.
			            </p>
			          </div>
			        </div>
			      </div>
			    </div>
			  </div>
			</div>
			@endif
		@endif

		@if(Auth::user()->admin)
			<div class="row align-items-center">
			  <div class="col-auto">
			    <h2>
			      Tasks
			    </h2>
			  </div>
			  <div class="col">
			  	<a href="/tasks/create" class="btn btn-primary" style=" margin-top: -1.25rem; float: right;">Add Task</a>
			  </div>
			</div>
			@if(count($tasks) > 0)
			<div class="row">
				<div class="col-12 col-xl-12">
					<div class="card">	
					    <table class="table" style="margin-bottom: 0;">
					      <thead>
					        <tr>
					          <th scope="col">#</th>
					          <th scope="col">Task</th>
					          <th scope="col">Action</th>
					        </tr>
					      </thead>
					      <tbody>
					      		@foreach($tasks as $key=>$task)
					          <tr>
					            <th scope="row">{{$key+1}}</th>
					            <td><a href="/tasks/{{$task->slug}}">{{$task->title}}</a></td>
					            <td><a href="/tasks/{{$task->slug}}/edit">Edit</a></td>
					          </tr>
					          @endforeach
					      </tbody>
					    </table>
					</div>
				</div>
			</div>
			@else
			<div class="row align-items-center" id="talentailBox">
			  <div class="col-lg-12">
			    <div class="card">
			      <div class="card-body">
			        <div class="row justify-content-center" style="margin-top:1rem;">
			          <div class="col-12 col-md-5 col-xl-4 my-5">
			            <p class="text-center mb-5" style="font-size: 2rem; margin-bottom: 0.25rem !important; -webkit-transform: scaleX(-1); transform: scaleX(-1);">😀</p>
			            <p class="text-center mb-3" style="margin-bottom: 2.25rem !important;">No tasks added yet.
			            </p>
			          </div>
			        </div>
			      </div>
			    </div>
			  </div>
			</div>
			@endif
		@endif

		@if(Auth::user()->admin)
			<div class="row align-items-center">
			  <div class="col-auto">
			    <h2>
			      Exercises
			    </h2>
			  </div>
			  <div class="col">
			  	<a href="/exercises/create" class="btn btn-primary" style=" margin-top: -1.25rem; float: right;">Add Exercise</a>
			  </div>
			</div>
			@if(count($exercises) > 0)
			<div class="row">
				<div class="col-12 col-xl-12">
					<div class="card">	
					    <table class="table" style="margin-bottom: 0;">
					      <thead>
					        <tr>
					          <th scope="col">#</th>
					          <th scope="col">Question</th>
					          <th scope="col">Exercise</th>
					          <th scope="col">Task</th>
					        </tr>
					      </thead>
					      <tbody>
					      		@foreach($exercises as $key=>$exercise)
					          <tr>
					            <th scope="row">{{$key+1}}</th>
					            <td><a href="/exercises/{{$exercise->slug}}" style="display: block; width: 500px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{$exercise->solution_title}}</a></td>
					            <td><a href="/tasks/{{$exercise->task->slug}}" style="display: block; width: 200px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{$exercise->title}}</a></td>
					            <td><a href="/tasks/{{$exercise->task->slug}}" style="display: block; width: 180px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{$exercise->task->title}}</a></td>
					          </tr>
					          @endforeach
					      </tbody>
					    </table>
					</div>
				</div>
			</div>
			@else
			<div class="row align-items-center" id="talentailBox">
			  <div class="col-lg-12">
			    <div class="card">
			      <div class="card-body">
			        <div class="row justify-content-center" style="margin-top:1rem;">
			          <div class="col-12 col-md-5 col-xl-4 my-5">
			            <p class="text-center mb-5" style="font-size: 2rem; margin-bottom: 0.25rem !important; -webkit-transform: scaleX(-1); transform: scaleX(-1);">😀</p>
			            <p class="text-center mb-3" style="margin-bottom: 2.25rem !important;">No exercises added yet.
			            </p>
			          </div>
			        </div>
			      </div>
			    </div>
			  </div>
			</div>
			@endif
		@endif

		@if(Auth::user()->admin)
			<div class="row align-items-center">
			  <div class="col-auto">
			    <h2>
			      Opportunities
			    </h2>
			  </div>
			  <div class="col">
			  	<a href="/opportunities/create" class="btn btn-primary" style=" margin-top: -1.25rem; float: right;">Add Opportunity</a>
			  </div>
			</div>
			@if(count($opportunities) > 0)
			<div class="row">
				<div class="col-12 col-xl-12">
					<div class="card">	
					    <table class="table" style="margin-bottom: 0;">
					      <thead>
					        <tr>
					          <th scope="col">#</th>
					          <th scope="col">Opportunity</th>
					          <th scope="col">Company</th>
					          <th scope="col">Location</th>
					        </tr>
					      </thead>
					      <tbody>
					      		@foreach($opportunities as $key=>$opportunity)
					          <tr>
					            <th scope="row">{{$key+1}}</th>
					            <td><a href="/opportunities/{{$opportunity->slug}}" style="display: block; width: 500px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{$opportunity->title}}</a></td>
					            <td><span style="display: block; width: 200px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{$opportunity->company->title}}</span></td>
					            <td><span style="display: block; width: 180px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{$opportunity->location}}</span></td>
					          </tr>
					          @endforeach
					      </tbody>
					    </table>
					</div>
				</div>
			</div>
			@else
			<div class="row align-items-center" id="talentailBox">
			  <div class="col-lg-12">
			    <div class="card">
			      <div class="card-body">
			        <div class="row justify-content-center" style="margin-top:1rem;">
			          <div class="col-12 col-md-5 col-xl-4 my-5">
			            <p class="text-center mb-5" style="font-size: 2rem; margin-bottom: 0.25rem !important; -webkit-transform: scaleX(-1); transform: scaleX(-1);">😀</p>
			            <p class="text-center mb-3" style="margin-bottom: 2.25rem !important;">No opportunities added yet.
			            </p>
			          </div>
			        </div>
			      </div>
			    </div>
			  </div>
			</div>
			@endif
		@endif

		@if(Auth::user()->admin)
			<div class="row align-items-center">
			  <div class="col-auto">
			    <h2>
			      Exercise Groupings
			    </h2>
			  </div>
			  <div class="col">
			  	<a href="/exercise-groupings/create" class="btn btn-primary" style=" margin-top: -1.25rem; float: right;">Add Exercise Grouping</a>
			  </div>
			</div>
			@if(count($exerciseGroupings) > 0)
			<div class="row">
				<div class="col-12 col-xl-12">
					<div class="card">	
					    <table class="table" style="margin-bottom: 0;">
					      <thead>
					        <tr>
					          <th scope="col">#</th>
					          <th scope="col">Exercise Grouping</th>
					          <th scope="col">Opportunity</th>
					          <th scope="col">Company</th>
					        </tr>
					      </thead>
					      <tbody>
					      		@foreach($exerciseGroupings as $key=>$exerciseGrouping)
					          <tr>
					            <th scope="row">{{$key+1}}</th>
					            <td><a href="/exercise-groupings/{{$exerciseGrouping->id}}" style="display: block; width: 500px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{$exerciseGrouping->title}}</a></td>
					            <td><span style="display: block; width: 180px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{$exerciseGrouping->opportunity->title}}</span></td>
					            <td><span style="display: block; width: 180px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{$exerciseGrouping->opportunity->company->title}}</span></td>
					          </tr>
					          @endforeach
					      </tbody>
					    </table>
					</div>
				</div>
			</div>
			@else
			<div class="row align-items-center" id="talentailBox">
			  <div class="col-lg-12">
			    <div class="card">
			      <div class="card-body">
			        <div class="row justify-content-center" style="margin-top:1rem;">
			          <div class="col-12 col-md-5 col-xl-4 my-5">
			            <p class="text-center mb-5" style="font-size: 2rem; margin-bottom: 0.25rem !important; -webkit-transform: scaleX(-1); transform: scaleX(-1);">😀</p>
			            <p class="text-center mb-3" style="margin-bottom: 2.25rem !important;">No exercise groupings added yet.
			            </p>
			          </div>
			        </div>
			      </div>
			    </div>
			  </div>
			</div>
			@endif
		@endif

		@if(Auth::user()->admin)
			<div class="row align-items-center">
			  <div class="col-auto">
			    <h2>
			      Attempted Exercises
			    </h2>
			  </div>
			</div>
			@if(count($answeredExercises) > 0)
			<div class="row">
				<div class="col-12 col-xl-12">
					<div class="card">	
					    <table class="table" style="margin-bottom: 0;">
					      <thead>
					        <tr>
					          <th scope="col">#</th>
					          <th scope="col">Exercise</th>
					          <th scope="col">User</th>
					          <th scope="col">Status</th>
					        </tr>
					      </thead>
					      <tbody>
					      		@foreach($answeredExercises as $key=>$answeredExercise)
					          <tr>
					            <th scope="row">{{$key+1}}</th>
					            <td><a href="/exercises/{{$answeredExercise->exercise->slug}}/{{$answeredExercise->user_id}}" style="display: block; width: 500px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{$answeredExercise->exercise->solution_title}}</a></td>
					            <td><span style="display: block; width: 200px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{$answeredExercise->user->name}}</span></td>
					            <td><span style="display: block; width: 180px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{$answeredExercise->status}}</span></td>
					          </tr>
					          @endforeach
					      </tbody>
					    </table>
					</div>
				</div>
			</div>
			@else
			<div class="row align-items-center" id="talentailBox">
			  <div class="col-lg-12">
			    <div class="card">
			      <div class="card-body">
			        <div class="row justify-content-center" style="margin-top:1rem;">
			          <div class="col-12 col-md-5 col-xl-4 my-5">
			            <p class="text-center mb-5" style="font-size: 2rem; margin-bottom: 0.25rem !important; -webkit-transform: scaleX(-1); transform: scaleX(-1);">😀</p>
			            <p class="text-center mb-3" style="margin-bottom: 2.25rem !important;">No exercises added yet.
			            </p>
			          </div>
			        </div>
			      </div>
			    </div>
			  </div>
			</div>
			@endif
		@endif

		@if(!Auth::user()->admin)
			<div class="row align-items-center">
			  <div class="col-auto">
			    <h2>
			      Attempted Exercises
			    </h2>
			  </div>
			</div>
			@if(count($answeredExercises) > 0)
			<div class="row">
				<div class="col-12 col-xl-12">
					<div class="card">	
					    <table class="table" style="margin-bottom: 0;">
					      <thead>
					        <tr>
					          <th scope="col">#</th>
					          <th scope="col">Exercise</th>
					          <th scope="col">User</th>
					          <th scope="col">Status</th>
					        </tr>
					      </thead>
					      <tbody>
					      		@foreach($answeredExercises as $key=>$answeredExercise)
					          <tr>
					            <th scope="row">{{$key+1}}</th>
					            <td><a href="/exercises/{{$answeredExercise->exercise->slug}}/{{$answeredExercise->user_id}}" style="display: block; width: 500px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{$answeredExercise->exercise->solution_title}}</a></td>
					            <td><span style="display: block; width: 200px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{$answeredExercise->user->name}}</span></td>
					            <td><span style="display: block; width: 180px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{$answeredExercise->status}}</span></td>
					          </tr>
					          @endforeach
					      </tbody>
					    </table>
					</div>
				</div>
			</div>
			@else
			<div class="row align-items-center" id="talentailBox">
			  <div class="col-lg-12">
			    <div class="card">
			      <div class="card-body">
			        <div class="row justify-content-center" style="margin-top:1rem;">
			          <div class="col-12 col-md-5 col-xl-4 my-5">
			            <p class="text-center mb-5" style="font-size: 2rem; margin-bottom: 0.25rem !important; -webkit-transform: scaleX(-1); transform: scaleX(-1);">😀</p>
			            <p class="text-center mb-3" style="margin-bottom: 2.25rem !important;">No exercises attempted yet. <a href="/roles/business-analyst">View exercises</a>.
			            </p>
			          </div>
			        </div>
			      </div>
			    </div>
			  </div>
			</div>
			@endif
		@endif

		@if(!Auth::user()->admin)
			<div class="row align-items-center">
			  <div class="col-auto">
			    <h2>
			      Applied Opportunities
			    </h2>
			  </div>
			</div>
			@if(count($appliedOpportunities) > 0)
			<div class="row">
				<div class="col-12 col-xl-12">
					<div class="card">	
					    <table class="table" style="margin-bottom: 0;">
					      <thead>
					        <tr>
					          <th scope="col">#</th>
					          <th scope="col">Opportunity</th>
					        </tr>
					      </thead>
					      <tbody>
					      		@foreach($appliedOpportunities as $key=>$appliedOpportunity)
					          <tr>
					            <th scope="row">{{$key+1}}</th>
					            <td><a href="/opportunities/{{$appliedOpportunity->opportunity->slug}}" style="display: block; width: 500px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{$appliedOpportunity->opportunity->title}}</a></td>
					          </tr>
					          @endforeach
					      </tbody>
					    </table>
					</div>
				</div>
			</div>
			@else
			<div class="row align-items-center" id="talentailBox">
			  <div class="col-lg-12">
			    <div class="card">
			      <div class="card-body">
			        <div class="row justify-content-center" style="margin-top:1rem;">
			          <div class="col-12 col-md-5 col-xl-4 my-5">
			            <p class="text-center mb-5" style="font-size: 2rem; margin-bottom: 0.25rem !important; -webkit-transform: scaleX(-1); transform: scaleX(-1);">😀</p>
			            <p class="text-center mb-3" style="margin-bottom: 2.25rem !important;">No opportunities applied yet. <a href="/opportunities">View opportunities</a>.
			            </p>
			          </div>
			        </div>
			      </div>
			    </div>
			  </div>
			</div>
			@endif
		@endif

		@if(!Auth::user()->admin)
			<div class="row align-items-center">
			  <div class="col-auto">
			    <h2>
			      Opportunity Submissions
			    </h2>
			  </div>
			</div>
			@if(count($opportunitySubmissions) > 0)
			<div class="row">
				<div class="col-12 col-xl-12">
					<div class="card">	
					    <table class="table" style="margin-bottom: 0;">
					      <thead>
					        <tr>
					          <th scope="col">#</th>
					          <th scope="col">Opportunity</th>
					        </tr>
					      </thead>
					      <tbody>
					      		@foreach($opportunitySubmissions as $key=>$opportunitySubmission)
					          <tr>
					            <th scope="row">{{$key+1}}</th>
					            <td><a href="/opportunity-submissions/{{$opportunitySubmission->slug}}" style="display: block; width: 500px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{$opportunitySubmission->title}}</a></td>
					          </tr>
					          @endforeach
					      </tbody>
					    </table>
					</div>
				</div>
			</div>
			@else
			<div class="row align-items-center" id="talentailBox">
			  <div class="col-lg-12">
			    <div class="card">
			      <div class="card-body">
			        <div class="row justify-content-center" style="margin-top:1rem;">
			          <div class="col-12 col-md-5 col-xl-4 my-5">
			            <p class="text-center mb-5" style="font-size: 2rem; margin-bottom: 0.25rem !important; -webkit-transform: scaleX(-1); transform: scaleX(-1);">😀</p>
			            <p class="text-center mb-3" style="margin-bottom: 2.25rem !important;">No opportunities submitted yet.
			            </p>
			          </div>
			        </div>
			      </div>
			    </div>
			  </div>
			</div>
			@endif
		@endif
	</div>

	<script type="text/javascript">
		function toggleVisibility(attemptedProjectId) {
			let attemptedIdString = attemptedProjectId.split("_");
			document.getElementById("attemptedProjectId").value = attemptedIdString[1];
			document.getElementById("toggleVisibilityButton").click();
		}
	</script>

	<!-- Start of HubSpot Embed Code -->
	  <!-- Start of Async Drift Code -->
<!-- End of Async Drift Code -->
	<!-- End of HubSpot Embed Code --> 
@endsection

@section ('footer')
@endsection