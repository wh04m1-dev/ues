<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeender extends Seeder
{
    public function run(): void
    {
        $datadepartments = [
            ["name" => "Information Technology Engineering"],
            ["name" => "Data Science and Engineering"],
            ["name" => "Telecommunication and Electronic Engineering"],
            ["name" => "Bio-Engineering"],
            ["name" => "Food Technology and Engineering"],
            ["name" => "Automation & Supply Chain Systems Engineering"],
            ["name" => "Environmental Engineering"],
        ];

        foreach ($datadepartments as $data) {
            $department = new Department();
            $department->name = $data["name"];
            $department->save();
        }
    }
}
