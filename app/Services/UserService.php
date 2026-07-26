<?php

namespace App\Services;

use App\Exceptions\BusinessException;
use App\Filters\UserFilter;
use App\Models\Otp;
use App\Models\User;
use App\Services\BlocklistService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserService
{
    public function store(array $data)
    {
        return User::create([
            'name' => $data['name'],

            'email' => $data['email'],
            'password' => $data['password'],
            'phone' => $data['phone'],

            'is_active' => $data['is_active'],
            'role' => $data['role'],
        ]);
    }
    public function update(array $data, User $user)
    {

        if (!empty($data['password'])) {
            $user->update(['password' => $data['password']]);
        }
        return $user->update([
            'name' => $data['name'],
        
            'email' => $data['email'],
            'phone' => $data['phone'],

            'is_active' => $data['is_active'],
          
           
        ]);
    }
    public function index()
    {
        return User::filters(new UserFilter())
            ->latest()
            ->paginate(10);
    }


    public function destroy(User $user) {}
}
