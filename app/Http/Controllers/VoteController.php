<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function index()
    {
        return response()->json(Vote::with(['election', 'ballotOption'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'election_id' => 'required|exists:elections,id',
            'ballot_option_id' => 'required|exists:ballot_options,id',
            'voter_identifier' => 'required|unique:votes,voter_identifier',
        ]);

        $vote = Vote::create($validated);

        return response()->json([
            'message' => 'Vote submitted successfully!',
            'vote' => $vote
        ], 201);
    }
}
