<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\AdminStoreCategoryRequest;
use App\Http\Requests\Api\Admin\AdminUpdateCategoryRequest;
use App\Http\Requests\Api\Admin\AdminGetCategoryRequest;
use App\Models\Category;
use App\Traits\FileSaveTrait;
use Illuminate\Http\Request;

use function Pest\Laravel\delete;

class AdminCategoryController extends Controller
{
    use FileSaveTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AdminGetCategoryRequest  $request)
    {
        $per_page = $request->get('per_page',$this->default_per_page);

        $data = Category::where('type',$request->type)->paginate($per_page);

        return $this->sendResponse(true,$data,'data retrieved successful',200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminStoreCategoryRequest $request)
    {
        $data = $request->validated();
        
        $category = Category::create($data);

        return $this->sendResponse(true,$category,'category created successful',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);

        if (is_null($category)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        return $this->sendResponse(true,$category,'category retrieved successful',200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateCategoryRequest $request, $id)
    {
        $category = Category::find($id);

        if (is_null($category)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $data = $request->validated();

        $category->update($data);

        return $this->sendResponse(true,$category,'category updated successful',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if(is_null($category)){
            return  $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $category->delete();
 
        return $this->sendResponse(true,$category,'category deleted successful',200);
    }
}
