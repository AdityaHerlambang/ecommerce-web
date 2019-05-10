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
	<title>Checkout</title>

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
                            <h3>Shipment Address</h3>

                            <p>Insert your shipment address.</p>


                            <form id="formcheckout" method="POST" action="/checkout/submit">
                                @method('POST')
                                @csrf

                                <input type="hidden" name="regency" class="regency_val">
                                <input type="hidden" name="province" class="province_val">
                                <input type="hidden" name="sub_total" class="sub_total_val">
                                <input type="hidden" name="shipping_cost" class="shipping_cost_val">
                                <input type="hidden" name="total" class="total_val">

								<div class="col_full">
									<select name="province_id" class="sm-form-control province">
                                        <option value="">- Select Province -</option>
                                        @foreach ($province['rajaongkir']['results'] as $prov)
										    <option value="{{$prov['province_id']}}">{{$prov['province']}}</option>
                                        @endforeach
									</select>
                                </div>
                                <div class="col_full">
                                    <select name="city_id" class="sm-form-control city">
                                        <option value="">- Select City -</option>
                                    </select>
                                </div>
                                <div class="col_full">
                                    Courier
                                    <select name="courier" class="sm-form-control courier">
                                        @foreach ($dataCourier as $courier)
                                            <option value="{{$courier->courier}}">{{$courier->courier}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col_full">
                                    Courier Service
                                    <select name="service" class="sm-form-control service">
                                    </select>
                                </div>
								<div class="col_full">
                                    <textarea name="address" class="sm-form-control" cols="30" rows="3" placeholder="Address"></textarea>
                                </div>

                                <script>
                                    jQuery(document).ready(function ($) {
                                        $(function(){
                                            $('.city').hide();
                                            $('.courier').hide();
                                            $('.service').hide();
                                            $('.submitorder').hide();

                                            $('.province_val').val($('.province').text());

                                            //province changed
                                            $('.province').change(function() {
                                                var data = "";
                                                $.ajax({
                                                    type:"GET",
                                                    url : "{{url('checkout/getcity')}}",
                                                    data : "province_id="+$(this).val(),
                                                    async: false,
                                                    success : function(response) {
                                                        data = response;
                                                        return response;
                                                    },
                                                    error: function() {
                                                        alert('Error occured');
                                                    }
                                                });
                                                var string = data.split(",");
                                                var array = string.filter(function(e){return e;});
                                                var select = $('.city');
                                                select.empty();
                                                console.log(array);
                                                var i = 0; var key = ""; var name = "";
                                                $.each(array, function(index, value) {
                                                    if(i % 2 == 0 || i == 0){
                                                        key = value;
                                                    }
                                                    else{
                                                        name = value;
                                                        select.append($('<option></option>').val(key).html(name));
                                                    }
                                                    i++;
                                                });
                                                $('.city').show();
                                                $('.courier').show();
                                                getShippingCost();
                                            });

                                            //courier changed
                                            $('.courier').change(function() {
                                                getShippingCost();
                                            });

                                            //city changed
                                            $('.city').change(function() {
                                                getShippingCost();
                                            });

                                            //service changed
                                            $('.service').change(function() {
                                                $('.shipping').text($(this).val());
                                                var subtotal = $('.cartsubtotal').text();
                                                var shipping = $('.shipping').text();
                                                $('.totalprice').text(parseInt(subtotal)+parseInt(shipping));



                                                $('.province_val').val($('.province option:selected').text());
                                                $('.regency_val').val($('.city option:selected').text());
                                                $('.sub_total_val').val($('.cartsubtotal').text());
                                                $('.shipping_cost_val').val($('.shipping').text());
                                                $('.total_val').val($('.totalprice').text());

                                                console.log($('.total_val').val());
                                            });

                                            $('.submitorder').click(function() {
                                                $('#formcheckout').submit();
                                            });

                                        });

                                        function getShippingCost(){
                                            $.ajax({
                                                type:"GET",
                                                url : "{{url('checkout/getshippingcost')}}",
                                                data : "destination="+$('.city').val()+"&courier="+$('.courier').val()+"&weight="+$('.weighttotal').text(),
                                                async: false,
                                                success : function(response) {
                                                    data = response;
                                                    return response;
                                                },
                                                error: function() {
                                                    alert('Error occured');
                                                }
                                            });

                                            var string = data.split(",");
                                            var array = string.filter(function(e){return e;});
                                            var select = $('.service');
                                            select.empty();
                                            console.log(array);
                                            var i = 0; var key = ""; var name = "";
                                            $.each(array, function(index, value) {
                                                if(i % 2 == 0 || i == 0){
                                                    name = value;
                                                }
                                                else{
                                                    key = value;
                                                    select.append($('<option></option>').val(key).html(name));
                                                }
                                                i++;
                                            });
                                            $('.service').show();
                                            $('.shipping').text($('.service').val());

                                            var subtotal = $('.cartsubtotal').text();
                                            var shipping = $('.shipping').text();
                                            $('.totalprice').text(parseInt(subtotal)+parseInt(shipping));

                                            $('.province_val').val($('.province option:selected').text());
                                            $('.regency_val').val($('.city option:selected').text());
                                            $('.sub_total_val').val($('.cartsubtotal').text());
                                            $('.shipping_cost_val').val($('.shipping').text());
                                            $('.total_val').val($('.totalprice').text());

                                            console.log($('.total_val').val());

                                            $('.submitorder').show();
                                        }

                                    });
                                </script>

                                {{-- <button class="button button-3d nomargin button-black" type="submit">SAVE</button> --}}
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
                                                <span class="amount cartsubtotal"></span>
                                            </td>
                                        </tr>
                                        <tr class="cart_item">
                                            <td class="cart-product-name">
                                                <strong>Weight Total</strong>
                                            </td>

                                            <td class="cart-product-name">
                                                <span class="amount weighttotal"></span> grams
                                            </td>
                                        </tr>
                                        <tr class="cart_item">
                                            <td class="cart-product-name">
                                                <strong>Shipping Cost</strong>
                                            </td>

                                            <td class="cart-product-name">
                                                <span class="amount shipping"></span>
                                            </td>
                                        </tr>
                                        <tr class="cart_item">
                                            <td class="cart-product-name">
                                                <strong>Total</strong>
                                            </td>

                                            <td class="cart-product-name">
                                                <strong><span class="amount color lead totalprice"></span></strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="accordion clearfix">
                                <div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Direct Bank Transfer</div>
                                <div class="acc_content clearfix">Donec sed odio dui. Nulla vitae elit libero, a pharetra augue. Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet.</div>

                                <div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Cheque Payment</div>
                                <div class="acc_content clearfix">Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus. Aenean lacinia bibendum nulla sed consectetur. Cras mattis consectetur purus sit amet fermentum.</div>

                                <div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Paypal</div>
                                <div class="acc_content clearfix">Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus. Aenean lacinia bibendum nulla sed consectetur.</div>
                            </div>
                            <button class="button button-3d fright submitorder">Place Order</button>
                        </div>

                        <div class="col-lg-12">
                            <h4>Your Orders</h4>

                            <div class="table-responsive">
                                <table class="table cart">
                                    <thead>
                                        <tr>
                                            <th class="cart-product-thumbnail">&nbsp;</th>
                                            <th class="cart-product-name">Product</th>
                                            <th class="cart-product-quantity">Quantity</th>
                                            <th class="cart-product-weight">Weight</th>
                                            <th class="cart-product-subtotal">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $cartSubtotal = 0; $weightTotal = 0;
                                        @endphp
                                        @foreach ($dataCart as $cart)
                                            <tr class="cart_item">
                                                <td class="cart-product-thumbnail">
                                                    {{-- Images --}}
                                                    @php
                                                        $i = 0;
                                                    @endphp
                                                    @foreach ($cart->product->product_image as $image)
                                                        @if ($i < 1)
                                                            <a href="{{url('product/'.$image->product_id)}}"><img src="{{url('product_images/'.$image->image_name)}}"></a>
                                                        @endif
                                                        @php
                                                            $i++;
                                                        @endphp
                                                    @endforeach
                                                </td>

                                                <td class="cart-product-name">
                                                    <a href="#">{{$cart->product->product_name}}</a>
                                                </td>

                                                <td class="cart-product-quantity">
                                                    <div class="quantity clearfix">
                                                        {{$cart->qty}}
                                                    </div>
                                                </td>

                                                <td class="cart-product-weight">
                                                    <span class="amount">{{$cart->product->weight}} grams</span>
                                                </td>

                                                {{-- Discount --}}
                                            @php
                                                $adaDiscount = 0; $discountpercentage = 0; $totalPrice = 0;
                                            @endphp
                                            @foreach ($cart->product->discount as $discount)
                                                @php

                                                    // Convert to timestamp
                                                    $start_ts = strtotime($discount->start);
                                                    $end_ts = strtotime($discount->end);
                                                    $user_ts = strtotime($today);

                                                @endphp
                                                @if (($user_ts >= $start_ts) && ($user_ts <= $end_ts))
                                                    @php
                                                        $adaDiscount = 1; $discountpercentage = $discount->percentage;
                                                    @endphp
                                                @endif
                                            @endforeach

                                            @if ($adaDiscount == 1)
                                                @php
                                                    $price = $cart->product->price - (($cart->product->price * $discountpercentage) / 100);
                                                    $totalPrice = $price * $cart->qty;
                                                @endphp
                                            @else
                                                @php
                                                    $totalPrice = $cart->product->price * $cart->qty;
                                                @endphp
                                            @endif

                                                <td class="cart-product-subtotal">
                                                    <span class="amount">{{$totalPrice}}</span>
                                                </td>
                                            </tr>
                                            @php
                                                $cartSubtotal += $totalPrice; $weightTotal += $cart->product->weight;
                                            @endphp
                                        @endforeach

                                        <script>
                                                jQuery(document).ready(function ($) {
                                                    $(function(){
                                                        $('.cartsubtotal').text('{{$cartSubtotal}}');
                                                        $('.weighttotal').text('{{$weightTotal}}');
                                                    });
                                                });
                                            </script>

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
