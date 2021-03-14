<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProgramTest extends TestCase
{
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
     * User can view exercises contained in their 
     * private program
     *
     * @return void
     */
    public function test_user_can_view_exercises_from_their_private_program()
    { }

    /**
     * User can view exercises from a public program
     *
     * @return void
     */
    public function test_user_can_view_exercises_from_public_program()
    { }

    /**
     * User can not view exercises from a program 
     * in which they are not assigned
     *
     * @return void
     */
    public function test_user_can_not_view_exercises_from_program_that_are_not_assigned()
    { }
}
