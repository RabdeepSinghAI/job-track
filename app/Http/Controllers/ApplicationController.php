<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = Application::forUser(Auth::id())->latest('applied_at');

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('company', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
            });
        }

        $applications = $query->paginate(10)->withQueryString();

        $stats = [
            'total'     => Application::forUser(Auth::id())->count(),
            'applied'   => Application::forUser(Auth::id())->byStatus('applied')->count(),
            'interview' => Application::forUser(Auth::id())->byStatus('interview')->count(),
            'offer'     => Application::forUser(Auth::id())->byStatus('offer')->count(),
            'rejected'  => Application::forUser(Auth::id())->byStatus('rejected')->count(),
        ];

        return view('applications.index', compact('applications', 'stats'));
    }

    public function create()
    {
        return view('applications.create');
    }

    public function show(Application $application)
    {
        $this->authorize('view', $application);
        $logs = $application->activityLogs()->get();
        return view('applications.show', compact('application', 'logs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company'        => 'required|string|max:255',
            'role'           => 'required|string|max:255',
            'location'       => 'nullable|string|max:255',
            'url'            => 'nullable|url|max:500',
            'contact_name'   => 'nullable|string|max:255',
            'status'         => 'required|in:applied,interview,offer,rejected',
            'applied_at'     => 'required|date',
            'interview_date' => 'nullable|date',
            'notes'          => 'nullable|string|max:2000',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['needs_followup'] = $request->boolean('needs_followup');

        Application::create($validated);

        return redirect()->route('applications.index')
            ->with('success', 'Application added.');
    }

    public function edit(Application $application)
    {
        $this->authorize('update', $application);
        return view('applications.edit', compact('application'));
    }

    public function update(Request $request, Application $application)
    {
        $this->authorize('update', $application);

        $validated = $request->validate([
            'company'        => 'required|string|max:255',
            'role'           => 'required|string|max:255',
            'location'       => 'nullable|string|max:255',
            'url'            => 'nullable|url|max:500',
            'contact_name'   => 'nullable|string|max:255',
            'status'         => 'required|in:applied,interview,offer,rejected',
            'applied_at'     => 'required|date',
            'interview_date' => 'nullable|date',
            'notes'          => 'nullable|string|max:2000',
        ]);

        $validated['needs_followup'] = $request->boolean('needs_followup');

        $application->update($validated);

        return redirect()->route('applications.index')
            ->with('success', 'Application updated.');
    }

    public function destroy(Application $application)
    {
        $this->authorize('delete', $application);
        $application->delete();

        return redirect()->route('applications.index')
            ->with('success', 'Application deleted.');
    }
}