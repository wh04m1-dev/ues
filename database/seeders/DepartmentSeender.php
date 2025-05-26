<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeender extends Seeder
{
    public function run(): void
    {
        $datadepartments = [
            [
                "name" => "Information Technology Engineering",
                "image" => "https://plus.unsplash.com/premium_photo-1664474619075-644dd191935f?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8aW1hZ2V8ZW58MHx8MHx8fDA%3D",
                "description" => "The Bachelor of Information Technology Engineering (ITE) program at the Faculty of Engineering, Royal University of Phnom Penh provides comprehensive, hands-on training in IT, combining theoretical and practical learning. It prepares students for careers in tech industries through coursework in computer software, networks, and advanced topics like AI and mobile development, along with mandatory practicums and internships to build real-world experience and skills."
            ],
            [
                "name" => "Data Science and Engineering",
                "image" => "https://example.com/data-science-image.jpg",
                "description" => "This program equips students with skills in data analysis, machine learning, and big data systems. It blends computer science, statistics, and domain knowledge to prepare students for careers in data-driven industries."
            ],
            [
                "name" => "Telecommunication and Electronic Engineering",
                "image" => "https://example.com/telecom-image.jpg",
                "description" => "The Telecommunication and Electronics Engineering program combines telecommunication and electronics technologies to educate students in designing communication systems and electronic devices. It prepares graduates with technical, research, leadership, and entrepreneurial skills for careers in various sectors such as telecom companies, media stations, transportation hubs, factories, and public or private institutions."
            ],
            [
                "name" => "Bio-Engineering",
                "image" => "https://example.com/bioeng-image.jpg",
                "description" => "The Bio-Engineering/Biotechnology program is designed to equip students with foundational knowledge in biological and chemical processes across various fields such as medicine, food, agriculture, and the environment, while also fostering skills in communication, teamwork, leadership, and entrepreneurship for successful careers in industry and research."
            ],
            [
                "name" => "Food Technology and Engineering",
                "image" => "https://example.com/foodtech-image.jpg",
                "description" => "This program focuses on food processing, safety, and technology innovations. Students learn to develop and manage food products and systems that meet safety and quality standards for both local and international markets."
            ],
            [
                "name" => "Automation & Supply Chain Systems Engineering",
                "image" => "https://example.com/automation-image.jpg",
                "description" => "The Automation and Supply Chain Systems Engineering (ASCSE) program, established in partnership with SIIT, Thammasat University, aims to prepare students for Industry 4.0 by providing education in automation, digital manufacturing, and supply chain optimization. Through a flexible 2+2 international bachelor's degree and industry collaboration, the program develops students’ technical and problem-solving skills to meet local and global workforce demands."
            ],
            [
                "name" => "Environmental Engineering",
                "image" => "https://example.com/environmental-image.jpg",
                "description" => "The Department of Environmental Engineering offers a high-quality bachelor's program, supported by KOICA and GIST, to equip motivated students—especially in developing countries like Cambodia—with the knowledge, skills, and technologies needed to effectively assess and manage environmental problems caused by human activities, and to strengthen local capacity for sustainable environmental conservation."
            ],
        ];

        foreach ($datadepartments as $data) {
            $department = new Department();
            $department->name = $data["name"];
            $department->image = $data["image"];
            $department->description = $data["description"];
            $department->save();
        }
    }
}
