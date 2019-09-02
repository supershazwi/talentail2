@extends ('layouts.main')

@section ('content')
  <div class="breadcrumb-bar navbar bg-white sticky-top" style="display: -webkit-box; padding: 0.75rem;">
      <nav aria-label="breadcrumb">
      </nav>
      <button onclick="downloadTemplate()" class="btn btn-primary">Download</button>
      <input type="hidden" id="templateUrl" value="https://storage.googleapis.com/talentail-123456789/{{$template->url}}" />
  </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-11">
                <section class="py-4 py-lg-5">
                    <h1 class="display-4 mb-3">{{$template->title}}</h1>
                    <p class="lead">{{$template->description}}</p>
                </section>
                 <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
                   <div class="carousel-inner">
                    @foreach($template->template_shots as $templateShot)
                      @if($loop->first)
                       <div class="carousel-item active">
                         <img class="d-block w-100" src="https://storage.googleapis.com/talentail-123456789/{{$templateShot->url}}" alt="">
                       </div>
                       @else
                       <div class="carousel-item">
                         <img class="d-block w-100" src="https://storage.googleapis.com/talentail-123456789/{{$templateShot->url}}" alt="">
                       </div>
                       @endif
                    @endforeach
                   </div>
                   <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
                     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                     <span class="sr-only">Previous</span>
                   </a>
                   <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
                     <span class="carousel-control-next-icon" aria-hidden="true"></span>
                     <span class="sr-only">Next</span>
                   </a>
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

            $('.carousel').carousel();
        })
    </script>

    <script type="text/javascript">
      function downloadTemplate() {
        window.location.replace(document.getElementById("templateUrl").value); 
      }
    </script> 

@endsection

@section ('footer')

@endsection