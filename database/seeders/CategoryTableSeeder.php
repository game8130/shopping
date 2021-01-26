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
                $now = \Carbon\Carbon::now()->toDateTimeString();
                foreach($categorys as $category) {
                    $category1Id = DB::table('category1')->insertGetId([
                        'category1_name' => $category['name'],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                    
                    foreach($category['category2'] as $key => $value) {
                        $category2NameId = DB::table('category2_name')->select('id')
                            ->where('category2_name' , $key)->first();
                        if(empty($category2NameId)) {
                            $category2NameId = DB::table('category2_name')->insertGetId([
                                'category2_name' => $key,
                                'created_at' => $now,
                                'updated_at' => $now,
                            ]);
                        } else {
                            $category2NameId = $category2NameId->id;
                        }
                        $category2Id = DB::table('category2')->insertGetId([
                            'category1_id' => $category1Id,
                            'category2_name_id' => $category2NameId,
                            'created_at'   => $now,
                            'updated_at'   => $now,
                        ]);

                        foreach($value as $v) {
                            $category3NameId = DB::table('category3_name')->select('id')
                                ->where('category3_name', $v)->first();
                            if(empty($category3NameId)) {
                                $category3NameId = DB::table('category3_name')->insertGetId([
                                    'category3_name' => $v,
                                    'created_at' => $now,
                                    'updated_at' => $now,
                                ]);
                            } else {
                                $category3NameId = $category3NameId->id;
                            }
                            DB::table('category3')->insertGetId([
                                'category2_id'      => $category2Id,
                                'category3_name_id' => $category3NameId,
                                'uuid'              => (string) Str::uuid(),
                                'created_at'        => $now,
                                'updated_at'        => $now,
                            ]);
                        }
                    }
                }
            });
        }
    }
}
