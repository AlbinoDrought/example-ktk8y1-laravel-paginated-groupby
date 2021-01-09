<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // create 100 activity records for one user:
        /** @var User|null $user */
        $user = User::query()
            ->whereHas('activities', null, '>', '1')
            ->orderBy('id')
            ->first();
        if ($user === null) {
            $user = User::factory()->create();
        }

        Activity::factory()->count(100)->create([
            'user_id' => $user->id,
        ]);
        // and 100 activity records for 100 random users:
        Activity::factory()->count(100)->create();
    }
}
