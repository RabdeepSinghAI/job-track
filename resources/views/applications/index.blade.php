@extends('layouts.app')

@section('title', 'My Applications')

@section('content')

{{-- Stats --}}
<div class="grid grid-cols-2 sm:grid-cols-5 gap-3 mb-8">
    @foreach([
        ['label' => 'Total',     'key' => 'total',     'color' => 'gray'],
        ['label' => 'Applied',   'key' => 'applied',   'color' => 'blue'],
        ['label' => 'Interview', 'key' => 'interview', 'color' => 'yellow'],
        ['label' => 'Offer',     'key' => 'offer',     'color' => 'green'],
        ['label' => 'Rejected',  'key' => 'rejected',  'color' => 'red'],
    ] as $stat)
    <div class="bg-gray-900 border border-gray-800 rounded-xl px-4 py-4 text-center">
        <div class="text-2xl font-bold text-white">{{ $stats[$stat['key']] }}</div>
        <div class="text-xs text-gray-400 mt-1">{{ $stat['label'] }}</div>
    </div>
    @endforeach
</div>

{{-- Header + Add button --}}
<div class="flex items-center justify-between mb-4">
    <h1 class="text-lg font-semibold text-white">Applications</h1>
    <a href="{{ route('applications.create') }}"
       class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
        + Add Application
    </a>
</div>

{{-- Search + Filter --}}
<form method="GET" action="{{ route('applications.index') }}" class="flex gap-3 mb-6">
    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Search company or role..."
        class="flex-1 bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500"
    >
    <select name="status" class="bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-indigo-500">
        <option value="">All statuses</option>
        @foreach(\App\Models\Application::statusLabels() as $value => $label)
            <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
    <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white text-sm px-4 py-2 rounded-lg transition">Filter</button>
    @if(request('search') || request('status'))
        <a href="{{ route('applications.index') }}" class="bg-gray-800 hover:bg-gray-700 text-gray-400 text-sm px-4 py-2 rounded-lg transition">Clear</a>
    @endif
</form>

{{-- Table --}}
@if($applications->isEmpty())
    <div class="text-center py-16 text-gray-500">
        <p class="text-lg mb-2">No applications yet.</p>
        <a href="{{ route('applications.create') }}" class="text-indigo-400 hover:text-indigo-300 text-sm">Add your first one</a>
    </div>
@else
<div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-800 text-gray-400 text-xs uppercase tracking-wider">
                <th class="text-left px-5 py-3">Company</th>
                <th class="text-left px-5 py-3">Role</th>
                <th class="text-left px-5 py-3 hidden sm:table-cell">Location</th>
                <th class="text-left px-5 py-3">Status</th>
                <th class="text-left px-5 py-3 hidden md:table-cell">Applied</th>
                <th class="text-right px-5 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-800">
            @foreach($applications as $app)
            @php
                $colors = [
                    'applied'   => 'bg-blue-500/10 text-blue-300 border-blue-500/20',
                    'interview' => 'bg-yellow-500/10 text-yellow-300 border-yellow-500/20',
                    'offer'     => 'bg-green-500/10 text-green-300 border-green-500/20',
                    'rejected'  => 'bg-red-500/10 text-red-300 border-red-500/20',
                ];
            @endphp
            <tr class="hover:bg-gray-800/50 transition">
                <td class="px-5 py-4 font-medium text-white">
                    <a href="{{ route('applications.show', $app) }}" class="hover:text-indigo-400 transition">
                        {{ $app->company }}
                        @if($app->needs_followup)
                            <span class="ml-1 text-orange-400 text-xs">⚠</span>
                        @endif
                        @if($app->interview_date && $app->interview_date->isFuture())
                            <span class="ml-1 text-yellow-400 text-xs">🎯 {{ $app->interview_date->format('M j') }}</span>
                        @endif
                    </a>
                </td>
                <td class="px-5 py-4 text-gray-300">{{ $app->role }}</td>
                <td class="px-5 py-4 text-gray-400 hidden sm:table-cell">{{ $app->location ?? '—' }}</td>
                <td class="px-5 py-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $colors[$app->status] }}">
                        {{ \App\Models\Application::statusLabels()[$app->status] }}
                    </span>
                </td>
                <td class="px-5 py-4 text-gray-400 hidden md:table-cell">{{ $app->applied_at->format('M j, Y') }}</td>
                <td class="px-5 py-4 text-right">
                    <a href="{{ route('applications.edit', $app) }}" class="text-gray-400 hover:text-white text-xs mr-3 transition">Edit</a>
                    <form method="POST" action="{{ route('applications.destroy', $app) }}" class="inline"
                          onsubmit="return confirm('Delete this application?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-600 hover:text-red-400 text-xs transition">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $applications->links() }}
</div>
@endif

@endsection