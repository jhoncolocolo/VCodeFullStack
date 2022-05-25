<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\RequestNameGeneral;

class CategoryController extends Controller 
{
    
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(\Category::all());
    }

    /**
     * Display the specified resource.
     *
     * @param    \App\Models\Category  $Category
     * @return  \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = \Category::find($id);
        return response()->json($category);
    } 
 
    /*
    * Store Category
    * @return  void
    */    
    public function store(RequestNameGeneral $request)
     {
       //Save categories
       $category = \Category::store($request);
       $data = [];
       if ($category) {
           $data['successful'] = true;
           $data['message'] = 'Record Entered Successfully';
           $data['last_insert_id'] = $category->id;
       }else{
           $data['successful'] = false;
           $data['message'] = 'Record Not Entered Successfully';
       }
       return response()->json($data);
  }

    /*
    * Update Category
    * @return  void
    */ 
    public function update($category,RequestNameGeneral $request)
     {
       //Update categories
       $category = \Category::update($category, $request);
       $data = [];
       if ($category) {
           $data['successful'] = true;
           $data['message'] = 'Record Update Successfully';
           $data['category_id'] = $category;
       }else{
           $data['successful'] = false;
           $data['message'] = 'Record Not Update Successfully';
       }
       return response()->json($data);
    }

    /*
    * Delete $category
    * @return  void
    */ 
    public function destroy($category)
     {
       //Delete categories
       $category = \Category::destroy($category);
       $data = [];
       if ($category) {
           $data['successful'] = true;
           $data['message'] = 'Record Delete Successfully';

       }else{
           $data['successful'] = false;
           $data['message'] = 'Record Not Delete Successfully';
       }
       return response()->json($data);
    }
}