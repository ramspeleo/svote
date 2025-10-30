<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'company_name',
        'status',
        'start_at',
        'end_at',
    ];

    // Automatically include ballot options when loading elections
    protected $with = ['ballotOptions'];

    public function ballotOptions()
    {
        return $this->hasMany(\App\Models\BallotOption::class, 'election_id');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'election_id');
    }
}
