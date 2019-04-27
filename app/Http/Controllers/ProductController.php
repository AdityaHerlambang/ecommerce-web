<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\ProductCategoryDetail;
use App\ProductImage;
use App\ProductsCategory;

class ProductController extends Controller
{

    protected $routelink = 'admin/product';

    protected $rules =
    [
        'product_name'     => 'required|string|max:255',
        'price'     => 'required|numeric',
        'description'     => 'string',
        'product_rate'     => 'numeric',
        'stock'     => 'required|numeric',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = "Products";
        $tableData = Product::get();


        return view('admin.product', compact('title','tableData'));
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

        $reqvalid = $request;

        $validatedData = $reqvalid->validate($this->rules);

        // return $request;

        try {
            $id = app(Product::class)->create($validatedData)->id;
        } catch (\Exception $exception) {
            return "unable to create ".$exception;
            logger()->error($exception);
            return redirect()->back()->with('error', 'Unable to create new user.');
        }

        $i = 0;
        foreach($request->file as $file){
            $i++;
            $imageName = (time()+$i).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('product_images'), $imageName);
            $productImage = new ProductImage;
            $productImage->product_id = $id;
            $productImage->image_name = $imageName;
            $productImage->save();
        }

    	return redirect('/admin/product');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $title = "Products";
        $data = Product::where('id',$id)->first();
        $dataImage = ProductImage::where('product_id',$id)->get();

        $initialPreview = array();
        $initialPreviewConfig = array();

        // initialPreviewConfig: [
        //     {caption: "Moon.jpg", downloadUrl: url1, size: 930321, width: "120px", key: 1, extra: {id: 100}},
        //     {caption: "Earth.jpg", downloadUrl: url2, size: 1218822, width: "120px", key: 2, extra: {id: 100}}
        // ],
        
        $i = 0;
        foreach($dataImage as $image){
            $i++;
            array_push($initialPreview,url('/')."/product_images/".$image->image_name);
            array_push($initialPreviewConfig,array(
                'downloadUrl' => url('/')."/product_images/".$image->image_name,
                'key' => $i,
                'extra' => array('id',$image->id)
            ));
        }

        $initialPreview = json_encode($initialPreview);
        $initialPreviewConfig = json_encode($initialPreviewConfig);
        

        return view('admin.product.productedit', compact('title','data','initialPreview','initialPreviewConfig'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        ProductImage::where('product_id', '=', $id)->delete();
        Product::where('id', '=', $id)->delete();
        return redirect($this->routelink);
    }
}
