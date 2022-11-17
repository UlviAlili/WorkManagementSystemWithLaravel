<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        @if(\Illuminate\Support\Facades\Auth::user()->status == 'admin')

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center"
               href="{{route('admin.dashboard')}}">
                <div class="sidebar-brand-text">Work Management</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item @if(Request::segment(1) == 'admin' && Request::segment(2) == 'panel') active @endif">
                <a class="nav-link" href="{{route('admin.dashboard')}}">
                    <i class="fas fa-fw fa-solar-panel"></i>
                    <span>Panel</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Content Management
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item @if(Request::segment(1) == 'admin' && Request::segment(2) == 'project') active @endif">
                <a class="nav-link @if(Request::segment(1) == 'admin' && Request::segment(2) == 'project') in @else collapsed @endif"
                   href="#"
                   data-toggle="collapse" data-target="#collapseProject"
                   aria-expanded="true" aria-controls="collapseProject">
                    <i class="fas fa-fw fa-layer-group"></i>
                    <span>Projects</span>
                </a>
                <div id="collapseProject"
                     class="collapse @if(Request::segment(1) == 'admin' && Request::segment(2) == 'project') show @endif"
                     aria-labelledby="headingProject" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Project Processing:</h6>
                        <a class="collapse-item @if(Request::segment(1) == 'admin' && Request::segment(2) == 'project' && !Request::segment(3)) active @endif"
                           href="{{route('admin.project.index')}}">All Projects</a>
                        <a class="collapse-item @if(Request::segment(1) == 'admin' && Request::segment(2) == 'project' && Request::segment(3) == 'create') active @endif"
                           href="{{route('admin.project.create')}}">Create New Project</a>
                    </div>
                </div>
            </li>

            <li class="nav-item @if(Request::segment(1) == 'admin' && Request::segment(2) == 'addUser') active @endif">
                <a class="nav-link @if(Request::segment(1) == 'admin' && Request::segment(2) == 'addUser') in @else collapsed @endif"
                   href="#"
                   data-toggle="collapse" data-target="#collapseTeam"
                   aria-expanded="true" aria-controls="collapseTeam">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Team</span>
                </a>
                <div id="collapseTeam"
                     class="collapse @if(Request::segment(1) == 'admin' && Request::segment(2) == 'addUser') show @endif"
                     aria-labelledby="headingTeam"
                     data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Team Processing:</h6>
                        <a class="collapse-item @if(Request::segment(1) == 'admin' && Request::segment(2) == 'addUser' && !Request::segment(3)) active @endif"
                           href="{{route('admin.addUser.index')}}">All Team Members</a>
                        <a class="collapse-item @if(Request::segment(1) == 'admin' && Request::segment(2) == 'addUser' && Request::segment(3) == 'create') active @endif"
                           href="{{route('admin.addUser.create')}}">Add New User</a>
                    </div>
                </div>
            </li>

        @elseif(\Illuminate\Support\Facades\Auth::user()->status == 'user')

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center"
               href="{{route('user.dashboard')}}">
                <div class="sidebar-brand-text">Work Management</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item @if(Request::segment(1) == 'user' && Request::segment(2) == 'panel') active @endif">
                <a class="nav-link" href="{{route('user.dashboard')}}">
                    <i class="fas fa-fw fa-solar-panel"></i>
                    <span>Panel</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Content Management
            </div>

            <!-- Nav Item - Dashboard -->
            <li class="nav-item @if(Request::segment(1) == 'user' && Request::segment(2) == 'project') active @endif">
                <a class="nav-link" href="{{route('user.project.index')}}">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>Projects</span></a>
            </li>

        @endif

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-black-50">
                                <b class="name1">{{\Illuminate\Support\Facades\Auth::user()->name}}
                                    <i class="fa fa-caret-down"></i> </b></span>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{route('profile')}}">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>

            <div class="container-fluid project-scroll">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">@yield('title','Dashboard')</h1>
                </div>
