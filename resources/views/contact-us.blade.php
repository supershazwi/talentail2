@extends ('layouts.main')

@section ('content')
  <div class="container">
      <div class="row justify-content-center" style="margin-top: 3rem;">
        <div class="col-xl-10 col-lg-11">
            <section class="py-4 py-lg-5">
                <h1 class="display-4 mb-3">Have questions?</h1>
                <p class="lead">Contact us. We'd love to hear from you and answer them.</p>
            </section>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-11">
          <div class="card">
              <div class="card-body">
                  <div class="tab-content">
                      <div class="tab-pane fade show active" role="tabpanel" id="profile" aria-labelledby="profile-tab">
                          <!--end of avatar-->
                          @if (session('contactStatus'))
                              <div class="alert alert-success" style="text-align: center;">
                                  {{ session('contactStatus') }}
                              </div>
                          @endif
                          <form method="POST" action="/contact-us">
                              @csrf
                              <div class="form-group row align-items-center">
                                  <label class="col-3">Name</label>
                                  <div class="col">
                                      <input type="text" placeholder="Johnny Dutch" value="" id="name" name="name" class="form-control" required />
                                  </div>
                              </div>
                              <div class="form-group row align-items-center">
                                  <label class="col-3">Email</label>
                                  <div class="col">
                                      <input type="email" placeholder="johnnydutch@mi10.com" value="" id="email" name="email" class="form-control" required />
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label class="col-3">Description</label>
                                  <div class="col">
                                      <textarea type="text" placeholder="Is this the platform to gain spy experience?" name="description" id="description" class="form-control" rows="4"></textarea>
                                  </div>
                              </div>
                              <div class="row justify-content-end">
                                  <div class="col">
                                      <button type="submit" class="btn btn-primary pull-right">Send Message</button>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
        </div>
      </div>
  </div>

  <input type="hidden" id="loggedInUserId" value="{{Auth::id()}}" />

  <script>
  // Initialize and add the map
  function initMap() {
    // The location of Uluru
    var uluru = {lat: -25.344, lng: 131.036};
    // The map, centered at Uluru
    var map = new google.maps.Map(
        document.getElementById('map'), {zoom: 4, center: uluru});
    // The marker, positioned at Uluru
    var marker = new google.maps.Marker({position: uluru, map: map});
  }
      </script>
      <!--Load the API from the specified URL
      * The async attribute allows the browser to render the page while the API loads
      * The key parameter will contain your own API key (which is not needed for this tutorial)
      * The callback parameter executes the initMap() function
      -->
      <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGxc8mXdKkIjWDjUitCitbWxSyDKLVzFI&callback=initMap">
      </script>

  <script type="text/javascript">
      $(function () {
          if(document.getElementById('loggedInUserId').value != "") {
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
          }
      })
  </script>
@endsection

@section ('footer')
    
    

@endsection