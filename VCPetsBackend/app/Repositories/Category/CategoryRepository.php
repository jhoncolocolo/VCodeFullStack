<?php

namespace App\Repositories\Category; 
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 
use App\Models\Category;
use App\Repositories\Base\BaseRepository; 

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{ 
  public $category;

  public function __construct()
  {
    $this->category = new Category();
    parent::__construct($this->category);
  }
}