<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Gemboot\Services\CoreService as GembootService;
use Carbon\Carbon;

use Spatie\Permission\Models\Role;
use App\Models\User;

class AuthService extends GembootService {

    public function __construct(User $model = null, $with = [], $orderBy = [])
    {
        if (empty($model)) {
            $model = new User();
        }
        parent::__construct($model, $with, $orderBy);
    }


    /**
     * Get a JWT via given credentials.
     *
     * @bodyParam npp string required
     * @bodyParam password string required
     * @response {
     *  "access_token": "token",
     *  "token_type": "Bearer",
     *  "expires_in": 60,
     * }
     * @return \Illuminate\Http\JsonResponse
     */
    public function login($email, $password, $request = null)
    {
        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        if (! $token = auth()->attempt($credentials)) {
            throw new \GembootBadRequestException("Email and password did not match!");
        }

        $user = get_user_login(true);

        return $this->respondWithToken($token, [
            'user' => $user,
            // 'roles' => $user->getRoleNames(),
            // 'permissions' => $user->getPermissionNames(),
        ]);
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
    public function me($request = null)
    {
        if(empty($request)) {
            $request = request();
        }

        $user = get_user_login(true);

        return [
            'user' => $user,
            // 'roles' => $user->getRoleNames(),
            // 'permissions' => $user->getPermissionNames(),
            // 'ip' => request()->ip(),
            // 'ip' => "",
            // 'client_ip' => request()->getClientIp(),
            // 'user_ip' => get_user_ip_addr(),
            // 'x_forwarded_for_ip' => request()->header('X-Forwarded-For'),
        ];
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
    public function logout($request = null)
    {
        auth()->logout();
        return ['message' => 'Successfully logged out'];
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
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Validate Token.
     *
     * @authenticated
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateToken()
    {
        return [
            "token_status" => true,
        ];
    }

    /**
     * Update Profile.
     *
     * @authenticated
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile($request = null)
    {
        if(empty($request)) {
            $request = request();
        }

        $user = auth()->user();
        // $user->nama = $request->nama;
        if ($request->has('password')) {
            $user->password = $request->password;
        }
        $user->save();

        return [
            // 'saved' => $user->load('rl_pegawai'),
            'saved' => get_user_login(true),
        ];
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, array $additional_data = [])
    {
        $response = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];

        return array_merge($response, $additional_data);
    }

}
