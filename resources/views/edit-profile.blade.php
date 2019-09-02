@extends ('layouts.main')

@section ('content')
<div class="container">
    <div class="content-list">
        <div class="row content-list-head" style="padding-top: 4.5rem !important;">
            <div class="col-auto">
                <h1>Edit Profile</h1>
            </div>
        </div>
        <!--end of content list head-->
        <form method="POST" action="/profile/save" enctype="multipart/form-data">
        @csrf
        <div class="content-list-body">
            @if ($errors->has('slug') && strlen($errors->first('slug')) > 0)
            <div class="alert alert-danger" style="text-align: center;">
                <p style="color: #721c24 !important;">The custom url has already been taken.</p>
            </div>
            @endif
            <h5 style="margin-top: 1.5rem;">Profile Image</h5>
            <div class="media mb-4">
                @if($user->avatar)
                <img alt="Image" src="https://storage.googleapis.com/talentail-123456789/{{$user->avatar}}" class="avatar avatar-lg mt-1" style="margin-top: 0px !important;"/>
                @else
                <img alt="Image" src="/img/avatar.png" class="avatar avatar-lg mt-1" style="margin-top: 0px !important;"/>
                @endif
                <div class="media-body ml-3">
                    <div class="custom-file custom-file-naked d-block mb-1">
                        <input type="file" class="custom-file-input d-none" id="avatar-file" name="avatar-file">
                        <label class="custom-file-label position-relative" for="avatar-file">
                            <span class="btn btn-primary">
                                Upload avatar
                            </span>
                        </label>
                    </div>
                    <small>Smile for the camera!</small>
                </div>
            </div>
            <!-- <h5 style="margin-top: 1.5rem;">Custom Url</h5>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">https://talentail.com/profile/</span>
              </div>
              <input type="text" name="slug" class="form-control" id="slug" placeholder="Enter your custom link (e.g. j.orange)" value="{{$user->slug}}">
            </div> -->
            <h5 style="margin-top: 1.5rem;">Full Name</h5>
            <input type="text" name="name" class="form-control" id="name" placeholder="Enter your full name (e.g. Johnie Orange)" value="{{$user->name}}">
            <h5 style="margin-top: 1.5rem;">Email</h5>
            <input type="text" name="email" class="form-control" id="email" placeholder="Enter your email (e.g. j.orange@gmail.com)" value="{{$user->email}}">
            <h5 style="margin-top: 1.5rem;">Website</h5>
            <input type="text" name="website" class="form-control" id="website" placeholder="Enter your website link (e.g. johnieorange.com)" value="{{$user->website}}">
            <h5 style="margin-top: 1.5rem;">LinkedIn</h5>
            <input type="text" name="linkedin" class="form-control" id="linkedin" placeholder="Enter your LinkedIn profile link (e.g. https://www.linkedin.com/in/jorange.007)" value="{{$user->linkedin}}">
            <h5 style="margin-top: 1.5rem;">Facebook</h5>
            <input type="text" name="facebook" class="form-control" id="facebook" placeholder="Enter your Facebook profile link (e.g. https://www.facebook.com/jorange.007)" value="{{$user->facebook}}">
            <h5 style="margin-top: 1.5rem;">Twitter</h5>
            <input type="text" name="twitter" class="form-control" id="twitter" placeholder="Enter your Twitter profile link (e.g. https://www.twitter.com/jorange.007)" value="{{$user->twitter}}">
            <h5 style="margin-top: 1.5rem;">Description</h5>
            <textarea type="text" placeholder="Tell us a little about yourself" name="description" id="description" class="form-control" rows="4" style="margin-bottom: 1.5rem;">{{$user->description}}</textarea>
            @if(Auth::user()->creator)
            <div style="display: block; margin-top: 1.5rem;">
                <h5 style="float: left; margin-right: 1.5rem; margin-top: 6px;">Work Experience</h5>
                <button class="btn btn-primary" onclick="addWork()">Add Work</button>
            </div>
            @foreach($user->experiences as $count=>$experience)
            <div class="accordion" id="workList_{{$count+1}}" style="margin-top: 1.5rem;">
                <div class="card task-card" id="card_{{$count+1}}" style="margin-bottom: 1.5rem;">
                    <div class="card-header">
                        <h5>Company</h5>
                        <input type="text" name="company_{{$count+1}}" class="form-control" id="company_{{$count+1}}" placeholder="Enter company name (e.g. Google)" value="{{$experience->company}}">
                    </div>
                    <div class="card-body" style="padding-bottom: 0rem;">
                        <h5>Role</h5>
                        <input type="text" name="role_{{$count+1}}" class="form-control" id="role_{{$count+1}}" placeholder="Enter role (e.g. Business Analyst)" value="{{$experience->role}}">
                        <h5 style="margin-top: 1.5rem;">Description</h5>
                        <textarea type="text" placeholder="Enter your work description" name="work-description_{{$count+1}}" id="work-description_{{$count+1}}" class="form-control" rows="4">{{$experience->description}}</textarea>
                        <div class="row">
                            <div class="col-lg-6" style="margin-top: 1.5rem;">
                                <h5>Start Date</h5>
                                <input type="date" class="form-control" name="start-date_{{$count+1}}" id="start-date_{{$count+1}}" value="{{$experience->start_date}}">
                            </div>
                            <div class="col-lg-6" style="margin-top: 1.5rem;">
                                <h5>End Date</h5>
                                <input type="date" class="form-control" name="end-date_{{$count+1}}" id="end-date_{{$count+1}}" value="{{$experience->end_date}}">
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-danger btn-sm" id="delete-work_{{$count+1}}" onclick="deleteWork()" style="float: right; margin-bottom: 1.5rem;">Delete</button>
                    </div>
                </div>
            </div>  
            @endforeach
            <div class="accordion" id="workList_{{count($user->experiences)+1}}" style="margin-top: 1.5rem;">
            </div>
            @endif
        </div>
        <button class="btn btn-primary pull-right" type="submit" id="saveChanges">Save Changes</button>
        </form>
    </div>
