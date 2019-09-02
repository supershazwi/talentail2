@extends ('layouts.main')

@section ('content')
  <form method="POST" action="/projects" enctype="multipart/form-data">
    {{ csrf_field() }}

    <div class="form-group">
      <h3>File</h3>
      <input type="file" name="file" class="form-control" id="file" />
    </div>
    
    <button type="submit" class="btn btn-primary" style="float: right;">Upload File</button>
  </form>
@endsection

@section ('footer')
      
@endsection