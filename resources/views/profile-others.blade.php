@extends ('layouts.main')

@section ('content')

<div class="breadcrumb-bar navbar bg-white sticky-top">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/profile">Profile</a>
            </li>
        </ol>
    </nav>
    @if(Auth::id() == $user->id)
    <a href="/profile/edit" class="btn btn-primary">Edit Profile</a>
    @endif
</div>   
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-11 col-xl-10">
                    <div class="page-header mb-4">
                        <div class="media">
                            <img alt="Image" src="https://storage.googleapis.com/talentail-123456789/{{$user->avatar}}" class="avatar avatar-lg mt-1" />
                            <div class="media-body ml-3">
                                <h1 class="mb-0">{{$user->name}} 
                                    @if($user->creator)
                                    <span class="badge badge-warning" style="font-size: 0.8rem;">Creator</span>
                                    @endif
                                </h1>
                                <p class="lead">{{$user->description}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="creatorInformation" role="tabpanel" aria-labelledby="creatorInformation-tab" data-filter-list="content-list-body">
                            <div class="row content-list-head">
                                <div class="col-auto">
                                    <h3>Work Experience</h3>
                                </div>
                            </div>
                            <div class="content-list-body row">
                                <div class="col-md-12">
                                    <div class="card card-team">
                                        <div class="card-body">
                                            @foreach($user->experiences as $experience)
                                            <div class="card-title">
                                                <h4 data-filter-by="text">{{$experience->company}}</h4>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-9">
                                                    <strong>{{$experience->role}}</strong>
                                                    <p>{{$experience->description}}</p>
                                                </div>
                                                <div class="col-lg-3">
                                                    <p>{{date("M Y", strtotime($experience->start_date))}} - {{date("M Y", strtotime($experience->end_date))}}</p>
                                                </div>
                                            </div>
                                            @if(!$loop->last)
                                                <hr/>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end of tab-->
                    </div>
                    <form class="modal fade" id="team-add-modal" tabindex="-1" role="dialog" aria-labelledby="team-add-modal" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">New Team</h5>
                                    <button type="button" class="close btn btn-round" data-dismiss="modal" aria-label="Close">
                                        <i class="material-icons">close</i>
                                    </button>
                                </div>
                                <!--end of modal head-->
                                <ul class="nav nav-tabs nav-fill">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="team-add-details-tab" data-toggle="tab" href="#team-add-details" role="tab" aria-controls="team-add-details" aria-selected="true">Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="team-add-members-tab" data-toggle="tab" href="#team-add-members" role="tab" aria-controls="team-add-members" aria-selected="false">Members</a>
                                    </li>
                                </ul>
                                <div class="modal-body">
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="team-add-details" role="tabpanel" aria-labelledby="team-add-details-tab">
                                            <h6>Team Details</h6>
                                            <div class="form-group row align-items-center">
                                                <label class="col-3">Name</label>
                                                <input class="form-control col" type="text" placeholder="Team name" name="team-name" />
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-3">Description</label>
                                                <textarea class="form-control col" rows="3" placeholder="Team description" name="team-description"></textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="team-add-members" role="tabpanel" aria-labelledby="team-add-members-tab">
                                            <div class="users-manage" data-filter-list="form-group-users">
                                                <div class="mb-3">
                                                    <ul class="avatars text-center">

                                                        <li>
                                                            <img alt="Claire Connors" src="/img/avatar-female-1.jpg" class="avatar" data-toggle="tooltip" data-title="Claire Connors" />
                                                        </li>

                                                        <li>
                                                            <img alt="Marcus Simmons" src="/img/avatar-male-1.jpg" class="avatar" data-toggle="tooltip" data-title="Marcus Simmons" />
                                                        </li>

                                                        <li>
                                                            <img alt="Peggy Brown" src="/img/avatar-female-2.jpg" class="avatar" data-toggle="tooltip" data-title="Peggy Brown" />
                                                        </li>

                                                        <li>
                                                            <img alt="Harry Xai" src="/img/avatar-male-2.jpg" class="avatar" data-toggle="tooltip" data-title="Harry Xai" />
                                                        </li>

                                                    </ul>
                                                </div>
                                                <div class="input-group input-group-round">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="material-icons">filter_list</i>
                                                        </span>
                                                    </div>
                                                    <input type="search" class="form-control filter-list-input" placeholder="Filter members" aria-label="Filter Members" aria-describedby="filter-members">
                                                </div>
                                                <div class="form-group-users">

                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="user-manage-1" checked>
                                                        <label class="custom-control-label" for="user-manage-1">
                                                            <div class="d-flex align-items-center">
                                                                <img alt="Claire Connors" src="/img/avatar-female-1.jpg" class="avatar mr-2" />
                                                                <span class="h6 mb-0" data-filter-by="text">Claire Connors</span>
                                                            </div>
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="user-manage-2" checked>
                                                        <label class="custom-control-label" for="user-manage-2">
                                                            <div class="d-flex align-items-center">
                                                                <img alt="Marcus Simmons" src="/img/avatar-male-1.jpg" class="avatar mr-2" />
                                                                <span class="h6 mb-0" data-filter-by="text">Marcus Simmons</span>
                                                            </div>
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="user-manage-3" checked>
                                                        <label class="custom-control-label" for="user-manage-3">
                                                            <div class="d-flex align-items-center">
                                                                <img alt="Peggy Brown" src="/img/avatar-female-2.jpg" class="avatar mr-2" />
                                                                <span class="h6 mb-0" data-filter-by="text">Peggy Brown</span>
                                                            </div>
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="user-manage-4" checked>
                                                        <label class="custom-control-label" for="user-manage-4">
                                                            <div class="d-flex align-items-center">
                                                                <img alt="Harry Xai" src="/img/avatar-male-2.jpg" class="avatar mr-2" />
                                                                <span class="h6 mb-0" data-filter-by="text">Harry Xai</span>
                                                            </div>
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="user-manage-5">
                                                        <label class="custom-control-label" for="user-manage-5">
                                                            <div class="d-flex align-items-center">
                                                                <img alt="Sally Harper" src="/img/avatar-female-3.jpg" class="avatar mr-2" />
                                                                <span class="h6 mb-0" data-filter-by="text">Sally Harper</span>
                                                            </div>
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="user-manage-6">
                                                        <label class="custom-control-label" for="user-manage-6">
                                                            <div class="d-flex align-items-center">
                                                                <img alt="Ravi Singh" src="/img/avatar-male-3.jpg" class="avatar mr-2" />
                                                                <span class="h6 mb-0" data-filter-by="text">Ravi Singh</span>
                                                            </div>
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="user-manage-7">
                                                        <label class="custom-control-label" for="user-manage-7">
                                                            <div class="d-flex align-items-center">
                                                                <img alt="Kristina Van Der Stroem" src="/img/avatar-female-4.jpg" class="avatar mr-2" />
                                                                <span class="h6 mb-0" data-filter-by="text">Kristina Van Der Stroem</span>
                                                            </div>
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="user-manage-8">
                                                        <label class="custom-control-label" for="user-manage-8">
                                                            <div class="d-flex align-items-center">
                                                                <img alt="David Whittaker" src="/img/avatar-male-4.jpg" class="avatar mr-2" />
                                                                <span class="h6 mb-0" data-filter-by="text">David Whittaker</span>
                                                            </div>
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="user-manage-9">
                                                        <label class="custom-control-label" for="user-manage-9">
                                                            <div class="d-flex align-items-center">
                                                                <img alt="Kerri-Anne Banks" src="/img/avatar-female-5.jpg" class="avatar mr-2" />
                                                                <span class="h6 mb-0" data-filter-by="text">Kerri-Anne Banks</span>
                                                            </div>
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="user-manage-10">
                                                        <label class="custom-control-label" for="user-manage-10">
                                                            <div class="d-flex align-items-center">
                                                                <img alt="Masimba Sibanda" src="/img/avatar-male-5.jpg" class="avatar mr-2" />
                                                                <span class="h6 mb-0" data-filter-by="text">Masimba Sibanda</span>
                                                            </div>
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="user-manage-11">
                                                        <label class="custom-control-label" for="user-manage-11">
                                                            <div class="d-flex align-items-center">
                                                                <img alt="Krishna Bajaj" src="/img/avatar-female-6.jpg" class="avatar mr-2" />
                                                                <span class="h6 mb-0" data-filter-by="text">Krishna Bajaj</span>
                                                            </div>
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="user-manage-12">
                                                        <label class="custom-control-label" for="user-manage-12">
                                                            <div class="d-flex align-items-center">
                                                                <img alt="Kenny Tran" src="/img/avatar-male-6.jpg" class="avatar mr-2" />
                                                                <span class="h6 mb-0" data-filter-by="text">Kenny Tran</span>
                                                            </div>
                                                        </label>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end of modal body-->
                                <div class="modal-footer">
                                    <button role="button" class="btn btn-primary" type="submit">
                                        Done
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
        </div>
    </div>
</div>     

@endsection

@section ('footer')
	
	

@endsection