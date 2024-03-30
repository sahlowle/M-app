<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\AdminStoreCategoryRequest;
use App\Http\Requests\Api\Admin\AdminUpdateCategoryRequest;
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
    public function index(Request  $request)
    {
        $per_page = $request->get('per_page',$this->default_per_page);

        $data = Category::paginate($per_page);

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

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile('category_images',$request->file('image'));
        }

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

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile('category_images',$request->file('image'));

            $path = $category->getRawOriginal('image');

            $this->deleteFile($path);
        }

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

        $path = $category->getRawOriginal('image');

        $category->delete();

        $this->deleteFile($path);
 
        return $this->sendResponse(true,$category,'category updated successful',200);
    }
}
