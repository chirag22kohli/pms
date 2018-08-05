<!-- Sidebar Holder -->
<nav id="sidebar">
    <div class="sidebar-header">
        <h1>
            <a href="index.html">Chap   <i class="fab fa-connectdevelop"></i></a>
        </h1>
        <span>C</span>
    </div>
    <div class="profile-bg"></div>
    <ul class="list-unstyled components">
        <li>
            <a href="{{url('client/home')}}">
                <i class="fas fa-th-large"></i>
                Dashboard
            </a>
        </li>
        
        <li>
            <a href="{{url('admin/projects/create')}}">
                <i class="fab fa-connectdevelop"></i>
                Create Project
            </a>
        </li>
        <li>
            <a href="grids.html">
                <i class="fas fa-th"></i>
                View Projects
            </a>
        </li>
        <li class="active">
            <a href="#pageSubmenu1" data-toggle="collapse" aria-expanded="false">
                <i class="far fa-file"></i>
                Assets
                <i class="fas fa-angle-down fa-pull-right"></i>
            </a>
            <ul class="collapse list-unstyled" id="pageSubmenu1">
                <li>
                    <a href="404.html">Trackers</a>
                </li>
                <li>
                    <a href="500.html">Objects</a>
                </li>
                
            </ul>
        </li>
        <li>
            <a href="widgets.html">
                <i class="far fa-user"></i>
                Profile
            </a>
        </li>
        <li>
            <a href="widgets.html">
                <i class="far fa-file"></i>
                Plan Info
            </a>
        </li>
        <li>
            <a href="mailbox.html">
                <i class="far fa-envelope"></i>
                Support
               
            </a>
        </li>
        
      
       
        <li>
            <a href="maps.html">
                <i class="fas fa-link"></i>
                Settings
            </a>
        </li>
    </ul>
</nav>