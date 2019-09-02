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
            <h1 style="color: #3e3e3c; margin-bottom: 0rem; font-size: 1.5rem;">Complete <span style="border-bottom: 5px solid #0984e3;">One Exercise In Each Section</span></h1>
          </div>
        </div>
        @foreach($opportunity->exercise_groupings as $key=>$exerciseGrouping)
        <div class="row" style="margin-top: 1.5rem;">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h2 class="card-title mb-3" style="margin-bottom: 0rem !important;">
                  Section {{$key+1}}. {{$exerciseGrouping->task->title}}
                </h2>
                <hr style="margin-top: 1.5rem; margin-bottom: 1.5rem;" />
                  <table class="table table-borderless" style="margin-bottom: 0rem !important;">
                    <tbody>
                        @foreach($exerciseGrouping->exercises as $key2=>$exercise)
                          <tr>
                            <th scope="row" style="padding-top: 0rem; padding-left: 0rem;">Exercise {{$key+1}}.{{$key2+1}}.</th>
                            <td style="padding-top: 0rem; padding-left: 0rem;"><a href="/exercises/{{$exercise->slug}}">{{$exercise->solution_title}}</a></td>
                            <td style="padding-top: 0rem; padding-left: 0rem;">
                              @if($statusArray[$exercise->id] == "Submitted For Review")
                              <span class="badge badge-warning">{{$statusArray[$exercise->id]}}</span>
                              @elseif($statusArray[$exercise->id] == "Competent")
                              <span class="badge badge-success">{{$statusArray[$exercise->id]}}</span>
                              @elseif($statusArray[$exercise->id] == "Needs Improvement")
                              <span class="badge badge-danger">{{$statusArray[$exercise->id]}}</span>
                              @elseif($statusArray[$exercise->id] == "Attempted")
                              <span class="badge badge-dark">{{$statusArray[$exercise->id]}}</span>
                              @else
                              <span class="badge badge-light">{{$statusArray[$exercise->id]}}</span>
                              @endif
                            </td>
                          </tr>
                        @endforeach
                    </tbody>
                  </table>  
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      <div class="col-lg-3">
        <div class="card">
          <div class="card-body">
          	<img src="https://storage.googleapis.com/talentail-123456789/{{$opportunity->company->url}}" alt="" class="avatar-img rounded" style="width: 3rem; margin-bottom: 1.5rem;">
            <h3>{{$opportunity->title}}</h3>
            <p><a href="/companies/{{$opportunity->company->slug}}">{{$opportunity->company->title}}</a>, {{$opportunity->location}}</p>
            <p>{{$opportunity->company->description}}</p>
            <p class="card-text small text-muted" style="margin-bottom: 0;">Applications</p>
            <p>0</p>
            <p class="card-text small text-muted" style="margin-bottom: 0;">Job Posted In</p>
            <p><a href="{{$opportunity->link}}">LinkedIn</a></p>
            <form id="applyForm" method="POST" action="/opportunities/{{$opportunity->slug}}/apply">
              @csrf
              <input type="hidden" id="applicable" name="applicable" value="{{$applicable}}" />
              <a href="#" onclick="applyForOpportunity()" class="btn btn-primary btn-block">Apply for Opportunity</a>
              <a href="/opportunities/{{$opportunity->slug}}/edit" class="btn btn-block btn-light" style="margin-top: 0.5rem;">Edit</a>
              @if($opportunity->visible)
              <a href="#" class="btn btn-block btn-light" style="margin-top: 0.5rem;" onclick="toggleVisibility()">Make Private</a>
              @else
              <a href="#" class="btn btn-block btn-light" style="margin-top: 0.5rem;" onclick="toggleVisibility()">Make Public</a>
              @endif
              <button type="submit" id="applyFormButton" style="display: none;" />
            </form>

            <form method="POST" action="/opportunities/{{$opportunity->slug}}/toggle-visibility">
              @csrf
              <button type="submit" style="display: none;" id="toggleOpportunityButton" />
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function toggleVisibility() {
    event.preventDefault();
    document.getElementById("toggleOpportunityButton").click();
  }

  function applyForOpportunity() {
    event.preventDefault();

    if(document.getElementById("applicable").value == true) {
      document.getElementById("applyFormButton").click();
    } else {
      document.getElementById("applyAlert").style.display = "block";
    }
  }

  function closeAlert() {
    event.preventDefault();
    document.getElementById("applyAlert").style.display = "none";
  }
</script>
@endsection

@section ('footer')   
@endsection