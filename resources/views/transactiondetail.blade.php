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
	<script src="{{asset('js/jquery.countdown.min.js')}}"></script>

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

                                <input type="hidden" name="id" value="{{$dataTransaction->id}}">

								<div class="col_full">
									<label for="recipient-name" class="control-label">Proof of Payment Image</label><br>
                                    <img id="create-imagepreview"
                                        @if ($dataTransaction->proof_of_payment == "")
                                            src="{{asset('images/box-img-placeholder.png  ')}}"
                                        @else
                                            src="{{asset('proof_images/'.$dataTransaction->proof_of_payment)}}"
                                        @endif
                                    style="height:200px;width:200px;display:inline-block"><br>
                                    @if ($dataTransaction->proof_of_payment == "")
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
                                    @endif
                                </div>
                                @if ($dataTransaction->proof_of_payment == "")
                                    <button class="button button-3d nomargin button-green" type="submit">SUBMIT PROOF</button>
                                @endif
							</form>
                        </div>

                        <div class="col-lg-6">
                            <h4>Cart Totals</h4>

                            <div class="table-responsive">
                                <table class="table cart">
                                    <tbody>
                                        @if ($dataTransaction->proof_of_payment == "")
                                            <tr class="cart_item">
                                                <td class="notopborder cart-product-name">
                                                    <h4><strong>Remaining Time</strong></h4>
                                                </td>

                                                <td class="notopborder cart-product-name">
                                                    <div id="timer" style="display:table-cell;">
                                                        <div style="float:left" ><h4 id="days"><strong></strong></h4></div>
                                                        <div style="float:left" ><h4 id="hours"><strong></strong></h4></div>
                                                        <div style="float:left" ><h4 id="minutes"><strong></strong></h4></div>
                                                        <div style="float:left"><h4 id="seconds"><strong></strong></h4></div>
                                                    </div>
                                                    <script>

                                                        jQuery(document).ready(function ($) {
                                                            setInterval(function() {
                                                                var endTime = new Date("{{$timeout}}");
                                                                endTime = (Date.parse(endTime) / 1000);

                                                                var now = new Date();
                                                                now = (Date.parse(now) / 1000);

                                                                var timeLeft = endTime - now;

                                                                var days = Math.floor(timeLeft / 86400);
                                                                var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
                                                                var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
                                                                var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

                                                                if (hours < "10") { hours = "0" + hours; }
                                                                if (minutes < "10") { minutes = "0" + minutes; }
                                                                if (seconds < "10") { seconds = "0" + seconds; }

                                                                $("#days").html(days + " <span>Days</span> &nbsp;");
                                                                $("#hours").html(hours + " <span>Hours</span> &nbsp;");
                                                                $("#minutes").html(minutes + " : &nbsp;");
                                                                $("#seconds").html(seconds + " &nbsp;");
                                                            }, 1000);

                                                        });

                                                    </script>
                                                </td>
                                            </tr>
                                        @else
                                            <tr class="cart_item">
                                                <td class="notopborder cart-product-name">
                                                    <h4><strong>Status</strong></h4>
                                                </td>

                                                <td class="notopborder cart-product-name">
                                                    {{$dataTransaction->status}}
                                                </td>
                                            </tr>
                                        @endif

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
                            <div class="accordion clearfix">
                                <div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Shipping Info</div>
                                <div class="acc_content clearfix">
                                    Courier : {{$dataTransaction->courier->courier}}<br>
                                    Service : {{$dataTransaction->service}}<br>
                                    Province : {{$dataTransaction->province}}<br>
                                    Regency : {{$dataTransaction->regency}}<br>
                                    Address : {{$dataTransaction->address}}
                                </div>
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
