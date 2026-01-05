<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Update;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function store(Request $request, $campaignId)
    {
        $campaign = Campaign::findOrFail($campaignId);
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $update = Update::create([
            'campaign_id' => $campaignId,
            'content' => $validated['content'],
            'image' => $request->image
        ]);

        return response()->json(['message' => 'Update added', 'data' => $update], 201);
    }
}