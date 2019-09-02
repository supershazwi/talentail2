@extends ('layouts.main')

@section ('content')
  <div class="row" style="margin-top: 1.5rem;">
      <div class="col-auto">
          <h3><a href="/companies">Companies</a> > {{$company->title}}</h3>
      </div>
  </div>
  <div class="row">
    <div class="col-lg-4">
      <div class="card card-kanban">
        <div class="card-body">
          <div class="card-title">
            <img src="{{$company->avatar}}" style="height: 48px; margin-bottom: 1rem;" />
            <h4>{{$company->title}}</h4>
          </div>
          <p>{{$company->description}}</p>
        </div>
      </div>
    </div>
    <div class="col-lg-8">
      <div class="kanban-col">
          <div class="card-list">
              <div class="card-list-header">
                  <h4>Opportunities</h4>
              </div>
              <div class="card-list-body">
                  @if($company->opportunities->count() != 0)
                  @foreach($company->opportunities as $opportunity)
                  <div class="card card-kanban">
                      <div class="card-body">
                          <div class="row">
                            <div class="col-lg-9">
                              <div class="card-title">
                                <h5><a href="/opportunities/{{$opportunity->slug}}">{{$opportunity->title}}</a></h5>
                              </div>
                              <p>{{$opportunity->description}}</p>
                            </div>
                            <div class="col-lg-3">
                              <strong>Skill</strong>
                              <p>{{$opportunity->skill->title}}</p>
                              <strong>Competencies</strong>
                              <p>15</p>
                              <strong>Projects</strong>
                              <p>2</p>
                            </div>
                          </div>
                      </div>
                  </div>
                  @endforeach
                  @else
                    <div class="card card-kanban">
                      <div class="card-body">
                          <div class="row" style="text-align: center;">
                            <div class="col-lg-12">
                              <h1 class="display-1 text-primary">4&#x1f635;4</h1>
                              <p>
                                  Aw shucks! There are currently no opportunities here. <a href="/companies">Check out other companies</a>.
                              </p>
                            </div>
                          </div>
                      </div>
                  </div>
                  @endif
              </div>
          </div>
      </div>
    </div>
  </div>
@endsection

@section ('footer')
	
	

@endsection