<!-- Sidebar Holder -->
<?php
$userPlan = \App\   UserPlan::where('user_id', Auth::id())->first();
$planInfo = App\Plan::where('id', $userPlan->plan_id)->first();
?>
<nav id="sidebar">
    <div class="sidebar-header">
        <h1>
            <a href="{{url('homepage')}}">Chap   <i class="fab fa-connectdevelop"></i></a>
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
            <a href="{{url('admin/projects')}}">
                <i class="fas fa-th"></i>
                Create/View Projects
            </a>
        </li>
        <!--<li class="active">
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
        </li> -->
        <li>
            <a href="{{url('client/profile')}}">
                <i class="far fa-user"></i>
                Profile
            </a>
        </li>
        <li>
            <a href="{{url('client/planinfo')}}">
                <i class="far fa-file"></i>
                Plan Info
            </a>
        </li>
        <li>
            <a href="{{url('client/scanpack')}}">
                <i class="far fa-file"></i>
                Scan Pack Usage/Limit
            </a>
        </li>
        <li>
            <a href="{{url('client/reports')}}">
                <i class="far fa-chart-bar"></i>
                Reports
            </a>
        </li>
        <li>
            <a href="{{url('client/support')}}">
                <i class="far fa-envelope"></i>
                Support

            </a>
        </li>
        <?php if ($planInfo->is_ecom == '1') { ?>
            <li>
                <a href="{{url('client/ecommerce')}}">
                    <i class="fa fa-cart-plus"></i>
                    Ecommerce 

                </a>
            </li>
        <?php } ?>


        <!-- <li>
             <a href="#">
                 <i class="fas fa-link"></i>
                 Settings
             </a>
         </li> -->
    </ul>
</nav>