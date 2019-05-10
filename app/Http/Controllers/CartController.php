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


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        $dataCart = Cart::with('product.product_image','product.discount')->where('user_id',Auth::id())->where('status','notyet')->get();

        // return $dataCart;
        $transactionCount = $this->transactionCount();

        return view('cart',compact('dataCart','header','dataCategory','cartData','cartCount','today','transactionCount'));

    }

    public function transactionCount(){
        Auth::shouldUse('user');
        $data = Transaction::where('user_id',Auth::id())->where('status','unverified')->count();

        return $data;
    }

    public function updateToCheckout(Request $request){
        Auth::shouldUse('user');

        $i = 0;
        foreach($request->cart_id as $cart){

            Cart::where('id', $cart)
            ->update(['qty' => $request->quantity[$i]]);

            $i++;
        }
        return redirect('/checkout');
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


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ////

        $rules =
        [
            'qty'     => 'required|numeric|min:1',
            'user_id' => 'required',
            'product_id' => 'required',
            'status' => 'required'
        ];

        $validatedData = $request->validate($rules);
        try {

            $jumlah = Cart::where('user_id',$request->user_id)->where('product_id',$request->product_id)->where('status','notyet')->count();

            if($jumlah > 0){
                return redirect()->back()->with('carterror','this item is already in your cart !');
            }

            $data = app(Cart::class)->create($validatedData);
            return redirect()->back()->with('addsuccess','Product added to cart !');
        } catch (\Exception $exception) {
            return "unable to create new user ".$exception;
            logger()->error($exception);
            return redirect()->back()->with('error', 'Unable to create new user.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
        Auth::shouldUse('user');
        $data = Cart::where('user_id',Auth::id())->get();

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Cart::where('id', '=', $id)->delete();
        return redirect()->back();
    }

    public function cancel()
    {
        Auth::shouldUse('user');

        Cart::where('user_id', Auth::id())
          ->where('status', 'notyet')
          ->update(['status' => 'cancelled']);

        return redirect()->back();
    }

}
