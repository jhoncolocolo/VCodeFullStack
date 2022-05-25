<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany; 
 

class Tag extends Model
{ 
  use HasFactory;
	protected $table = 'tags';
 
	protected $primaryKey = 'id';
 
	protected $fillable = ["name"];
 
	protected $hidden = ['created_at','updated_at'];

  /**
   * @return  mixed
  */
  public function tag_by_pet(): HasMany
  {
      return $this->hasMany(TagByPet::class);
  }
}