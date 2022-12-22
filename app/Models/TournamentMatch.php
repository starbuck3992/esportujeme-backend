<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentMatch extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function userHome()
    {
        return $this->belongsTo(User::class, 'user_home', 'id');
    }

    public function userGuest()
    {
        return $this->belongsTo(User::class, 'user_guest', 'id');
    }

    public function screenshotHome()
    {
        return $this->belongsTo(Image::class, 'screenshot_home', 'id');
    }

    public function screenshotGuest()
    {
        return $this->belongsTo(Image::class, 'screenshot_guest', 'id');
    }
}
