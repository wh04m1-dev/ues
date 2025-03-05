<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeender extends Seeder
{
    public function run(): void
    {
        $dataroles = [
            ["name" => "admin"],
            ["name" => "student"],
        ];

        foreach ($dataroles as $data) {
            $role = new Role();
            $role->name = $data["name"];
            $role->save();
        }
    }
}
