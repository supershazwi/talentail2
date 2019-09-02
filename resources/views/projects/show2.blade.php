@extends ('layouts.main')

@section ('content')
  <div class="row" style="margin-top: 25px;">
    <div class="col-lg-4">
      <div class="card card-kanban">
        <div class="card-body">
          <div class="card-title">
            <h4>{{$project->title}}</h4>
            <p class="text-small">{{$project->description}}</p>
          </div>
          <a href="#" data-toggle="tooltip" data-placement="top" title="">
              <img class="avatar" src="/img/avatar-male-4.jpg">
          </a>
          <a href="#">
            <span style="font-size: .875rem; line-height: 1.3125rem;">Roger Ver</span>
          </a>
        </div>
      </div>
      <div class="card card-kanban">
        <div class="card-body">
          <div class="card-title">
            <h4>{{$role->title}}</h4>
          </div>
          <div class="card-title">
            <p class="text-small"><i class="fas fa-check"></i> Elicit requirements for software development using interviews</p>
          </div>
          <div class="card-title">
            <p class="text-small"><i class="fas fa-check"></i> Critically evaluate information gathered from multiple sources</p>
          </div>
          <div class="card-title">
            <p class="text-small"><i class="fas fa-check"></i> Translate technical information into business language to ensure understanding of the requirements</p>
          </div>
          <div class="card-title">
            <p class="text-small"><i class="fas fa-check"></i> Translate technical information into business language to ensure understanding of the requirements</p>
          </div>
          <div class="card-meta d-flex justify-content-between">
              <div class="d-flex align-items-center">
                  <p style="margin-right: 15px;"><a href="#">See 25 more competencies</a></p>
              </div>
          </div>
        </div>
      </div>
      <div class="card card-kanban">
        <div class="card-body">
          <div class="card-title">
            <h4>Provided Files</h4>
          </div>
          <ul class="list-group list-group-activity dropzone-previews flex-column-reverse">
            <li class="list-group-item" data-t="null" data-i="null" data-l="null" data-e="null" style="padding: 0px; border-color: transparent; margin-bottom: 0.75rem;">
                <div class="media align-items-center">
                    <ul class="avatars">
                        <li>
                            <div class="avatar bg-primary">
                                <i class="material-icons">insert_drive_file</i>
                            </div>
                        </li>
                    </ul>
                    <div class="media-body d-flex justify-content-between align-items-center">
                        <div>
                            <a href="#" data-filter-by="text" class="A-filter-by-text">Pain Points & Wish Lists - Combined Puff Preparation</a>
                            <br>
                            <span class="text-small SPAN-filter-by-text" data-filter-by="text">5kb Excel Document</span>
                        </div>
                        <div class="dropdown">
                            <button class="btn-options" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Download</a>
                                <a class="dropdown-item" href="#">Share</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item" data-t="null" data-i="null" data-l="null" data-e="null" style="padding: 0px; border-color: transparent; margin-bottom: 0.75rem;">
                <div class="media align-items-center">
                    <ul class="avatars">
                        <li>
                            <div class="avatar bg-primary">
                                <i class="material-icons">insert_drive_file</i>
                            </div>
                        </li>
                    </ul>
                    <div class="media-body d-flex justify-content-between align-items-center">
                        <div>
                            <a href="#" data-filter-by="text" class="A-filter-by-text">As-Is Process - Potato Puff Preparation</a>
                            <br>
                            <span class="text-small SPAN-filter-by-text" data-filter-by="text">15kb Visio Document</span>
                        </div>
                        <div class="dropdown">
                            <button class="btn-options" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Download</a>
                                <a class="dropdown-item" href="#">Share</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item" data-t="null" data-i="null" data-l="null" data-e="null" style="padding: 0px; border-color: transparent; margin-bottom: 0.75rem;">
                <div class="media align-items-center">
                    <ul class="avatars">
                        <li>
                            <div class="avatar bg-primary">
                                <i class="material-icons">insert_drive_file</i>
                            </div>
                        </li>
                    </ul>
                    <div class="media-body d-flex justify-content-between align-items-center">
                        <div>
                            <a href="#" data-filter-by="text" class="A-filter-by-text">As-Is Process - Sardine Puff Preparation</a>
                            <br>
                            <span class="text-small SPAN-filter-by-text" data-filter-by="text">15kb Visio Document</span>
                        </div>
                        <div class="dropdown">
                            <button class="btn-options" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Download</a>
                                <a class="dropdown-item" href="#">Share</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-lg-8">
      <div class="kanban-col">
          <div class="card-list">
              <div class="card-list-header">
                  <h4>Brief</h4>
              </div>
              <div class="card-list-body">
                  <div class="card card-kanban">
                      <div class="card-body">
                          <h5>Birth of Superfoods Pte. Ltd.</h5>
                          <p class="text-small">Superfoods Pte. Ltd. was founded by Mr Lee in Singapore on September 2000 with the sole aim of making Singaporeans happy with the food he creates. Over the course of 18 years, Superfoods Pte. Ltd. has grown to a total of 5,000 shops across countries such as Indonesia, Phillipines, Malaysia, Thailand and Singapore and employs about 10,000 employees of all nationalities. Mr Lee has taken the role of Chairman and the role of CEO has been taken over by the previous Vice-President of Operations, Mrs Selena.</p>
                          <h5>Main Lines of Business</h5>
                          <p class="text-small">Superfoods has come far from its initial one-man pushcart stall operated by Mr Lee selling curry puffs at busy Raffles Place to fill the stomachs of hungry and driven professionals. Today, some of its lines of business include: </p>
                          <ul>
                            <li><p class="text-small">Extended range of food products like curry puffs, samosas, popiahs and goreng pisangs</p></li>
                            <li><p class="text-small">White-labelling of products for third party vendors to sell as their own</p></li>
                            <li><p class="text-small">Food ingredients at supermarkets like Sheng Shiong and NTUC Fairprice</p></li>
                          </ul>
                          <h5>Tight Competition</h5>
                          <p class="text-small">Following the success of Mr Lee and Superfoods, many young Singaporeans have started their own food businesses to get a shot at achieving success. Since then, many other businesses have sprouted to gain a portion of the marketshare that Superfoods owns. Businesses have started to automate their food production processes, upskilled their workforce and began experimenting with new food fusions.</p>
                          <h5>Innovate to Stay Ahead</h5>
                          <p class="text-small">Mr Lee has organised an all-hands meeting with all the key executives of Superfoods. The purpose of this meeting is to come up with ways that the current processes at Superfoods can be streamlined and bring about at least 20% reduction in cost and 10% reduction in time. Mr Lee has given you access to Superfoods' documents and you are now able to analyse the current processes and decide, how best to achieve Mr Lee's wishes.</p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="kanban-col">
          <div class="card-list">
              <div class="card-list-header">
                  <h4>To-dos</h4>
              </div>
              <div class="accordion" id="accordionExample">
                <div class="card">
                  <div class="card-header" id="headingOne">
                    <p class="text-small" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="color: #007bff !important; cursor: pointer;">
                      1. Draw out the As-Is process map to detail the end-to-end process of variance analysis within the payroll run process.
                    </p>
                  </div>

                  <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                      <p class="text-small">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
                      <form class="dropzone" action="..." style="margin-bottom: 0px;">
                          <span class="dz-message" style="background-color: rgba(0, 0, 0, 0.03);">Drop files or click here to upload</span>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header" id="headingTwo">
                    <p class="text-small" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="color: #007bff !important; cursor: pointer;">
                      2. Draw out the To-be process map to detail the end-to-end process of variance analysis within the payroll run process.
                    </p>
                  </div>
                  <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">
                      <p class="text-small">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header" id="headingThree">
                    <p class="text-small" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" style="color: #007bff !important; cursor: pointer;">
                      3. Derive the functional requirement specifications of the applications needed to support the To-be process map you have detailed in Step 2.
                    </p>
                  </div>
                  <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="card-body">
                      <p class="text-small">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
                    </div>
                  </div>
                </div>
              </div>
          </div>
      </div>
      <button class="btn btn-primary" type="button" id="submitproject" style="float: right;">Submit</button>
      <button class="btn btn-primary btn-round btn-floating btn-lg collapsed" type="button" data-toggle="collapse" data-target="#floating-chat" aria-expanded="false" aria-controls="sidebar-floating-chat">
          <i class="material-icons">chat_bubble</i>
          <i class="material-icons">close</i>
      </button>
      <div class="sidebar-floating collapse" id="floating-chat" style="">
        <div class="sidebar-content">
            <div class="chat-module" data-filter-list="chat-module-body">
                <div class="chat-module-top">
                    <form>
                        <div class="input-group input-group-round">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="material-icons">search</i>
                                </span>
                            </div>
                            <input type="search" class="form-control filter-list-input" placeholder="Search chat" aria-label="Search Chat" aria-describedby="search-chat">
                        </div>
                    </form>
                    <div class="chat-module-body filter-list-1533828216416"><div class="media chat-item">
                            <img alt="Claire" src="/img/avatar-female-1.jpg" class="avatar">
                            <div class="media-body">
                                <div class="chat-item-title">
                                    <span class="chat-item-author SPAN-filter-by-text" data-filter-by="text">Claire</span>
                                    <span data-filter-by="text" class="SPAN-filter-by-text">4 days ago</span>
                                </div>
                                <div class="chat-item-body DIV-filter-by-text" data-filter-by="text">
                                    <p>Hey guys, just kicking things off here in the chat window. Hope you're all ready to tackle this great project. Let's smash some Brand Concept &amp; Design!</p>

                                </div>

                            </div>
                        </div><div class="media chat-item">
                            <img alt="Peggy" src="/img/avatar-female-2.jpg" class="avatar">
                            <div class="media-body">
                                <div class="chat-item-title">
                                    <span class="chat-item-author SPAN-filter-by-text" data-filter-by="text">Peggy</span>
                                    <span data-filter-by="text" class="SPAN-filter-by-text">4 days ago</span>
                                </div>
                                <div class="chat-item-body DIV-filter-by-text" data-filter-by="text">
                                    <p>Nice one <a href="#">@Claire</a>, we've got some killer ideas kicking about already.
                                        <img src="https://media.giphy.com/media/aTeHNLRLrwwwM/giphy.gif" alt="alt text" title="Thinking">
                                    </p>

                                </div>

                            </div>
                        </div><div class="media chat-item">
                            <img alt="Marcus" src="/img/avatar-male-1.jpg" class="avatar">
                            <div class="media-body">
                                <div class="chat-item-title">
                                    <span class="chat-item-author SPAN-filter-by-text" data-filter-by="text">Marcus</span>
                                    <span data-filter-by="text" class="SPAN-filter-by-text">3 days ago</span>
                                </div>
                                <div class="chat-item-body DIV-filter-by-text" data-filter-by="text">
                                    <p>Roger that boss! <a href="">@Ravi</a> and I have already started gathering some stuff for the mood boards, excited to start! 🔥</p>

                                </div>

                            </div>
                        </div><div class="media chat-item">
                            <img alt="Ravi" src="/img/avatar-male-3.jpg" class="avatar">
                            <div class="media-body">
                                <div class="chat-item-title">
                                    <span class="chat-item-author SPAN-filter-by-text" data-filter-by="text">Ravi</span>
                                    <span data-filter-by="text" class="SPAN-filter-by-text">3 days ago</span>
                                </div>
                                <div class="chat-item-body DIV-filter-by-text" data-filter-by="text">
                                    <h1 id="-">😉</h1>

                                </div>

                            </div>
                        </div><div class="media chat-item">
                            <img alt="Claire" src="/img/avatar-female-1.jpg" class="avatar">
                            <div class="media-body">
                                <div class="chat-item-title">
                                    <span class="chat-item-author SPAN-filter-by-text" data-filter-by="text">Claire</span>
                                    <span data-filter-by="text" class="SPAN-filter-by-text">2 days ago</span>
                                </div>
                                <div class="chat-item-body DIV-filter-by-text" data-filter-by="text">
                                    <p>Can't wait! <a href="#">@David</a> how are we coming along with the <a href="#">Client Objective Meeting</a>?</p>

                                </div>

                            </div>
                        </div><div class="media chat-item">
                            <img alt="David" src="/img/avatar-male-4.jpg" class="avatar">
                            <div class="media-body">
                                <div class="chat-item-title">
                                    <span class="chat-item-author SPAN-filter-by-text" data-filter-by="text">David</span>
                                    <span data-filter-by="text" class="SPAN-filter-by-text">Yesterday</span>
                                </div>
                                <div class="chat-item-body DIV-filter-by-text" data-filter-by="text">
                                    <p>Coming along nicely, we've got a draft for the client questionnaire completed, take a look! 🤓</p>

                                </div>

                                <div class="media media-attachment">
                                    <div class="avatar bg-primary">
                                        <i class="material-icons">insert_drive_file</i>
                                    </div>
                                    <div class="media-body">
                                        <a href="#" data-filter-by="text" class="A-filter-by-text">questionnaire-draft.doc</a>
                                        <span data-filter-by="text" class="SPAN-filter-by-text">24kb Document</span>
                                    </div>
                                </div>

                            </div>
                        </div><div class="media chat-item">
                            <img alt="Sally" src="/img/avatar-female-3.jpg" class="avatar">
                            <div class="media-body">
                                <div class="chat-item-title">
                                    <span class="chat-item-author SPAN-filter-by-text" data-filter-by="text">Sally</span>
                                    <span data-filter-by="text" class="SPAN-filter-by-text">2 hours ago</span>
                                </div>
                                <div class="chat-item-body DIV-filter-by-text" data-filter-by="text">
                                    <p>Great start guys, I've added some notes to the task. We may need to make some adjustments to the last couple of items - but no biggie!</p>

                                </div>

                            </div>
                        </div><div class="media chat-item">
                            <img alt="Peggy" src="/img/avatar-female-2.jpg" class="avatar">
                            <div class="media-body">
                                <div class="chat-item-title">
                                    <span class="chat-item-author SPAN-filter-by-text" data-filter-by="text">Peggy</span>
                                    <span data-filter-by="text" class="SPAN-filter-by-text">Just now</span>
                                </div>
                                <div class="chat-item-body DIV-filter-by-text" data-filter-by="text">
                                    <p>Well done <a href="#">@all</a>. See you all at 2 for the kick-off meeting. 🤜</p>

                                </div>

                            </div>
                        </div></div>
                </div>
                <div class="chat-module-bottom">
                    <form class="chat-form">
                        <textarea class="form-control" placeholder="Type message" rows="1" style="overflow: hidden; word-wrap: break-word; resize: none; height: 40px;"></textarea>
                        <div class="chat-form-buttons">
                            <button type="button" class="btn btn-link">
                                <i class="material-icons">tag_faces</i>
                            </button>
                            <div class="custom-file custom-file-naked">
                                <input type="file" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">
                                    <i class="material-icons">attach_file</i>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section ('footer')
	
	

@endsection