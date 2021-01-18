<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category1 = DB::table('category1')->count();
        $category2 = DB::table('category2')->count();
        if ($category1 == 0 && $category2 == 0) {
            $categorys = config('default.category1');
            DB::transaction(function () use ($categorys) {
                foreach($categorys as $category) {
                    $category1Id = DB::table('category1')->insertGetId([
                        'name'       => $category['name'],
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                        'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    ]);
                    foreach($category['category2'] as $value) {
                        DB::table('category2')->insertGetId([
                            'category1_id' => $category1Id,
                            'uuid'         => (string) Str::uuid(),
                            'name'         => $value,
                            'created_at'   => \Carbon\Carbon::now()->toDateTimeString(),
                            'updated_at'   => \Carbon\Carbon::now()->toDateTimeString(),
                        ]);
                    }
                }
            });
        }
    }
}
