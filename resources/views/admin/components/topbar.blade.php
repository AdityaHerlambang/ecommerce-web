
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{url('/')}}">
                        <!-- Logo icon -->
                        <h3 style="color:white;">Shop<span> <b>Admin</b></span></h3>
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>


                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">

                            <li class="nav-item dropdown notif">
                                    <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-message"></i>
                                        @php
                                            $adaNotif = 0;
                                            Auth::shouldUse('admin');
                                            $admin = Auth::user();
                                            $notification = $admin->unreadNotifications;
                                        @endphp
                                        @foreach ($notification as $notif)
                                            @php
                                                $adaNotif = 1;
                                            @endphp
                                            <a href="#">
                                                <div class="mail-contnet">
                                                    <h5>{{$notif->data}}</h5> <span class="mail-desc"></span> <span class="time">{{$notif->created_at}}</span>
                                                </div>
                                            </a>
                                        @endforeach
                                        @if ($adaNotif)
                                            <div class="notify adanotif"> <span class="heartbit"></span> <span class="point"></span> </div>
                                        @endif
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
                                        <ul>
                                            <li>
                                                <div class="drop-title">Notifications</div>
                                            </li>
                                            <li>
                                                <div class="message-center">
                                                    @php
                                                        Auth::shouldUse('admin');
                                                        $admin = Auth::user();
                                                        $notification = $admin->unreadNotifications;
                                                    @endphp
                                                    @foreach ($notification as $notif)
                                                        <a href="#">
                                                            <div class="mail-contnet">
                                                                <h5>{{$notif->data}}</h5> <span class="mail-desc"></span> <span class="time">{{$notif->created_at}}</span>
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <script>
                                        jQuery(document).ready(function ($) {
                                            $(function(){

                                                $('.notif').click(function(){
                                                    $('.adanotif').hide();

                                                    $.ajax({
                                                        type:"GET",
                                                        url : "{{url('admin/notif/clear')}}",
                                                        data : "val=empty",
                                                        async: false,
                                                        success : function(response) {
                                                            data = response;
                                                            return response;
                                                        },
                                                        error: function() {
                                                            alert('Error occured');
                                                        }
                                                    });

                                                });

                                            });

                                        });
                                    </script>

                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('assets/images/users/1.jpg')}}" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="{{asset('assets/images/users/1.jpg')}}" alt="user"></div>
                                            <div class="u-text">
                                                <h4>User</h4>
                                                <p class="text-muted">Administrator</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{route('logout')}}"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
