@extends ('layouts.main')

@section ('content')
<div class="container">
  <div class="row" style="margin-top: 3rem;">
      <div class="col-lg-12" style="text-align: center; margin-bottom: 2.5rem;">
        <h1 style="font-size: 1.5rem; margin-bottom: 1.5rem;">{{$role->title}} Opportunities</h1>
        <!-- <a href="/opportunities/post-an-opportunity" class="btn btn-primary">
          Post an Opportunity
        </a> -->
      </div>
      @foreach($opportunities as $opportunity)
      <div class="col-12 col-md-6 col-xl-4">
        <div class="card">
          <div class="card-body">
            <div class="text-center">
              <a href="/opportunities/{{$opportunity->slug}}" class="card-avatar avatar avatar-lg mx-auto">
                  <img src="https://storage.googleapis.com/talentail-123456789/{{$opportunity->company->url}}" alt="..." class="avatar-img rounded">
              </a>
            </div>

            <!-- Title -->
            <a href="/opportunities/{{$opportunity->role->slug}}/{{$opportunity->slug}}"><h2 class="card-title text-center mb-3">
              {{$opportunity->title}} 
            </h2></a>

            <p class="text-center" style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; margin-bottom: 0.5rem;">{{$opportunity->company->title}}</p>

            <p class="text-center" style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical;">
            {{$opportunity->location}}</p>

            <!-- Divider -->
            <hr>

            <div class="row">
              <div class="col" style="text-align: center;">
                  <p class="card-text small text-muted" style="margin-bottom: 0;">Exercises</p>
                  <p style="margin-bottom: 0;">{{count($opportunity->exercise_groupings)}}</p>
                </div>
                <div class="col" style="text-align: center;">
                  
                  <!-- Avatar group -->
                  <p class="card-text small text-muted" style="margin-bottom: 0;">Applications</p>
                  <p style="margin-bottom: 0;">0</p>

                </div>
            </div> <!-- / .row -->
          </div> <!-- / .card-body -->
        </div>
      </div>
      @endforeach
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