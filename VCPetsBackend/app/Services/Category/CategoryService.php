<?php

namespace App\Services\Category; 
use App\Repositories\Category\CategoryRepository;

class CategoryService
{ 

    private $categoryRepository;

    public function __construct()
    {
        $this->categoryRepository = (new CategoryRepository());
    }

    /**
    *Return all values
     *
     * @return  mixed
    */
    public function all()
	{
      return $this->categoryRepository->all();
    }


   /*
    * Get Category By Id
    * @param  $categoryId Int
    */
    public function find($categoryId)
    {
        return $this->categoryRepository->show($categoryId);
    }

    /*
    * Create Category
    * @param  $data Array
    */
    public function store($data)
    {
        $category = new $this->categoryRepository->category($data->all());
        //Save Category
        return $this->categoryRepository->save($category);
    }

    /*
    * Update Category
    * @param  $categoryId Int
    * @param  $data Array
    */
    public function update($categoryId, $data)
    {
        $category = $this->categoryRepository
                         ->show($categoryId)
                         ->fill($data->all());

        //Update Category
        return $this->categoryRepository->save($category);
    }

    /*
    * Delete Category
    * @param  $categoryId Int
    */
    public function destroy($categoryId)
    {
        //Delete Category
        return $this->categoryRepository->destroy($categoryId);
    }
}