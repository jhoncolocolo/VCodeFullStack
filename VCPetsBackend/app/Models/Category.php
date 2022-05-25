<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany; 
 

class Category extends Model
{ 
  use HasFactory;
	protected $table = 'categories';
 
	protected $primaryKey = 'id';
 
	protected $fillable = ["name"];
 
	protected $hidden = ['created_at','updated_at'];

  /**
   * @return  mixed
  */
  public function pet(): HasMany
  {
      return $this->hasMany(Pet::class);
  }
}