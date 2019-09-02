@extends ('layouts.main')

@section ('content')
<div class="container">
  <div class="row">
    <div class="col-12 col-lg-12 col-xl-12">
      
      <!-- Header -->
      <div class="header mt-md-5">
        @if (session('selectCategorySelected'))
        <div class="alert alert-warning" role="alert" style="text-align: center;">
          <h4 class="alert-heading" style="margin-bottom: 0;">{{session('selectCategorySelected')}}</h4>
        </div>
        @endif
        <div class="header-body">
          <!-- Title -->
          <h1 class="header-title">
            Select Category
          </h1>
        </div>
      </div>

      <!-- Card -->

    </div>
  </div> <!-- / .row -->
  <div class="row">
    <div class="col-12 col-lg-12 col-xl-12">
      <div class="row align-items-center">
        <div class="col">
          <p>Select the category that you are creating this task for.</p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-lg-4 col-xl-4">
      <div class="row align-items-center">
        <div class="col">
          <form method="POST" action="/tasks/select-category">
            {{ csrf_field() }}
            <div class="form-group">
              <select class="form-control" data-toggle="select" name="category">
                <option value="Nil">Select category</option>
                @foreach($categories as $category)
                  <option value="{{$category->id}}">{{$category->title}}</option>
                @endforeach
              </select>
            </div>
            <div>
              <button class="btn btn-primary" id="submit" type="submit">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section ('footer')
  
@endsection