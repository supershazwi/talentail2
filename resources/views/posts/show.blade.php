@extends ('layouts.main')

@section ('content')
<form method="POST" action="/blog/posts/toggle-visibility" id="toggleVisibilityPost">
  @csrf
  <input type="hidden" name="post_id" value="{{$post->id}}" />
  <button type="submit" style="display: none;" id="toggleVisibilityPostButton">Submit</button>
</form>

<form method="POST" action="/blog/posts/delete-post" id="deletePost">
  @csrf
  <input type="hidden" name="post_id" value="{{$post->id}}" />
  <button type="submit" style="display: none;" id="deletePostButton">Submit</button>
</form>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8" style="padding-top: 2.5rem;">      
		<div class="card">
			<div class="card-body" style="margin-bottom: -1rem;">
				<img src="https://storage.googleapis.com/talentail-123456789/{{$post->url}}" style="width: 100%; margin-bottom: 1.5rem; border-radius: 5px;"/>
				<h1>{{$post->title}}</h1>
				<div class="avatar-group">
					<a href="{{$post->user->twitter}}" class="avatar avatar-xs">
					<img src="https://storage.googleapis.com/talentail-123456789/avatars/suIjFfp9XX3ntrojqNt9ySuBfo1F4b7LSGx60YyP.png" alt="..." class="avatar-img rounded-circle">
					</a>
				</div>
				<a href="{{$post->user->twitter}}" style="margin-left: 0.5rem !important;">Shazwi Suwandi</a> on {{date_format($post->created_at, 'd F Y')}}
				<div style="margin-top: 1.5rem;">
					@parsedown($post->content)
				</div>
				<hr/>
				<p class="text-muted">Tags: 
					@foreach($tags as $tag)
						<span class="badge badge-primary">{{$tag}}</span>
					@endforeach	
				</p>
			</div>
		</div>
		@if(Auth::user() && Auth::user()->admin)
		@if($post->published)
		<button onclick="toggleVisibility()" class="btn btn-block btn-primary">
		  Make post private
		</button>
		@else
		<button onclick="toggleVisibility()" class="btn btn-block btn-primary">
		  Publish post
		</button>
		@endif
		<a href="/blog/posts/{{$post->slug}}/edit" class="btn btn-block btn-dark">
		  Edit post
		</a>
		<button onclick="deletePost()" class="btn btn-block btn-light">
		  Delete post
		</button>
		<a href="/blog/admin" class="btn btn-block btn-link text-muted">
		  Cancel
		</a>
		@endif

		<div id="disqus_thread" style="padding: 1rem;"></div>
		<script>

		/**
		*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
		*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
		
		var disqus_config = function () {
		this.page.url = "https://talentail.com/tutorials/create-projects";  // Replace PAGE_URL with your page's canonical URL variable
		this.page.identifier = "How do I create projects?"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
		};
		
		(function() { // DON'T EDIT BELOW THIS LINE
		var d = document, s = d.createElement('script');
		s.src = 'https://talentail.disqus.com/embed.js';
		s.setAttribute('data-timestamp', +new Date());
		(d.head || d.body).appendChild(s);
		})();
		</script>
		<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
	</div>
  </div> <!-- / .row -->
</div>

<script type="text/javascript">
	function toggleVisibility() {
		document.getElementById("toggleVisibilityPostButton").click();
	}

	function deletePost() {
		document.getElementById("deletePostButton").click();
	}
</script>
@endsection

@section ('footer')
    
    

@endsection

