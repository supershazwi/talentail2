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
          <a href="/blog/add" class="btn btn-primary d-block d-md-inline-block" style="float: right; display: inline-block;">
            Add Post
          </a>
        </div>
      </div>

      <!-- Card -->
      <div class="card">
          <table class="table table-nowrap" style="margin-bottom: 0;">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Tags</th>
                <th scope="col">Author</th>
                <th scope="col">Published</th>
                <th scope="col">Date Created</th>
              </tr>
            </thead>
            <tbody>
              @foreach($posts as $key=>$post)
              <tr>
              	<td>{{$key+1}}</td>
              	<td><a href="/blog/posts/{{$post->slug}}">{{$post->title}}</a></td>
              	<td>{{$post->tags}}</td>
              	<td>{{$post->user->name}}</td>
              	<td>{{$post->published}}</td>
              	<td>{{date_format($post->created_at, 'd F Y')}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
      </div>
    </div>
  </div> <!-- / .row -->
</div>
@endsection

@section ('footer')
    
    

@endsection

