<?php

namespace App\Services\Pet; 
use App\Repositories\Pet\PetRepository;
use Illuminate\Support\Facades\DB;
use Throwable;
use Storage;


class PetService
{ 

    private $petRepository;

    public function __construct()
    {
        $this->petRepository = (new PetRepository());
    }

    /**
    *Return all values
     *
     * @return  mixed
    */
    public function all()
	{
      return $this->petRepository->all();
    }

   /*
    * Get Pet By Id
    * @param  $petId Int
    */
    public function find($petId)
    {
        return $this->petRepository->show($petId);
    }

    /*
    * Get Pet By Status
    * @param  $petId Int
    */
    public function getPetsByStatus($status)
    {
        return $this->petRepository->getPetsByStatus($status);
    }

    /*
    * Do Pet
    * @param  $data Array
    */
    public function store($data)
    {
        DB::beginTransaction();
        try {
            $pet = $this->petRepository->store($data);
            
            if( $data->file('photoUrlsFile')){ 
                $path = Storage::disk('public_uploads')->put('images/pets', $data->file('photoUrlsFile')); 
                $urlBD = 'http://'. $_SERVER['HTTP_HOST'].'/uploads/'.$path; 
                $pet->fill(['photoUrls' => $urlBD])->save();
            }

            DB::commit();

            return [
             'successful' => true,
             'message' => 'Record Entered Successfully',
             'pet' => $pet
            ];

        } catch (\Exception | Throwable $e) {

            DB::rollBack();

            return [
                "successful" => false,
                "message" => "Record Not Entered Successfully"
            ];
        }
    }

    /*
    * Update Pet
    * @param  $petId Int
    * @param  $data Array
    */
    public function update($petId, $data)
    {
        //Update Pet
        $pet = $this->petRepository->update($petId, $data);
        $data = [];
        if ($pet) {
           $data['successful'] = true;
           $data['message'] = 'Record Update Successfully';
           $data['pet_id'] = $pet;
        }else{
           $data['successful'] = false;
           $data['message'] = 'Record Not Update Successfully';
        }
        return $pet;
    }

    /*
    * Delete Pet
    * @param  $petId Int
    */
    public function destroy($petId)
    {
        //Delete Pet
        $pet= $this->petRepository->destroy($petId);
        $data = [];
        if ($pet) {
           $data['successful'] = true;
           $data['message'] = 'Record Delete Successfully';

        }else{
           $data['successful'] = false;
           $data['message'] = 'Record Not Delete Successfully';
        }
        return $data;
    }
}