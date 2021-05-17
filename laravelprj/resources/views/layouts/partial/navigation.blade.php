<nav class="navbar navbar-expand-lg navbar-light bg-light" style="position: absolute; right:150px;padding: 0rem 0rem;">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto" style="flex-direction: row;">
                @if(! auth()->check())
                @else
                    <li class="nav-item active">
                        <a class="nav-link" href="/{{strtolower(auth()->user()->getuserRoles()[0]["name"])}}/reserve" style="padding-right: .5rem; padding-left: .5rem;">
                            <i class="fa fa-clipboard"></i>Reserve</a>
                    </li>
                    <li class="nav-item active">

                        <a class="nav-link" href="/board" style="padding-right: .5rem; padding-left: .5rem;">
                            <i class="fa fa-comments icon"></i>Board</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" style="padding-right: .5rem; padding-left: .5rem;">
                            <i class="fa fa-user icon"></i> {{ auth()->user()->name }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('sessions.destroy') }}" style="padding-right: .5rem; padding-left: .5rem;"><i class="fa fa-sign-out icon"></i>Log out</a>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
</nav>
