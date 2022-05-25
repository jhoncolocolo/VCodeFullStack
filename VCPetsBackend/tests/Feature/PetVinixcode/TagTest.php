<?php

namespace Tests\Feature\PetVinixcode;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tag;

class TagTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    /**
    * test get all tags.
    *
    * @return  void
    */
   public function test_tags_get_all()
   {
        Tag::create([
            'name' => $name_1 = $this->faker->text(32),
        ]);

        Tag::create([
            'name' => $name_2 = $this->faker->text(32),
        ]);

       $response = $this->json('GET','api/tags');

       $response->assertJson([
            [
                'name' => $name_1,
            ],
            [
                'name' => $name_2,
            ]
        ]);

        $this->assertDatabaseCount('tags', 2);

       $response->assertStatus(200);
   }


    /**
    * test get tag By Id.
    *
    * @return  void
    */
   public function test_tags_get_by_id()
   {
       $tag = Tag::create([
            'name' => $name_1 =  $this->faker->text(32),
        ]);

       $response = $this->json('GET','api/tags/'.$tag->id);

       $response->assertJson([
            'name' => $name_1,
        ]);

       $response->assertStatus(200);
   }

   /**
     * test create tag.
     *
     * @return  void
     */
    public function test_tags_create()
    {

        $response = $this->json('POST','api/tags',[
            'name' => $this->faker->text(32),
        ]);
        $this->assertDatabaseCount('tags', 1);
        $response->assertStatus(200);
    }

    /**
     * test update tag.
     *
     * @return  void
     */
    public function test_tags_update()
    {
        $tag = Tag::create([
            'name' => $this->faker->text(32),
        ]);
        $response = $this->json('PUT','api/tags/'.$tag->id,[
            'name' => $name = $this->faker->text(32),
          
        ]);

        $this->assertDatabaseHas('tags', [
            'name' => $name,        
        ]);

        $response->assertStatus(200);
    }

    /**
     * test delete tag.
     *
     * @return  void
     */
    public function test_tags_delete()
    {
        $tag = Tag::create([
            'name' => $this->faker->text(32),
        ]);

        $response = $this->json('DELETE','api/tags/'.$tag->id);

        $this->assertDatabaseCount('tags', 0);

        $response->assertStatus(200);
    }
}