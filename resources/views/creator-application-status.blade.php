@extends ('layouts.main')

@section ('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8">
      
      <!-- Header -->
      <div class="header mt-md-5">
        <div class="header-body">

          <h6 class="header-pretitle">
            Creator Application Status
          </h6>

          <!-- Title -->
          <h1 class="header-title">
            {{$creatorApplication->user->name}}
          </h1>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <strong>Status:</strong>
          <p><span class="badge badge-warning">{{$creatorApplication->status}}</span></p>
          <strong>Description:</strong> 
          <p>{{$creatorApplication->description}}</p>
          <strong>Submitted Files:</strong> 
          @foreach($creatorApplication->creator_application_files as $file) 
            @if($loop->last)
            <p style="margin-bottom: 0;"><a href="https://storage.googleapis.com/talentail-123456789/{{$file->url}}" download="{{$file->title}}">{{$file->title}}</a></p>
            @else
            <p><a href="https://storage.googleapis.com/talentail-123456789/{{$file->url}}" download="{{$file->title}}">{{$file->title}}</a></p>
            @endif
          @endforeach
        </div>
      </div>

    </div>
  </div> <!-- / .row -->
</div>

@endsection

@section ('footer')

@endsection