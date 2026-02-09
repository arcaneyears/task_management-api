<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected UserService $userService) {}

    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', \App\Models\User::class);
        $users = $this->userService->getAllUsers($request->all());
        return response()->json(UserResource::collection($users)->response()->getData());
    }

    public function show(int $id): JsonResponse
    {
        $user = $this->userService->getUserById($id);
        $this->authorize('view', $user);
        return response()->json(['data' => new UserResource($user->load('role'))]);
    }

    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $user = $this->userService->getUserById($id);
        $this->authorize('update', $user);
        $this->userService->updateUser($id, $request->validated());
        return response()->json(['message' => 'User updated successfully']);
    }
}
