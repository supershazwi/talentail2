@extends ('layouts.main')

@section ('content')
<input type="hidden" name="workspacePostId" value="{{$workspacePost->id}}" id="workspacePostId" />
<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-10">
      
      <!-- Header -->
      <div class="header mt-md-5">
        <div class="header-body">
          <div class="row align-items-center">
            <div class="col">
              
              <!-- Pretitle -->
              <h6 class="header-pretitle">
                {{$project->title}}
              </h6>

              <!-- Title -->
              <h1 class="header-title">
                Project Workspace
              </h1>

            </div>
          </div> <!-- / .row -->
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          
          <!-- Form -->
          <form method="POST" action="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/workspace" enctype="multipart/form-data">
            @csrf
            <div class="input-group input-group-lg input-group-flush input-group-merge">
              <input type="text" class="form-control form-control-appended" placeholder="Post to project workspace..." name="content">
              <div class="input-group-append" style="margin-right: 0.5rem;">
                <!-- <button class="btn btn-block btn-light" style="border-radius: 5px;">
                  Attach
                </button> -->

                <!-- <input type="file" class="btn btn-light"/> -->
                  <input type="file" name="file-1[]" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple style="visibility: hidden; width: 165px;"/>
                  <label for="file-1" style="position: absolute; margin-left: 1.5rem; border-radius: 0.25rem !important; padding: 0.5rem 1rem 0.5rem 1rem; background: #edf2f9; border-color: #edf2f9; color: #283e59 !important; height: 43.5px !important"> <span style="font-size: 1.15rem; margin-top: 0.5rem !important;">Attach file(s)</span></label>
              </div>
              <div class="input-group-append">
                <button type="submit" class="btn btn-block btn-primary" style="border-radius: 5px;">
                  Submit post
                </button>
              </div>
            </div>
            <div id="selectedFiles">
            </div>
          </form>

        </div>
      </div>

      <div class="card">
        <div class="card-body">
          
          <!-- Header -->
          <div class="mb-3">
            <div class="row align-items-center">
              <div class="col-auto">
                
                <!-- Avatar -->
                <a href="/profile/{{$workspacePost->user_id}}" class="avatar">
                  @if($workspacePost->user->avatar)
                   <img src="https://storage.googleapis.com/talentail-123456789/{{$workspacePost->user->avatar}}" alt="..." class="avatar-img rounded-circle">
                  @else
                  <img src="/img/avatar.png" alt="..." class="avatar-img rounded-circle">
                  @endif
                </a>

              </div>
              <div class="col ml--2">

                <!-- Title -->
                <h4 class="card-title mb-1">
                  {{$workspacePost->user->name}}
                </h4>

                <!-- Time -->
                <p class="card-text small text-muted">
                  <span class="fe fe-clock"></span> <time datetime="2018-05-24">{{$workspacePost->created_at->diffForHumans()}}</time>
                </p>
                
              </div>
              <div class="col-auto">
                
              </div>
            </div> <!-- / .row -->
          </div>

          <!-- Text -->
          <p class="mb-3">
            {{$workspacePost->content}}
          </p>

          @foreach($workspacePost->workspace_post_files as $workspacePostFile)
          <div id="file-group_{{$workspacePostFile->id}}">
            <a href="https://storage.googleapis.com/talentail-123456789/{{$workspacePostFile->url}}">{{$workspacePostFile->title}}</a><br/>
          </div>
          @endforeach

          <!-- Divider -->
          <hr>

          <!-- Comments -->

          @foreach($workspacePost->comments as $comment)
          <div class="comment mb-3">
            <div class="row">
              <div class="col-auto">

                <a href="/profile/{{$comment->user_id}}" class="avatar">
                  @if($comment->user->avatar)
                   <img src="https://storage.googleapis.com/talentail-123456789/{{$comment->user->avatar}}" alt="..." class="avatar-img rounded-circle">
                  @else
                  <img src="/img/avatar.png" alt="..." class="avatar-img rounded-circle">
                  @endif
                </a>

              </div>
              <div class="col ml--2">
                
                <!-- Body -->
                <div class="comment-body" style="display: block;">

                  <div class="row">
                    <div class="col">

                      <!-- Title -->
                      <h5 class="comment-title">
                        {{$comment->user->name}}
                      </h5>

                    </div>
                    <div class="col-auto">

                      <!-- Time -->
                      <time class="comment-time">
                        {{$comment->created_at->diffForHumans()}}
                      </time>

                    </div>
                  </div> <!-- / .row -->

                  <!-- Text -->
                  <p class="comment-text">
                    {{$comment->content}}
                  </p>

                  @foreach($comment->comment_files as $commentFile)
                  <div id="file-group_{{$commentFile->id}}">
                    <a href="https://storage.googleapis.com/talentail-123456789/{{$commentFile->url}}">{{$commentFile->title}}</a><br/>
                  </div>
                  @endforeach 

                </div>

              </div>
            </div> <!-- / .row -->
          </div>
          @endforeach

          <!-- Divider -->
          @if(count($workspacePost->comments) > 0)
          <hr>
          @endif

          <!-- Form -->
          <div class="row align-items-start">
            <div class="col-auto">

              <div class="avatar">
                @if(Auth::user()->avatar)
                 <img src="https://storage.googleapis.com/talentail-123456789/{{Auth::user()->avatar}}" alt="..." class="avatar-img rounded-circle">
                @else
                <img src="/img/avatar.png" alt="..." class="avatar-img rounded-circle">
                @endif
              </div>

            </div>
            <div class="col ml--2">

              <!-- Input -->
              <form method="POST" action="/roles/{{$project->role->slug}}/projects/{{$project->slug}}/workspace/{{$workspacePost->id}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="comment" />
                <input type="hidden" name="workspacePostId" value="{{$workspacePost->id}}" />
                <label class="sr-only">Leave a comment...</label>
                <textarea class="form-control" placeholder="Leave a comment" rows="2" name="content"></textarea>

                <div id="workspaceFiles_{{$workspacePost->id}}" style="width: 45% important; margin-top: 1rem !important; float: left;"></div>

                <div style="float: right;">
                  <input type="file" name="workspacePost_{{$workspacePost->id}}[]" id="workspacePost_{{$workspacePost->id}}" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple style="visibility: hidden; width: 165px;"/>
                  <label for="workspacePost_{{$workspacePost->id}}" style="position: absolute; margin-left: -8rem; margin-top: 1rem; border-radius: 0.25rem !important; padding: 0.5rem 1rem 0.5rem 1rem; background: #edf2f9; border-color: #edf2f9; color: #283e59 !important; height: 40px !important"> <span style="font-size: 0.9375rem; margin-top: 0.5rem !important;">Attach file(s)</span></label>

                  <button type="submit" class="btn btn-primary" style="margin-top: 1rem; border-radius: 5px;">
                    Submit comment
                  </button>
                </div>
              </form>

            </div>
          </div> <!-- / .row -->

        </div>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">

  var workspacePostId = document.getElementById("workspacePostId").value;

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var selDiv = "";
  var selCommentsDiv = "";

  document.addEventListener("DOMContentLoaded", init, false);

  function init() {
    document.querySelector('#workspacePost_' + workspacePostId).addEventListener('change', handleWorkspacePostFileSelect, false);
  }

  function handleWorkspacePostFileSelect(e) {
    if(!e.target.files) return;

    var idString = e.target.id.split("_");
    var idFromString = idString[1];

    // console.log('workspacePost_' + idFromString);

    document.getElementById('workspaceFiles_' + idFromString).innerHTML = "";
    var files = e.target.files;
    for(var i=0; i<files.length; i++) {
      var f = files[i];
      document.getElementById('workspaceFiles_' + idFromString).innerHTML += f.name + "<br/>";
    }
  }
</script>

@endsection

@section ('footer')
@endsection