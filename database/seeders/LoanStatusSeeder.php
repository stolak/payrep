<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LoanStatus;

class LoanStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LoanStatus::insert([
            [
            'code'=> 0,
            'status'=> 'Pending'
            ],
            [
                'code'=> 1,
                'status'=> 'Approved'
            ],
            [
            'code'=> 2,
            'status'=> 'Active'
            ],
            [
                'code'=> 3,
                'status'=> 'Complete'
            ],
            
        ]);
    }
}
