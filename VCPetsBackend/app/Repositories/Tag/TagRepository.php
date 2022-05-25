<?php

namespace App\Repositories\Tag; 
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 
use App\Models\Tag;
use App\Repositories\Base\BaseRepository; 

class TagRepository  extends BaseRepository implements TagRepositoryInterface
{ 
  public $tag;

  public function __construct()
  {
    $this->tag = new Tag();
    parent::__construct($this->tag);
  }
}