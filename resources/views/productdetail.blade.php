<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="SemiColonWeb" />

	<!-- Stylesheets
	============================================= -->
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Raleway:300,400,500,600,700|Crete+Round:400i" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="{{asset('css/bootstrap.css')}}" type="text/css" />
	<link rel="stylesheet" href="{{asset('style.css')}}" type="text/css" />
	<link rel="stylesheet" href="{{asset('css/dark.css')}}" type="text/css" />
	<link rel="stylesheet" href="{{asset('css/font-icons.css')}}" type="text/css" />
	<link rel="stylesheet" href="{{asset('css/animate.css')}}" type="text/css" />
	<link rel="stylesheet" href="{{asset('css/magnific-popup.css')}}" type="text/css" />

	<link rel="stylesheet" href="{{asset('css/responsive.css')}}" type="text/css" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<!-- SLIDER REVOLUTION 5.x CSS SETTINGS -->
	<link rel="stylesheet" type="text/css" href="{{asset('include/rs-plugin/css/settings.css')}}" media="screen" />
	<link rel="stylesheet" type="text/css" href="{{asset('include/rs-plugin/css/layers.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('include/rs-plugin/css/navigation.css')}}">


    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


	<!-- Document Title
	============================================= -->
	<title>Product</title>

	<style>

		.revo-slider-emphasis-text {
			font-size: 58px;
			font-weight: 700;
			letter-spacing: 1px;
			font-family: 'Raleway', sans-serif;
			padding: 15px 20px;
			border-top: 2px solid #FFF;
			border-bottom: 2px solid #FFF;
		}

		.revo-slider-desc-text {
			font-size: 20px;
			font-family: 'Lato', sans-serif;
			width: 650px;
			text-align: center;
			line-height: 1.5;
		}

		.revo-slider-caps-text {
			font-size: 16px;
			font-weight: 400;
			letter-spacing: 3px;
			font-family: 'Raleway', sans-serif;
		}

		.tp-video-play-button { display: none !important; }

		.tp-caption { white-space: nowrap; }

	</style>

</head>

