<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\AdminStoreMallRequest;
use App\Http\Requests\Api\Admin\AdminUpdateMallRequest;
use App\Models\User;
use App\Traits\FileSaveTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdministratorController extends Controller
{

    use FileSaveTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $per_page = $request->get('per_page',$this->default_per_page);

        $data = User::paginate($per_page);

        return $this->sendResponse(true,$data,'data retrieved successful',200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminStoreMallRequest $request)
    {
        $data = $request->validated();
        
        $data['password'] = Hash::make($request->password);

        $admin = User::create($data);

        return $this->sendResponse(true,$admin,'admin created successful',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = User::find($id);

        if (is_null($admin)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        return $this->sendResponse(true,$admin,'admin retrieved successful',200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateMallRequest $request, $id)
    {
        $admin = User::find($id);

        if (is_null($admin)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $data = $request->validated();

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return $this->sendResponse(true,$admin,'admin updated successful',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mall = Mall::find($id);

        if (is_null($mall)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }
        
        $path = $mall->getRawOriginal('image');

        $mall->delete();

        $this->deleteFile($path);

        return $this->sendResponse(true,$mall,'mall deleted successful',200);
    }
}
