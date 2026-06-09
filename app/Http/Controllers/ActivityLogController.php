<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function store(Request $request, Application $application)
    {
        $validated = $request->validate([
            'type' => 'required|in:note,interview,email,offer,rejected',
            'body' => 'required|string|max:2000',
        ]);

        $validated['application_id'] = $application->id;
        $validated['user_id'] = Auth::id();

        ActivityLog::create($validated);

        return redirect()->route('applications.show', $application)
            ->with('success', 'Activity logged.');
    }

    public function destroy(ActivityLog $activityLog)
    {
        abort_if($activityLog->user_id !== Auth::id(), 403);
        $activityLog->delete();

        return back()->with('success', 'Entry deleted.');
    }
}