<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExerciseTest extends TestCase
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
     * Coach can only view exercises they have created
     *
     * @return void
     */
    public function test_coach_can_view_their_exercises() {
    
    }

    /**
     * Coach can not view exercises from other coach
     * @return void
     */
    public function test_coach_can_not_view_exercises_from_other() {
    
    }

}
