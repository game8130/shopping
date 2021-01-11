<?php

use Illuminate\Database\Seeder;

class LevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $levels = config('default.levels');
        $db_level = DB::table('levels')->count();
        if ($db_level == 0) {
            foreach ($levels as $value) {
                DB::transaction(function () use ($value) {
                    DB::table('levels')->insertGetId([
                        'name'       => $value['name'],
                        'amount'     => $value['amount'],
                        'amount_max' => $value['amount_max'],
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                        'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    ]);
                });
            }
        }
    }
}
