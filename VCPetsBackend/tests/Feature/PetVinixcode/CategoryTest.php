<?php

namespace Tests\Feature\PetVinixcode;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;

class CategoryTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    /**
    * test get all categories.
    *
    * @return  void
    */
   public function test_categories_get_all()
   {
        Category::create([
            'name' => $name_1 = $this->faker->text(32),
        ]);

        Category::create([
            'name' => $name_2 = $this->faker->text(32),
        ]);

       $response = $this->json('GET','api/categories');

       $response->assertJson([
            [
                'name' => $name_1,
            ],
            [
                'name' => $name_2,
            ]
        ]);

        $this->assertDatabaseCount('categories', 2);

       $response->assertStatus(200);
   }


    /**
    * test get category By Id.
    *
    * @return  void
    */
   public function test_categories_get_by_id()
   {
       $category = Category::create([
            'name' => $name_1 =  $this->faker->text(32),
        ]);

       $response = $this->json('GET','api/categories/'.$category->id);

       $response->assertJson([
            'name' => $name_1,
        ]);

       $response->assertStatus(200);
   }

   /**
     * test create category.
     *
     * @return  void
     */
    public function test_categories_create()
    {

        $response = $this->json('POST','api/categories',[
            'name' => $this->faker->text(32),
        ]);
        $this->assertDatabaseCount('categories', 1);
        $response->assertStatus(200);
    }

    /**
     * test update category.
     *
     * @return  void
     */
    public function test_categories_update()
    {
        $category = Category::create([
            'name' => $this->faker->text(32),
        ]);
        $response = $this->json('PUT','api/categories/'.$category->id,[
            'name' => $name = $this->faker->text(32),
          
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => $name,        
        ]);

        $response->assertStatus(200);
    }

    /**
     * test delete category.
     *
     * @return  void
     */
    public function test_categories_delete()
    {
        $category = Category::create([
            'name' => $this->faker->text(32),
        ]);

        $response = $this->json('DELETE','api/categories/'.$category->id);

        $this->assertDatabaseCount('categories', 0);

        $response->assertStatus(200);
    }
}