<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Traits\Favoriteable;

class Event extends Model
{
    use Favoriteable, HasFactory;
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
        // return $this->favoriters->contains(auth()->user());
        return $this->hasBeenFavoritedBy(auth()->user());
    }

    public $cast = [
        'position' => 'array',
    ];

    public function getPositionAttribute($details)
    {
        return json_decode($details, true);
    }
}
