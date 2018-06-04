<?php
/**
 * @apiDefine AuthHeader
 * @apiGroup general
 * @apiHeader {String} Content-Type application/json
 * @apiHeader {String} Authorization Auth header
 * @apiHeaderExample {String} Authorization Header Example:
 * Content-Type : application/json
 * Authorization: Bearer <jwt-token>
 */
/**
 * @apiDefine ContentTypeHeader
 * @apiGroup general
 * @apiHeader {String} Content-Type application/json
 * @apiHeaderExample {String} ContentType Header Example:
 * Content-Type: application/json
 */
/**
 * @apiDefine UnauthorizedError
 * @apiGroup general
 * @apiError (4xx Client Errors) unauthorized Invalid or missing Authorization
 * @apiError (4xx Client Errors) token_not_provided Token Not Provided
 * @apiError (4xx Client Errors) token_expired Access token expired
 * @apiErrorExample 401 Unauthorized Example:
 * HTTP/1.1 401 Unauthorized
 * {
 *     "error": {
 *            "code":"unauthenticated",
 *            "message":"Unauthenticated."
 *     }
 * }
 */


namespace Backoffice\Controllers;

use App\Exceptions\BadRequestException;
use App\Exceptions\ForbidenException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Backoffice\Requests\LoginForm;

class AuthController
{
    public function login(LoginForm $request)
    {
        $credentials = $request->only('username', 'password');
        $credentials['name'] = $credentials['username'];
        unset($credentials['username']);
        if(filter_var($credentials['name'], FILTER_VALIDATE_EMAIL)) {
            $credentials = ['email' => $credentials['name'], 'password' => $credentials['password']];
        }
        if ( ! $token = JWTAuth::attempt($credentials)) {
            throw new BadRequestException('invalid_credentials', 'Invalid Credentials.');
        }
        return response([
            'status' => 'success',
            'token'  => $token
        ])
        ->header('Authorization', $token);
    }

    /**
     * @api {post} /api/login Get access token
     * @apiGroup General
     * @apiName Get access token
     * @apiDescription Generate JWT access token in server for current user.
     * @apiVersion 0.9.9
     *
     * @apiParam {sting} username Username
     * @apiParam {string} password Password
     * @apiParamExample {json} Request-Example:
     *     {
     *       "username": "admin",
     *       "password": "admin"
     *     }
     *
     * @apiSuccessExample  {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "status":"success",
     *          "token":"<token-string>"
     *     }
     *
     * @apiError (4xx Client Errors) invalid_credentials Invalid Credentials.
     * @apiError (4xx Client Errors) access_forbidden Access Forbidden for this user.
     * @apiErrorExample 400 Bad Request Example:
     * HTTP/1.1 400 Bad Request
     * {
     *     "error":
     *     {
     *        "code":"invalid_credentials",
     *        "message":"Invalid Credentials"
     *     }
     * }
     * @apiErrorExample 403 Access Forbidden Example:
     * HTTP/1.1 403 Forbidden
     * {
     *     "error":
     *     {
     *        "code":"access_forbidden",
     *        "message":"Access Forbidden for this user"
     *     }
     * }
     * @apiUse ContentTypeHeader
     * @apiSampleRequest off
     * @apiPermission none
     */
    public function apiLogin(LoginForm $request)
    {
        $credentials = $request->only('username', 'password');
        $credentials['name'] = $credentials['username'];
        unset($credentials['username']);

        if ( ! $token = JWTAuth::attempt($credentials)) {
            throw new BadRequestException('invalid_credentials', 'Invalid Credentials.');
        }

        if (!Auth::user()->allow_api_login) {
            throw new ForbidenException('access_forbidden', 'Access Forbidden for this user');
        }

        return response([
            'status' => 'success',
            'token'  => $token
        ])
            ->header('Authorization', $token);
    }

    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function refresh()
    {
        return response([
            'status' => 'success'
        ]);
    }

    public function logout()
    {
        JWTAuth::invalidate();
        return response([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }
}
