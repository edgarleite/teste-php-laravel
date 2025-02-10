<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        /**
         * Inserção dos valores para o created_at e updated_at.
         * Removidas as múltiplas chamadas insert() separadas.
         * insertOrIgnore() previne duplicações sem necessidade de verificações extras.
         */
        DB::table('categories')->insertOrIgnore([
            ['name' => 'Remessa Parcial', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Remessa', 'created_at' => $now, 'updated_at' => $now]
        ]);
    }
}