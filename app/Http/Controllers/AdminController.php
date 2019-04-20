<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $tableData = Admin::get();

        return view('admin.dataadmin',compact('tableData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
        //
        $validatedData = $request->validate([
            'name'     => 'required|string|max:255',
            'username'    => 'required|string|max:255|unique:admins',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|numeric',
            'imageupload' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        $image = $request->file('imageupload');
        $image_name = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/admin_profile_images');
        $image->move($destinationPath, $image_name);

        $validatedData['profile_image'] = $image_name;

        try {
            $validatedData['password']        = bcrypt(array_get($validatedData, 'password'));
            $admin                             = app(Admin::class)->create($validatedData);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
