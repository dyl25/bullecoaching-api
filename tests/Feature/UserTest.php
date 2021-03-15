<?php

namespace Tests\Feature;

use App\Models\Gender;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Role;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWTAuth as TymonJWTAuth;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Coach can only get the users that they have created
     *
     * @return void
     */
    public function test_coach_can_only_get_their_created_users()
    {
        $gender = Gender::factory()->create();

        $roleCoach = Role::factory()->create(['name' => 'coach']);
        $roleUser = Role::factory()->create(['name' => 'user']);

        $coach = User::factory()->for($roleCoach)->for($gender)->create();
        $otherCoach = User::factory()->for($roleCoach)->for($gender)->create();

        $usersCoach = User::factory()
            ->for($roleUser)
            ->for($gender)
            ->count(5)
            ->create([
                'creator_id' => $coach->id,
            ]);
        $usersOtherCoach = User::factory()
            ->for($roleUser)
            ->for($gender)
            ->count(2)
            ->create([
                'creator_id' => $otherCoach->id
            ]);

        $token = JWTAuth::fromUser($coach);

        $response = $this->withHeaders([
            'Authorization' => "Bearer " . $token
        ])->get('/api/users');

        $response->assertJsonCount(
            $usersCoach->count()
        );
    }
}
