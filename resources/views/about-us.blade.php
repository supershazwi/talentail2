@extends ('layouts.main')

@section ('content')
  <div class="container">
      <div class="row justify-content-center" style="margin-top: 3rem;">
        <div class="col-xl-10 col-lg-11">
            <section class="py-4 py-lg-5">
                <h1 class="display-4 mb-3">The platform to achieve greater control over one's career</h1>
                <p class="lead">At Talentail, we believe that everyone should be given an equal opportunity to control their career paths and ultimately their happiness. Therefore, creators have come together to design projects and provide you with real world experience.</p>
            </section>
            <div class="tab-pane fade show active" id="team" role="tabpanel" aria-labelledby="teams-tab" data-filter-list="content-list-body">
                <!--end of content list head-->
                <div class="content-list-body row">
                    <div class="col-xl-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                  <div class="col-lg-2">
                                    <img src="/img/lol.jpeg" style="width: 100%; height: auto; border-radius: 0.5rem;"/>
                                  </div>
                                  <div class="col-lg-10">
                                    <h3 data-filter-by="text">Shazwi Suwandi</h3>
                                    <p>Shazwi has been working as a tech consultant since graduating from National University of Singapore and has gained significant experience in digital transformation projects. He likes to overthink in his everyday life and sometimes land himself onto problems that he wants to solve. When push comes to shove, he will roll up his sleeves, his pants, tie up his hair and sit tight till a solution is found. He still can't afford his own bat signal yet, so he can only be contactable on the other channels below.</p>
                                    <a target="_blank" href="https://www.linkedin.com/in/shazwi/"><i class="fab fa-linkedin"></i></a>
                                    <a target="_blank" href="https://t.me/supershazwi" style="margin-left: 0.5rem;"><i class="fab fa-telegram"></i></a>
                                    <a target="_blank" href="https://wa.me/6593839053" style="margin-left: 0.5rem;"><i class="fab fa-whatsapp-square"></i></a>
                                    <a href="mailto:supershazwi@gmail.com?Subject=Hello%20Shazwi" target="_top" style="margin-left: 0.5rem;"><i class="fas fa-envelope-square"></i></a>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end of content-list-body-->
            </div>
        </div>
      </div>
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