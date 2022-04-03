<header>
    <nav class="d-flex px-5 align-items-center">
        <a href="{{url('/')}}" class="d-inline-block">
            <img src="{{asset('assets/images/logo.png')}}" width="210px" alt="Logo" />
        </a>
        <ul class="d-flex list-unstyled align-items-center mb-0 mx-auto navbar-links">
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
        <div class="user-auth-dropdown">
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
    </nav>
</header>