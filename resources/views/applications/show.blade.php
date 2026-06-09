@extends('layouts.app')

@section('title', $application->company . ' — ' . $application->role)

@section('content')

<div class="max-w-3xl">

    {{-- Back + Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('applications.index') }}" class="text-gray-500 hover:text-white transition text-sm">← Back</a>
        <h1 class="text-lg font-semibold text-white">{{ $application->company }} — {{ $application->role }}</h1>
    </div>

    {{-- Details Card --}}
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 mb-6">
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm">
            <div>
                <div class="text-gray-500 text-xs uppercase tracking-wider mb-1">Status</div>
                @php
                    $colors = [
                        'applied'   => 'bg-blue-500/10 text-blue-300 border-blue-500/20',
                        'interview' => 'bg-yellow-500/10 text-yellow-300 border-yellow-500/20',
                        'offer'     => 'bg-green-500/10 text-green-300 border-green-500/20',
                        'rejected'  => 'bg-red-500/10 text-red-300 border-red-500/20',
                    ];
                @endphp
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $colors[$application->status] }}">
                    {{ \App\Models\Application::statusLabels()[$application->status] }}
                </span>
            </div>
            <div>
                <div class="text-gray-500 text-xs uppercase tracking-wider mb-1">Applied</div>
                <div class="text-white">{{ $application->applied_at->format('M j, Y') }}</div>
            </div>
            @if($application->interview_date)
            <div>
                <div class="text-gray-500 text-xs uppercase tracking-wider mb-1">Interview</div>
                <div class="text-yellow-300">{{ $application->interview_date->format('M j, Y') }}</div>
            </div>
            @endif
            @if($application->location)
            <div>
                <div class="text-gray-500 text-xs uppercase tracking-wider mb-1">Location</div>
                <div class="text-white">{{ $application->location }}</div>
            </div>
            @endif
            @if($application->contact_name)
            <div>
                <div class="text-gray-500 text-xs uppercase tracking-wider mb-1">Contact</div>
                <div class="text-white">{{ $application->contact_name }}</div>
            </div>
            @endif
            @if($application->needs_followup)
            <div>
                <div class="text-gray-500 text-xs uppercase tracking-wider mb-1">Follow Up</div>
                <div class="text-orange-400 font-medium">⚠ Needs follow up</div>
            </div>
            @endif
        </div>
        @if($application->notes)
        <div class="mt-4 pt-4 border-t border-gray-800">
            <div class="text-gray-500 text-xs uppercase tracking-wider mb-2">Notes</div>
            <div class="text-gray-300 text-sm">{{ $application->notes }}</div>
        </div>
        @endif
        <div class="mt-4 pt-4 border-t border-gray-800 flex gap-3">
            <a href="{{ route('applications.edit', $application) }}"
               class="bg-gray-800 hover:bg-gray-700 text-white text-sm px-4 py-2 rounded-lg transition">
                Edit
            </a>
            @if($application->url)
            <a href="{{ $application->url }}" target="_blank"
               class="bg-gray-800 hover:bg-gray-700 text-indigo-400 text-sm px-4 py-2 rounded-lg transition">
                View Posting
            </a>
            @endif
        </div>
    </div>

    {{-- Activity Log --}}
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 mb-6">
        <h2 class="text-sm font-semibold text-white mb-4">Activity Log</h2>

        @if($logs->isEmpty())
            <p class="text-gray-500 text-sm">No activity yet. Log your first update below.</p>
        @else
        <div class="space-y-3 mb-6">
            @foreach($logs as $log)
            <div class="flex gap-3 items-start">
                <div class="text-lg">{{ explode(' ', \App\Models\ActivityLog::typeLabels()[$log->type])[0] }}</div>
                <div class="flex-1">
                    <div class="text-gray-300 text-sm">{{ $log->body }}</div>
                    <div class="text-gray-600 text-xs mt-0.5">{{ $log->created_at->format('M j, Y g:i A') }}</div>
                </div>
                <form method="POST" action="{{ route('logs.destroy', $log) }}" onsubmit="return confirm('Delete this entry?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-gray-700 hover:text-red-400 text-xs transition">Delete</button>
                </form>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Add Log Entry --}}
        <form method="POST" action="{{ route('logs.store', $application) }}" class="border-t border-gray-800 pt-4">
            @csrf
            <div class="flex gap-3 mb-3">
                <select name="type" class="bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-indigo-500">
                    @foreach(\App\Models\ActivityLog::typeLabels() as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <textarea name="body" rows="2" required
                class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 resize-none mb-3"
                placeholder="What happened? e.g. Had first round interview with Sarah, went well..."></textarea>
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                Log Activity
            </button>
        </form>
    </div>

</div>

@endsection