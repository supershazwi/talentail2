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
                  Exercise Grouping Managmement
                </h6>

                <!-- Title -->
                <h1 class="header-title">
                  Create a New Exercise Grouping
                </h1>

              </div>
            </div> <!-- / .row -->
          </div>
        </div>

        <!-- Form -->
          <form method="POST" action="/exercise-groupings/save-exercise-grouping">
          {{ csrf_field() }}

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="mb-1">
                  Task
                </label>
                <select class="form-control" data-toggle="select" name="task">
                  <option value="Nil">Select task</option>
                  @foreach($tasks as $task)
                  <option value="{{$task->id}}">{{$task->title}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="mb-1">
                  Select opportunity
                </label>
                <select class="form-control" data-toggle="select" name="opportunity">
                  <option value="Nil">Select opportunity</option>
                  @foreach($opportunities as $opportunity)
                  <option value="{{$opportunity->id}}">{{$opportunity->title}} - {{$opportunity->company->title}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <hr class="mt-4 mb-5">

          <h1 class="header-title">
            Task/Exercise Grouping
          </h1>

          @foreach($tasks as $task)
            @if(count($task->exercises) > 0)
            <div class="card" data-toggle="lists" style="margin-top: 1.5rem;">
              <div class="table-responsive">
                <table class="table table-sm table-nowrap card-table">
                  <thead>
                    <tr>
                      <th>
                        <div class="custom-control custom-checkbox table-checkbox">
                          <input type="checkbox" class="custom-control-input" id="task_{{$task->id}}" onclick="toggleCheckboxes()">
                          <label class="custom-control-label" for="task_{{$task->id}}">
                            &nbsp;
                          </label>
                        </div>
                      </th>
                      <th colspan="7" style="color: #12263f;">
                        {{$task->title}}
                      </th>
                    </tr>
                  </thead>
                  <tbody class="list">
                    @foreach($task->exercises as $exercise)
                    <tr>
                      <td>
                        <div class="custom-control custom-checkbox table-checkbox">
                          <input type="checkbox" class="custom-control-input task_{{$task->id}}" name="exercises[]" id="exercise_{{$exercise->task->id}}_{{$exercise->id}}" value="{{$exercise->id}}" onclick="toggleIndividualCheckboxes()">
                          <label class="custom-control-label" for="exercise_{{$exercise->task->id}}_{{$exercise->id}}" id="exercise_{{$exercise->id}}">
                            
                          </label>
                        </div>
                      </td>
                      <td colspan="7" style="width: 100%;">
                        <a target="_blank" href="/exercises/{{$exercise->slug}}">{{$exercise->solution_title}}</a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            @endif
          @endforeach

          <!-- Buttons -->
          <button type="submit" class="btn btn-block btn-primary">
            Save Exercise Grouping
          </button>
          <a href="/dashboard" class="btn btn-block btn-link text-muted">
            Cancel
          </a>

        </form>
        

      </div>
    </div> <!-- / .row -->
  </div>
  <script type="text/javascript" src="/js/editormd.js"></script>
  <script src="/js/languages/en.js"></script>
  <script type="text/javascript">

  </script>
@endsection

@section ('footer')
@endsection