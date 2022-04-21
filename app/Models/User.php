<?php

namespace App\Models;

use App\Traits\Search;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Overtrue\LaravelFavorite\Traits\Favoriter;
use Overtrue\LaravelLike\Traits\Liker;

class User extends Authenticatable
{

    use  Liker, Search, Favoriter, HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'birthday',
        'is_student',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_student' => 'boolean'
    ];

    public function toggleFavorite(Model $object)
    {
        $isFavorite = $this->hasFavorited($object);
        $isFavorite ? $this->unfavorite($object) : $this->favorite($object);
        return !$isFavorite;
    }
}
