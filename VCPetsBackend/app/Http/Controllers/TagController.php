<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\RequestNameGeneral;

class TagController extends Controller 
{
    
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(\Tag::all());
    }

    /**
     * Display the specified resource.
     *
     * @param    \App\Models\Tag  $Tag
     * @return  \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = \Tag::find($id);
        return response()->json($tag);
    } 
 
    /*
    * Store Tag
    * @return  void
    */    
    public function store(RequestNameGeneral $request)
     {
       //Save tags
       $tag = \Tag::store($request);
       $data = [];
       if ($tag) {
           $data['successful'] = true;
           $data['message'] = 'Record Entered Successfully';
           $data['last_insert_id'] = $tag->id;
       }else{
           $data['successful'] = false;
           $data['message'] = 'Record Not Entered Successfully';
       }
       return response()->json($data);
  }

    /*
    * Update Tag
    * @return  void
    */ 
    public function update($tag,RequestNameGeneral $request)
     {
       //Update tags
       $tag = \Tag::update($tag, $request);
       $data = [];
       if ($tag) {
           $data['successful'] = true;
           $data['message'] = 'Record Update Successfully';
           $data['tag_id'] = $tag;
       }else{
           $data['successful'] = false;
           $data['message'] = 'Record Not Update Successfully';
       }
       return response()->json($data);
    }

    /*
    * Delete $tag
    * @return  void
    */ 
    public function destroy($tag)
     {
       //Delete tags
       $tag = \Tag::destroy($tag);
       $data = [];
       if ($tag) {
           $data['successful'] = true;
           $data['message'] = 'Record Delete Successfully';

       }else{
           $data['successful'] = false;
           $data['message'] = 'Record Not Delete Successfully';
       }
       return response()->json($data);
    }
}