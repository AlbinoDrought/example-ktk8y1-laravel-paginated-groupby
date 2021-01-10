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

        // create some activities for today:
        Activity::factory()->count(2)->create([
            'created_at' => now()->startOfDay(),
            'user_id' => $user->id,
        ]);
        Activity::factory()->count(2)->create([
            'created_at' => now()->endOfDay(),
            'user_id' => $user->id,
        ]);

        // and some for yesterday:
        Activity::factory()->count(2)->create([
            'created_at' => now()->subDay()->startOfDay(),
            'user_id' => $user->id,
        ]);
        Activity::factory()->count(2)->create([
            'created_at' => now()->subDay()->endOfDay(),
            'user_id' => $user->id,
        ]);

        // and some records for random users
        Activity::factory()->count(30)->create();
    }
}
