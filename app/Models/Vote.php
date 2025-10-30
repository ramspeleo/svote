<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'election_id',
        'ballot_option_id',
        'voter_identifier',
    ];

    public function election()
    {
        return $this->belongsTo(Election::class);
    }

    public function ballotOption()
    {
        return $this->belongsTo(BallotOption::class);
    }
}
