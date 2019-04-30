<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Discount;
use App\Product;

class DiscountController extends Controller
{

    protected $routelink = 'admin/product/discount';

    protected $rules =
    [
        'id_product'     => 'required',
        'percentage'     => 'required|numeric',
        'start'     => 'required|string',
        'end'     => 'required|string'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        $productName = Product::select('product_name')->where('id',$id)->first();
        $title = "Discount for : ".$productName->product_name;
        
        $tableData = Discount::where('id_product',$id)->get();
        $id_product = $id;
        return view('admin.discount',compact('title','tableData','id_product'));
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
        //
        $validatedData = $request->validate($this->rules);

        try {
            $data = app(Discount::class)->create($validatedData);
            return redirect()->back();
        } catch (\Exception $exception) {
            return "unable to create new user ".$exception;
            logger()->error($exception);
            return redirect()->back()->with('error', 'Unable to create new user.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data = Discount::where('id',$id)->first();

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount $discount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $rulesUpdate =
        [
            'id_product'     => 'required',
            'percentage'     => 'required|numeric',
            'start'     => 'required|string',
            'end'     => 'required|string'
        ];

        $reqvalid = $request->validate($rulesUpdate);

        $data = Discount::find($id);
        $data->percentage = $reqvalid['percentage'];
        $data->start = $reqvalid['start'];
        $data->end = $reqvalid['end'];
        $data->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Discount::where('id', '=', $id)->delete();
        return redirect()->back();
    }
}
