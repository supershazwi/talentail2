@extends ('layouts.main')

@section ('content')
    @if(!empty(Auth::user()) && Auth::user()->creator)
    <div class="breadcrumb-bar navbar bg-white sticky-top" style="display: -webkit-box; padding: 0.75rem;">
        <nav aria-label="breadcrumb">
        </nav>
        <button onclick="uploadTemplate()" class="btn btn-primary">Upload</button>
    </div>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-11">
                <section class="py-4 py-lg-5">
                    <h1 class="display-4 mb-3">Templates</h1>
                    <p class="lead">Explore our list of templates that you can use to complete your projects.</p>
                </section>
                <div class="tab-pane fade show active" id="templates" role="tabpanel" aria-labelledby="teams-tab" data-filter-list="content-list-body">
                    <div class="content-list-body row">
                        @foreach($templates as $template)
                        <div class="col-xl-4 col-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 data-filter-by="text"><a href="/templates/{{$template->id}}">{{$template->title}}</a></h5>
                                    <p style="margin-top: 0.5rem;">{{$template->description}}</p>
                                    <a href="/profile/{{$template->user_id}}" data-toggle="tooltip" data-placement="top" title="">
                                      @if($template->user->avatar)
                                      <img class="avatar" src="https://storage.googleapis.com/talentail-123456789/{{$template->user->avatar}}">
                                      @else
                                      <img class="avatar" src="/img/avatar.png">
                                      @endif
                                    </a>
                                    <a href="/profile/{{$template->user_id}}">
                                      <span style="font-size: .875rem; line-height: 1.3125rem;">{{$template->user->name}}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="loggedInUserId" value="{{Auth::id()}}" />

    <script type="text/javascript">
        $(function () {
            var pusher = new Pusher("5491665b0d0c9b23a516", {
              cluster: 'ap1',
              forceTLS: true,
              auth: {
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  }
            });

            var purchaseChannel = pusher.subscribe('purchases_' + document.getElementById('loggedInUserId').value);
            purchaseChannel.bind('new-purchase', function(data) {
                toastr.success(data.username + ' ' + data.message); 
            });
        })
    </script>

    <script type="text/javascript">
      function uploadTemplate() {
        window.location.replace('/templates/upload'); 
      }
    </script> 

@endsection

@section ('footer')

@endsection