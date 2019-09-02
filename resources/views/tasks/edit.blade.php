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
                  Task Management
                </h6>

                <!-- Title -->
                <h1 class="header-title">
                  Edit Task
                </h1>

              </div>
            </div> <!-- / .row -->
          </div>
        </div>

        <form id="taskForm" method="POST" class="mb-4" action="/tasks/{{$task->slug}}/save-task">

          {{ csrf_field() }}

          <div class="form-group">
            <label>
              Task title
            </label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Enter title" value="{{ $task->title }}" autofocus>
          </div>

          <div class="form-group">
            <label class="mb-1">
              Task description
            </label>

            <input type="text" name="description" class="form-control" id="description" placeholder="Enter description" value="{{ $task->description }}">
          </div>

          <div class="form-group">
            <label class="mb-1">
              Roles
            </label>

            <select class="form-control" data-toggle="select" name="role">
              <option value="Nil">Select role</option>
              @foreach($roles as $role)
                @if($task->role_id == $role->id)
                <option value="{{$role->id}}" selected>{{$role->title}}</option>
                @else
                <option value="{{$role->id}}">{{$role->title}}</option>
                @endif
              @endforeach
            </select>
          </div>

          <button class="btn btn-primary" id="createTask" type="submit" style="float: right; display: none;">Create Task</button>
          <button class="btn btn-default" id="saveTask" type="submit" style="float: right; margin-right: 0.5rem; display: none;">Save</button>
          <button class="btn btn-default" onclick="cancel()" style="float: right; margin-right: 0.5rem; display: none;">Cancel</button>
        </form>

        <button onclick="saveTask()" id="saveTaskButton" class="btn btn-block btn-primary">
          Save Task
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

    function saveTask() {
      event.preventDefault();
      document.getElementById("saveTask").click();
    }
  </script>
@endsection

@section ('footer')
@endsection