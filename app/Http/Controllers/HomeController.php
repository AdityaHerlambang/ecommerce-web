<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Product;
use App\ProductCategoryDetail;
use App\ProductImage;
use App\ProductsCategory;
use App\Cart;

class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cartData = "";
        if(Auth::guard('user')->check()){
            $cartData = $this->cartData();
        }
        $header = $this->header();
        $dataCategory = $this->headercategories();
        $today = Carbon::today()->toDateString();

        $dataProduct = Product::with('product_category_detail.product_category', 'product_image', 'discount')->orderBy('products.id','desc')->limit(5)->get();

        return view('beranda', compact('header', 'dataCategory', 'dataProduct','today','cartData'));
    }

    public function pageCategory($id){

        $cartData = "";
        if(Auth::guard('user')->check()){
            $cartData = $this->cartData();
        }
        $header = $this->header();
        $dataCategory = $this->headercategories();
        $categoryName = ProductsCategory::where('id',$id)->first()->category_name;
        $gender = ProductsCategory::where('id',$id)->first()->gender;
        if($gender == '1'){
            $gender = 'Men';
        }
        else{
            $gender = 'Women';
        }
        $categoryId = ProductsCategory::where('id',$id)->first()->id;
        $today = Carbon::today()->toDateString();

        $dataProduct = Product::with('product_category_detail.product_category', 'product_image', 'discount')
                                ->orderBy('products.id','desc')->get();

                                // return $dataProduct;

        return view('category', compact('header', 'dataCategory', 'dataProduct','today','categoryName','categoryId','gender','cartData'));
    }

    public function pageProduct(Request $request,$id){

        $cartData = "";
        if(Auth::guard('user')->check()){
            $cartData = $this->cartData();
        }

        $header = $this->header();
        $dataCategory = $this->headercategories();

        $today = Carbon::today()->toDateString();

        $product = Product::with('product_category_detail.product_category', 'product_review.user', 'product_image', 'discount')
                                ->orderBy('products.id','desc')
                                ->where('products.id',$id)
                                ->first();


        return view('productdetail', compact('header', 'dataCategory', 'product','today','cartData'));
    }

    public function cartData(){
        Auth::shouldUse('user');
        $data = Cart::with('product.product_image')->where('user_id',Auth::id())->get();

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

    public function submitReview(Request $request){
        //TODO: Check apabila product ini telah terdeliver ke user.
    }

    public function headercategories()
    {
        return ProductsCategory::get();
    }

}
