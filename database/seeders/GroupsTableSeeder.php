<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminGroupName = config('default.adminGroupName');
        $generalGroupName = config('default.generalGroupName');
        $group = DB::table('groups')->where('name', $adminGroupName)->first();
        if ($group == null) {
            DB::transaction(function () use ($adminGroupName, $generalGroupName) {
                $this->insert($adminGroupName);
                $this->insert($generalGroupName);
            });
        }
    }

    /**
     * @param $name
     */
    public function insert($name)
    {
        DB::table('groups')->insertGetId([
            'name'       => $name,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
    }
}
