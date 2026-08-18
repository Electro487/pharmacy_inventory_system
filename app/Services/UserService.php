<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService {
    public function getAll()
    {
        return User::with('role')
            ->latest()
            ->paginate(10);
    }

    public function getById(int $id): User
    {
        return User::with('role')->findOrFail($id);
    }

    public function create(array $data): User 
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function update(User $user, array $data): User 
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $user->update($data);
        return $user;
    }

    public function delete(User $user): void
    {
        $user->delete();
    }
}
