<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        DB::connection('mongodb')->collection('users')->insert([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'nomor_hp' => '081234567890',
            'alamat' => 'Alamat Default',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down()
    {
        DB::connection('mongodb')->collection('users')->delete();
    }
};
