@extends ('layouts.main')

@section ('content')
  <div class="container">
    <div class="row justify-content-center" style="margin-top: 3rem;">
      <div class="col-xl-10 col-lg-11">
          <section class="py-4 py-lg-5">
              <h1 class="display-4 mb-3">FAQ</h1>
          </section>
      </div>
      <div class="col-xl-10 col-lg-11">

        <!-- Card -->
        <div class="card">
          <div class="card-body">
            <div class="row justify-content-center">
              <div class="col">
                <h3>1. What is the difference between Talentail and other sites such as Coursera, Udacity, etc.?</h3>
                <p style="margin-bottom: 0rem;">We focus more on the application of knowledge on real world adapted projects. We seek to complement all the education sites out there by providing the appropriate environment for users to showcase their competence.</p>
              </div>
            </div> <!-- / .row -->
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <div class="row justify-content-center">
              <div class="col">
                <h3>2. Why would companies trust the projects on this platform?</h3>
                <p style="margin-bottom: 0rem;">We thoroughly vet each contributor on the platform by looking at not only their experiences but also their tangible work to determine that they are fit to advise on the creation of projects and its accompanying tasks.</p>
              </div>
            </div> <!-- / .row -->
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <div class="row justify-content-center">
              <div class="col">
                <h3>3. Why come up with this idea?</h3>
                <p style="margin-bottom: 0rem;">There are a lot of people getting into a new career or wanting to switch careers. One similar problem they face is the lack of experience. Other professions such as creative designers can create beautiful art pieces and use that as a portfolio to show their capabilities. Why not other "indirect" roles such as business analysts? They simply need a project/use case to apply their knowledge on and those projects/use cases are what Talentail is consolidating.</p>
              </div>
            </div> <!-- / .row -->
          </div>
        </div>

      </div>
    </div> <!-- / .row -->
  </div>

  <input type="hidden" id="loggedInUserId" value="{{Auth::id()}}" />

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