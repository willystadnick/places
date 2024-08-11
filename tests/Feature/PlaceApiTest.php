<?php

namespace Tests\Feature;

use App\Models\Place;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlaceApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_place()
    {
        $user = User::factory()->create(); 

        $response = $this->actingAs($user) 
                         ->postJson('/api/places', [
                             'name' => 'Test Place',
                             'city' => 'Test City',
                             'state' => 'Test State',
                         ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'name' => 'Test Place',
                     'city' => 'Test City',
                     'state' => 'Test State',
                 ]);

        $this->assertDatabaseHas('places', [
            'name' => 'Test Place',
            'city' => 'Test City',
            'state' => 'Test State',
        ]);
    }

    /** @test */
    public function it_can_list_all_places()
    {
        $user = User::factory()->create();
        Place::factory()->create([
            'name' => 'List Place',
        ]);

        $response = $this->actingAs($user) 
                         ->getJson('/api/places');

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'name' => 'List Place',
                 ]);
    }

    /** @test */
    public function test_can_get_a_place()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;
    
        $place = Place::factory()->create([
            'name' => 'inventore',
            'city' => 'Karleyburgh',
            'state' => 'Minnesota',
        ]);
    
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/places/' . $place->id);
    
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $place->id,
                    'name' => $place->name,
                    'slug' => $place->slug,
                    'city' => $place->city,
                    'state' => $place->state,
                    'created_at' => $place->created_at->toJSON(),
                    'updated_at' => $place->updated_at->toJSON(),
                ]
            ]);
    }
    
    

    /** @test */
    public function it_can_update_a_place()
    {
        $user = User::factory()->create(); 
        $place = Place::factory()->create();

        $response = $this->actingAs($user) 
                         ->putJson('/api/places/' . $place->id, [
                             'name' => 'Updated Place',
                             'city' => 'Updated City',
                             'state' => 'Updated State',
                         ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'name' => 'Updated Place',
                     'city' => 'Updated City',
                     'state' => 'Updated State',
                 ]);

        $this->assertDatabaseHas('places', [
            'id' => $place->id,
            'name' => 'Updated Place',
            'city' => 'Updated City',
            'state' => 'Updated State',
        ]);
    }

    /** @test */
    public function it_can_delete_a_place()
    {
        $user = User::factory()->create();
        $place = Place::factory()->create();

        $response = $this->actingAs($user) 
                         ->deleteJson('/api/places/' . $place->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('places', [
            'id' => $place->id,
        ]);
    }
}
