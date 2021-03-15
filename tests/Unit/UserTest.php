<?php

namespace Tests\Unit;

use App\Models\Gender;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Test if user is role coach
     *
     * @return void
     */
    public function test_user_is_coach_attribute()
    {
        $role = Role::factory()->create(['name' => 'coach']);

        $user = User::factory()->for($role)->make();

        $this->assertTrue($user->isCoach);
    }

    /**
     * Test if user is not role coach
     *
     * @return void
     */
    public function test_user_is_not_coach_attribute()
    {
        $gender = Gender::factory()->create();
        $role = Role::factory()->create(['name' => 'usr']);

        $user = User::factory()
        ->for($role)
        ->for($gender)
        ->create();

        $this->assertFalse($user->isCoach);
    }

    /**
     * Test if user is role user
     *
     * @return void
     */
    public function test_user_is_user_attribute()
    {
        $gender = Gender::factory()->create();
        $role = Role::factory()->create(['name' => 'user']);

        $user = User::factory()
        ->for($role)
        ->for($gender)
        ->make();

        $this->assertTrue($user->isUser);
    }

    /**
     * Test if user is not role user
     *
     * @return void
     */
    public function test_user_is_not_user_attribute()
    {
        $role = Role::factory()->create(['name' => 'adm']);

        $user = User::factory()->for($role)->make();

        $this->assertFalse($user->isCoach);
    }

}
