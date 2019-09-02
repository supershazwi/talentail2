@extends ('layouts.main')

@section ('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <section class="py-4 py-lg-5" style="text-align: center; padding-bottom: 0rem !important;">
         <img src="https://storage.googleapis.com/talentail-123456789/{{$company->url}}" alt="" class="avatar-img rounded" style="width: 7.5rem; height: 7.5rem;">
        <h1 style="margin-top: 1.5rem;">{{$company->title}}</h1>
        <p>{{$company->description}}</p>
        
        @if($company->website)
        <a target="_blank" href="{{$company->website}}" style="margin-right: 1rem; font-size: 1.5rem;"><i class="fas fa-link"></i></a>
        @endif
        @if($company->linkedin)
        <a target="_blank" href="{{$company->linkedin}}" style="margin-right: 1rem; font-size: 1.5rem;"><i class="fab fa-linkedin"></i></a>
        @endif
        @if($company->facebook)
        <a target="_blank" href="{{$company->facebook}}" style="margin-right: 1rem; font-size: 1.5rem;"><i class="fab fa-facebook-square"></i></a>
        @endif
        @if($company->twitter)
        <a target="_blank" href="{{$company->twitter}}" style="font-size: 1.5rem;"><i class="fab fa-twitter-square"></i></a>
        @endif

      </section>
    </div>
  </div>
  <hr style="margin-top: 2.5rem; margin-bottom: 2.5rem;" />
  <div class="row">
    @foreach($company->opportunities as $opportunity)
    <div class="col-12 col-md-6 col-xl-4">
      <div class="card">
        <div class="card-body">

          <!-- Title -->
          <a href="/opportunities/{{$opportunity->slug}}"><h2 class="card-title text-center mb-3">
            {{$opportunity->title}} 
          </h2></a>

          <p class="text-center" style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical;">{{$opportunity->company->title}}, {{$opportunity->location}}</p>

          <!-- Divider -->
          <hr>

          <div class="row">
            <div class="col" style="text-align: center;">
                <p class="card-text small text-muted" style="margin-bottom: 0;">Exercises</p>
                <p style="margin-bottom: 0;">{{count($opportunity->exercises)}}</p>
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
</div>
@endsection

@section ('footer')    
@endsection