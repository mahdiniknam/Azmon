<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponseTrait;

class UserController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        $users = User::all();

        return $this->successResponse(UserResource::collection($users), 'Users retrieved successfully');
    }
}
