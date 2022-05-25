<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\RequestPet;
use App\Enums\StatusesPets;

class PetController extends Controller 
{
    
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(\Pet::all());
    }


    /**
     * Display Pets Status.
     * @param   string $status
     * @return  \Illuminate\Http\Response
     */
    public function findByStatus($status)
    {
        if(!StatusesPets::IsValidOption($status)){
            return response()->json( ['message' => 'Invalid status value'], 400);
        }
        return response()->json(\Pet::getPetsByStatus($status));
    } 

    /**
     * Display the specified resource.
     *
     * @param    \App\Models\Pet  $Pet
     * @return  \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(\Pet::find($id));
    } 
 
    /*
    * Store Pet
    * @return  void
    */    
    public function store(RequestPet $request)
     {
        return \Pet::store($request);
     }

    /*
    * Update Pet
    * @return  void
    */ 
    public function update($pet,RequestPet $request)
     {
       //Update pets
       $pet = \Pet::update($pet, $request);
       return response()->json($pet);
    }

    /*
    * Delete $pet
    * @return  void
    */ 
    public function destroy($pet)
     {
       //Delete pets
       return response()->json(\Pet::destroy($pet));
    }
}