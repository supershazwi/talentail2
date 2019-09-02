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
        @if($portfolio->user->avatar)
         <img src="https://storage.googleapis.com/talentail-123456789/{{$portfolio->user->avatar}}" alt="" class="avatar-img rounded" style="width: 7.5rem; height: 7.5rem;">
        @else
        <img src="https://api.adorable.io/avatars/150/{{$portfolio->user->email}}.png" alt="..." class="avatar-img rounded" style="width: 7.5rem; height: 7.5rem;">
        @endif
        <a href="/profile/{{$portfolio->user_id}}"><h1 style="margin-top: 1.5rem; margin-bottom: 0rem;">{{$portfolio->user->name}}</h1></a>
        <p>{{$portfolio->user->email}}</p>
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
                  @if(Auth::id() != null && $portfolio->user_id == Auth::id())
                  <a href="/portfolios/{{$portfolio->id}}/manage-portfolio" class="btn btn-primary" style="margin-bottom: 0.1875rem !important;" onclick="addTask()">Manage Portfolio</a>
                  @endif
                </div>
              </div>
        </div>
      </div>

      <div class="content-list-body row">
          <div class="col-lg-12">
            @foreach($reviewedExercises as $answeredExercise)
              <div class="card mb-3" style="margin-bottom: 0rem !important;">
                  <div class="card-body">
                      <a href="/exercises/{{$answeredExercise->exercise->slug}}"><span style="letter-spacing: -.02em; font-weight: 500; font-size: 1.0625rem; line-height: 1.1;">{{$answeredExercise->exercise->title}}</span> 
                      </a>
                      <p style="margin-top: 0.5rem;">{{$answeredExercise->exercise->description}}</p>
                      <h3>Exercise</h3>
                      <p>{{$answeredExercise->exercise->solution_title}}</p>
                      <h3>Submission</h3>
                      @if(count($answeredExercise->answered_exercise_files) > 0)
                      <div class='row'>
                        <div class='col-12 col-md-12'>
                          <div class='form-group' style="margin-bottom: 0rem;">
                            @foreach($answeredExercise->answered_exercise_files as $answeredExerciseFile)
                              <a href="https://storage.googleapis.com/talentail-123456789/{{$answeredExerciseFile->url}}">{{$answeredExerciseFile->title}}</a><br/>
                            @endforeach
                          </div>
                        </div>
                      </div>
                      @endif
                  </div>
              </div>
              @if(!$loop->last) 
                <hr style="margin-top: 2.5rem; margin-bottom: 2.5rem;"/>
              @endif
            @endforeach
          </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  function addPortfolioToCart() {
    document.getElementById("addPortfolioToCartButton").click();
  }
</script>
@endsection

@section ('footer')    
@endsection