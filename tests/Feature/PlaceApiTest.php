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
            ->postJson(route('places.store'), [
                'name' => 'Test Place',
                'city' => 'Test City',
                'state' => 'Test State',
            ]);

            $response->assertStatus(201)
            ->assertJson(Place::where('name', 'Test Place')->first()->toArray());
   

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
        $place = Place::factory()->create([
            'name' => 'List Place',
        ]);

        $response = $this->actingAs($user)
            ->getJson(route('places.index'));

        $response->assertStatus(200)
            ->assertJson([
                'data' => [$place->toArray()],
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
        ])->getJson(route('places.show', $place));

        $response->assertStatus(200)
            ->assertJson([
                'data' => $place->toArray(),
            ]);
    }

    /** @test */
    public function it_can_update_a_place()
    {
        $user = User::factory()->create();
        $place = Place::factory()->create();

        $response = $this->actingAs($user)
            ->putJson(route('places.update', $place), [
                'name' => 'Updated Place',
                'city' => 'Updated City',
                'state' => 'Updated State',
            ]);

            $response->assertStatus(200)
            ->assertJson($place->refresh()->toArray());   

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
    
        $response = $this->actingAs($user)->deleteJson(route('places.destroy', $place->id));
    
        $response->assertStatus(204);
    
        $this->assertDatabaseMissing('places', [
            'id' => $place->id,
        ]);
    }
}
