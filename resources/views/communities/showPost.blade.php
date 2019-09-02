@extends ('layouts.main')

@section ('content')
@if(Auth::user())
<input type="hidden" id="userId" value="{{Auth::id()}}" />
<input type="hidden" name="communityPostCommentsArray" value="{{$communityPostCommentsArray}}" id="communityPostCommentsArray" />

<form method="POST" id="deleteCommunityPostCommentForm">
  @csrf
  <input type="hidden" name="community-post-comment-id" id="community-post-comment-id" value="" />
  <input type="hidden" name="community-post-id" value="{{$communityPost->id}}" />
  <input type="hidden" name="community-slug" value="{{$communityPost->community->slug}}" />
  <button type="submit" style="display: none;" id="deleteCommunityPostCommentButton">Submit</button>
</form>

@endif
<div class="container">
  <div class="row" style="margin-top: 1.5rem;">
    <div class="col-lg-9">
        <div class="card">
          <div class="card-body">
            <h3 style="margin-bottom: 0rem; float: left;">
              <a href="#" style="margin-right: 0.25rem;" id="community-post_{{$communityPost->id}}" onclick="upvoteCommunityPost()">
                @if($communityTopPostVote != null && $communityTopPostVote == 'u')
                <i class="fas fa-arrow-up" id="community-post-upvote_{{$communityPost->id}}" style="color: #2c7be5;"></i>
                @else
                <i class="fas fa-arrow-up" id="community-post-upvote_{{$communityPost->id}}"></i>
                @endif
              </a>
              <span id="community-score_{{$communityPost->id}}">{{$communityPost->score}}</span> 
              <a href="#" style="margin-left: 0.25rem;" id="community-post_{{$communityPost->id}}" onclick="downvoteCommunityPost()">
                @if($communityTopPostVote != null && $communityTopPostVote == 'd')
                <i class="fas fa-arrow-down" id="community-post-downvote_{{$communityPost->id}}" style="color: #e74c3c;"></i>
                @else
                <i class="fas fa-arrow-down" id="community-post-downvote_{{$communityPost->id}}"></i>
                @endif
              </a>
            </h3>
            <h3 style="margin-left: 5rem; margin-bottom: 0.5rem;">{{$communityPost->title}}</h3>
            <div style="margin-left: 5rem;">
              @parsedown($communityPost->description)
              @foreach($communityPost->community_post_files as $communityPostFile)
                @if($loop->last)
                <p><a href="https://storage.googleapis.com/talentail-123456789/{{$communityPostFile->url}}">{{$communityPostFile->title}}</a></p>
                @else
                <p style="margin-bottom: 0.25rem;"><a href="https://storage.googleapis.com/talentail-123456789/{{$communityPostFile->url}}">{{$communityPostFile->title}}</a></p>
                @endif
              @endforeach
              <div class="row">
                <div class="col">
                  <span onclick="showTopCommentBox()" class="pointer text-muted">Reply</span>
                  @if(Auth::id() && $communityPost->user_id == Auth::id())
                    | <span onclick="deleteCommunityPost()" class="pointer text-muted" id="delete-community-post_{{$communityPost->id}}">Delete</span> 
                  @endif
                </div>
                <div class="col" style="text-align: right;">
                  <a href="/profile/{{$communityPost->user->id}}" class="text-muted">{{$communityPost->user->name}}</a>, {{$communityPost->created_at->diffForHumans()}}
                </div>
              </div> 
              <div class="row" style="margin-top: 1.5rem; display: none;" id="topCommentBox">
                <div class="col">
                  <form action="/community-post/{{$communityPost->id}}/create-comment" method="POST" class="mb-4" enctype="multipart/form-data" style="margin-bottom: 0rem !important;">
                  @csrf
                    <textarea class="form-control" name="content" id="topCommentTextareaBox" rows="5" placeholder="Write your comment..." style="resize: none;" autofocus></textarea>
                    <div class="row">
                      <div class="col-lg-5">
                        <div id="selectedFiles" style="margin-top: 0.5rem;">
                        </div>
                      </div>
                      <div class="col">
                        <button class="btn btn-primary" style="margin-top: 0.5rem; float: right;">Comment</button>
                        <input type="file" name="topFile[]" id="topFile" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple style="display: none;"/>
                        <label for="topFile" class="btn btn-light" style="float: right; margin-top: 0.5rem; margin-right: 0.5rem;"> <span style="font-size: .9375rem;">Attach file(s)</span></label>
                        <button class="btn btn-default" style="margin-top: 0.5rem; margin-right: 0.5rem; float: right;" onclick="cancelCommentBox2()">Cancel</button>
                      </div>
                    </div>

                    <input type="hidden" name="communitySlug" value="{{$communityPost->community->slug}}" />
                    <input type="hidden" name="communityPostId" value="{{$communityPost->id}}" />
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

        @if(count($communityPost->community_post_comments) > 0)
          <h3>Comments</h3>
          @foreach($communityPost->community_post_comments->sortByDesc('created_at') as $communityPostComment)
          <div class="card">
            <div class="card-body">
              <h3 style="margin-bottom: 0rem; float: left;">
                <a href="#" style="margin-right: 0.25rem;" id="community-post-comment_{{$communityPostComment->id}}" onclick="upvoteCommunityPostComment()">
                  @if(!empty($voteArray[$communityPostComment->id]) && $voteArray[$communityPostComment->id] == 'u')
                  <i class="fas fa-arrow-up" id="community-post-comment-upvote_{{$communityPostComment->id}}" style="color: #2c7be5;"></i>
                  @else
                  <i class="fas fa-arrow-up" id="community-post-comment-upvote_{{$communityPostComment->id}}"></i>
                  @endif
                </a>
                <span id="community-post-comment-score_{{$communityPostComment->id}}">{{$communityPostComment->score}}</span> 
                <a href="#" style="margin-left: 0.25rem;" id="community-post-comment_{{$communityPostComment->id}}" onclick="downvoteCommunityPostComment()">
                  @if(!empty($voteArray[$communityPostComment->id]) && $voteArray[$communityPostComment->id] == 'd')
                  <i class="fas fa-arrow-down" id="community-post-comment-downvote_{{$communityPostComment->id}}" style="color: #e74c3c;"></i>
                  @else
                  <i class="fas fa-arrow-down" id="community-post-comment-downvote_{{$communityPostComment->id}}"></i>
                  @endif
                </a>
              </h3>
              <div style="margin-left: 5rem;">
                <p>{{$communityPostComment->content}}</p>
                @foreach($communityPostComment->community_post_comment_files as $communityPostCommentFile)
                  @if($loop->last)
                  <p><a href="https://storage.googleapis.com/talentail-123456789/{{$communityPostCommentFile->url}}">{{$communityPostCommentFile->title}}</a></p>
                  @else
                  <p style="margin-bottom: 0.25rem;"><a href="https://storage.googleapis.com/talentail-123456789/{{$communityPostCommentFile->url}}">{{$communityPostCommentFile->title}}</a></p>
                  @endif
                @endforeach
                <div class="row">
                  <div class="col">
                    <!-- <a href="#" id="community-post-comment_{{$communityPostComment->id}}" onclick="showCommentBox()" class="text-muted">Reply</a> -->
                    <span id="community-post-comment_{{$communityPostComment->id}}" onclick="showCommentBox()" class="text-muted pointer" style="margin-bottom: 0rem;">Reply</span>
                    @if(Auth::id() && $communityPostComment->user_id == Auth::id())
                      | <span id="delete-community-post-comment_{{$communityPostComment->id}}" onclick="deleteCommunityPostComment()" class="pointer text-muted">Delete</span> 
                    @endif
                  </div>
                  <div class="col" style="text-align: right;">
                    <a href="/profile/{{$communityPostComment->user->id}}" class="text-muted">{{$communityPostComment->user->name}}</a>, {{$communityPostComment->created_at->diffForHumans()}}
                  </div>
                </div> 
                <div class="row" style="margin-top: 1.5rem; display: none;" id="commentBox_{{$communityPostComment->id}}">
                  <div class="col">
                    <form action="/community-post-comment/{{$communityPostComment->id}}/create-comment" method="POST" class="mb-4" enctype="multipart/form-data" style="margin-bottom: 0rem !important;">
                    @csrf
                      <textarea class="form-control" name="content" id="textareaCommentBox_{{$communityPostComment->id}}" rows="5" placeholder="Write your comment..." style="resize: none;" autofocus></textarea>
                      
                      <div class="row">
                        <div class="col-lg-5">
                          <div id="selectedFiles_{{$communityPostComment->id}}" style="margin-top: 0.5rem;">
                          </div>
                        </div>
                        <div class="col">
                          <button class="btn btn-primary" style="margin-top: 0.5rem; float: right;">Comment</button>
                          <input type="file" name="file_{{$communityPostComment->id}}[]" id="file_{{$communityPostComment->id}}" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple style="display: none;"/>
                          <label for="file_{{$communityPostComment->id}}" class="btn btn-light" style="float: right; margin-top: 0.5rem; margin-right: 0.5rem;"> <span style="font-size: .9375rem;">Attach file(s)</span></label>
                          <button class="btn btn-default" style="margin-top: 0.5rem; margin-right: 0.5rem; float: right;" onclick="cancelCommentBox()" id="cancelCommentBox_{{$communityPostComment->id}}">Cancel</button>
                        </div>
                      </div>

                      <input type="hidden" name="communitySlug" value="{{$communityPostComment->community_post->community->slug}}" />
                      <input type="hidden" name="communityPostCommentId" value="{{$communityPostComment->id}}" />
                      <input type="hidden" name="communityPostId" value="{{$communityPost->id}}" />
                    </form>
                  </div>
                </div>
              </div>
              @foreach($communityPostComment->nested_comments as $nestedComment)
              <div style="margin-top: 1.5rem; margin-left: 1.5rem;">
                <h3 style="margin-bottom: 0rem; float: left;">
                  <a href="#" style="margin-right: 0.25rem;" id="community-post-comment_{{$nestedComment->id}}" onclick="upvoteCommunityPostComment()">
                    @if(!empty($voteArray[$nestedComment->id]) && $voteArray[$nestedComment->id] == 'u')
                    <i class="fas fa-arrow-up" id="community-post-comment-upvote_{{$nestedComment->id}}" style="color: #2c7be5;"></i>
                    @else
                    <i class="fas fa-arrow-up" id="community-post-comment-upvote_{{$nestedComment->id}}"></i>
                    @endif
                  </a>
                  <span id="community-post-comment-score_{{$nestedComment->id}}">{{$nestedComment->score}}</span> 
                  <a href="#" style="margin-left: 0.25rem;" id="community-post-comment_{{$nestedComment->id}}" onclick="downvoteCommunityPostComment()">
                    @if(!empty($voteArray[$nestedComment->id]) && $voteArray[$nestedComment->id] == 'd')
                    <i class="fas fa-arrow-down" id="community-post-comment-downvote_{{$nestedComment->id}}" style="color: #e74c3c;"></i>
                    @else
                    <i class="fas fa-arrow-down" id="community-post-comment-downvote_{{$nestedComment->id}}"></i>
                    @endif
                  </a>
                </h3>
                <div style="margin-left: 5rem;">
                  <p>{{$nestedComment->content}}</p>
                  @foreach($nestedComment->community_post_comment_files as $communityPostCommentFile)
                    @if($loop->last)
                    <p><a href="https://storage.googleapis.com/talentail-123456789/{{$communityPostCommentFile->url}}">{{$communityPostCommentFile->title}}</a></p>
                    @else
                    <p style="margin-bottom: 0.25rem;"><a href="https://storage.googleapis.com/talentail-123456789/{{$communityPostCommentFile->url}}">{{$communityPostCommentFile->title}}</a></p>
                    @endif
                  @endforeach
                  <div class="row">
                    <div class="col">
                      <span id="community-post-comment_{{$nestedComment->id}}" onclick="showCommentBox()" class="pointer text-muted">Reply</span> 
                      @if(Auth::id() && $nestedComment->user_id == Auth::id())
                        | <span id="delete-community-post-comment_{{$nestedComment->id}}" onclick="deleteCommunityPostComment()" class="pointer text-muted">Delete</span> 
                      @endif
                    </div>
                    <div class="col" style="text-align: right;">
                      <a href="/profile/{{$nestedComment->user->id}}" class="text-muted">{{$nestedComment->user->name}}</a>, {{$nestedComment->created_at->diffForHumans()}}
                    </div>
                  </div>
                  <div class="row" style="margin-top: 1.5rem; display: none;" id="commentBox_{{$nestedComment->id}}">
                    <div class="col">
                      <form action="/community-post-comment/{{$communityPostComment->id}}/create-comment" method="POST" class="mb-4" enctype="multipart/form-data" style="margin-bottom: 0rem !important;">
                        @csrf
                        <textarea class="form-control" name="content" id="textareaCommentBox_{{$nestedComment->id}}" rows="5" placeholder="Write your comment..." style="resize: none;" autofocus></textarea>
                        <div class="row">
                          <div class="col-lg-5">
                            <div id="selectedFiles_{{$nestedComment->id}}" style="margin-top: 0.5rem;">
                            </div>
                          </div>
                          <div class="col">
                            <button class="btn btn-primary" style="margin-top: 0.5rem; float: right;">Comment</button>
                            <input type="file" name="file_{{$nestedComment->id}}[]" id="file_{{$nestedComment->id}}" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple style="display: none;"/>
                            <label for="file_{{$nestedComment->id}}" class="btn btn-light" style="float: right; margin-top: 0.5rem; margin-right: 0.5rem;"> <span style="font-size: .9375rem;">Attach file(s)</span></label>
                            <button class="btn btn-default" style="margin-top: 0.5rem; margin-right: 0.5rem; float: right;" onclick="cancelCommentBox()" id="cancelCommentBox_{{$nestedComment->id}}">Cancel</button>
                          </div>
                        </div>

                        <input type="hidden" name="nestedCommentId" value="{{$nestedComment->id}}" />
                        <input type="hidden" name="communitySlug" value="{{$communityPostComment->community_post->community->slug}}" />
                        <input type="hidden" name="communityPostCommentId" value="{{$communityPostComment->id}}" />
                        <input type="hidden" name="communityPostId" value="{{$communityPost->id}}" />
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
          @endforeach
        @else
          <div class="card">
            <div class="card-body">
              <div class="row justify-content-center" style="margin-top:1rem;">
                <div class="col-12 col-md-5 col-xl-4 my-5" style="text-align: center;">
                  <p class="text-center mb-5" style="font-size: 2rem; margin-bottom: 0.25rem !important; -webkit-transform: scaleX(-1); transform: scaleX(-1);">😅</p>
                  <p style="margin-bottom: 2.25rem !important;"> Feels really empty here. Leave a comment.
                  </p>
                </div>
              </div>
            </div>
          </div>
        @endif
    </div>
    <div class="col-lg-3">
      <div class="card">
        <div class="card-body">
          <h3>{{$community->title}}</h3>
          <p>{{$community->description}}</p>

          @if($subscribed)
            <button class="btn btn-primary btn-block" id="subscribed" disabled>Subscribed</button>
          @else
          <form id="subscribeForm" method="POST" action="/communities/{{$community->slug}}/subscribe" enctype="multipart/form-data" style="margin-bottom: 0.5rem;">
            @csrf
            <button type="submit" class="btn btn-primary btn-block" id="subscribe">Subscribe</button>
          </form>
          @endif
          <a href="/communities/{{$community->slug}}/create-post" class="btn btn-block btn-light">Create Post</a>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  var communityPostCommentsArray = document.getElementById("communityPostCommentsArray").value.split(",");
  var selDiv = "";
  
  document.addEventListener("DOMContentLoaded", init, false);
  
  function init() {
    document.querySelector('#topFile').addEventListener('change', handleFileSelect, false);
    selDiv = document.querySelector("#selectedFiles");

    for(var l=0; l<communityPostCommentsArray.length; l++) {
      var communityPostCommentId = communityPostCommentsArray[l];
      document.querySelector('#file_' + communityPostCommentId).addEventListener('change', handleFile2Select, false);
    }
  }

  function handleFileSelect(e) {
    console.log("handleFileSelect");
    if(!e.target.files) return;
    selDiv.innerHTML = "";
    
    var files = e.target.files;
    for(var i=0; i<files.length; i++) {
      var f = files[i];
      
      selDiv.innerHTML += f.name + "<br/>";
    }
  }

  function handleFile2Select(e) {
    console.log("handleFile2Select");
    if(!e.target.files) return;

    var idString = e.target.id.split("_");
    var idFromString = idString[1];

    document.getElementById('selectedFiles_' + idFromString).innerHTML = "";
    var files = e.target.files;
    for(var i=0; i<files.length; i++) {
      var f = files[i];
      document.getElementById('selectedFiles_' + idFromString).innerHTML += f.name + "<br/>";
    }
  }

  function showTopCommentBox() {
    if(document.getElementById('userId') == null) {
      window.location.href = "/login";
    } else {
      document.getElementById("topCommentBox").style.display = "block";
    }
  }

  function cancelCommentBox2() {
    event.preventDefault();

    // empty the textarea
    document.getElementById("topCommentTextareaBox").value = '';

    document.getElementById("topCommentBox").style.display = "none";
  }

  function showCommentBox() {
    if(document.getElementById('userId') == null) {
      window.location.href = "/login";
    } else {
      let commentBoxIdString = event.target.id.split("_");

      document.getElementById("commentBox_"+commentBoxIdString[1]).style.display = "block"; 
    }
  }

  function cancelCommentBox() {
    event.preventDefault();

    let commentBoxIdString = event.target.id.split("_");

    // empty the textarea
    document.getElementById("textareaCommentBox_"+commentBoxIdString[1]).value = '';

    document.getElementById("commentBox_"+commentBoxIdString[1]).style.display = "none";

    document.getElementById("selectedFiles_"+commentBoxIdString[1]).innerHTML = "";

    document.getElementById("file_"+commentBoxIdString[1]).value = "";
  }
