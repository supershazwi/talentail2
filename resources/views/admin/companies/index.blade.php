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
	            Admin
	          </h6>

	          <!-- Title -->
	          <h1 class="header-title">
	            Companies
	          </h1>

	        </div>
	      </div> <!-- / .row -->
	    </div> <!-- / .header-body -->

	  </div>
	</div> <!-- / .header -->
	<div class="container">
		<div class="row">
			<div class="col-12 col-xl-12">
				<div class="card">	
				    <table class="table table-nowrap" style="margin-bottom: 0;">
				      <thead>
				        <tr>
				          <th scope="col">#</th>
				          <th scope="col">Company</th>
				          <th scope="col">Jobs</th>
				          <th scope="col">Projects</th>
				          <th scope="col">Status</th>
				        </tr>
				      </thead>
				      <tbody>
				      		@foreach($companies as $key=>$company)
				          <tr>
				            <th scope="row">{{$key+1}}</th>
				            <td><a href="/companies/{{$company->slug}}">{{$company->title}}</a></td>
				            <td>2</td>
				            <td>2</td>
				            @if($company->published)
				            	<td><span class="badge badge-primary">Public</span></td>
				            @else
				            	<td><span class="badge badge-warning">Private</span></td>
				            @endif
				          </tr>
				          @endforeach
				      </tbody>
				    </table>
				</div>
			</div>
		</div>
	</div>
@endsection

@section ('footer')    
@endsection