<?php

namespace Tests\Feature\PetVinixcode;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Pet;
use App\Models\Category;
use App\Models\Tag;
use App\Models\TagByPet;
use Tests\Feature\PetVinixcode\Factory\MasterFactory;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Enums\StatusesPets;

class PetTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    //Var That define if the client has enable extention gd in order to check images in laravel according his version
    private $canTestingImage; 

    protected function setUp(): void
    {
        parent::setUp();
        //Base Factories
        MasterFactory::createBase();
        
        $this->setUpFaker();

        $this->canTestingImage = in_array('gd', get_loaded_extensions() );
    }

    /**
    * Method for create a pet with your tags complete
    * @param $countTags | Array Is to define how many tags is created for users
    * @param $status | Enum Option StatusesPets Is to define Status Pet
    * @return Model
    */
    protected function seeder_pet_complete($countTags = [1,2,3],$status = null  ){
        
        if(is_null($status) ) $status = $this->faker->randomElement(StatusesPets::getValues());

        $tags = Tag::whereIn('id',$countTags)->get();

        $params = [
            'category_id' => Category::inRandomOrder()->first()->id,
            'name' => $this->faker->text(32),
            'photoUrls' => $this->faker->text(255),
            'status' => $status,
            'tags' => $tags->toArray()
        ];

        $images = ($this->canTestingImage) ? ['photoUrlsFile' => UploadedFile::fake()->image('pet.png')] : [];

        //Store Our Registry in the table Pet throught to Fake Route with fake params
        $request = Request::create('/api/pets','POST',$params,[],$images);

        return \Pet::store($request);
    }

    /**
    * Test get all pets.
    * @return  void
    */
   public function test_pets_get_all()
   {
        $pet1 = $this->seeder_pet_complete();

        $pet2 = $this->seeder_pet_complete([5,6]);

        $response = $this->json('GET','api/pets');

        $response->assertJson([
            [
                'category_id' => $pet1['pet']->category_id,
                'name' => $pet1['pet']->name,
                'photoUrls' => $pet1['pet']->photoUrls,
                'status' => $pet1['pet']->status->value, //Value is the propierty of Enum Class
            ],
            [
                'category_id' => $pet2['pet']->category_id,
                'name' => $pet2['pet']->name,
                'photoUrls' => $pet2['pet']->photoUrls,
                'status' => $pet2['pet']->status->value, //Value is the propierty of Enum Class
            ]
        ]);

        $this->assertDatabaseCount('pets', 2);

        $this->assertDatabaseCount('tag_by_pets', 5);

       $response->assertStatus(200);
   }

    /**
    * Test Get Pet By Id With Model or Registry Does not exist.
    * @return void
    */
    public function test_pets_get_by_id_with_nonexistent_model()
    {
        $response = $this->json('GET','api/pets/1');
        $this->assertEquals('Pet Not Found', $response['message']);
        $response->assertStatus(404);
    }

    /**
    * Test Get Pet By Id With Invalid Parameter
    * @return void
    */
    public function test_pets_get_by_id_with_invalid_parameter()
    {
        $response = $this->json('GET','api/pets/G');
        $this->assertEquals('Invalid ID supplied', $response['message']);
        $response->assertStatus(400);
    }

    /**
    * Test  Get Pet By Id.
    * @return  void
    */
   public function test_pets_get_by_id()
   {
       $pet = $this->seeder_pet_complete([7]);

       $response = $this->json('GET','api/pets/'.$pet['pet']->id);

       $response->assertJson([
            'category_id' => $pet['pet']->category_id,
            'name' => $pet['pet']->name,
            'photoUrls' => $pet['pet']->photoUrls,
            'status' => $pet['pet']->status->value, //Value is the propierty of Enum Class
        ]);

       $this->assertDatabaseCount('tag_by_pets', 1);

       $response->assertStatus(200);
   }



    /**
    * Test Get Pet By Status With Invalid Status
    * @return void
    */
    public function test_pets_get_by_status_with_invalid_status()
    {
        $response = $this->json('GET','api/pets/findByStatus/other_status');
        $this->assertEquals('Invalid status value', $response['message']);
        $response->assertStatus(400);
    }

    /**
    * Test Get Pet By Status.
    * @return  void
    */
    public function test_pets_get_by_status(){

        $pet1 = $this->seeder_pet_complete([1],StatusesPets::AVAILABLE->value);
       // dd($pet1);

        $pet2 = $this->seeder_pet_complete([5,6],StatusesPets::AVAILABLE->value);

        $pet3 = $this->seeder_pet_complete([2,3,4],StatusesPets::PENDING->value);


        $pet4 = $this->seeder_pet_complete([5,6],StatusesPets::PENDING->value);


        $pet5 = $this->seeder_pet_complete([4,5,6],StatusesPets::PENDING->value);


        $pet6 = $this->seeder_pet_complete([5,6,7],StatusesPets::SOLD->value);

        $response = $this->json('GET','api/pets/findByStatus/'.StatusesPets::PENDING->value);
        
        $response->assertJson([
            [
                'name' => $pet3['pet']->name,
                'photoUrls' => $pet3['pet']->photoUrls,
                'status' => $pet3['pet']->status->value, //Value is the propierty of Enum Class
            ],
            [
                'name' => $pet4['pet']->name,
                'photoUrls' => $pet4['pet']->photoUrls,
                'status' => $pet4['pet']->status->value, //Value is the propierty of Enum Class
            ],
            [
                'name' => $pet5['pet']->name,
                'photoUrls' => $pet5['pet']->photoUrls,
                'status' => $pet5['pet']->status->value, //Value is the propierty of Enum Class
            ]
        ]);

        $this->assertDatabaseCount('pets', 6);

        $this->assertDatabaseCount('tag_by_pets', 14);

       $response->assertStatus(200);
    }


    /**
    * Test Create Pet With Validation Exeption For this case photoUrls field
    * @return void
    */
    public function test_pets_create_with_validation_exception()
    {
        $pet = $this->seeder_pet_complete();

        $response = $this->json('POST','api/pets/', [
          'category_id' => Category::inRandomOrder()->first()->id,
          'name' => $this->faker->text(32),
          'status' => StatusesPets::PENDING->value,
        ]);

        $response->assertJson([
            'message' => 'Validation exception',
            'errors' => [
                'photoUrls' => ['The Field Photo Urls Is Required']
            ]
        ]);

        $response->assertStatus(405);
    }

   /**
     * Test Create Pet.
     * @return  void
     */
    public function test_pets_create()
    {
        $tags = Tag::whereIn('id',[1,2,3])->get();

        $response = $this->json('POST','api/pets',[
            'category_id' => Category::inRandomOrder()->first()->id,
            'name' => $this->faker->text(32),
            'photoUrls' => $this->faker->text(255),
            'status' => $this->faker->randomElement(StatusesPets::getValues()),
            'tags' => $tags->toArray()
        ]);
 
        $this->assertDatabaseCount('pets', 1);

        $this->assertDatabaseCount('tag_by_pets', 3);
        
        $response->assertStatus(200);
    }



    /**
    * Test Update Pet With Model or Registry Does not exist.
    * @return void
    */
    public function test_pets_udpate_with_nonexistent_model()
    {
        $response = $this->json('PUT','api/pets/1',[
          'category_id' =>  Category::inRandomOrder()->first()->id,
          'name' => 'Lion',
          'photoUrls' => 'http://one_image.com/lion.pnn',
          'status' => StatusesPets::PENDING->value,
        ]);
        $this->assertEquals('Pet Not Found', $response['message']);
        $response->assertStatus(404);
    }

    /**
    * Test Update Pet  With Invalid Parameter
    * @return void
    */
    public function test_pets_update_with_invalid_parameter()
    {
        $response = $this->json('PUT','api/pets/Z',[
          'category_id' =>  Category::inRandomOrder()->first()->id,
          'name' => 'Lion',
          'photoUrls' => 'http://one_image.com/lion.pnn',
          'status' => StatusesPets::PENDING->value,
        ]);
        $this->assertEquals('Invalid ID supplied', $response['message']);
        $response->assertStatus(400);
    }

    /**
    * Test Update Pet  With Validation Exeption For this case without name field
    * @return void
    */
    public function test_pets_update_with_validation_exception()
    {
        $pet = $this->seeder_pet_complete();

        $response = $this->json('PUT','api/pets/'.$pet["pet"]->id,[
          'category_id' => $category_id = Category::inRandomOrder()->first()->id,
          'photoUrls' => $pet["pet"]->photoUrls,
          'status' => $pet["pet"]->status,
        ]);

        $response->assertJson([
            'message' => 'Validation exception',
            'errors' => [
                'name' => ['The Field Name Is Required']
            ]
        ]);

        $response->assertStatus(405);
    }

    /**
     * Test update pet.
     * @return  void
     */
    public function test_pets_update()
    {
        $pet = $this->seeder_pet_complete();

        $response = $this->json('PUT','api/pets/'.$pet["pet"]->id,[
          'category_id' => $category_id = Category::inRandomOrder()->first()->id,
          'name' => $pet["pet"]->name,
          'photoUrls' => $pet["pet"]->photoUrls,
          'status' => $pet["pet"]->status,
        ]);

        $this->assertDatabaseHas('pets', [
            'category_id' => $category_id,        
        ]);

        $this->assertDatabaseCount('tag_by_pets', 3);

        $response->assertStatus(200);
    }


    /**
    * Test delete pet with Model or Registry Does not exist.
    * @return void
    */
    public function test_pets_delete_with_nonexistent_model()
    {
        $response = $this->json('DELETE','api/pets/1');
        $this->assertEquals('Pet Not Found', $response['message']);
        $response->assertStatus(404);
    }

    /**
    * Test delete pet with Invalid Parameter
    * @return void
    */
    public function test_pets_delete_with_invalid_parameter()
    {
        $response = $this->json('DELETE','api/pets/N');
        $this->assertEquals('Invalid ID supplied', $response['message']);
        $response->assertStatus(400);
    }

    /**
     * Test delete pet.
     *
     * @return  void
     */
    public function test_pets_delete()
    {
        $pet = $this->seeder_pet_complete();

        $response = $this->json('DELETE','api/pets/'.$pet["pet"]->id);

        $this->assertDatabaseCount('pets', 0);

        $response->assertStatus(200);
    }
}