<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\ProductReview;
use App\Response;
use App\Transaction;
use App\TransactionDetail;
use App\Product;
use App\User;
use App\Notifications\UserNotification;

class ReviewController extends Controller
{
    //

    public function submitResponse(Request $request){
        Auth::shouldUse('admin');

        $data = new Response;
        $data->review_id = $request->review_id;
        $data->content = $request->content;
        $data->admin_id = Auth::id();
        $data->save();

        $user_id = ProductReview::where('id',$request->review_id)->first()->user_id;
        $namaproduk = ProductReview::selectRaw('products.product_name as product_name')->join('products','product_reviews.product_id','products.id')->where('product_reviews.id',$request->review_id)->first()->product_name;

        $user = User::where('id',$user_id)->first();
        $user->notify(new UserNotification('Admin MERESPON review Anda pada produk '.$namaproduk));

        return redirect()->back();
    }

    public function submitReview(Request $request){
        Auth::shouldUse('user');

        $transaction = Transaction::where('user_id',Auth::id())->where('status','success')->get();
        foreach($transaction as $trans){
            $transDetail = TransactionDetail::where('transaction_id',$trans->id)->get();
            foreach($transDetail as $detail){
                if($detail->product_id == $request->product_id){

                    $productCount = ProductReview::where('user_id',Auth::id())->where('product_id',$request->product_id)->count();

                    if($productCount > 0 ){
                        return redirect()->back();
                    }

                    $data = new ProductReview();
                    $data->product_id = $request->product_id;
                    $data->rate = $request->rate;
                    $data->content = $request->content;
                    $data->user_id = Auth::id();
                    $data->save();

                    $rateSum = ProductReview::selectRaw('SUM(rate) as ratetotal')->where('product_id',$request->product_id)
                                                ->first()->ratetotal;
                    $rateCount = ProductReview::where('product_id',$request->product_id)
                                                ->count();

                    $rateNow = $rateSum / $rateCount;
                    $rateNow = ceil($rateNow);

                    Product::where('id',$request->product_id)->update(['product_rate' => $rateNow]);

                }
            }
        }

        return redirect()->back();

    }
}
