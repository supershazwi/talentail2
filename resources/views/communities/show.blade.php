@extends ('layouts.main')

@section ('content')
@if(Auth::user())
<input type="hidden" id="userId" value="{{Auth::id()}}" />
@endif

<div class="container">
  <div class="row" style="margin-top: 1.5rem;">
    <div class="col-lg-9">
        @if(count($communityPosts) > 0)
        <div class="card">
          <div class="card-body">
            @foreach($communityPosts as $communityPost)
              <h3 style="margin-bottom: 0rem; float: left;">
                <a href="#" style="margin-right: 0.25rem;" id="community-post_{{$communityPost->id}}" onclick="upvoteCommunityPost()">
                  @if(!empty($voteArray[$communityPost->id]) && $voteArray[$communityPost->id] == 'u')
                  <i class="fas fa-arrow-up" id="community-post-upvote_{{$communityPost->id}}" style="color: #2c7be5;"></i>
                  @else
                  <i class="fas fa-arrow-up" id="community-post-upvote_{{$communityPost->id}}"></i>
                  @endif
                </a>
                <span id="community-score_{{$communityPost->id}}">{{$communityPost->score}}</span> 
                <a href="#" style="margin-left: 0.25rem;" id="community-post_{{$communityPost->id}}" onclick="downvoteCommunityPost()">
                  @if(!empty($voteArray[$communityPost->id]) && $voteArray[$communityPost->id] == 'd')
                  <i class="fas fa-arrow-down" id="community-post-downvote_{{$communityPost->id}}" style="color: #e74c3c;"></i>
                  @else
                  <i class="fas fa-arrow-down" id="community-post-downvote_{{$communityPost->id}}"></i>
                  @endif
                </a>
              </h3>
              <h3 style="margin-left: 5rem; margin-bottom: 0.5rem;">
                <a href="/communities/{{$community->slug}}/posts/{{$communityPost->id}}">{{$communityPost->title}}</a>
              </h3>
              <a href="/profile/{{$communityPost->user->id}}" style="margin-left: 5rem;" class="text-muted">{{$communityPost->user->name}}</a>, {{$communityPost->created_at->diffForHumans()}}
              @if(!$loop->last)
                <hr/>
              @endif
            @endforeach
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12" style="justify-content: center;">
            {{ $communityPosts->links() }}
          </div>
        </div>
        @else
        <div class="card">
          <div class="card-body">
            <div class="row justify-content-center" style="margin-top:1rem;">
              <div class="col-12 col-md-5 col-xl-4 my-5" style="text-align: center;">
                <p class="text-center mb-5" style="font-size: 2rem; margin-bottom: 0.25rem !important; -webkit-transform: scaleX(-1); transform: scaleX(-1);">😅</p>
                <p style="margin-bottom: 2.25rem !important;"> Feels really empty here. Create a post.
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
          <form id="subscribeForm" method="POST" action="/communities/{{$community->slug}}/subscribe" enctype="multipart/form-data">
            @csrf
            <button type="submit" class="btn btn-primary btn-block" id="subscribe">Subscribe</button>
          </form>
          @endif
          <a href="/communities/{{$community->slug}}/create-post" class="btn btn-block btn-light" style="margin-top: 0.5rem;">Create Post</a>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="http://code.jquery.com/jquery-3.3.1.min.js"
               integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
               crossorigin="anonymous">
      </script>
      <script>

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
                    } else {
                      document.getElementById("community-post-downvote_"+communityPostIdString[1]).style.color = "#e74c3c";
                      document.getElementById("community-post-upvote_"+communityPostIdString[1]).style.color = "#12263f";
                      document.getElementById("community-score_"+communityPostIdString[1]).innerHTML=result[1];
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