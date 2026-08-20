<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): JsonResponse
    {
        $users = $this->userService->getAll();

        return response()->json([
            'message' => 'Users retrieved successfully.',
            'users' => UserResource::collection($users),
        ]);
    }

    public function show(User $user): JsonResponse
    {
        $user = $this->userService->getById($user->id);

        return response()->json([
            'message' => 'User retrieved successfully.',
            'user' => new UserResource($user),
        ]);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->create(
                $request->validated()
            );

            $user->load('role');

            return response()->json([
                'message' => 'User created successfully.',
                'user' => new UserResource($user),
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function update(
        UpdateUserRequest $request,
        User $user
    ): JsonResponse {
        try {
            $user = $this->userService->update(
                $user,
                $request->validated()
            );

            $user->load('role');

            return response()->json([
                'message' => 'User updated successfully.',
                'user' => new UserResource($user),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function destroy(User $user): JsonResponse
    {
        try {
            $this->userService->delete($user);

            return response()->json([
                'message' => 'User deleted successfully.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}