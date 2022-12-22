<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function tournamentType()
    {
        return $this->belongsTo(TournamentType::class);
    }

    public function tournamentStatus()
    {
        return $this->belongsTo(TournamentStatus::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function tournamentMatches()
    {
        return $this->hasMany(TournamentMatch::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
