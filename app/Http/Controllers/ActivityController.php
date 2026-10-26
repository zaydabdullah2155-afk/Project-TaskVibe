<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::orderBy('remind_at')->get();

        return view('activities.index', compact('activities'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'remind_at' => 'required|date_format:H:i',
        ]);

        Activity::create($data);

        return redirect()->route('activities.index')
            ->with('success', 'Pengingat berhasil ditambahkan.');
    }

    public function toggle(Activity $activity)
    {
        $activity->update(['is_done' => ! $activity->is_done]);

        return redirect()->route('activities.index');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()->route('activities.index')
            ->with('success', 'Pengingat dihapus.');
    }
}