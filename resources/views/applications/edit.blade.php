@extends('layouts.app')

@section('title', 'Edit Application')

@section('content')

<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('applications.index') }}" class="text-gray-500 hover:text-white transition text-sm">← Back</a>
        <h1 class="text-lg font-semibold text-white">Edit Application</h1>
    </div>

    <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
        <form method="POST" action="{{ route('applications.update', $application) }}">
            @csrf
            @method('PUT')
            @include('applications._form')
            <div class="mt-6 flex gap-3">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                    Save Changes
                </button>
                <a href="{{ route('applications.index') }}"
                    class="bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm px-5 py-2.5 rounded-lg transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
