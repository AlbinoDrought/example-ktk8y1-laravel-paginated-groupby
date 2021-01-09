<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Thing;
use App\Models\User;
use Illuminate\Database\Query\Builder;

class ActivityController extends Controller
{
    public function index()
    {
        /** @var User $user Let's assume this is the logged-in user */
        $user = User::query()
            ->whereHas('activities', null, '>', '1')
            ->orderBy('id')
            ->firstOrFail();

        return Activity::query()
            ->fromSub(function (Builder $query) use ($user) {
                $query
                    ->where('user_id', '=', $user->id)
                    ->where('subject_type', '=', Thing::class)
                    // I'm not 100% sure what this groupBy should accomplish - might need to be changed
                    ->groupBy('created_at')
                    ->from('activities');
            }, 'jazz')
            ->latest('created_at')
            ->latest('id')
            ->paginate();
    }
}
