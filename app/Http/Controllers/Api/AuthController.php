<?php
namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Gemboot\Controllers\CoreRestController as GembootController;
use Carbon\Carbon;

use Spatie\Permission\Models\Role;
use App\Services\AuthService;
use App\Models\User;

/**
 * @group Authentication
 *
 * APIs for authentication
 */
class AuthController extends GembootController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(User $model, AuthService $service)
    {
        parent::__construct($model, $service);
        $this->middleware('auth:api', [
            'except' => [
                'register',
                'login'
            ]
        ]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @bodyParam email string required
     * @bodyParam password string required
     * @response {
     *  "access_token": "token",
     *  "token_type": "Bearer",
     *  "expires_in": 60,
     * }
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseBadRequest(['error'=>$validator->errors()]);
        }

        $credentials = request(['email', 'password']);

        return $this->responseSuccessOrException(function() use ($credentials, $request) {
            return $this->service->login($credentials['email'], $credentials['password'], $request);
        });
    }

    /**
     * Get the authenticated User.
     *
     * @authenticated
     * @response {
     *  "name": "User Name",
     *  "npp": "User Username",
     * }
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->responseSuccessOrException(function() {
            return $this->service->me();
        });
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @authenticated
     * @response {
     *  "message": "Successfully logged out",
     * }
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        return $this->responseSuccessOrException(function() {
            return $this->service->logout();
        });
    }

    /**
     * Refresh a token.
     *
     * @authenticated
     * @response {
     *  "access_token": "token",
     *  "token_type": "Bearer",
     *  "expires_in": 60,
     * }
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->responseSuccessOrException(function() {
            return $this->service->refresh();
        });
    }

    /**
     * Validate Token.
     *
     * @authenticated
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateToken(Request $request)
    {
        return $this->responseSuccessOrException(function() {
            return $this->service->validateToken();
        });
    }

    /**
     * Update Profile.
     *
     * @authenticated
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            // 'name'      => 'required|string|max:20',
            'password'  => 'sometimes|required|confirmed|string|min:6|max:20',
        ]);

        if ($validator->fails()) {
            return $this->responseBadRequest(['error' => $validator->errors()]);
        }

        return $this->responseSuccessOrException(function() use ($request) {
            return $this->service->updateProfile($request);
        });
    }

}
