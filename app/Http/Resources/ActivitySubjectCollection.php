<?php

namespace App\Http\Resources;

use App\Models\Activity;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

/**
 * Class ActivitySubjectCollection
 * @package App\Http\Resources
 * @property-read Activity[]|Collection $resource
 */
class ActivitySubjectCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $subjects = [];

        foreach ($this->resource as $activity) {
            $subjects[] = $this->when(
                $activity->relationLoaded('subject') && $activity->subject instanceof \App\Models\Thing,
                function () use ($activity) {
                    return new Thing($activity->subject);
                }
            );
        }

        return $subjects;
    }
}
