<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use Spatie\Permission\Models\Role;
use App\Models\User;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test middleware auth:api.
     *
     * @dataProvider unauthorizedDataProvider
     * @return void
     */
    public function test_middleware_unauthorized($method, $path) {
        if($method == 'get') {
            $response = $this->get($path);
        } else {
            $response = $this->post($path);
        }
        ob_get_clean();
        $response->assertUnauthorized();
    }

    /**
     * Login test.
     *
     * @return void
     */
    public function test_post_login() {
        $pass = '1234567890';
        $user = User::factory()->create([
            'email' => 'anggerpputro@gmail.com',
            'password' => $pass,
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => $pass,
        ]);
        ob_get_clean();

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('status')->has('message')->has('data')
                    ->has('data.access_token')
                    ->has('data.token_type')
                    ->has('data.expires_in')
                    ->has('data.user')
            );
    }

    /**
     * Get me test.
     *
     * @return void
     */
    public function test_get_me() {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->getJson('/api/auth/me');
        ob_get_clean();

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('status')->has('message')->has('data')
                    ->has('data.user')
            );
    }

    /**
     * Validate token test.
     *
     * @return void
     */
    public function test_validate_token() {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->getJson('/api/auth/validate-token');
        ob_get_clean();

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('status')->has('message')->has('data')
            );
    }


    public function unauthorizedDataProvider() {
        return [
            'get-me'                => ['get', '/api/auth/me'],
            'refresh-token'         => ['get', '/api/auth/refresh-token'],
            'validate-token'        => ['get', '/api/auth/validate-token'],
            'update-profile'        => ['post', '/api/auth/update-profile'],
            'logout'                => ['post', '/api/auth/logout'],
        ];
    }
}
