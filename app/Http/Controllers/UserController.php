<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Resources\UserResource;
use App\Services\ApiResponse;
use App\Services\User\CreateUserService;
use App\Services\User\DeleteUserService;
use App\Services\User\ReadUserService;
use App\Services\User\UpdateUserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $response = new ApiResponse();
        try {
            $response->data = UserResource::collection((new ReadUserService())($request->all()));
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());
            $response->loadTemplate(ApiResponse::$ERROR, $exception->getMessage());
        }
        return $response->httpResponse();
    }

    /**
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        $response = new ApiResponse();
        try {
            $response->data = (new UserResource($user));
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());
            $response->loadTemplate(ApiResponse::$ERROR, $exception->getMessage());
        }
        return $response->httpResponse();
    }

    /**
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request): Response
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);
        $response = new ApiResponse();
        try {
            $response->data = new UserResource((new CreateUserService())($request->all()));
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());
            $response->loadTemplate(ApiResponse::$ERROR, $exception->getMessage());
        }
        return $response->httpResponse();
    }

    /**
     * @param Request $request
     * @param User $user
     * @return Response
     * @throws ValidationException
     */
    public function update(Request $request, User $user): Response
    {
        $this->validate($request, [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
        ]);
        $response = new ApiResponse();
        try {
            $response->data = new UserResource((new UpdateUserService())($request->all(), $user));
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());
            $response->loadTemplate(ApiResponse::$ERROR, $exception->getMessage());
        }
        return $response->httpResponse();
    }

    /**
     * @param User $user
     * @return Response
     */
    public function destroy(User $user): Response
    {
        $response = new ApiResponse();
        try {
            $response->data = new UserResource((new DeleteUserService())($user));
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());
            $response->loadTemplate(ApiResponse::$ERROR, $exception->getMessage());
        }
        return $response->httpResponse();
    }
}
