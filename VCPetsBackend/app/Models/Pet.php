<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany; 
use Illuminate\Database\Eloquent\Relations\BelongsTo; 
use Illuminate\Database\Eloquent\Relations\BelongsToMany; 
use App\Enums\StatusesPets;

class Pet extends Model
{ 
  use HasFactory;
	protected $table = 'pets';
 
	protected $primaryKey = 'id';
 
	protected $fillable = ["category_id","name","photoUrls","status"];
 
	protected $hidden = ['created_at','updated_at'];

  /**
   * The attributes that should be cast.
   *
   * @var array
   */
  protected $casts = [
      'status' => StatusesPets::class,
  ];

  /**
   * @return  mixed
  */
  public function tag_by_pet(): HasMany
  {
      return $this->hasMany(TagByPet::class);
  }



    /**
     * @return mixed
     */
    public function tags()
    {
      return $this->hasMany('\App\Models\TagByPet', 'pet_id', 'id')
                ->join('tags', 'tags.id', '=', 'tag_by_pets.tag_id')
                ->select('pet_id','tags.id','name');
    }

	
  /**
   * @return  mixed
  */
  public function category(): BelongsTo
  {
      return $this->belongsTo(Category::class);
  }


  /**
    * Pets can belong to many Tags.
    *
    * @return Model
  */
  public function tag()
  {
    return $this->belongsToMany(Tag::class, 'tag_by_pets')->withTimestamps();
  }
}