</div>

<script type="text/javascript">
    
    function addWork() {
        event.preventDefault();

        let cardCounter = document.querySelectorAll('.task-card').length + 1;

        document.getElementById("workList_" + cardCounter).innerHTML += "<div class='card task-card' id='card_" + cardCounter + "' style='margin-bottom: 1.5rem;'><div class='card-header'><h5>Company</h5><input type='text' name='company_" + cardCounter + "' class='form-control' id='company_" + cardCounter + "' placeholder='Enter company name (e.g. Google)'></div><div class='card-body' style='padding-bottom: 0rem;'><h5>Role</h5><input type='text' name='role_" + cardCounter + "' class='form-control' id='role_" + cardCounter + "' placeholder='Enter role (e.g. Business Analyst)'><h5 style='margin-top: 1.5rem;'>Description</h5><textarea type='text' placeholder='Enter your work description' name='work-description_" + cardCounter + "' id='work-description_" + cardCounter + "' class='form-control' rows='4'></textarea><div class='row'><div class='col-lg-6' style='margin-top: 1.5rem;'><h5>Start Date</h5><input type='date' class='form-control' name='start-date_" + cardCounter + "' id='start-date_" + cardCounter + "'></div><div class='col-lg-6' style='margin-top: 1.5rem;'><h5>End Date</h5><input type='date' class='form-control' name='end-date_" + cardCounter + "' id='end-date_" + cardCounter + "'></div></div><br/><button class='btn btn-danger btn-sm' id='delete-work_" + cardCounter + "' onclick='deleteWork()' style='float: right; margin-bottom: 1.5rem;'>Delete</button></div></div>";

        document.getElementById("workList_" + cardCounter).insertAdjacentHTML('afterend', "<div class='accordion' id='workList_" + (cardCounter+1) + "' style='margin-top: 1.5rem;'></div>");
    }

    function saveChanges() {
        document.getElementById("saveChanges").click();
    }

    function deleteWork() {
        let workIdString = event.target.id.split("_");
        let workId = parseInt(workIdString[1]);

        // count number of work cards there are
        let cardCounter = document.querySelectorAll('.task-card').length;

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