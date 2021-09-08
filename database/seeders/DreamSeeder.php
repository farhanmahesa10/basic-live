<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dream;
class DreamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Dream::create([
            'dream' => 'Bikin Logo',
            'user_id' => 1
        ]);
        Dream::create([
            'dream' => 'Bikin Laporan',
            'user_id' => 1
        ]);
        Dream::create([
            'dream' => 'Bikin Feature',
            'user_id' => 1
        ]);
    }
}