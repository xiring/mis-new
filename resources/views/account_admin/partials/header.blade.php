<div class="dashboard-header">
    <nav class="navbar navbar-expand-lg bg-primary fixed-top">
        <a class="navbar-brand" href="{{ route('accountant.dashboard') }}"> <img src="{{ asset($system_settings->logo) }}" class="img-link" height="40px"/> </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto navbar-right-top">
                <li class="nav-item mt-2">
                    <div id="custom-search" class="top-search-bar">
                        Running Session {{ $system_settings->detail->running_session }}
                    </div>
                </li>
                <li class="nav-item ml-2">
                    <form method="get" action="{{ route('accountant.invoice.search') }}">
                        <div id="custom-search" class="top-search-bar">
                            <input class="form-control" type="number" name="inovice_id" placeholder="Search Invoice.." required>
                        </div>
                    </form>
                </li>
                <li class="nav-item dropdown nav-user">
                    <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ Auth::user()->avatar }}" alt="" class="user-avatar-md rounded-circle"></a>
                    <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                        <div class="nav-user-info">
                            <h5 class="mb-0 text-white nav-user-name">{{ Auth::user()->name }}</h5>
                        </div>
                        <a class="dropdown-item"  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-power-off mr-2"></i>Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>
