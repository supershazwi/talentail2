@extends ('layouts.main')

@section ('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8">
      
      <!-- Header -->
      <div class="header mt-md-5">
        <div class="header-body">

          <div class="row">
          <!-- Title -->
            <div class="col-lg-12">
              <h1 class="header-title" style="display: inline-block; height: 100%; margin-top: 5px;">
                Work Experience
              </h1><button class="btn btn-primary d-block d-md-inline-block" style="float: right; display: inline-block;" onclick="addWork()">
                Add Experience
              </button>
            </div>
          </div>
        </div>
      </div>

      <form method="POST" action="/work-experience">
      @csrf
      @foreach($user->experiences as $count=>$experience)
      <div class="card" id="workList_{{$count+1}}">
        <div class="card-body experience-card">
          <div class="row">
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label>
                  Company
                </label>
                <input type="text" name="company_{{$count+1}}" class="form-control" id="company_{{$count+1}}" placeholder="Enter company name (e.g. Google)" value="{{$experience->company}}">
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label>
                  Role
                </label>
                <input type="text" name="role_{{$count+1}}" class="form-control" id="role_{{$count+1}}" placeholder="Enter role (e.g. Business Analyst)" value="{{$experience->role}}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-12">
              <div class="form-group">
                <label>
                  Description
                </label>
                <textarea type="text" placeholder="Enter your work description" name="work-description_{{$count+1}}" id="work-description_{{$count+1}}" class="form-control" rows="5">{{$experience->description}}</textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label>
                  Start Date
                </label>
                <input type="date" class="form-control" name="start-date_{{$count+1}}" id="start-date_{{$count+1}}" value="{{$experience->start_date}}">
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label>
                  End Date
                </label>
                <input type="date" class="form-control" name="end-date_{{$count+1}}" id="end-date_{{$count+1}}" value="{{$experience->end_date}}">
              </div>
              <button class="btn btn-danger" id="delete-work_{{$count+1}}" onclick="deleteWork()" style="float: right; margin-bottom: 0rem;">Delete</button>
            </div>
          </div>
        </div>
      </div>
      @endforeach
      <div class="card" id="workList_{{count($user->experiences)+1}}">
      </div>
      <button class="btn btn-primary" type="submit">Save Changes</button>
      </form>
    </div>
  </div> <!-- / .row -->
</div>

<script type="text/javascript">
    
  function addWork() {
    event.preventDefault();

    let cardCounter = document.querySelectorAll('.experience-card').length + 1;

    document.getElementById("workList_" + cardCounter).innerHTML += "<div class='card-body experience-card'><div class='row'><div class='col-12 col-md-6'><div class='form-group'><label>Company</label><input type='text' name='company_" + cardCounter + "' class='form-control' id='company_" + cardCounter + "' placeholder='Enter company name (e.g. Google)'></div></div><div class='col-12 col-md-6'><div class='form-group'><label>Role</label><input type='text' name='role_" + cardCounter + "' class='form-control' id='role_" + cardCounter + "' placeholder='Enter role (e.g. Business Analyst)'></div></div></div><div class='row'><div class='col-12 col-md-12'><div class='form-group'><label>Description</label><textarea type='text' placeholder='Enter your work description' name='work-description_" + cardCounter + "' id='work-description_" + cardCounter + "' class='form-control' rows='5'></textarea></div></div></div><div class='row'><div class='col-12 col-md-6'><div class='form-group'><label>Start Date</label><input type='date' class='form-control' name='start-date_" + cardCounter + "' id='start-date_" + cardCounter + "'></div></div><div class='col-12 col-md-6'><div class='form-group'><label>End Date</label><input type='date' class='form-control' name='end-date_" + cardCounter + "' id='end-date_" + cardCounter + "'></div><button class='btn btn-danger' id='delete-work_" + cardCounter + "' onclick='deleteWork()' style='float: right; margin-bottom: 0rem;'>Delete</button></div></div></div>";

    document.getElementById("workList_" + cardCounter).insertAdjacentHTML('afterend', "<div class='card' id='workList_" + (cardCounter+1) + "'></div>");
  }

  function deleteWork() {
      event.preventDefault();
      let workIdString = event.target.id.split("_");
      let workId = parseInt(workIdString[1]);

      // count number of work cards there are
      let cardCounter = document.querySelectorAll('.experience-card').length;

      let elem = document.getElementById("workList_" + workId);
      elem.parentNode.removeChild(elem);

      let a;

      for (i = workId; i < cardCounter; i++) {
          a = document.getElementById("card_" + (i+1));
          a.id = "card_" + i;

          a = document.getElementById("company_" + (i+1));
          a.id = "company_" + i;
          a.name = "company_" + i;

          a = document.getElementById("role_" + (i+1));
          a.id = "role_" + i;
          a.name = "role_" + i;

          a = document.getElementById("work-description_" + (i+1));
          a.id = "work-description_" + i;
          a.name = "work-description_" + i;

          a = document.getElementById("start-date_" + (i+1));
          a.id = "start-date_" + i;
          a.name = "start-date_" + i;

          a = document.getElementById("end-date_" + (i+1));
          a.id = "end-date_" + i;
          a.name = "end-date_" + i;

          a = document.getElementById("delete-work_" + (i+1));
          a.id = "delete-work_" + i;

          a = document.getElementById("workList_" + (i+1));
          a.id = "workList_" + i;
      }

      a = document.getElementById("workList_" + (cardCounter+1));
      a.id = "workList_" + cardCounter;
  }

</script>
@endsection

@section ('footer')
    
    

@endsection