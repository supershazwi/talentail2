@extends ('layouts.main')

@section ('content')
<div class="container">
  <div class="row" style="margin-top: 3rem;">
      <div class="col-lg-12" style="text-align: center; margin-bottom: 2.5rem;">
        <h1 style="font-size: 1.5rem;">Select Role To View Tasks</h1>
        <p>Tasks are grouped according to specific roles. There are several exercises grouped per task.</p>
      </div>
      @foreach($roles as $role)
        <div class="col-12 col-md-6 col-xl-4">
          <div class="card">
            <div class="card-body">
              <!-- Title -->
              <a href="/roles/{{$role->slug}}"><h2 class="card-title text-center mb-3">
                {{$role->title}}
              </h2></a>

              <!-- Text -->

              <p class="card-text text-center mb-4" style="overflow: hidden; text-overflow: ellipsis;display: -webkit-box; max-height: 72px; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                {{$role->description}}
              </p>  

              <!-- Divider -->
              <hr>

              <div class="row align-items-center" style="text-align: center;">
                <div class="col">
                  
                  <p class="card-text small text-muted" style="margin-bottom: 0;">Tasks</p>
                  <p style="margin-bottom: 0;">{{count($role->exercises->groupBy('task_id'))}}</p>

                </div>

                <div class="col">
                  
                  <p class="card-text small text-muted" style="margin-bottom: 0;">Exercises</p>
                  <p style="margin-bottom: 0;">{{count($role->exercises)}}</p>

                </div>
              </div> 

            </div>
          </div>
        </div>
      @endforeach
  </div>
</div>
@endsection

@section ('footer')

@endsection