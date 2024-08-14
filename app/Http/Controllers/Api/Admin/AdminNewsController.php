<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Api\Admin\AdminUpdateNewsRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\AdminStoreNewsRequest;
use App\Models\News;
use App\Traits\FileSaveTrait;
use Illuminate\Http\Request;

class AdminNewsController extends Controller
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

        $data = News::get();

        return $this->sendResponse(true,$data,'data retrieved successful',200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminStoreNewsRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile('news_images',$request->file('image'));
        }

        $news = News::create($data);

        return $this->sendResponse(true,$news,'news created successful',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $news = News::find($id);

        if (is_null($news)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        return $this->sendResponse(true,$news,'news retrieved successful',200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateNewsRequest $request, $id)
    {
        $news = News::find($id);

        if (is_null($news)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile('news_images',$request->file('image'));

            $path = $news->getRawOriginal('image');

            $this->deleteFile($path);
        }

        $news->update($data);

        return $this->sendResponse(true,$news,'news updated successful',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news = News::find($id);

        if (is_null($news)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }
        
        $path = $news->getRawOriginal('image');

        $news->delete();

        $this->deleteFile($path);

        return $this->sendResponse(true,$news,'news deleted successful',200);
    }
}
