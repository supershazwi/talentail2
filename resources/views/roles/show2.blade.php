// original skills show

@extends ('layouts.main')

@section ('content')
  <div class="breadcrumb-bar navbar bg-white sticky-top">
      <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/roles">Roles</a>&nbsp;> {{$role->title}}
              </li>
          </ol>
      </nav>
  </div>
  <div class="row">
    <div class="col-lg-4">
      <div class="card card-kanban">
        <div class="card-body">
          <div class="card-title">
            <h4>{{$role->title}}</h4>
          </div>
          <div class="card-title">
            <p class="text-small"><i class="fas fa-angle-right"></i> Elicit requirements for software development using interviews</p>
          </div>
          <div class="card-title">
            <p class="text-small"><i class="fas fa-angle-right"></i> Critically evaluate information gathered from multiple sources</p>
          </div>
          <div class="card-title">
            <p class="text-small"><i class="fas fa-angle-right"></i> Translate technical information into business language to ensure understanding of the requirements</p>
          </div>
          <div class="card-title">
            <p class="text-small"><i class="fas fa-angle-right"></i> Translate technical information into business language to ensure understanding of the requirements</p>
          </div>
          <div class="card-meta d-flex justify-content-between">
              <div class="d-flex align-items-center">
                  <p style="margin-right: 15px;">
                    <a href="#" data-toggle="modal" data-target="#competency-modal">See 25 more</a>
                  </p>
              </div>
          </div>
        </div>
      </div>
      <div class="card card-kanban">
        <div class="card-body">
          <div class="card-title">
            <h4>Opportunities</h4>
          </div>
          <div class="card-title">
            <span class="text-small">Accenture, Deloitte, Capgemini, Standard Chartered Bank, ...</span>
          </div>
          <div class="card-meta d-flex justify-content-between">
              <div class="d-flex align-items-center">
                  <p style="margin-right: 15px;">
                    <a href="#" data-toggle="modal" data-target="#opportunity-modal">See 36 more</a>
                  </p>
              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-8">
      <div class="kanban-col">
          <div class="card-list">
              <div class="card-list-header">
                  <h4>Projects</h4>
              </div>
              <div class="card-list-body">
                  @foreach($role->projects as $project)
                  <div class="card card-kanban">
                      <div class="card-body">
                          <div class="row">
                            <div class="col-lg-11">
                              <div class="card-title">
                                      <h5><a href="/roles/{{$role->slug}}/projects/{{$project->slug}}">{{$project->title}}</a></h5>
                              </div>
                              <p class="text-small">{{$project->description}}</p>
                              <a href="#" data-toggle="tooltip" data-placement="top" title="">
                                  <img class="avatar" src="/img/avatar-male-4.jpg">
                              </a>
                              <a href="#">
                                <span style="font-size: .875rem; line-height: 1.3125rem;">Roger Ver</span>
                              </a>
                            </div>
                            <div class="col-lg-1" style="text-align: center;">
                              <h5 style="float: right; color: #16a085;">${{$project->amount}}</h5>
                            </div>
                          </div>
                      </div>
                  </div>
                  @endforeach
              </div>
          </div>
      </div>
    </div>
  </div>

  <div class="modal fade" tabindex="-1" role="dialog" id="competency-modal">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Business Analyst Competencies</h5>
                  <button type="button" class="close btn btn-round" data-dismiss="modal" aria-label="Close">
                      <i class="material-icons">close</i>
                  </button>
              </div>
              <!--end of modal head-->
              <div class="modal-body">
                <div class="card-title">
                  <span class="badge badge-success">Achieved</span>
                </div>
                  @foreach($competencies as $competency)
                 <div class="card-title">
                   <p class="text-small"><i class="fas fa-check"></i> {{$competency->title}}</p>
                 </div>
                 @endforeach
                 <div class="card-title">
                   <span class="badge badge-warning">In Progress</span>
                 </div>
                 @foreach($competencies as $competency)
                 <div class="card-title">
                   <p class="text-small"><i class="fas fa-check"></i> {{$competency->title}}</p>
                 </div>
                 @endforeach

                 <div class="card-title">
                   <span class="badge badge-secondary">Not Attempted</span>
                 </div>
                 @foreach($competencies as $competency)
                 <div class="card-title">
                   <p class="text-small"><i class="fas fa-check"></i> {{$competency->title}}</p>
                 </div>
                 @endforeach
              </div>
          </div>
      </div>
  </div>
  <div class="modal fade" tabindex="-1" role="dialog" id="opportunity-modal">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Business Analyst Opportunities</h5>
                  <button type="button" class="close btn btn-round" data-dismiss="modal" aria-label="Close">
                      <i class="material-icons">close</i>
                  </button>
              </div>
              <!--end of modal head-->
              <div class="modal-body">
                <div class="row">
                  <div class="col-lg-4">
                    <div class="card-title">
                      <span class="badge badge-success">Applied</span>
                    </div>
                    <div class="card-title">
                      <p class="text-small"><i class="fas fa-angle-right"></i> Accenture</p>
                    </div>
                    <div class="card-title">
                      <p class="text-small"><i class="fas fa-angle-right"></i> Capgemini</p>
                    </div>
                    <div class="card-title">
                      <p class="text-small"><i class="fas fa-angle-right"></i> Deloitte</p>
                    </div>
                    <div class="card-title">
                      <p class="text-small"><i class="fas fa-angle-right"></i> Ernst & Young</p>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="card-title">
                      <span class="badge badge-warning">In Progress</span>
                    </div>
                    <div class="card-title">
                      <p class="text-small"><i class="fas fa-angle-right"></i> Accenture</p>
                    </div>
                    <div class="card-title">
                      <p class="text-small"><i class="fas fa-angle-right"></i> Capgemini</p>
                    </div>
                    <div class="card-title">
                      <p class="text-small"><i class="fas fa-angle-right"></i> Deloitte</p>
                    </div>
                    <div class="card-title">
                      <p class="text-small"><i class="fas fa-angle-right"></i> Ernst & Young</p>
                    </div>
                  </div>
                  <div class="col-lg-4">
                   <div class="card-title">
                     <span class="badge badge-secondary">Not Applied</span>
                   </div>
                   <div class="card-title">
                     <p class="text-small"><i class="fas fa-angle-right"></i> Accenture</p>
                   </div>
                   <div class="card-title">
                     <p class="text-small"><i class="fas fa-angle-right"></i> Capgemini</p>
                   </div>
                   <div class="card-title">
                     <p class="text-small"><i class="fas fa-angle-right"></i> Deloitte</p>
                   </div>
                   <div class="card-title">
                     <p class="text-small"><i class="fas fa-angle-right"></i> Ernst & Young</p>
                   </div>
                  </div>
                </div>
              </div>
          </div>
      </div>
  </div>
@endsection

@section ('footer')
	
	

@endsection