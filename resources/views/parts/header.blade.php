<!-- Top Bar
		============================================= -->
		<div id="top-bar" class="d-none d-md-block">

			<div class="container clearfix">

				<div class="col_half nobottommargin">

					<p class="nobottommargin"><strong>Call:</strong> 1800-547-2145 | <strong>Email:</strong> herlambangadt@gmail.com</p>

				</div>

				<div class="col_half col_last fright nobottommargin">

					<!-- Top Links
					============================================= -->
					<div class="top-links">
						<ul>
							@if (!isset($header) || $header == 'guest')
								<li><a href="{{url('/register')}}">Register</a></li>
								<li><a href="#">Login</a>
									<div class="top-link-section">
										<form method="POST" action="{{ url('/login') }}">
											@csrf
											<div class="input-group" id="top-login-username">
												<div class="input-group-prepend">
													<div class="input-group-text"><i class="icon-user"></i></div>
												</div>
												<input id="email" type="text" class="form-control" name="email" value="" required autofocus>
												@if ($errors->has('email'))
													<span class="invalid-feedback" role="alert">
														<strong>{{ $errors->first('email') }}</strong>
													</span>
												@endif
											</div>
											<div class="input-group" id="top-login-password">
												<div class="input-group-prepend">
													<div class="input-group-text"><i class="icon-key"></i></div>
												</div>
												<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

												@if ($errors->has('password'))
													<span class="invalid-feedback" role="alert">
														<strong>{{ $errors->first('password') }}</strong>
													</span>
												@endif										</div>
											<label class="checkbox">
												<input class="form-check-input" type="checkbox" name="remember" value="true" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
											</label>
											<button type="submit" class="btn btn-primary">
												{{ __('Login') }}
											</button>

											@if (Route::has('password.request'))
												<a class="btn btn-link" href="{{ route('password.request') }}">
													{{ __('Forgot Your Password?') }}
												</a>
											@endif
										</form>
									</div>
								</li>
							@elseif($header == 'admin')
								<li><a href="{{url('/admin')}}">Admin Dashboard</a>
								</li>
								<li><a href="{{route('logout')}}">Logout</a>
								</li>
							@elseif($header == 'customer')
								<li><a href="{{route('logout')}}">Logout</a>
								</li>
							@endif
						</ul>
					</div><!-- .top-links end -->

				</div>

			</div>

		</div><!-- #top-bar end -->

		<!-- Header
		============================================= -->
		<header id="header">

			<div id="header-wrap">

				<div class="container clearfix">

					<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

					<!-- Logo
					============================================= -->
					<div id="logo">
						<a href="{{url('/')}}" class="standard-logo" data-dark-logo="{{asset('images/logo-dark.png')}}"><img src="{{asset('images/logo.png')}}" alt="Canvas Logo"></a>
						<a href="{{url('/')}}" class="retina-logo" data-dark-logo="{{asset('images/logo-dark@2x.png')}}"><img src="{{asset('images/logo@2x.png')}}" alt="Canvas Logo"></a>
					</div><!-- #logo end -->

					<!-- Primary Navigation
					============================================= -->
					<nav id="primary-menu">

						<ul>
							<li class="mega-menu"><a href="#"><div>Categories</div><span>Out of the Box</span></a>
								<div class="mega-menu-content style-2 clearfix">
									<ul class="mega-menu-column col-lg-3">
										<li class="mega-menu-title"><a href="#"><div>Men</div></a>
											<ul>
                                                @foreach ($dataCategory as $category)
                                                    @if ($category->gender == '1')
                                                        <li><a href="{{url('/category/'.$category->id)}}"><div>{{$category->category_name}}</div></a></li>
                                                    @endif
                                                @endforeach
											</ul>
										</li>
									</ul>
									<ul class="mega-menu-column col-lg-3">
										<li class="mega-menu-title"><a href="#"><div>Women</div></a>
											<ul>
                                                @foreach ($dataCategory as $category)
                                                    @if ($category->gender == '2')
                                                        <li><a href="{{url('/category/'.$category->id)}}"><div>{{$category->category_name}}</div></a></li>
                                                    @endif
                                                @endforeach
											</ul>
										</li>
									</ul>
								</div>
                            </li>
                            @if (isset($header) && $header == 'customer')
                                @php
                                    $adaNotif = 0;
                                    Auth::shouldUse('user');
                                    $user = Auth::user();
                                    $notification = $user->unreadNotifications;
                                @endphp
                                @foreach ($notification as $notif)
                                    @php
                                        $adaNotif++;
                                    @endphp
                                @endforeach
                                <li class="mega-menu"><a href="{{url('/transaction')}}"><div>Transaction ({{$transactionCount}})</div></a></li>
                                <li class="mega-menu"><a href="{{url('/notification')}}"><div>Notification ({{$adaNotif}})</div></a></li>
                            @endif
						</ul>

						@if (isset($header) && $header == 'customer')
							<!-- Top Cart
							============================================= -->
							<div id="top-cart">
								<a href="#" id="top-cart-trigger"><i class="icon-shopping-cart"></i><span>{{$cartCount}}</span></a>
								<div class="top-cart-content">
									<div class="top-cart-title">
										<h4>Shopping Cart</h4>
									</div>
									<div class="top-cart-items">

                                        @if ($cartData != "")
                                            @foreach ($cartData as $cart)
                                                <div class="top-cart-item clearfix">
                                                    <div class="top-cart-item-image">
                                                        @php
                                                            $a = 0;
                                                        @endphp
                                                        @foreach ($cart->product->product_image as $image)
                                                            @if ($a < 1)
                                                                <a href="#"><img src="{{asset('product_images/'.$image->image_name)}}" alt="Blue Round-Neck Tshirt" /></a>
                                                            @endif
                                                            @php
                                                                $a++;
                                                            @endphp
                                                        @endforeach
                                                    </div>
                                                    <div class="top-cart-item-desc">
                                                        <a href="#">{{$cart->product->product_name}}</a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif


									</div>
									<div class="top-cart-action clearfix">
										<button onClick="window.location.href='{{url('/cart')}}'" class="button button-3d button-small nomargin fright">View Cart</button>
									</div>
								</div>
							</div><!-- #top-cart end -->
                        @endif


					</nav><!-- #primary-menu end -->

				</div>

			</div>

		</header><!-- #header end -->
