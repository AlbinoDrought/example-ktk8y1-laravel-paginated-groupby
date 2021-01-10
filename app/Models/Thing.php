<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Thing
 * @package App\Models
 * @property int $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $title
 * @property int $user_id
 * @property-read User $user
 * @property-read Activity[]|Collection $activities
 */
class Thing extends Model
{
    use HasFactory;

    public function activities()
    {
        return $this->morphToMany(
            Activity::class,
            'subject'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
