<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    // use RefreshDatabase;

    public function test_models_can_be_instantiated() {
        $user = User::factory()->make();
        $this->assertTrue(true);
    }
}
