@extends ('layouts.main')

@section ('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-11">
                <section class="py-4 py-lg-5">
                    <h1 class="display-4 mb-3">Upload Template</h1>
                </section>
                @if (($errors->has('title') && strlen($errors->first('title')) > 0) || $errors->has('description') && strlen($errors->first('description')) > 0 || $errors->has('file') && strlen($errors->first('file')) > 0 || $errors->has('shot') && strlen($errors->first('shot')) > 0)
                <div class="alert alert-danger" style="text-align: center;">
                  @if ($errors->has('title') && strlen($errors->first('title')) > 0)
                    <p style="color: #721c24 !important;">{{ $errors->first('title') }}</p>
                  @endif
                  @if ($errors->has('description') && strlen($errors->first('description')) > 0)
                    <p style="color: #721c24 !important;">{{ $errors->first('description') }}</p>
                  @endif
                  @if ($errors->has('file') && strlen($errors->first('file')) > 0)
                    <p style="color: #721c24 !important;">{{ $errors->first('file') }}</p>
                  @endif
                  @if ($errors->has('shot') && strlen($errors->first('shot')) > 0)
                    <p style="color: #721c24 !important;">{{ $errors->first('shot') }}</p>
                  @endif
                </div>
                @endif
                <form id="templateForm" method="POST" action="/templates/upload" enctype="multipart/form-data">
                @csrf
                <h3>Template Title</h3>
                <input type="text" name="title" class="form-control" id="title" placeholder="Enter title" value="{{ old('title') }}" autofocus>
                <h3 style="margin-top: 1.5rem;">Template Description</h3>
                <textarea class="form-control" name="description" id="description" maxlength="280" rows="5" placeholder="Enter description" style="resize: none;" onkeypress="keyDescription()">{{ old('description') }}</textarea>
                <br/>
                <div class="tab-pane fade show active" id="templates" role="tabpanel" aria-labelledby="teams-tab" data-filter-list="content-list-body">
                    <div class="content-list-body row">
                        <div class="col">
                            <div class="box">
                              <input type="file" name="file[]" id="file" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" style="visibility: hidden; margin-bottom: 1.5rem;"/>
                              <label for="file" style="position: absolute; left: 0; margin-left: 12px; margin-bottom: 1.5rem;  border-radius: 0.25rem !important; padding: 0.2rem 1.25rem; height: 36px;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span style="font-size: 1rem;">Choose File</span></label>
                            </div>
                            <div id="selectedFiles"></div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show active" id="templateShots" role="tabpanel" aria-labelledby="teams-tab" data-filter-list="content-list-body" style="margin-top: 0.5rem;">
                    <div class="content-list-body row">
                        <div class="col">
                            <div class="box">
                              <input type="file" name="shot[]" id="shot" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple style="visibility: hidden; margin-bottom: 1.5rem;"/>
                              <label for="shot" style="position: absolute; left: 0; margin-left: 12px; margin-bottom: 1.5rem;  border-radius: 0.25rem !important; padding: 0.2rem 1.25rem; height: 36px;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span style="font-size: 1rem;">Choose Screenshots</span></label>
                            </div>
                            <div id="selectedShots"></div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" id="upload" type="submit" style="float: right;">Upload</button>
                </form>
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
      var selDiv = "";
      var shotDiv = "";
      
      document.addEventListener("DOMContentLoaded", init, false);
    
      function init() {
        document.querySelector('#file').addEventListener('change', handleFileSelect, false);
        selDiv = document.querySelector("#selectedFiles");

        document.querySelector('#shot').addEventListener('change', handleShotSelect, false);
        shotDiv = document.querySelector("#selectedShots");
      }
      
      function handleFileSelect(e) {
        if(!e.target.files) return;
        selDiv.innerHTML = "";
        
        var files = e.target.files;
        for(var i=0; i<files.length; i++) {
          var f = files[i];
          
          selDiv.innerHTML += f.name + "<br/>";
        }
      }

      function handleShotSelect(e) {
        if(!e.target.files) return;
        shotDiv.innerHTML = "";
        
        var files = e.target.files;
        for(var i=0; i<files.length; i++) {
          var f = files[i];
          
          shotDiv.innerHTML += f.name + "<br/>";
        }
      }
    </script>

@endsection

@section ('footer')

@endsection