<?php

namespace App\Http\Controllers;

use App\Models\BallotOption;
use Illuminate\Http\Request;

class BallotOptionController extends Controller
{
    /**
     * Display a listing of ballot options.
     */
    public function index()
    {
        return response()->json(BallotOption::with('election')->get());
    }

    /**
     * Store a newly created ballot option.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'election_id' => 'required|exists:elections,id',
            'candidate_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $option = BallotOption::create($validated);

        return response()->json($option, 201);
    }

    /**
     * Display the specified ballot option.
     */
    public function show(BallotOption $ballotOption)
    {
        return response()->json($ballotOption->load('election'));
    }

    /**
     * Update the specified ballot option.
     */
    public function update(Request $request, BallotOption $ballotOption)
    {
        $validated = $request->validate([
            'candidate_name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $ballotOption->update($validated);

        return response()->json($ballotOption);
    }

    /**
     * Remove the specified ballot option.
     */
    public function destroy(BallotOption $ballotOption)
    {
        $ballotOption->delete();

        return response()->json(['message' => 'Ballot option deleted successfully.']);
    }
}
