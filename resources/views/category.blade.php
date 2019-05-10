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

	<!-- Document Title
	============================================= -->
	<title>{{$categoryName}} - {{$gender}}</title>

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
				<h1>{{$categoryName}} - {{$gender}}</h1>
				<span>Start Buying your Favourite {{$categoryName}}</span>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
					<li class="breadcrumb-item active" aria-current="page">{{$categoryName}}</li>
				</ol>
			</div>

		</section><!-- #page-title end -->

		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap">

				<div class="container clearfix">

					<!-- Post Content
					============================================= -->
					<div class="postcontent nobottommargin col_last">

						<!-- Shop
						============================================= -->
						<div id="shop" class="shop product-2 grid-container clearfix" data-layout="fitRows">

                                @foreach ($dataProduct as $product)
                                    @foreach ($product->product_category_detail as $product_category_detail)
                                        @if ($product_category_detail->category_id == $categoryId)
                                        <div class="product clearfix">
                                            <div class="product-image">
                                                {{-- Images --}}
                                                @php
                                                    $i = 0;
                                                @endphp
                                                @foreach ($product->product_image as $image)
                                                    @php
                                                        $i++;
                                                    @endphp
                                                    @if ($i < 3)
                                                        <a href="{{url('product/'.$image->product_id)}}"><img src="{{url('product_images/'.$image->image_name)}}"></a>
                                                    @endif
                                                @endforeach

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

                                                {{-- Buttons --}}
                                                <div class="product-overlay">
                                                    {{-- <a href="#" class="add-to-cart"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a> --}}
                                                    <a href="{{url('product/'.$product->id)}}" class="item-quick-view" ><i class="icon-zoom-in2"></i><span> View Detail</span></a>
                                                </div>
                                            </div>

                                            {{-- Description --}}
                                            <div class="product-desc">
                                                <div class="product-title"><h3><a href="#">{{$product->product_name}}</a></h3></div>
                                                @if ($a == 1) {{-- Ada Discount --}}
                                                    <div class="product-price"><del>Rp. {{$product->price}}</del> <ins>Rp. {{$product->price - (($product->price * $discountpercentage) / 100)}}</ins></div>
                                                @else
                                                    <div class="product-price"><ins>Rp. {{$product->price}}</ins></div>
                                                @endif
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
                                            </div>
                                        </div>
                                    @endif

                                    @endforeach
                                @endforeach

						</div><!-- #shop end -->

					</div><!-- .postcontent end -->

					<!-- Sidebar
					============================================= -->
					<div class="sidebar nobottommargin">
						<div class="sidebar-widgets-wrap">

							<div class="widget widget_links clearfix">

								<h4>Shop Categories</h4>
								<ul>
                                    @foreach ($dataCategory as $category)
                                        <li><a href="{{url('category/'.$category->id)}}">{{$category->category_name}} -
                                            @if ($category->gender == '1')
                                                Men
                                            @else
                                                Women
                                            @endif
                                        </a></li>
                                    @endforeach
								</ul>

                            </div>
						</div>
					</div><!-- .sidebar end -->

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
	<script src="{{asset('js/jquery.js')}}"></script>
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
