<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background: #e9500e">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('logo/logo-white.png') }}" width="100px">
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    @if (Auth::guard('admin')->check())
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fa fa-desktop"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.question.index') }}">
                <i class="fa fa-question"></i>
                <span>Question</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.employee.response.index') }}">
                <i class="fa fa-reply"></i>
                <span>Response</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.employee.feedback.index') }}">
                <i class="fa fa-comments"></i>
                <span>Feedback</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.employee.index') }}">
                <i class="fa fa-users"></i>
                <span>Employee</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fa fa-list-alt"></i>
                <span>Summary</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('admin.summary.response.index') }}">Response Question</a>
                    <a class="collapse-item" href="{{ route('admin.summary.response_employee.index') }}">Response
                        Employee</a>
                    <a class="collapse-item" href="{{ route('admin.summary.feedback.index') }}">Feedback</a>
                    <a class="collapse-item" href="{{ route('admin.summary.question.index') }}">Question</a>
                    <a class="collapse-item" href="{{ route('admin.summary.employee.index') }}">Employee</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
                aria-expanded="true" aria-controls="collapseThree">
                <i class="fa fa-calendar"></i>
                <span>HR Calendar</span>
            </a>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('admin.hr.calendar.index.list') }}">List Data</a>
                    <!--<a class="collapse-item" href="{{ route('admin.hr.calendar.index.view') }}">View-->
                    <!--    Calendar</a>-->
                </div>
            </div>
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
