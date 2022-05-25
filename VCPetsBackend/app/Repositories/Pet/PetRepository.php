<?php

namespace App\Repositories\Pet; 
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 
use App\Models\Pet;
use App\Repositories\Base\BaseRepository; 
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PetRepository extends BaseRepository implements PetRepositoryInterface
{
    private $pet;

    CONST RELATIONS = [
      'category',
      'tags'
    ];

    public function __construct()
    {
      $this->pet = new Pet();
      parent::__construct($this->pet, self::RELATIONS);
    }

   /*
    * Get Pet By Status
    * @param  $status string
    */
    public function getPetsByStatus($status)
    {
      $select = $this->model
              ->select(['id','name','photoUrls','status', 'category_id'])
              ->whereStatus($status)
              ->with(self::RELATIONS)
              ->get();
      $select->makeHidden(['category_id']);
      return $select;
    }

   /**
    * Save Pet
     *
     * @return  mixed
   */
    public function store($data)
    {
      $pet = $this->pet->create(array(
        'category_id' => $data['category_id'],
        'name' => $data['name'],
        'photoUrls' => $data['photoUrls'],
        'tags' => json_encode($data["tags"]),
        'status' => $data['status'],
        'created_at' => Carbon::now()
      ));
      
      //Get Ids From Tags table in ordert to sinronize tags associate to model, we are validating get tags as array object 
      $tag_ids = array_column( (gettype($data['tags']) == "string" ? json_decode($data['tags'], true) :  $data['tags']) , 'id');

      $pet->tag()->sync($tag_ids);

      return $pet;
    }

   /**
    *Update Pet
     *
     * @return  mixed
   */
   public function update($pet,$data)
    {
        $pet = parent::show($pet);
        $pet->fill(array(
          'category_id' => $data['category_id'],
          'name' => $data['name'],
          'photoUrls' => $data['photoUrls'],
          'tags' => $data['tags'],
          'status' => $data['status'],
          'updated_at' => Carbon::now()
        ));

        $pet->save();

        //Get Ids From Tags table in ordert to sinronize tags associate to model, we are validating get tags as array object 
        $tag_ids = array_column( (gettype($data['tags']) == "string" ? json_decode($data['tags'], true) :  $data['tags']) , 'id');
        
        $pet->tag()->sync($tag_ids);

        return $pet;
   }

}