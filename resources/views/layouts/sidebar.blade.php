
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{route('dashboard')}}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link " data-bs-target="#tables-nav2" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>User</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav2" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{route('user.create')}}">
                        <i class="bi bi-circle"></i><span>Add User</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('user.listing')}}" class="active">
                        <i class="bi bi-circle"></i><span>Show</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link " data-bs-target="#tables-nav7" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>Party Transaction</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav7" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{route('party_transaction.create')}}">
                        <i class="bi bi-circle"></i><span>Add Party Transaction</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('party_transaction.listing')}}" class="active">
                        <i class="bi bi-circle"></i><span>Show</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link " data-bs-target="#tables-nav8" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>Account Sub Account</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav8" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{route('account_sub_account.create')}}">
                        <i class="bi bi-circle"></i><span>Add Manage Account</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('account_sub_account.listing')}}" class="active">
                        <i class="bi bi-circle"></i><span>Show</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link " data-bs-target="#tables-nav10" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>Manage Permission</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav10" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{route('role_permission.create')}}">
                        <i class="bi bi-circle"></i><span>Manage Permission</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('role_permission.listing')}}" class="active">
                        <i class="bi bi-circle"></i><span>Show</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link " data-bs-target="#tables-nav11" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>Party Transaction</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav11" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{route('party_transaction.create')}}">
                        <i class="bi bi-circle"></i><span>Add Party Transaction</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('party_transaction.listing')}}" class="active">
                        <i class="bi bi-circle"></i><span>Show</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link " data-bs-target="#tables-nav12" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>Manage Transaction</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav12" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{route('party_account_transaction.create')}}">
                        <i class="bi bi-circle"></i><span>Add Manage Transaction</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('party_account_transaction.listing')}}" class="active">
                        <i class="bi bi-circle"></i><span>Show</span>
                    </a>
                </li>
            </ul>
        </li>


{{--        <li class="nav-heading">Pages</li>--}}

{{--        <li class="nav-item">--}}
{{--            <a class="nav-link collapsed" href="users-profile.html">--}}
{{--                <i class="bi bi-person"></i>--}}
{{--                <span>Profile</span>--}}
{{--            </a>--}}
{{--        </li><!-- End Profile Page Nav -->--}}

{{--        <li class="nav-item">--}}
{{--            <a class="nav-link collapsed" href="pages-faq.html">--}}
{{--                <i class="bi bi-question-circle"></i>--}}
{{--                <span>F.A.Q</span>--}}
{{--            </a>--}}
{{--        </li><!-- End F.A.Q Page Nav -->--}}

{{--        <li class="nav-item">--}}
{{--            <a class="nav-link collapsed" href="pages-contact.html">--}}
{{--                <i class="bi bi-envelope"></i>--}}
{{--                <span>Contact</span>--}}
{{--            </a>--}}
{{--        </li><!-- End Contact Page Nav -->--}}

{{--        <li class="nav-item">--}}
{{--            <a class="nav-link collapsed" href="pages-register.html">--}}
{{--                <i class="bi bi-card-list"></i>--}}
{{--                <span>Register</span>--}}
{{--            </a>--}}
{{--        </li><!-- End Register Page Nav -->--}}

{{--        <li class="nav-item">--}}
{{--            <a class="nav-link collapsed" href="pages-login.html">--}}
{{--                <i class="bi bi-box-arrow-in-right"></i>--}}
{{--                <span>Login</span>--}}
{{--            </a>--}}
{{--        </li><!-- End Login Page Nav -->--}}

{{--        <li class="nav-item">--}}
{{--            <a class="nav-link collapsed" href="pages-error-404.html">--}}
{{--                <i class="bi bi-dash-circle"></i>--}}
{{--                <span>Error 404</span>--}}
{{--            </a>--}}
{{--        </li><!-- End Error 404 Page Nav -->--}}

{{--        <li class="nav-item">--}}
{{--            <a class="nav-link collapsed" href="pages-blank.html">--}}
{{--                <i class="bi bi-file-earmark"></i>--}}
{{--                <span>Blank</span>--}}
{{--            </a>--}}
{{--        </li><!-- End Blank Page Nav -->--}}

    </ul>

</aside><!-- End Sidebar-->
