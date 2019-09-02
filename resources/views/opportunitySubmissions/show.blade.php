@extends ('layouts.main')

@section ('content')
<div class="header">
  <div class="container">
    <div class="alert alert-warning alert-dismissible fade show" role="alert" id="applyAlert" style="margin-top: 1.5rem; text-align: center; display: none;" >
      Please complete at least one exercise per task provided. This drastically improves your chances of securing an interview. 
      <button type="button" class="close" onclick="closeAlert()">
        <span aria-hidden="true">×</span>
      </button>
    </div>
    <div class="row" style="margin-top: 3rem;">
      <div class="col-lg-9">
        <div class="row">
          <div class="col-lg-12">
            <h1 style="color: #3e3e3c; margin-bottom: 0rem; font-size: 1.5rem;">Exercises will appear here <span style="border-bottom: 5px solid #0984e3;">once we have mapped them to the job description</span></h1>
            <hr style="margin-top: 2.5rem; margin-bottom: 2.5rem;"/>
            <h2>Job Description</h2>
            <div class="card">
              <div class="card-body exercise-brief" style="margin-bottom: -1rem;">
                @parsedown($opportunitySubmission->description)
              </div>
            </div>
          </div>
        </div>
        <!-- first 1 -->
      </div>
      <div class="col-lg-3">
        <div class="card">
          <div class="card-body">
            <h3>{{$opportunitySubmission->title}}</h3>
            <p>{{$opportunitySubmission->company}}, {{$opportunitySubmission->location}}</p>
            <a href="/opportunity-submissions/{{$opportunitySubmission->slug}}/edit" class="btn btn-block btn-light" style="margin-top: 0.5rem;">Edit</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
</script>
@endsection

@section ('footer')   
@endsection