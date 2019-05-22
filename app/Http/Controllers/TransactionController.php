<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Notifications\Notifiable;

use App\Product;
use App\ProductCategoryDetail;
use App\ProductImage;
use App\ProductsCategory;
use App\Cart;
use App\Courier;
use App\Transaction;
use App\TransactionDetail;
use App\User;
use App\Admin;

use App\Notifications\UserNotification;
use App\Notifications\AdminNotification;

class TransactionController extends Controller
{
    //

    public function index(){
        Auth::shouldUse('user');

        //cartData = data untuk di header, dataCart = data utama
        $cartCount = 0;

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

        $dataTransaction = Transaction::with('courier')->where('user_id',Auth::id())->get();

        return view('transaction',compact('cartData','header','dataCategory','today','transactionCount','cartCount','dataTransaction'));
    }

    public function adminView(){
        $title = "Transaction";
        $tableData = Transaction::with('user','courier')->get();

        return view('admin.transaction', compact('title','tableData'));
    }

    public function transactionDetail($id){
        Auth::shouldUse('user');

        //cartData = data untuk di header, dataCart = data utama

        //START Header
        $cartCount = 0;

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

        $timeout = Carbon::createFromFormat('Y-m-d H:i:s', $dataTransaction->timeout)->format('Y/m/d H:i:s');
        $todayTime = Carbon::now()->toDateTimeString();
        $todayFormatted = Carbon::createFromFormat('Y-m-d H:i:s', $todayTime)->format('Y/m/d H:i:s');

        return view('transactiondetail',compact('cartData','header','dataCategory','today','transactionCount','cartCount','dataTransaction','detailTransaction','timeout','todayFormatted'));
    }

    public function transactionDetailAdmin($id,$user_id){

        //cartData = data untuk di header, dataCart = data utama

        //START Header
        $cartCount = 0;

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

        $dataTransaction = Transaction::where('user_id',$user_id)->where('id',$id)->first();
        $detailTransaction = TransactionDetail::with('product.product_image')->where('transaction_id',$id)->get();

        $timeout = Carbon::createFromFormat('Y-m-d H:i:s', $dataTransaction->timeout)->format('Y/m/d H:i:s');
        $todayTime = Carbon::now()->toDateTimeString();
        $todayFormatted = Carbon::createFromFormat('Y-m-d H:i:s', $todayTime)->format('Y/m/d H:i:s');

        return view('transactiondetail',compact('cartData','header','dataCategory','today','transactionCount','cartCount','dataTransaction','detailTransaction','timeout','todayFormatted'));
    }

    public function showTransaction($id){
        return Transaction::where('id',$id)->first();
    }

    public function updateStatus(Request $request, $id){

        Transaction::where('id', $request->id)
          ->update(['status' => $request->status]);

        $user_id = Transaction::where('id', $request->id)->first()->user_id;

        $user = User::where('id',$user_id)->first();
        $user->notify(new UserNotification('<a href=">'.url('transaction/'.$request->id).'">ada TRANSAKSI Anda yang berubah status menjadi '.$request->status,'</a>'));

        return redirect()->back();

    }

    // public function testNotif($data){
    //     Auth::shouldUse('user');
    //     $user = Auth::user();
    //     $user->notify(new UserNotification('Halo Dunia !'));

    //     return $user->unreadNotifications;

    // }

    public function submitProof(Request $request){

        $trans = Transaction::where('id',$request->id)->first();

        $timeout = Carbon::parse($trans->timeout);
        $today = Carbon::now();

        if ($timeout->lessThan($today)){
            return redirect()->back()->with('timoutexceeded','Timeout Exceeded !');
        }

        $rules =
        [
            'imageupload' => 'required|image|mimes:jpeg,png,gif,svg'
        ];

        $validatedData = $request->validate($rules);

        $image = $request->file('imageupload');
        $image_name = "proof-".$request->id.'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/proof_images');
        $image->move($destinationPath, $image_name);

        $proofOfPayment = $image_name;
        Transaction::where('id', $request->id)
          ->update(['proof_of_payment' => $proofOfPayment]);

        $nama_user = Transaction::join('users','transactions.user_id','users.id')->where('transactions.id', $request->id)->first()->name;
        $admin = Admin::first();
        $admin->notify(new AdminNotification('<a href=">'.url('transaction/'.$request->id).'">ada UPDATE BUKTI pada transaksi user '.$nama_user.'</a>'));

        return redirect()->back();

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
