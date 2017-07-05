<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        if ($this->command->confirm('Do you wish to refresh migration before seeding, it will clear all old data ?')) {
            $this->command->call('migrate:refresh');
            $this->command->line('Data cleared.');
        }

        $numberOfUsers = $this->command->ask('How many users you need?', 10);
        $users = factory(User::class, $numberOfUsers)->create();
        $this->command->info('Users created.');
    }
}
