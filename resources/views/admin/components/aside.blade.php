
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- User profile -->
                <div class="user-profile" style="background: url({{asset('assets/images/background/user-info.jpg')}}) no-repeat;">
                    <!-- User profile image -->
                    <div class="profile-img"> <img src="{{asset('assets/images/users/profile.png')}}"  alt="user" /> </div>
                    <!-- User profile text-->
                    <div class="profile-text"> <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">User</a>
                        <div class="dropdown-menu animated flipInY">
                            <div class="dropdown-divider"></div>
                            <a href="login.html" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                        </div>
                    </div>
                </div>
                <!-- End User profile text-->
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">Menu</li>
                        <li>
                            <a class="waves-effect waves-dark" href="{{url('/admin')}}" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard </span></a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="{{url('/admin/dataadmin')}}" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Data Admin </span></a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="{{url('/admin/productcategory')}}" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Product Categories </span></a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="{{url('/admin/courier')}}" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Courier </span></a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="{{url('/admin/product')}}" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Product </span></a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="{{url('/admin/transaction')}}" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Transaction </span></a>
                        </li>
                        {{-- <li>
                            <a class="waves-effect waves-dark" href="/createtemplate" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Create Template </span></a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="/menugenerate" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Generate </span></a>
                        </li> --}}
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
            <!-- Bottom points-->
            <div class="sidebar-footer">
                <!-- item-->
                <a href="" class="link" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a>
            </div>
            <!-- End Bottom points-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
