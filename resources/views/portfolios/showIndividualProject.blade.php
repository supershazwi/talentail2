@extends ('layouts.main')

@section ('content')
<form method="POST" action="/portfolios/{{$portfolio->id}}/add-portfolio-to-cart" id="addPortfolioToCart">
  @csrf
  <input type="hidden" name="portfolio_id" value="{{$portfolio->id}}" />
  <button type="submit" style="display: none;" id="addPortfolioToCartButton">Submit</button>
</form>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-xl-10 col-lg-11">
      <section class="py-4 py-lg-5" style="text-align: center; padding-bottom: 0rem !important;">
        @if (session('notAuthorised'))
          <div class="alert alert-danger" id="notAuthorisedAlert" style="text-align: center;">
            <h4 class="alert-heading" style="margin-bottom: 0;">{{session('notAuthorised')}}</h4>
          </div>
        @endif
        @if($portfolio->user->avatar)
         <img src="https://storage.googleapis.com/talentail-123456789/{{$portfolio->user->avatar}}" alt="" class="avatar-img rounded" style="width: 7.5rem; height: 7.5rem;">
        @else
        <img src="/img/avatar.png" alt="..." class="avatar-img rounded" style="width: 7.5rem; height: 7.5rem;">
        @endif
        <a href="/profile/{{$portfolio->user_id}}"><h1 style="margin-top: 1.5rem;">{{$portfolio->user->name}}</h1></a>
        <p>{{$portfolio->user->description}}</p>

        <div class="text-center" style="margin-bottom: 0.75rem;">
            <span class="badge badge-primary">{{$portfolio->role->title}}</span>
        </div>

          <div class="text-center" style="margin-bottom: 1.2rem;">
            @foreach($portfolio->industries as $industry)
            <span class="badge badge-warning">{{$industry->title}}</span>
           @endforeach
        </div>
        <!-- <p>Shazwi has been working as a tech consultant since graduating from National University of Singapore and has gained significant experience in digital transformation projects. He likes to overthink in his everyday life and sometimes land himself onto problems that he wants to solve. When push comes to shove, he will roll up his sleeves, his pants, tie up his hair and sit tight till a solution is found. He still can't afford his own bat signal yet, so he can only be contactable on the other channels below.</p> -->
      
        <a target="_blank" href="https://www.linkedin.com/in/shazwi/" style="margin-right: 1rem; font-size: 1.5rem;"><i class="fab fa-linkedin"></i></a>
        <a target="_blank" href="https://www.facebook.com/supershazwi" style="margin-right: 1rem; font-size: 1.5rem;"><i class="fab fa-facebook-square"></i></a>
        <a target="_blank" href="https://twitter.com/supershazwi" style="font-size: 1.5rem;"><i class="fab fa-twitter-square"></i></a>

      </section>

      <div class="header mt-md-5" style="margin-top: 0rem !important;">
        <div class="header-body" style="padding-top: 0;">
          <div class="row align-items-center">
                <div class="col-auto">
                  <label class="mb-1">
                    {{$portfolio->role->title}}
                  </label>
                </div>
                <div class="col">

                </div>
                <div class="col-auto">
                  <a href="/portfolios/{{$portfolio->id}}/projects/{{$attemptedProject->id}}/leave-review" class="btn btn-primary" style="margin-bottom: 0.1875rem !important;" onclick="addTask()">Leave Review</a>
                </div>
              </div>
        </div>
      </div>

      <div class="content-list-body row">
          <div class="col-lg-12">
              <div class="card mb-3" style="margin-bottom: 0rem !important;">
                  <div class="card-body">
                      <a href="#"><span style="letter-spacing: -.02em; font-weight: 500; font-size: 1.0625rem; line-height: 1.1;">{{$attemptedProject->project->title}}</span> 
                        @if(!$attemptedProject->project->internal)
                        <span class="badge badge-soft-secondary" style="margin-left: 0.5rem; margin-top: -0.5rem;">External</span>
                        @endif
                      </a>
                      <p style="margin-top: 0.5rem;">{{$attemptedProject->project->description}}</p>
                      @if(count($attemptedProject->answered_task_files) > 0)
                      <div class='row'>
                        <div class='col-12 col-md-12'>
                          <div class='form-group' style="margin-bottom: 0rem;">
                            <h4><label class='mb-1'>Supporting files</label></h4>
                            @foreach($attemptedProject->answered_task_files as $answeredTaskFile)
                              <a href="https://storage.googleapis.com/talentail-123456789/{{$answeredTaskFile->url}}">{{$answeredTaskFile->title}}</a><br/>
                            @endforeach
                          </div>
                        </div>
                      </div>
                      @endif
                      @if($attemptedProject->project->internal)
                        <hr style="margin-top: 1.375rem;"/>
                        @if($attemptedProject->project->user->avatar)
                         <img src="https://storage.googleapis.com/talentail-123456789/{{$attemptedProject->project->user->avatar}}" alt="..." class="avatar-img rounded" style="height: 3rem; width: 3rem; float: left;">
                        @else
                        <img src="/img/avatar.png" alt="..." class="avatar-img rounded" style="height: 3rem; width: 3rem; float: left;">
                        @endif
                        <div style="margin-left: 4rem !important;">
                          <p style="margin-bottom: 0.25rem;"><a href="/profile/{{$attemptedProject->project->user->id}}">{{$attemptedProject->project->user->name}}</a> <span class="badge badge-warning" style="font-size: 0.8rem;">Creator</span></p>
                          <p style="margin-bottom: 0rem;">{{$attemptedProject->review->description}}</p>
                        </div>
                      @endif
                  </div>
              </div>
          </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  setTimeout(function(){ document.getElementById("notAuthorisedAlert").style.display = "none" }, 3000);
</script>
@endsection

@section ('footer')    
@endsection