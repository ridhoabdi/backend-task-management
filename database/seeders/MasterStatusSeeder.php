<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MasterStatus;

class MasterStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['id_status' => 1, 'nama_status' => 'Pending'],
            ['id_status' => 2, 'nama_status' => 'Progress'], 
            ['id_status' => 3, 'nama_status' => 'Done']
        ];

        foreach ($statuses as $status) {
            MasterStatus::updateOrCreate(
                ['id_status' => $status['id_status']],
                $status
            );
        }
    }
}
