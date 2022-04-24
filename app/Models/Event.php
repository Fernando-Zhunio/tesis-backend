<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Overtrue\LaravelLike\Traits\Likeable;



class Event extends Model
{
    use Likeable, Favoriteable, HasFactory;
    protected $fillable = [
        'name', 'description', 'image', 'position', 'status', 'start_date', 'end_date',
    ];
    protected $appends = ['is_favorite'];


    public function users()
    {
        return $this->belongsTo(User::class, 'event_id', 'user_id', 'event_user');
    }

    protected function getIsFavoriteAttribute()
    {
        /** @var User $user */
        $user = auth()->user() ?? null;
        return $user ? $this->hasBeenFavoritedBy($user): null;
    }

    public $cast = [
        'position' => 'array',
    ];

    public function getPositionAttribute($details)
    {
        return json_decode($details, true);
    }

    public function toggleFavorite(Model $object)
    {
        return 'fernando';
       return $this->hasFavorited($object) ? $this->unfavorite($object) : $this->favorite($object);
    }

    public function scopeSearch($builder, $search)
    {
        if($search) {
            return $builder->where('name', 'like', "%$search%");
        }
        return $builder;
    }
}
