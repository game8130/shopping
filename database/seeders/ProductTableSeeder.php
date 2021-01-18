<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category2 = DB::table('category2')->get();
        $product = DB::table('product')->count();
        if ($category2 !== null && $product == 0) {
            DB::transaction(function () use ($category2) {
                foreach ($category2 as $value) {
                    DB::table('product')->insert([
                        'uuid'            => (string) Str::uuid(),
                        'category1_id'    => $value->category1_id,
                        'category2_id'    => $value->id,
                        'name'            => 'Tempo三層盒裝面紙-櫻花(86抽x5盒/串)',
                        'description'     => '*櫻花般柔韌觸感，濕水後柔韌依舊*精緻羽毛壓花，不易鬆散、不掉屑*不添加螢光劑，純淨安心',
                        'suggested_price' => '299',
                        'price'           => '187',
                        'residual'        => 1000,
                        'created_at'      => \Carbon\Carbon::now()->toDateTimeString(),
                        'updated_at'      => \Carbon\Carbon::now()->toDateTimeString(),
                    ]);
                }

            });
        }
    }
}
