@extends ('layouts.main')

@section ('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8" style="padding-top: 2.5rem;">      
      <div class="card">
        <div class="card-body" style="margin-bottom: -1rem;">
          <h1>How do I create a project?</h1>
          <div class="avatar-group">
            <a href="#" class="avatar avatar-xs">
            <img src="https://storage.googleapis.com/talentail-123456789/avatars/suIjFfp9XX3ntrojqNt9ySuBfo1F4b7LSGx60YyP.png" alt="..." class="avatar-img rounded-circle">
            </a>
          </div>
          <a href="#" style="margin-left: 0.5rem !important;">Shazwi Suwandi</a> on 18<sup>th</sup> December 2018
          <div style="margin-top: 1.5rem;">
            <h3>Introduction</h3>
            <p>Talentail was created for the sole purpose of providing an outlet for users to not only say what they've learned but instead apply that knowledge onto real world projects. Creators with a significant amount of experience have been invited to create projects for users to attempt.</p>
            <p>In this tutorial, we will go through what it takes to produce a complete project, one that is ready to be attempted by users and assessed by creators.</p>
            <br/>
            <h3>Step 0: Apply to be a Creator</h3>
            <p>If you are already a creator, proceed to Step 1. We place high importance on the quality of the creators that are on Talentail. Therefore, one has to <a href="/creator-application">apply</a> to become a creator. When you land onto the page, fill up a brief description of the type of projects that you will be creating and preferably attach some of the work you have done in the past.</p>
            <figure>
              <img src="/img/apply-creator-1.png" style="width: 100%; border-radius: 5px;" />
              <figcaption style="text-align: center; color: #6c757d !important;" class="text-small">Creator Application Form (1/2)</figcaption>
            </figure>
            <p>Once you have been approved, you will be requested to provide your paypal account for us to issue payouts to you when candidates purchase and attempts your project.</p>
            <figure>
              <img src="/img/apply-creator-2.png" style="width: 100%; border-radius: 5px;" />
              <figcaption style="text-align: center; color: #6c757d !important;" class="text-small">Creator Application Form (2/2)</figcaption>
            </figure>
            <br />
            <p>Once you've applied as a creator, you can create projects. Complete projects include:</p>
            <ol>
              <li><strong>Title</strong> - has to be unique</li>
              <li><strong>Short description</strong> - this will be visible when users browse projects</li>
              <li><strong>Industry</strong> - the industry your project is based on</li>
              <li><strong>Full description & role brief</strong> - more depth has to be given for the project and also what is expected out of the role</li>
              <li><strong>Tasks</strong> - users who purchase projects have to attempt and submit tasks in this section</li>
              <li><strong>Files</strong> - if there are files that can supplement the project, upload them in this section</li>
              <li><strong>Competencies</strong> - the skills and competencies that your project assesses for</li>
              <li><strong>Miscellaneous</strong> - project price and also duration that a user is given to complete the project</li>
            </ol>
            <br />
            <h3>Step 1: Go to the dashboard and click "Add Project"</h3>
            <figure>
              <img src="/img/dashboard-add-project.png" style="width: 100%; border-radius: 5px;" />
              <figcaption style="text-align: center; color: #6c757d !important;" class="text-small">Add Project from Dashboard Page</figcaption>
            </figure>
            <br />
            <h3>Step 2: Select role that you are creating the project for</h3>
            <figure>
              <img src="/img/select-role.png" style="width: 100%; border-radius: 5px;" />
              <figcaption style="text-align: center; color: #6c757d !important;" class="text-small">Add Project from Dashboard Page</figcaption>
            </figure>
            <br />
            <h3>Step 3: Add a project title, short description, industry, full description & role brief</h3>
            <figure>
              <img src="/img/create-project-1.png" style="width: 100%; border-radius: 5px;" />
              <figcaption style="text-align: center; color: #6c757d !important;" class="text-small">Project Creation Form (1/6)</figcaption>
            </figure>
            <br />
            <p>Decide a catchy title that captures the essence of the project that you're creating. Something generic such as "Digital Transformation Project" will not suffice as there will be many other projects that are digital transformation ones. Instead, specify more details such as "Digital Transformation Project for a Mid-sized Client within the Logistics Industry". The title will be formed into a url, therefore your project title has to be unique across the entire platform.</p>
            <p>When users browse for projects on the platform, they are able to immediately see both the project title and description. Try to condense your project description down to 280 characters so that users can be given a brief overview before retrieving more details.</p>
            <figure>
              <img src="/img/create-project-2.png" style="width: 100%; border-radius: 5px;" />
              <figcaption style="text-align: center; color: #6c757d !important;" class="text-small">Browse Projects Page</figcaption>
            </figure>
            <br />
            <h3>Step 4: Add Project Tasks</h3>
            <p>When creating projects for users, the way to assess their skills is through the attempting of tasks. You are able to click the "Add Task" button and add three different kinds of task:</p>
            <ul>
              <li>Multiple Choice Questions - both single answer and multiple answers can be enabled</li>
              <li>Open-ended - if you need users to give an essay-like answer</li>
              <li>N.A. - if you do not require eiter mcq nor open-ended answer</li>
              <li style="list-style: none;">* All three options can be accompanied with an additional option of enabling users to upload their own files</li>
            </ul>
            <br />
            <h3>Step 5: Add a project thumbnail</h3>
            <figure style="width: 49%; float: left;">
              <img src="/img/select-thumbnail.png" style="width: 100%; border-radius: 5px;" />
              <figcaption style="text-align: center; color: #6c757d !important;" class="text-small">Select an eye-catching thumbnail</figcaption>
            </figure>
            <figure style="width: 49%; float: right;">
              <img src="/img/thumbnail.png" style="width: 100%; border-radius: 5px;" />
              <figcaption style="text-align: center; color: #6c757d !important;" class="text-small">Sample Project Thumbnail</figcaption>
            </figure>
            <br style="clear:both;"/>
            <br />
            <p>Provide a catchy image as the project thumbnail as it increases the chances of grabbing the attention of users and result in them finding out further on the project details.</p>
            <br />
            <h3>Step 6: Add Supporting Files</h3>
            <p>In case you want to add supplementary files for users to attempt the tasks, add the necessary files in this section. It is advisable that you store all the files in a single folder for easier upload. In case you want to select multiple files, you can select a whole row of files by selecting the first file and pressing the "Shift" button or by selecting individual files by pressing either the "Ctrl" button on Windows or the "Command" button on Mac.</p>
            <figure style="width: 47.5%; float: left;">
              <img src="/img/create-project-4.png" style="width: 100%; border-radius: 5px;" />
              <figcaption style="text-align: center; color: #6c757d !important;" class="text-small">Selecting a Row of Files using Shift Key</figcaption>
            </figure>
            <figure style="width: 47.5%; float: right;">
              <img src="/img/create-project-5.png" style="width: 100%; border-radius: 5px;" />
              <figcaption style="text-align: center; color: #6c757d !important;" class="text-small">Selecting Individual Files using Ctrl/Option Key</figcaption>
            </figure>
            <br style="clear:both;"/>
            <br/> 
            <h3>Step 7: Map Competencies</h3>
            <p>All projects have to assess users based on a set of competencies. Each role has been pre-populated with a standard list of competencies. As a creator, you have to decide what specific competencies that your project is assessing for and map that.</p>
            <br />
            <h3>Step 8: Add Miscellaneous Information</h3>
            <p>You have to add the price to your project before users can purchase it, attempt the tasks on it and get assessed by you. On top of that, as a way to encourage users to complete the project, please decide the allocated time for each user to complete the project. The amount of hours you add onto the project will determine the deadline for users. Once this deadline is reached, the project will be closed and will not allow users to submit any more answers.</p>
          </div>
        </div>
      </div>
      <div id="disqus_thread" style="padding: 1rem;"></div>
      <script>

      /**
      *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
      *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
      
      var disqus_config = function () {
      this.page.url = "https://talentail.com/tutorials/create-projects";  // Replace PAGE_URL with your page's canonical URL variable
      this.page.identifier = "How do I create projects?"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
      };
      
      (function() { // DON'T EDIT BELOW THIS LINE
      var d = document, s = d.createElement('script');
      s.src = 'https://talentail.disqus.com/embed.js';
      s.setAttribute('data-timestamp', +new Date());
      (d.head || d.body).appendChild(s);
      })();
      </script>
      <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    </div>
  </div>
</div>
@endsection

@section ('footer')
    
    

@endsection

