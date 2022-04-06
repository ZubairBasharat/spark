<header>
    <nav class="d-flex px-4 px-md-5 align-items-center">
        <a href="{{url('/')}}" class="d-inline-block site__logo">
            <img src="{{asset('assets/images/logo.png')}}" width="210px" alt="Logo" />
        </a>
        <ul class="d-lg-flex list-unstyled align-items-center mb-0 mx-auto navbar-links d-none">
            <li>
                <a href="{{url('/about-us')}}" class="text-decoration-none"> About </a>
            </li>
            <li>
                <a href="{{url('personal-dashboard')}}" class="text-decoration-none"> My Personal Dashboard </a>
            </li>
            <li>
                <a href="{{url('action-plan')}}" class="text-decoration-none"> My Action Plan </a>
            </li>
            <li>
                <a href="{{url('resources')}}" class="text-decoration-none"> Resources </a>
            </li>
        </ul>
        <div class="user-auth-dropdown ms-auto ms-lg-0">
            <div class="dropdown">
                <button class="border-0 bg-transparent d-flex align-items-center" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{asset('/assets/images/avatar.png')}}" width="50px" height="50px" class="rounded-circle me-3"
                        alt="username" />
                    <span class="me-3">{{Session::get('user_name')}}</span>
                    <i class="bi bi-chevron-down text-red"></i>
                </button>
                <ul class="dropdown-menu">
                    <li class="dropdown-item">
                        <a href="#" class="text-decoration-none d-block">Profile</a>
                    </li>
                    <li class="dropdown-item">
                        <a href="{{url('logout')}}" class="text-decoration-none d-block">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
        <button class="bg-transparent border-0 d-lg-none" type="button" style="font-size: 28px;"  data-sidebar="nav-menu">
            <i class="bi bi-list"></i>
        </button>
    </nav>
</header>
<!-- Mobile Navigation -->
<div class="mobile-menu position-fixed bg-white h-100 pb-4 w-100 d-lg-none">
    <div class="bg-light-grey py-3 px-3 text-center sidebar-menu-header
        d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Main Menu</h5> <i class="bi bi-x f-30 text-danger cursor-pointer" data-sidebar="nav-menu"></i>
    </div>
    <div class="menu-content">
        <ul type="none" class="list-unstyled text-start p-0">
            <li>
                <a href="{{url('/about-us')}}" class="d-block px-4 py-3 text-grey text-decoration-none "> About </a>
            </li>
            <li>
                <a href="{{url('personal-dashboard')}}" class="d-block px-4 py-3 text-grey text-decoration-none "> My Personal Dashboard </a>
            </li>
            <li>
                <a href="{{url('action-plan')}}" class="d-block px-4 py-3 text-grey text-decoration-none "> My Action Plan </a>
            </li>
            <li>
                <a href="{{url('resources')}}" class="d-block px-4 py-3 text-grey text-decoration-none "> Resources </a>
            </li>
        </ul>
    </div>
</div>