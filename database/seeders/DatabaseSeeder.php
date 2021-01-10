<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Thing;
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

        // create some random activities for today:
        Activity::factory()->count(2)->create([
            'created_at' => now()->startOfDay(),
            'user_id' => $user->id,
        ]);
        Activity::factory()->count(2)->create([
            'created_at' => now()->endOfDay(),
            'user_id' => $user->id,
        ]);

        // a random thing that the user generated a lot of activity for:
        $thing = Thing::factory()->create([
            'title' => 'Busy Thing',
        ]);
        Activity::factory()->count(10)->create([
            'user_id' => $user->id,
            'subject_id' => $thing->id,
            'subject_type' => get_class($thing),
        ]);

        // and some random activities for yesterday:
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
