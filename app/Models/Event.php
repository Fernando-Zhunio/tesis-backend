<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'description', 'image', 'position', 'status', 'start_date', 'end_date',
    ];

    public function users()
    {
        return $this->belongsTo(User::class,'event_id', 'user_id','event_user');
    }

    public $cast = [
        'position' => 'json',
    ];

    // public function event_user()
    // {
    //     return $this->hasMany(EventUser::class);
    // }


}
