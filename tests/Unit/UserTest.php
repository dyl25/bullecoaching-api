<?php

namespace Tests\Unit;

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
    public function testUserIsCoachAttributeIsTrue()
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
    public function testUserIsCoachAttributeIsFalse()
    {
        $role = Role::factory()->create(['name' => 'usr']);

        $user = User::factory()->for($role)->make();

        $this->assertFalse($user->isCoach);
    }

    /**
     * Test if user is role user
     *
     * @return void
     */
    public function testUserIsUserAttributeIsTrue()
    {
        $role = Role::factory()->create(['name' => 'user']);

        $user = User::factory()->for($role)->make();

        $this->assertTrue($user->isUser);
    }

    /**
     * Test if user is not role user
     *
     * @return void
     */
    public function testUserIsUserAttributeIsFalse()
    {
        $role = Role::factory()->create(['name' => 'adm']);

        $user = User::factory()->for($role)->make();

        $this->assertFalse($user->isCoach);
    }

}
