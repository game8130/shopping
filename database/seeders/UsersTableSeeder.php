<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $level = DB::table('levels')->where('name', config('default.levels')[0]['name'])->first();
        $user = DB::table('users')->where('account', config('default.adminAccount'))->first();
        if ($level !== null && $user === null) {
            DB::transaction(function () use ($level) {
                DB::table('users')->insert([
                'level_id'        => $level->id,
                'uuid'            => (string) Str::uuid(),
                'account'         => config('default.adminAccount'),
                'email'           => config('default.adminEmail'),
                'password'        => Hash::make(config('default.adminPassword')),
                'name'            => config('default.adminName'),
                'active'          => 1,
                'token'           => '',
                'phone'           => '0912345678',
                'login_at'        => null,
                'created_at'      => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at'      => \Carbon\Carbon::now()->toDateTimeString(),
                ]);
            });
        }
    }
}
