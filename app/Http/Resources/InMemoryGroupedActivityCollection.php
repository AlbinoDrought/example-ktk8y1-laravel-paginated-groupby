<?php

namespace App\Http\Resources;

use App\Models\Activity;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

/**
 * Class InMemoryGroupedActivityCollection
 * @package App\Http\Resources
 * @property-read Activity[]|Collection $resource
 */
class InMemoryGroupedActivityCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->groupBy(function (Activity $activity) {
            return $activity->created_at->toDateString();
        })->map(function ($activities) {
            /** @var Activity[]|Collection $activities */
            return [
                'date' => $activities[0]->created_at->format('l'),
                'created_at' => $activities[0]->created_at->format('M d Y'),
                'records' => collect($activities)->map(function (Activity $activity) {
                    return $this->when(
                        $activity->relationLoaded('subject') && $activity->subject instanceof \App\Models\Thing,
                        function () use ($activity) {
                            return new Thing($activity->subject);
                        }
                    );
                })
            ];
        })->values();
    }
}
