@extends ('layouts.main')

@section ('content')
    @include('toast::messages')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-11">
                <section class="py-4 py-lg-5">
                    <h1 class="display-4 mb-3">Creators</h1>
                    <p class="lead">What sets Talentail apart from other platforms is the quality and relevance of the projects that reside within. Our creators work at reputable firms and have accumulated a wealth of experience. This enables them to produce robust projects that resembles their own work experiences.</p>
                </section>
                <div class="tab-pane fade show active" id="teams" role="tabpanel" aria-labelledby="teams-tab" data-filter-list="content-list-body">
                    <div class="row content-list-head">
                        <div class="col-auto">
                        </div>
                        <form class="col-md-auto">
                            <div class="input-group input-group-round">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">filter_list</i>
                                    </span>
                                </div>
                                <input type="search" class="form-control filter-list-input" placeholder="Filter creators" aria-label="Filter creators" aria-describedby="filter-creators">
                            </div>
                        </form>
                    </div>
                    <!--end of content list head-->
                    <div class="content-list-body row">
                        @foreach($creators as $creator)
                        <div class="col-xl-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                      <div class="col-lg-4">
                                        @if($creator->avatar)
                                        <img src="https://storage.googleapis.com/talentail-123456789/{{$creator->avatar}}" style="width: 100%; height: auto; border-radius: 0.5rem;"/>
                                        @else
                                        <img src="/img/avatar.png" style="width: 100%; height: auto; border-radius: 0.5rem;"/>
                                        @endif
                                      </div>
                                      <div class="col-lg-8">
                                        <h5 data-filter-by="text"><a href="/profile/{{$creator->id}}">{{$creator->name}}</a></h5>
                                        <p>{{$creator->description}}</p>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!--end of content-list-body-->
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

            toastr.options = {
                positionClass: 'toast-bottom-right'
            };     

            var messageChannel = pusher.subscribe('messages_' + document.getElementById('loggedInUserId').value);
            messageChannel.bind('new-message', function(data) {
                toastr.options.onclick = function () {
                    window.location.replace(data.url);
                };

                toastr.info("<strong>" + data.username + "</strong><br />" + data.message); 
            });

            var purchaseChannel = pusher.subscribe('purchases_' + document.getElementById('loggedInUserId').value);
            purchaseChannel.bind('new-purchase', function(data) {
                toastr.success(data.username + ' ' + data.message); 
            });
        })
    </script>

@endsection

@section ('footer')

@endsection