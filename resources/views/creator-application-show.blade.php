@extends ('layouts.main')

@section ('content')

<form method="POST" action="/creator-applications/update-status" type="hidden">
  @csrf
  <input type="hidden" name="status" id="status"/>
  <input type="hidden" name="creator_application_id" value="{{$creatorApplication->id}}" />
  <button type="submit" style="display: none;" id="updateCreatorApplicationStatus">Submit</button>
</form>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8">
      
      <!-- Header -->
      <div class="header mt-md-5">
        <div class="header-body">

          <h6 class="header-pretitle">
            Creator Application
          </h6>

          <!-- Title -->
          <a href="/profile/{{$creatorApplication->user->id}}"><h1 class="header-title">
            {{$creatorApplication->user->name}}
          </h1></a>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <strong>Description:</strong> 
          <p>{{$creatorApplication->description}}</p>
          <strong>Submitted Files:</strong> 
          @foreach($creatorApplication->creator_application_files as $file) 
            @if($loop->last)
            <p style="margin-bottom: 0;"><a href="#">{{$file->title}}</a></p>
            @else
            <p><a href="#">{{$file->title}}</a></p>
            @endif
          @endforeach
        </div>
      </div>

      @if($creatorApplication->status!="approved1")
      <button class="btn btn-light" role="button" onclick="rejectApplication()">
          Reject Application
      </button>
      <button class="btn btn-primary" role="button" onclick="approveApplication()">
          Approve Application
      </button>
      @endif
    </div>
  </div> <!-- / .row -->
</div>

<script type="text/javascript">
  function rejectApplication() {
    document.getElementById("status").value = "rejected";
    document.getElementById("updateCreatorApplicationStatus").click();
  }

  function approveApplication() {
    document.getElementById("status").value = "approved1";
    document.getElementById("updateCreatorApplicationStatus").click();
  }
</script>

@endsection

@section ('footer')

@endsection