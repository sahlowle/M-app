<?php
namespace App\Traits;
use Illuminate\Http\Request;


trait SearchFilter
{
    function scopeFilter($query,Request $request) {
        
        if ($request->filled('category_id')) {
            $query->where('category_id',$request->category_id);
        }

        if ($request->filled('name')) {
            $class =  (new \ReflectionClass($this))->getShortName();

            if ($class == 'News')
            {
                $query->where('title->'.app()->getLocale(), 'like', '%'.$request->name.'%')
                ->OrWhere('content->'.app()->getLocale(), 'like', '%'.$request->name.'%');
            } 
            else
            {
                $query->where('name->'.app()->getLocale(), 'like', '%'.$request->name.'%')
                ->OrWhere('description->'.app()->getLocale(), 'like', '%'.$request->name.'%');
            }
        }
    }
}