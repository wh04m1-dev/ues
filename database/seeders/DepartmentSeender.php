<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeender extends Seeder
{
    public function run(): void
    {
        $datadepartments = [
            ["name" => "Information Technology Engineering", "image" => "https://plus.unsplash.com/premium_photo-1664474619075-644dd191935f?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8aW1hZ2V8ZW58MHx8MHx8fDA%3D"],
            ["name" => "Data Science and Engineering", "image" => "https://example.com/data-science-image.jpg"],
            ["name" => "Telecommunication and Electronic Engineering", "image" => "https://example.com/telecom-image.jpg"],
            ["name" => "Bio-Engineering", "image" => "https://example.com/bioeng-image.jpg"],
            ["name" => "Food Technology and Engineering", "image" => "https://example.com/foodtech-image.jpg"],
            ["name" => "Automation & Supply Chain Systems Engineering", "image" => "https://example.com/automation-image.jpg"],
            ["name" => "Environmental Engineering", "image" => "https://example.com/environmental-image.jpg"],
        ];

        foreach ($datadepartments as $data) {
            $department = new Department();
            $department->name = $data["name"];
            $department->image = $data["image"];
            $department->save();
        }
    }
}
