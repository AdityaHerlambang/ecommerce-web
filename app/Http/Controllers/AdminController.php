<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;

class AdminController extends Controller
{

    protected $routelink = 'admin/dataadmin';

    protected $rules =
    [
        'name'     => 'required|string|max:255',
        'username'    => 'required|string|max:255|unique:admins',
        'password' => 'required|string|min:6',
        'phone' => 'required|string|numeric',
        'imageupload' => 'required|image|mimes:jpeg,png,gif,svg'
    ];

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
        // return $request;
        $validatedData = $request->validate($this->rules);

        $image = $request->file('imageupload');
        $image_name = "admin-".$request->username.'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/admin_profile_images');
        $image->move($destinationPath, $image_name);

        $validatedData['profile_image'] = $image_name;

        try {
            $validatedData['password']        = bcrypt(array_get($validatedData, 'password'));
            $admin                            = app(Admin::class)->create($validatedData);
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
        $data = Admin::where('id',$id)->first();

        return $data;
        
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

        $rulesUpdate = [
            'name'     => 'required|string|max:255',
            'username'    => 'required|string|max:255|unique:admins,id,'.$request->id,
            'phone' => 'required|string|numeric',
            'imageupload' => 'image'
        ];

        $reqvalid = $request->validate($rulesUpdate);
        
        $data = Admin::find($id);
        $data->username = $reqvalid['username'];
        if(isset($request->password) && $request->password != ""){
            $data->password = bcrypt($request->password);
        }
        
        if(isset($reqvalid['imageupload'])){
            $image = $request->file('imageupload');
            $image_name = "admin-".$reqvalid['username'].'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/admin_profile_images');
            $image->move($destinationPath, $image_name);

            $data->profile_image = $image_name;
        }

        $data->name = $reqvalid['name'];
        $data->phone = $reqvalid['phone'];
        $data->save();

        return redirect($this->routelink);
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
        Admin::where('id', '=', $id)->delete();
        return redirect($this->routelink);
    }

}
