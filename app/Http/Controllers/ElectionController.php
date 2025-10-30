<?php

namespace App\Http\Controllers;

use App\Models\Election;
use Illuminate\Http\Request;

class ElectionController extends Controller
{
    // 🟢 List all elections
    public function index()
    {
        $elections = Election::latest()->get();
        return response()->json($elections);
    }

    // 🟢 Create a new election
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'status' => 'in:draft,open,closed'
    //     ]);

    //     $election = Election::create($request->all());
    //     return response()->json($election, 201);
    // }

    // 🟢 Show a single election
    public function show(Election $election)
    {
        return response()->json($election);
    }

    // 🟡 Update an election (e.g., change title or status)
    public function update(Request $request, Election $election)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:draft,open,closed'
        ]);

        $election->update($request->all());
        return response()->json($election);
    }

    // 🔴 Delete an election
    public function destroy(Election $election)
    {
        $election->delete();
        return response()->json(['message' => 'Election deleted']);
    }
    public function store(Request $request)
{
    $validated = $request->validate([
        'company_name' => 'required|string',
        'title' => 'required|string',
    ]);

    $election = Election::create([
        'company_name' => $validated['company_name'],
        'title' => $validated['title'],
        'status' => 'open',
    ]);

    // Auto-create YES, NO, ABSTAIN
    foreach (['YES', 'NO', 'ABSTAIN'] as $option) {
        \App\Models\BallotOption::create([
            'election_id' => $election->id,
            'label' => $option,
        ]);
    }

    return response()->json($election->load('ballotOptions'), 201);
}
// public function results($id)
// {
//     $election = \App\Models\Election::with('ballotOptions.votes')->findOrFail($id);

//     $results = $election->ballotOptions->map(function ($option) {
//         return [
//             'option' => $option->label,
//             'votes' => $option->votes->count(),
//         ];
//     });

//     return response()->json([
//         'election' => $election->title,
//         'company' => $election->company_name,
//         'status' => $election->status,
//         'results' => $results,
//         'total_votes' => $results->sum('votes'),
//     ]);
// }
public function results(Election $election)
{
    $results = $election->ballotOptions()
        ->withCount('votes')
        ->get()
        ->map(function ($option) {
            return [
                'label' => $option->label,
                'total' => $option->votes_count,
            ];
        });

    return response()->json([
        'title' => $election->title,
        'company_name' => $election->company_name,
        'results' => $results,
    ]);
}



}
