<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\AdminUpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminCustomerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $per_page = $request->get('per_page',$this->default_per_page);

        $data = Customer::paginate($per_page);

        return $this->sendResponse(true,$data,'data retrieved successful',200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);

        if (is_null($customer)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        return $this->sendResponse(true,$customer,'data retrieved successful',200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateCustomerRequest $request, $id)
    {
        $customer = Customer::find($id);

        if (is_null($customer)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $data = $request->validated();

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $customer->update($data);

        return $this->sendResponse(true,$customer,'data updated successful',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);

        if (is_null($customer)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $customer->delete();

        return $this->sendResponse(true,$customer,'data deleted successful',200);
    }
}
