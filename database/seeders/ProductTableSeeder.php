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
        $category3 = DB::table('category3')->get();
        $product = DB::table('product')->count();
        if ($category3 !== null && $product == 0) {
            DB::transaction(function () use ($category3) {
                foreach ($category3 as $value) {
                    DB::table('product')->insert([
                        'uuid'            => (string) Str::uuid(),
                        'category3_id'    => $value->id,
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
