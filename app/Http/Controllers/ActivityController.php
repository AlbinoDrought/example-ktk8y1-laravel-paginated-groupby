<?php

namespace App\Http\Controllers;

use App\Http\Resources\InMemoryGroupedActivityCollection;
use App\Models\Activity;
use App\Models\Thing;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $user Let's assume this is the logged-in user */
        $user = User::query()
            ->whereHas('activities', null, '>', '1')
            ->orderBy('id')
            ->firstOrFail();

        $mode = $request->get('mode', 'collection-group');

        switch ($mode) {
            case 'grouped':
                return $this->modeGrouped($user);
            case 'collection-group':
                return $this->modeActivitiesToSubjects($user);
            case 'collection-group-ignore-dupes':
                return $this->modeActivitiesToSubjectsIgnoreDupes($user);
            default:
                throw new \RuntimeException('Unknown mode ' . $mode);
        }
    }

    private function modeGrouped(User $user)
    {
        return Activity::query()
            ->with('subject')
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

    private function modeActivitiesToSubjects(User $user)
    {
        return new InMemoryGroupedActivityCollection(
            Activity::query()
                ->with(['subject', 'subject.user'])
                ->where('user_id', '=', $user->id)
                ->where('subject_type', '=', Thing::class)
                ->latest('created_at')
                ->latest('id')
                ->paginate()
        );
    }

    private function modeActivitiesToSubjectsIgnoreDupes(User $user)
    {
        return new InMemoryGroupedActivityCollection(
            Activity::query()
                ->with(['subject', 'subject.user'])
                ->fromSub(function (Builder $query) use ($user) {
                    $query
                        ->select([DB::raw('DATE(created_at) AS created_at'), 'user_id', 'subject_id', 'subject_type'])
                        ->where('user_id', '=', $user->id)
                        ->where('subject_type', '=', Thing::class)
                        ->distinct()
                        ->from('activities');
                }, 'jazz')
                ->paginate()
        );
    }
}
