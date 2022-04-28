<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Our customer roles
     *
     * @var array|string[]
     */
    private array $roles = [
        'Admin',
        'Moderator',
        'Client'
    ];

    /**
     * @return void
     */
    public function run(): void
    {
        Role::whereNotIn('name', $this->roles)->delete();

        foreach ($this->roles as $role) {
            Role::firstOrCreate([
                'name' => $role
            ]);
        }
    }
}
