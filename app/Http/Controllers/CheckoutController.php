<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Product;
use App\ProductCategoryDetail;
use App\ProductImage;
use App\ProductsCategory;
use App\Cart;
use App\Courier;
use App\Transaction;
use App\TransactionDetail;

class CheckoutController extends Controller
{
    //

    protected $RAJAONGKIR_APIKEY = "75a1df16604b2054292aa1c9c41f9eb7";

    public function index(){
        Auth::shouldUse('user');

        //cartData = data untuk di header, dataCart = data utama

        $cartData = "";
        if(Auth::guard('user')->check()){
            $cartData = $this->cartData();
            $cartCount = 0;
            foreach($cartData as $cart){
                $cartCount++;
            }
        }
        $header = $this->header();
        $dataCategory = $this->headercategories();
        $today = Carbon::today()->toDateString();

        $transactionCount = $this->transactionCount();

        $dataCourier = Courier::get();
        $dataCart = Cart::with('product.product_image','product.discount')->where('user_id',Auth::id())->where('status','notyet')->get();

        // return $dataCart;
        $province = json_decode($this->province(), true);

        return view('checkout',compact('dataCart','header','dataCategory','cartData','cartCount','today','province','dataCourier','transactionCount'));

    }

    public function transactionCount(){
        Auth::shouldUse('user');
        $data = Transaction::where('user_id',Auth::id())->where('status','unverified')->count();

        return $data;
    }

    public function store(Request $request){
        Auth::shouldUse('user');

        $todayString = Carbon::today()->toDateString();

        $today = Carbon::today();
        $timeout = $today->addDays(3)->toDateTimeString();

        $courier_id = Courier::where('courier',$request->courier)->first()->id;

        $data = new Transaction;
        $data->timeout = $timeout;
        $data->address = $request->address;
        $data->regency = $request->regency;
        $data->province = $request->province;
        $data->total = $request->total;
        $data->shipping_cost = $request->shipping_cost;
        $data->sub_total = $request->sub_total;
        $data->user_id = Auth::id();
        $data->courier_id = $courier_id;
        $data->status = 'unverified';
        $data->save();

        $dataCart = Cart::with('product.product_image','product.discount')->where('user_id',Auth::id())->where('status','notyet')->get();
        foreach($dataCart as $cart){
            $adaDiscount = 0; $discountpercentage = 0;

            $detail = new TransactionDetail;
            $detail->transaction_id = $data->id;
            $detail->product_id = $cart->product_id;
            foreach($cart->product->discount as $discount){
                $start_ts = strtotime($discount->start);
                $end_ts = strtotime($discount->end);
                $user_ts = strtotime($todayString);
                if (($user_ts >= $start_ts) && ($user_ts <= $end_ts)){
                        $adaDiscount = 1; $discountpercentage = $discount->percentage;
                }
            }
            $detail->qty = $cart->qty;
            if($adaDiscount){
                $discount = (($cart->product->price * $discountpercentage) / 100);
                $price = $cart->product->price - $discount;
                $totalPrice = $price * $cart->qty;

                $detail->discount = $discount;
                $detail->selling_price = $totalPrice;
            }
            else{
                $detail->discount = 0;
                $totalPrice = $cart->product->price * $cart->qty;
                $detail->selling_price = $totalPrice;
            }
            $detail->save();

            return redirect('transaction/'.$data->id);

        }

        Cart::where('user_id', Auth::id())
          ->where('status', 'notyet')
          ->update(['status' => 'checkedout']);

    }

    public function province(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: ".$this->RAJAONGKIR_APIKEY
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return  $response;
        }
    }

    public function city(Request $request){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=$request->province_id",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: ".$this->RAJAONGKIR_APIKEY
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            $response = json_decode($response, true);
            $datastring = "";
            foreach($response['rajaongkir']['results'] as $res){
                $datastring .= $res['city_id'].','.$res['city_name'].',';
            }
            return $datastring;
        }
    }

    public function shippingCost(Request $request){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=17&destination=$request->destination&weight=$request->weight&courier=$request->courier",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: ".$this->RAJAONGKIR_APIKEY
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            $response = json_decode($response, true);
            $datastring = "";
            foreach($response['rajaongkir']['results'] as $res){
                if($res['code'] == $request->courier){
                    foreach($res['costs'] as $cost){
                        $datastring .= $cost['service'].',';
                        foreach($cost['cost'] as $detailcost){
                            $datastring .= $detailcost['value'].',';
                        }
                    }
                }
            }
            return $datastring;
        }
    }

    public function header()
    {
        if (Auth::guard('admin')->check()) {
            $header = "admin";
        } else if (Auth::guard('user')->check()) {
            $header = "customer";
        } else {
            $header = "guest";
        }
        return $header;
    }

    public function headercategories()
    {
        return ProductsCategory::get();
    }

    public function cartData(){
        Auth::shouldUse('user');
        $data = Cart::with('product.product_image')->where('user_id',Auth::id())->where('status','notyet')->get();

        return $data;
    }

}
