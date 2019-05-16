<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

use App\Product;
use App\ProductCategoryDetail;
use App\ProductImage;
use App\ProductsCategory;
use App\Cart;
use App\Transaction;

class DashboardController extends Controller
{
    //

    public function index(){

        $now = Carbon::now();
        $bulanTahunText = $now->format('F')." ".$now->format('Y');
        $tahun = $now->format('Y');

        //Per Bulan
        $namaBulan = array();
        array_push($namaBulan,"Januari");
        array_push($namaBulan,"Februari");
        array_push($namaBulan,"Maret");
        array_push($namaBulan,"April");
        array_push($namaBulan,"Mei");
        array_push($namaBulan,"Juni");
        array_push($namaBulan,"Juli");
        array_push($namaBulan,"Agustus");
        array_push($namaBulan,"September");
        array_push($namaBulan,"Oktober");
        array_push($namaBulan,"November");
        array_push($namaBulan,"Desember");
        $dataChart = array();
        for($i = 1; $i <= 12; $i++){
            $row = Transaction::selectRaw("SUM(total) as total, COUNT(id) as jumlah")
            ->where(DB::raw('MONTH(created_at)'),'=',$i)
            ->where(DB::raw('YEAR(created_at)'),'=',$tahun)
            ->where("status","success")
            ->first();

            $penjualan = $row->total;
            $jumlah = $row->jumlah;

            if($penjualan == null){
                $penjualan = 0;
            }
            if($jumlah == null){
                $jumlah = 0;
            }

            array_push($dataChart,array('penjualan' => $penjualan,'bulan'=>$namaBulan[$i-1],'jumlah' => $jumlah));
        }

        //Per Tahun
        $namaTahun = array();
        $dataTahun = Transaction::selectRaw('YEAR(created_at) as tahun')->groupBy(DB::raw('YEAR(created_at)'))->get();
        foreach($dataTahun as $data){
            array_push($namaTahun,$data->tahun);
        }
        $dataPertahun = array();

        for($i = 0; $i < count($namaTahun); $i++){
            $row = Transaction::selectRaw("SUM(total) as total, COUNT(id) as jumlah")
            ->where(DB::raw('YEAR(created_at)'),'=',$namaTahun[$i])
            ->where("status","success")
            ->first();

            $penjualan = $row->total;
            $jumlah = $row->jumlah;

            if($penjualan == null){
                $penjualan = 0;
            }
            if($jumlah == null){
                $jumlah = 0;
            }

            array_push($dataPertahun,array('penjualan' => $penjualan,'tahun'=>$namaTahun[$i],'jumlah' => $jumlah));
        }


        return view('admin.dashboard',compact('bulanTahunText','dataChart','tahun','dataPertahun'));
    }

    public function clearNotif(){
        Auth::shoulduse('admin');
        $user = Auth::user();
        $user->unreadNotifications()->update(['read_at' => now()]);

    }

}
