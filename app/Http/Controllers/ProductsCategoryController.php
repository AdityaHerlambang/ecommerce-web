<?php

namespace App\Http\Controllers;

use App\ProductsCategory;
use Illuminate\Http\Request;

class ProductsCategoryController extends Controller
{

    protected $routelink = 'admin/productcategory/';

    protected $rules =
    [
        'category_name'     => 'required|string|max:255',
        'gender'     => 'required|numeric'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = "Product Categories";

        $tableData = ProductsCategory::get();

        return view('admin.product_categories', compact('title','tableData'));
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
            $data                            = app(ProductsCategory::class)->create($validatedData);
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
     * @param  \App\ProductsCategory  $productsCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data = ProductsCategory::where('id',$id)->first();

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductsCategory  $productsCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductsCategory $productsCategory)
    {
        //
        $data = ProductsCategory::where('id',$id)->first();

        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductsCategory  $productsCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $rulesUpdate =
        [
            'category_name'     => 'required|string|max:255',
            'gender'     => 'required|numeric'
        ];

        $reqvalid = $request->validate($rulesUpdate);

        $data = ProductsCategory::find($id);
        $data->category_name = $reqvalid['category_name'];
        $data->gender = $reqvalid['gender'];
        $data->save();

        return redirect($this->routelink);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductsCategory  $productsCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        ProductsCategory::where('id', '=', $id)->delete();
        return redirect($this->routelink);
    }
}