<body class="stretched">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">

        @include('parts.header')

        <!-- Page Title
		============================================= -->
		<section id="page-title">

			<div class="container clearfix">
				<h1>{{$product->product_name}}</h1>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
					<li class="breadcrumb-item active" aria-current="page">{{$product->product_name}}</li>
				</ol>
			</div>

		</section><!-- #page-title end -->

		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap">

				<div class="container clearfix">

					<div class="single-product">

						<div class="product">

							<div class="col_two_fifth">

								<!-- Product Single - Gallery
								============================================= -->
								<div class="product-image">
									<div class="fslider" data-pagi="false" data-arrows="false" data-thumbs="true">
										<div class="flexslider">
											<div class="slider-wrap" data-lightbox="gallery">
                                                 {{-- Images --}}
                                                @php
                                                    $i = 0;
                                                @endphp
                                                @foreach ($product->product_image as $image)
                                                    @php
                                                        $i++;
                                                    @endphp
                                                    @if ($i < 3)
                                                        <div class="slide" data-thumb="{{url('product_images/'.$image->image_name)}}">
                                                            <a href="{{url('product/'.$image->product_id)}}" data-lightbox="gallery-item"><img src="{{url('product_images/'.$image->image_name)}}"></a>
                                                        </div>
                                                    @endif
                                                @endforeach
											</div>
										</div>
                                    </div>

                                    {{-- Discount --}}
                                    @php
                                        $a = 0; $discountpercentage = 0;
                                    @endphp
                                    @foreach ($product->discount as $discount)
                                        @php

                                            // Convert to timestamp
                                            $start_ts = strtotime($discount->start);
                                            $end_ts = strtotime($discount->end);
                                            $user_ts = strtotime($today);

                                        @endphp
                                        @if (($user_ts >= $start_ts) && ($user_ts <= $end_ts))
                                            @php
                                                $a = 1; $discountpercentage = $discount->percentage;
                                            @endphp
                                            <div class="sale-flash">{{$discount->percentage}}% Off*</div>
                                        @endif
                                    @endforeach
								</div><!-- Product Single - Gallery End -->

							</div>

							<div class="col_two_fifth product-desc">

								<!-- Product Single - Price
								============================================= -->
								@if ($a == 1) {{-- Ada Discount --}}
                                    <div class="product-price"><del>Rp. {{$product->price}}</del> <ins>Rp. {{$product->price - (($product->price * $discountpercentage) / 100)}}</ins></div>
                                @else
                                    <div class="product-price"><ins>Rp. {{$product->price}}</ins></div>
                                @endif

								<!-- Product Single - Rating
								============================================= -->
								<div class="product-rating">
                                    @php
                                        $a = 5;
                                    @endphp
                                    @for ($i = 0; $i < $product->product_rate; $i++)
                                        @php
                                            $a--;
                                        @endphp
                                        <i class="icon-star3"></i>
                                    @endfor
                                    @for ($i = 0; $i < $a; $i++)
                                        <i class="icon-star-empty"></i>
                                    @endfor
                                </div>

								<div class="clear"></div>
								<div class="line"></div>

								<!-- Product Single - Quantity & Cart Button
                                ============================================= -->
                                @if (Auth::guard('user')->check())
                                    <form class="cart nobottommargin clearfix" method="post" action="{{url('/cart')}}" enctype='multipart/form-data'>
                                        @method('POST')
                                        @csrf
                                        @php
                                            Auth::shouldUse('user')
                                        @endphp
                                        <div class="quantity clearfix">
                                            <input type="hidden" name="product_id" value="{{$product->id}}">
                                            <input type="hidden" name="user_id" value="{{Auth::id()}}">
                                            <input type="hidden" name="status" value="notyet">
                                            <input type="button" value="-" class="minus">
                                            <input type="text" step="1" min="1"  name="qty" value="1" title="Qty" class="qty" size="4" />
                                            <input type="button" value="+" class="plus">
                                        </div>
                                        <button type="submit" class="add-to-cart button nomargin">Add to cart</button>
                                    </form><!-- Product Single - Quantity & Cart Button End -->
                                @endif
                                @if (isset($addsuccess))
                                    <script>
                                        swal("Success", "{{$addsuccess}}", "success");
                                    </script>
                                @endif
                                @if (isset($carterror))
                                    <script>
                                        swal("Error", "{{$carterror}}", "error");
                                    </script>
                                @endif

								<div class="clear"></div>
								<div class="line"></div>

								<!-- Product Single - Short Description
								============================================= -->

								<p>{{$product->description}}</p>

								<!-- Product Single - Short Description End -->

								<!-- Product Single - Meta
								============================================= -->
								<div class="card product-meta">
									<div class="card-body">
                                        <span itemprop="productID" class="sku_wrapper">Weight: <span class="sku">{{$product->weight}} kg</span></span>
                                        <br>
										<span class="posted_in">Stock: <a rel="tag">{{$product->stock}}</a>.</span>
									</div>
								</div><!-- Product Single - Meta End -->

							</div>

							<div class="col_one_fifth col_last">

								<div class="divider divider-center"><i class="icon-circle-blank"></i></div>

								<div class="feature-box fbox-plain fbox-dark fbox-small">
									<div class="fbox-icon">
										<i class="icon-thumbs-up2"></i>
									</div>
									<h3>100% Original</h3>
									<p class="notopmargin">We guarantee you the sale of Original Brands.</p>
								</div>

							</div>

							<div class="col_full nobottommargin">

								<div class="tabs clearfix nobottommargin" id="tab-1">

									<ul class="tab-nav clearfix">
										<li><a href="#tabs-3"><i class="icon-star3"></i><span class="d-none d-md-inline-block"> Reviews</span></a></li>
									</ul>

									<div class="tab-container">

										<div class="tab-content clearfix" id="tabs-3">

											<div id="reviews" class="clearfix">

												<ol class="commentlist clearfix">
                                                @foreach ($product->product_review as $review)
                                                    <li class="comment even thread-even depth-1" id="li-comment-1">
                                                        <div id="comment-1" class="comment-wrap clearfix">

                                                            <div class="comment-meta">
                                                                <div class="comment-author vcard">
                                                                    <span class="comment-avatar clearfix">
                                                                    <img alt='' src="{{asset('user_profile_images/'.$review->user->profile_image)}}" height='60' width='60' /></span>
                                                                </div>
                                                            </div>

                                                            <div class="comment-content clearfix">
                                                                <div class="comment-author">{{$review->user->name}}<span><a href="#" title="Permalink to this comment">{{$review->created_at}}</a></span></div>
                                                                <p>{{$review->content}}</p>
                                                                <div class="review-comment-ratings">
                                                                    @php
                                                                        $a = 5;
                                                                    @endphp
                                                                    @for ($i = 0; $i < $review->rate; $i++)
                                                                        @php
                                                                            $a--;
                                                                        @endphp
                                                                        <i class="icon-star3"></i>
                                                                    @endfor
                                                                    @for ($i = 0; $i < $a; $i++)
                                                                        <i class="icon-star-empty"></i>
                                                                    @endfor
                                                                </div>
                                                            </div>

                                                            <div class="clear"></div>

                                                        </div>
                                                    </li>
                                                @endforeach

												</ol>

												<!-- Modal Reviews
                                                ============================================= -->
                                                @if (Auth::guard('user')->check())
												    <a href="#" data-toggle="modal" data-target="#reviewFormModal" class="button button-3d nomargin fright">Add a Review</a>
                                                @endif

												<div class="modal fade" id="reviewFormModal" tabindex="-1" role="dialog" aria-labelledby="reviewFormModalLabel" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title" id="reviewFormModalLabel">Submit a Review</h4>
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															</div>
															<div class="modal-body">
                                                                <form class="nobottommargin" id="template-reviewform" name="template-reviewform" action="{{url('/review/submit')}}" method="post">
                                                                    @method('POST')
                                                                    @csrf

                                                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                                                    <input type="hidden" name="user_id" value="{{Auth::id()}}">

																	<div class="col_full col_last">
																		<label for="template-reviewform-rating">Rating</label>
																		<select id="template-reviewform-rating" name="rate" class="form-control">
																			<option value="">-- Select One --</option>
																			<option value="1">1</option>
																			<option value="2">2</option>
																			<option value="3">3</option>
																			<option value="4">4</option>
																			<option value="5">5</option>
																		</select>
																	</div>

																	<div class="clear"></div>

																	<div class="col_full">
																		<label for="template-reviewform-comment">Comment <small>*</small></label>
																		<textarea class="required form-control" id="template-reviewform-comment" name="content" rows="6" cols="30"></textarea>
																	</div>

																	<div class="col_full nobottommargin">
																		<button class="button button-3d nomargin" type="submit" id="template-reviewform-submit" name="template-reviewform-submit" value="submit">Submit Review</button>
																	</div>

																</form>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
															</div>
														</div><!-- /.modal-content -->
													</div><!-- /.modal-dialog -->
												</div><!-- /.modal -->
												<!-- Modal Reviews End -->

											</div>

										</div>

									</div>

								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

		</section><!-- #content end -->

		@include('parts.footer')

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>

	<!-- External JavaScripts
	============================================= -->
	<script src="{{asset('js/plugins.js')}}"></script>

	<!-- Footer Scripts
	============================================= -->
	<script src="{{asset('js/functions.js')}}"></script>

	<!-- SLIDER REVOLUTION 5.x SCRIPTS  -->
	<script src="{{asset('include/rs-plugin/js/jquery.themepunch.tools.min.js')}}"></script>
	<script src="{{asset('include/rs-plugin/js/jquery.themepunch.revolution.min.js')}}"></script>

	<script src="{{asset('include/rs-plugin/js/extensions/revolution.extension.video.min.js')}}"></script>
	<script src="{{asset('include/rs-plugin/js/extensions/revolution.extension.slideanims.min.js')}}"></script>
	<script src="{{asset('include/rs-plugin/js/extensions/revolution.extension.actions.min.js')}}"></script>
	<script src="{{asset('include/rs-plugin/js/extensions/revolution.extension.layeranimation.min.js')}}"></script>
	<script src="{{asset('include/rs-plugin/js/extensions/revolution.extension.kenburn.min.js')}}"></script>
	<script src="{{asset('include/rs-plugin/js/extensions/revolution.extension.navigation.min.js')}}"></script>
	<script src="{{asset('include/rs-plugin/js/extensions/revolution.extension.migration.min.js')}}"></script>
	<script src="{{asset('include/rs-plugin/js/extensions/revolution.extension.parallax.min.js')}}"></script>

	<script>

		var tpj=jQuery;
		tpj.noConflict();

		tpj(document).ready(function() {

			var apiRevoSlider = tpj('#rev_slider_ishop').show().revolution(
			{
				sliderType:"standard",
				jsFileLocation:"include/rs-plugin/js/",
				sliderLayout:"fullwidth",
				dottedOverlay:"none",
				delay:9000,
				navigation: {},
				responsiveLevels:[1200,992,768,480,320],
				gridwidth:1140,
				gridheight:500,
				lazyType:"none",
				shadow:0,
				spinner:"off",
				autoHeight:"off",
				disableProgressBar:"on",
				hideThumbsOnMobile:"off",
				hideSliderAtLimit:0,
				hideCaptionAtLimit:0,
				hideAllCaptionAtLilmit:0,
				debugMode:false,
				fallbacks: {
					simplifyAll:"off",
					disableFocusListener:false,
				},
				navigation: {
					keyboardNavigation:"off",
					keyboard_direction: "horizontal",
					mouseScrollNavigation:"off",
					onHoverStop:"off",
					touch:{
						touchenabled:"on",
						swipe_threshold: 75,
						swipe_min_touches: 1,
						swipe_direction: "horizontal",
						drag_block_vertical: false
					},
					arrows: {
						style: "ares",
						enable: true,
						hide_onmobile: false,
						hide_onleave: false,
						tmp: '<div class="tp-title-wrap">	<span class="tp-arr-titleholder">title</span> </div>',
						left: {
							h_align: "left",
							v_align: "center",
							h_offset: 10,
							v_offset: 0
						},
						right: {
							h_align: "right",
							v_align: "center",
							h_offset: 10,
							v_offset: 0
						}
					}
				}
			});

			apiRevoSlider.bind("revolution.slide.onloaded",function (e) {
				SEMICOLON.slider.sliderParallaxDimensions();
			});

		}); //ready

	</script>

</body>
</html>
