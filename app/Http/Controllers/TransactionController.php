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

class TransactionController extends Controller
{
    //

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

        $dataTransaction = Transaction::where('user_id',Auth::id())->get();

        return view('transaction',compact('cartData','header','dataCategory','today','transactionCount','cartCount','dataTransaction'));
    }

    public function transactionDetail($id){
        Auth::shouldUse('user');

        //cartData = data untuk di header, dataCart = data utama

        //START Header

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

        //END Header

        $dataTransaction = Transaction::where('user_id',Auth::id())->where('id',$id)->first();
        $detailTransaction = TransactionDetail::with('product.product_image')->where('transaction_id',$id)->get();

        return view('transactiondetail',compact('cartData','header','dataCategory','today','transactionCount','cartCount','dataTransaction','detailTransaction'));
    }

    public function transactionCount(){
        Auth::shouldUse('user');
        $data = Transaction::where('user_id',Auth::id())->where('status','unverified')->count();

        return $data;
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
