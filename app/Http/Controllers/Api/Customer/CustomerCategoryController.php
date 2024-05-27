<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CustomerCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {     

        $data = Category::get();

        return $this->sendResponse(true,$data,'data retrieved successful',200);
    }
}