</script>

<script src="http://code.jquery.com/jquery-3.3.1.min.js"
               integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
               crossorigin="anonymous">
</script>
<script>
      function deleteCommunityPost() {
        event.preventDefault();
        let communityPostIdString = event.target.id.split("_");

        document.getElementById("deleteCommunityPostCommentForm").action = "/delete-community-post/"+communityPostIdString[1];

        document.getElementById("deleteCommunityPostCommentButton").click();
      }

      function deleteCommunityPostComment() {
        event.preventDefault();
        let communityPostIdString = event.target.id.split("_");

        document.getElementById("deleteCommunityPostCommentForm").action = "/delete-community-post-comment/"+communityPostIdString[1];
        document.getElementById("community-post-comment-id").value = communityPostIdString[1];

        document.getElementById("deleteCommunityPostCommentButton").click();
      }

      function upvoteCommunityPost() {
        event.preventDefault();
        let communityPostIdString = event.target.id.split("_");

        if(document.getElementById('userId') == null) {
          window.location.href = "/login";
        } 

         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

         jQuery.ajax({
            url: "/community-post/"+communityPostIdString[1]+"/upvote",
            method: 'post',
            data: {
               communityPostId: communityPostIdString[1],
               userId: document.getElementById('userId').value
            },
            success: function(result){
              if(result[0] == "upvote") {
                document.getElementById("community-post-upvote_"+communityPostIdString[1]).style.color = "#2c7be5";
                document.getElementById("community-post-downvote_"+communityPostIdString[1]).style.color = "#12263f";
                document.getElementById("community-score_"+communityPostIdString[1]).innerHTML=result[1];
              } else if(result[0] == "neutral") {
                document.getElementById("community-post-upvote_"+communityPostIdString[1]).style.color = "#12263f";
                document.getElementById("community-post-downvote_"+communityPostIdString[1]).style.color = "#12263f";
                document.getElementById("community-score_"+communityPostIdString[1]).innerHTML=result[1];
              } else if(result[0] == "downvote") {
                document.getElementById("community-post-downvote_"+communityPostIdString[1]).style.color = "#e74c3c";
                document.getElementById("community-post-upvote_"+communityPostIdString[1]).style.color = "#12263f";
                document.getElementById("community-score_"+communityPostIdString[1]).innerHTML=result[1];
              } else {
                console.log(result);
              }
            }});
      } 

      function upvoteCommunityPostComment() {
        event.preventDefault();
        let communityPostCommentIdString = event.target.id.split("_");

        if(document.getElementById('userId') == null) {
          window.location.href = "/login";
        } 
         

         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

         jQuery.ajax({
            url: "/community-post-comment/"+communityPostCommentIdString[1]+"/upvote",
            method: 'post',
            data: {
               communityPostCommentId: communityPostCommentIdString[1],
               userId: document.getElementById('userId').value
            },
            success: function(result){
              if(result[0] == "upvote") {
                document.getElementById("community-post-comment-upvote_"+communityPostCommentIdString[1]).style.color = "#2c7be5";
                document.getElementById("community-post-comment-downvote_"+communityPostCommentIdString[1]).style.color = "#12263f";
                document.getElementById("community-post-comment-score_"+communityPostCommentIdString[1]).innerHTML=result[1];
              } else if(result[0] == "neutral") {
                document.getElementById("community-post-comment-upvote_"+communityPostCommentIdString[1]).style.color = "#12263f";
                document.getElementById("community-post-comment-downvote_"+communityPostCommentIdString[1]).style.color = "#12263f";
                document.getElementById("community-post-comment-score_"+communityPostCommentIdString[1]).innerHTML=result[1];
              } else if(result[0] == "downvote") {
                document.getElementById("community-post-comment-downvote_"+communityPostCommentIdString[1]).style.color = "#e74c3c";
                document.getElementById("community-post-comment-upvote_"+communityPostCommentIdString[1]).style.color = "#12263f";
                document.getElementById("community-post-comment-score_"+communityPostCommentIdString[1]).innerHTML=result[1];
              } else {
                console.log(result);
              }
            }});
      } 

      function downvoteCommunityPostComment() {
        event.preventDefault();

        if(document.getElementById('userId') == null) {
          window.location.href = "/login";
        } 

        let communityPostCommentIdString = event.target.id.split("_");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

         jQuery.ajax({
            url: "/community-post-comment/"+communityPostCommentIdString[1]+"/downvote",
            method: 'post',
            data: {
               communityPostCommentId: communityPostCommentIdString[1],
               userId: document.getElementById('userId').value
            },
            success: function(result){
              if(result[0] == "upvote") {
                document.getElementById("community-post-comment-upvote_"+communityPostCommentIdString[1]).style.color = "#2c7be5";
                document.getElementById("community-post-comment-downvote_"+communityPostCommentIdString[1]).style.color = "#12263f";
                document.getElementById("community-post-comment-score_"+communityPostCommentIdString[1]).innerHTML=result[1];
              } else if(result[0] == "neutral") {
                document.getElementById("community-post-comment-upvote_"+communityPostCommentIdString[1]).style.color = "#12263f";
                document.getElementById("community-post-comment-downvote_"+communityPostCommentIdString[1]).style.color = "#12263f";
                document.getElementById("community-post-comment-score_"+communityPostCommentIdString[1]).innerHTML=result[1];
              } else  if(result[0] == "downvote") {
                document.getElementById("community-post-comment-downvote_"+communityPostCommentIdString[1]).style.color = "#e74c3c";
                document.getElementById("community-post-comment-upvote_"+communityPostCommentIdString[1]).style.color = "#12263f";
                document.getElementById("community-post-comment-score_"+communityPostCommentIdString[1]).innerHTML=result[1];
              } else {
                console.log(result);
              }
            }});
      } 

      function downvoteCommunityPost() {
        event.preventDefault();
        let communityPostIdString = event.target.id.split("_");
        
         if(document.getElementById('userId') == null) {
          window.location.href = "/login";
        } 

         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

         jQuery.ajax({
            url: "/community-post/"+communityPostIdString[1]+"/downvote",
            method: 'post',
            data: {
               communityPostId: communityPostIdString[1],
               userId: document.getElementById('userId').value
            },
            success: function(result){
               if(result[0] == "upvote") {
                document.getElementById("community-post-upvote_"+communityPostIdString[1]).style.color = "#2c7be5";
                document.getElementById("community-post-downvote_"+communityPostIdString[1]).style.color = "#12263f";
                document.getElementById("community-score_"+communityPostIdString[1]).innerHTML=result[1];
              } else if(result[0] == "neutral") {
                document.getElementById("community-post-upvote_"+communityPostIdString[1]).style.color = "#12263f";
                document.getElementById("community-post-downvote_"+communityPostIdString[1]).style.color = "#12263f";
                document.getElementById("community-score_"+communityPostIdString[1]).innerHTML=result[1];
              } else {
                document.getElementById("community-post-downvote_"+communityPostIdString[1]).style.color = "#e74c3c";
                document.getElementById("community-post-upvote_"+communityPostIdString[1]).style.color = "#12263f";
                document.getElementById("community-score_"+communityPostIdString[1]).innerHTML=result[1];
              }
            }});
      } 

</script>
<!-- End of Async Drift Code -->
<!-- End of HubSpot Embed Code --> 
@endsection

@section ('footer')   
@endsection