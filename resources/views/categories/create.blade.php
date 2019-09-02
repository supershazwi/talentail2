@extends ('layouts.main')

@section ('content')
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-12">
        
        <!-- Header -->
        <div class="header mt-md-5">
          <div class="header-body">
            <div class="row align-items-center">
              <div class="col">
                
                <!-- Pretitle -->
                <h6 class="header-pretitle">
                  New category
                </h6>

                <!-- Title -->
                <h1 class="header-title">
                  Create a new category
                </h1>

              </div>
            </div> <!-- / .row -->
          </div>
        </div>

        <form id="categoryForm" method="POST" class="mb-4" action="/categories/save-category">

          {{ csrf_field() }}

          <div class="form-group">
            <label>
              Category title
            </label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Enter title" value="{{ old('title') }}" autofocus>
          </div>

          <div class="form-group">
            <label class="mb-1">
              Category description
            </label>

            <input type="text" name="description" class="form-control" id="description" placeholder="Enter description" value="{{ old('description') }}">
          </div>

          <div class="form-group">
            <label>
              Roles
            </label>
            
            @foreach($roles as $role)
            @if(!$loop->last)
                <div class="row align-items-center" style="margin-bottom: 1rem;">
            @else
                <div class="row align-items-center">
            @endif
              <div class="col-auto">
                <div class="custom-control custom-checkbox-toggle">
                  <input type="checkbox" class="custom-control-input" name="role[]" id="role_{{$role->id}}" value="{{$role->id}}">
                  <label class="custom-control-label" for="role_{{$role->id}}" id="role_{{$role->id}}"></label>
                </div>
              </div>
              <div class="col">
                <span>{{$role->title}}</span>
              </div>
            </div>
            @endforeach

          </div>

          <button class="btn btn-primary" id="createCategory" type="submit" style="float: right; display: none;">Create Category</button>
          <button class="btn btn-default" id="saveCategory" type="submit" style="float: right; margin-right: 0.5rem; display: none;">Save</button>
          <button class="btn btn-default" onclick="cancel()" style="float: right; margin-right: 0.5rem; display: none;">Cancel</button>
        </form>

        <button onclick="saveCategory()" id="saveCategoryButton" class="btn btn-block btn-primary">
          Save Category
        </button>
        <a href="#" class="btn btn-block btn-link text-muted">
          Cancel
        </a>

      </div>
    </div>
  </div>

  <script type="text/javascript" src="/js/editormd.js"></script>
  <script src="/js/languages/en.js"></script>
  <script type="text/javascript">

    function saveCategory() {
      event.preventDefault();
      document.getElementById("saveCategory").click();
    }
  </script>
@endsection

@section ('footer')
@endsection