<?php

namespace App\Services\Tag; 
use App\Repositories\Tag\TagRepository;

class TagService
{ 

    private $tagRepository;

    public function __construct()
    {
        $this->tagRepository = (new TagRepository());
    }

    /**
    *Return all values
     *
     * @return  mixed
    */
    public function all()
	{
      return $this->tagRepository->all();
    }


   /*
    * Get Tag By Id
    * @param  $tagId Int
    */
    public function find($tagId)
    {
        return $this->tagRepository->show($tagId);
    }


    /*
    * Create Tag
    * @param  $data Array
    */
    public function store($data)
    {
        $tag = new $this->tagRepository->tag($data->all());
        //Save Tag
        return $this->tagRepository->save($tag);
    }

    /*
    * Update Tag
    * @param  $tagId Int
    * @param  $data Array
    */
    public function update($tagId, $data)
    {
        $tag = $this->tagRepository
                         ->show($tagId)
                         ->fill($data->all());

        //Update Tag
        return $this->tagRepository->save($tag);
    }

    /*
    * Delete Tag
    * @param  $tagId Int
    */
    public function destroy($tagId)
    {
        //Delete Tag
        return $this->tagRepository->destroy($tagId);
    }
}