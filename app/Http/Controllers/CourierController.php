<?php

namespace App\Http\Controllers;

use App\Courier;
use Illuminate\Http\Request;

class CourierController extends Controller
{

    protected $routelink = 'admin/courier';

    protected $rules =
    [
        'courier'     => 'required|string|max:255|unique:couriers'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = "Courier";
        $tableData = Courier::get();

        return view('admin.courier', compact('title','tableData'));
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
            $data = app(Courier::class)->create($validatedData);
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
     * @param  \App\Courier  $courier
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data = Courier::where('id',$id)->first();

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Courier  $courier
     * @return \Illuminate\Http\Response
     */
    public function edit(Courier $courier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Courier  $courier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $rulesUpdate =
        [
            'courier'     => 'required|string|max:255|unique:couriers'
        ];

        $reqvalid = $request->validate($rulesUpdate);

        $data = Courier::find($id);
        $data->courier = $reqvalid['courier'];
        $data->save();

        return redirect($this->routelink);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Courier  $courier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Courier::where('id', '=', $id)->delete();
        return redirect($this->routelink);
    }
}
