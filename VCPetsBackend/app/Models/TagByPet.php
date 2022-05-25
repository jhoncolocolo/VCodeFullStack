<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
use Illuminate\Database\Eloquent\Relations\BelongsTo; 

class TagByPet extends Model
{ 
  use HasFactory;
	protected $table = 'tag_by_pets';
 
	protected $primaryKey = 'id';
 
	protected $fillable = ["pet_id","tag_id"];
 
	protected $hidden = ['pet_id', 'created_at','updated_at'];


	
  /**
   * @return  mixed
  */
  public function pet(): BelongsTo
  {
      return $this->belongsTo(Pet::class);
  }

  /**
   * @return  mixed
  */
  public function tag(): BelongsTo
  {
      return $this->belongsTo(Tag::class);
  }
}