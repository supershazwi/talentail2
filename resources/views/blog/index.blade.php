@extends ('layouts.main')

@section ('content')
<div class="container">
<div class="row">
    <div class="col-12 col-lg-12 col-xl-12">
      
      <!-- Header -->
      <div class="header mt-md-5">
        <div class="header-body">

          <h6 class="header-pretitle">
            Overview
          </h6>

          <!-- Title -->
          <h1 class="header-title" style="display: inline-block; height: 100%; margin-top: 5px;">
            Blog Posts
          </h1>
        </div>
      </div>
     </div>
 </div>
  <div class="row">
      @foreach($posts as $post)
      <div class="col-12 col-md-6 col-xl-4">
      	<div class="card">
      	  <a href="/blog/posts/{{$post->slug}}">
      	    <img src="https://storage.googleapis.com/talentail-123456789/{{$post->url}}" alt="..." class="card-img-top">
      	  </a>
      	  <div class="card-body">
      	    <div class="row align-items-center">
      	      <div class="col">
      	    
      	        <!-- Title -->
      	        
      	        <a href="/blog/posts/{{$post->slug}}"><h2 class="card-title mb-2 name">{{$post->title}}</h2></a>
      	        <p style="overflow: hidden;display: -webkit-box;-webkit-line-clamp: 3;-webkit-box-orient: vertical;">{{$post->content}}</p>
      	        <div class="avatar-group">
      	        	<a href="/profile" class="avatar avatar-xs">
      	        	<img src="https://storage.googleapis.com/talentail-123456789/avatars/suIjFfp9XX3ntrojqNt9ySuBfo1F4b7LSGx60YyP.png" alt="..." class="avatar-img rounded-circle">
      	        	</a>
      	        </div>
      	        <a href="/profile" style="margin-left: 0.5rem !important;">Shazwi Suwandi</a>
      	      </div>
      	    </div> <!-- / .row -->

      	    <!-- Divider -->
      	    <hr>

      	    <div class="row align-items-center">
      	      <div class="col">
      	        
      	        <!-- Time -->
      	        <p class="card-text small text-muted">
      	          {{date_format($post->created_at, 'd F Y')}}
      	        </p>

      	      </div>
      	    </div> <!-- / .row -->
      	  </div> <!-- / .card-body -->
      	</div>
      </div>
      @endforeach
  </div> <!-- / .row -->
</div>
@endsection

@section ('footer')
    
    

@endsection