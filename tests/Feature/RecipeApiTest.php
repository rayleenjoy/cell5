<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Recipe;

class RecipeApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setUp():void
    {
        parent::setUp();
    }

    public function test_create_recipe()
    {
        $formData = [
            'name'=>'Chicken Adobo',   
            'cuisine'=>'Filipino Dish',
            'ingredients'=> 'Test INgredients'
        ];

        $this->json('POST',route('recipe.store'),$formData)
             ->assertStatus(200);   

    }

    public function test_update_task()
    {
        $recipe = factory(Recipe::class)->make();
        $recipe->save();

        $updatedData = [
            'name' => 'Updated Chicken Adobo Recipe',
            'ingredients' => 'Add some chili'
        ];

        $this->json('PUT', route('recipe.update', $recipe->id), $updatedData)
            ->assertStatus(200);
    }

    public function test_show_task()
    {

        $recipe = factory(Recipe::class)->make();
        $recipe->save();

        $this->get(route('recipe.show', $recipe->id))->assertStatus(200)
             ->assertJsonStructure([
                'success',
                'data',
                'message',
            ]);
    }
   
    public function test_delete_task()
    {
        $recipe = factory(Recipe::class)->make();
        $recipe->save();

        $this->delete(route('recipe.destroy', $recipe->id))->assertStatus(200);
    }

    public function test_list_tasks()
    {
        $recipe = factory(Recipe::class)->make();
        $recipe->save();

        $this->json('POST', 'api/recipe/list', [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
                'message',
            ]);
    }

}
