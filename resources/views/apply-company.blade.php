@extends ('layouts.main')

@section ('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8">
      
      <!-- Header -->
      <div class="header mt-md-5">
        @if (session('success'))
        <div class="alert alert-success" role="alert" id="successAlert" style="text-align: center;">
          <h4 class="alert-heading" style="margin-bottom: 0;">Your application has been submitted. We will get back to you shortly.</h4>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger" role="alert" id="errorAlert" style="text-align: center;">
          @foreach(session('error') as $error)
          @if($loop->last)
          <h4 class="alert-heading" style="margin-bottom: 0;">{{$error}}</h4>
          @else
          <h4 class="alert-heading">{{$error}}</h4>
          @endif
          @endforeach
        </div>
        @endif

        <div class="header-body">

          <!-- Title -->
          <h1 class="header-title">
            Apply to be a Company
          </h1>
        </div>
      </div>

      <p>Being a part of a company will allow you to source out candidates using the platform. You will gain access to our full database of endorsed portfolios. This is a new way of finding the right talent for your company. Join us in this journey.</p>

      <!-- Card -->
      <form method="POST" action="/companies/apply">
        @csrf
        <div class="card" style="margin-top: 1.5rem;">
          <div class="card-body">
            <div class="form-group">
              <label class="mb-1">
                Please provide a brief description of the role you play at your company
              </label>
              <textarea class="form-control" name="description" id="description" rows="5" placeholder="Enter description" style="margin-bottom: 0 !important;">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
              <label class="mb-1">
                Select your company if applicable
              </label>
              <select class="form-control" data-toggle="select" name="company" value="{{ old('company') }}">
                <option value="Nil">Select company</option>
                @foreach($companies as $company)
                  <option value="{{$company->id}}">{{$company->title}}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
              <label class="mb-1">
                Enter your company name if it's not in the above list
              </label>
              <input type="text" name="title" class="form-control" id="title" placeholder="Enter company name" value="{{ old('title') }}">
            </div>
          </div>
        </div>

        <button class="btn btn-primary" role="button" type="submit">
            Submit Application
        </button>
      </form>


    </div>
  </div> <!-- / .row -->
</div>

<script type="text/javascript">

  setTimeout(function(){ document.getElementById("successAlert").style.display = "none" }, 3000);

</script>
@endsection

@section ('footer')

@endsection