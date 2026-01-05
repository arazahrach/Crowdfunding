<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::where('is_active', true)->get();
        return response()->json(['data' => $campaigns]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'target_amount' => 'required|numeric|min:1000',
            'end_date' => 'required|date|after:today',
        ]);

        $campaign = Campaign::create($validated);
        return response()->json(['message' => 'Campaign created', 'data' => $campaign], 201);
    }

    public function show($id)
    {
        $campaign = Campaign::with(['donations', 'updates'])->findOrFail($id);
        $campaign->progress = $campaign->target_amount > 0
            ? min(100, round(($campaign->collected_amount / $campaign->target_amount) * 100))
            : 0;
        return response()->json(['data' => $campaign]);
    }

    public function update(Request $request, $id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->update($request->only(['title', 'description', 'target_amount', 'end_date']));
        return response()->json(['message' => 'Updated', 'data' => $campaign]);
    }

    public function destroy($id)
        {
            $campaign = Campaign::findOrFail($id);
            $campaign->is_active = false;
            $campaign->save();
            return response()->json(['message' => 'Campaign closed']);
        }

        
    public function category()
        {
            return $this->belongsTo(\App\Models\Category::class, 'category_id');
        }

    public function donations()
        {
            return $this->hasMany(\App\Models\Donation::class, 'campaign_id');
        }

}