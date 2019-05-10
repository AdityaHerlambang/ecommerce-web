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

	<!-- Document Title
	============================================= -->
	<title>Transaction Detail</title>

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
                <h1>Checkout</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                </ol>
            </div>

        </section><!-- #page-title end -->

        <!-- Content
        ============================================= -->
        <section id="content">

            <div class="content-wrap">

                <div class="container clearfix">

                    <div class="row clearfix">
                        <div class="col-lg-6">
                            <h3>Proof of Payment</h3>

                            <p>Upload your Proof of Payment</p>


                            <form id="formcheckout" method="POST" action="/transactionsubmitproof" enctype="multipart/form-data">
                                @method('POST')
                                @csrf

                                <input type="hidden" name="regency" class="regency_val">
                                <input type="hidden" name="province" class="province_val">
                                <input type="hidden" name="sub_total" class="sub_total_val">
                                <input type="hidden" name="shipping_cost" class="shipping_cost_val">
                                <input type="hidden" name="total" class="total_val">

								<div class="col_full">
									<label for="recipient-name" class="control-label">Proof of Payment Image</label><br>
                                    <img id="create-imagepreview" src="{{asset('images/box-img-placeholder.png  ')}}" style="height:200px;width:200px;display:inline-block"><br>
                                    <input type="file" class="form-control" name="imageupload" value="" onchange="readURL(this);">
                                    <script>
                                        function readURL(input) {

                                            jQuery(document).ready(function ($) {
                                                if (input.files && input.files[0]) {
                                                    var reader = new FileReader();

                                                    reader.onload = function (e) {
                                                        $('#create-imagepreview')
                                                            .attr('src', e.target.result);
                                                    };

                                                    reader.readAsDataURL(input.files[0]);
                                                }
                                            });
                                        }
                                    </script>
                                </div>
                                <button class="button button-3d nomargin button-green" type="submit">SUBMIT PROOF</button>
							</form>
                        </div>

                        <div class="col-lg-6">
                            <h4>Cart Totals</h4>

                            <div class="table-responsive">
                                <table class="table cart">
                                    <tbody>
                                        <tr class="cart_item">
                                            <td class="notopborder cart-product-name">
                                                <strong>Cart Subtotal</strong>
                                            </td>

                                            <td class="notopborder cart-product-name">
                                                <span class="amount cartsubtotal">{{$dataTransaction->sub_total}}</span>
                                            </td>
                                        </tr>
                                        <tr class="cart_item">
                                            <td class="cart-product-name">
                                                <strong>Shipping Cost</strong>
                                            </td>

                                            <td class="cart-product-name">
                                                <span class="amount shipping">{{$dataTransaction->shipping_cost}}</span>
                                            </td>
                                        </tr>
                                        <tr class="cart_item">
                                            <td class="cart-product-name">
                                                <h3><strong>PAYMENT TOTAL</strong></h3>
                                            </td>

                                            <td class="cart-product-name">
                                                <h2><strong><span class="totalprice">{{$dataTransaction->total}}</span></strong></h2>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="accordion clearfix">
                                <div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Payment Instructions</div>
                                <div class="acc_content clearfix">Transfer amount of payment total to this BNI Bank Account : 01234567890 a/n TESTING AJA before Timeout reach 0 seconds.</div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <h4>Products</h4>

                            <div class="table-responsive">
                                <table class="table cart">
                                    <thead>
                                        <tr>
                                            <th class="cart-product-thumbnail">&nbsp;</th>
                                            <th class="cart-product-name">Product</th>
                                            <th class="cart-product-quantity">Quantity</th>
                                            <th class="cart-product-weight">Discount</th>
                                            <th class="cart-product-subtotal">Selling Price (after discount)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $cartSubtotal = 0; $weightTotal = 0;
                                        @endphp
                                        @foreach ($detailTransaction as $detail)
                                            <tr class="cart_item">
                                                <td class="cart-product-thumbnail">
                                                    {{-- Images --}}
                                                    @php
                                                        $i = 0;
                                                    @endphp
                                                    @foreach ($detail->product->product_image as $image)
                                                        @if ($i < 1)
                                                            <a href="{{url('product/'.$image->product_id)}}"><img src="{{url('product_images/'.$image->image_name)}}"></a>
                                                        @endif
                                                        @php
                                                            $i++;
                                                        @endphp
                                                    @endforeach
                                                </td>

                                                <td class="cart-product-name">
                                                    <a href="#">{{$detail->product->product_name}}</a>
                                                </td>

                                                <td class="cart-product-quantity">
                                                    <div class="quantity clearfix">
                                                        {{$detail->qty}}
                                                    </div>
                                                </td>

                                                <td class="cart-product-weight">
                                                    <span class="amount">{{$detail->discount}}</span>
                                                </td>

                                                <td class="cart-product-subtotal">
                                                    <span class="amount">{{$detail->selling_price}}</span>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
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
