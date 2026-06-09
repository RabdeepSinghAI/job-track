<div class="space-y-5">

    {{-- Company + Role --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Company <span class="text-red-400">*</span></label>
            <input type="text" name="company" value="{{ old('company', $application->company ?? '') }}"
                class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500"
                placeholder="e.g. Google" required>
            @error('company') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Role <span class="text-red-400">*</span></label>
            <input type="text" name="role" value="{{ old('role', $application->role ?? '') }}"
                class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500"
                placeholder="e.g. Software Engineer" required>
            @error('role') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Location + URL --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Location</label>
            <input type="text" name="location" value="{{ old('location', $application->location ?? '') }}"
                class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500"
                placeholder="e.g. Remote, New York, NY">
            @error('location') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Job Posting URL</label>
            <input type="url" name="url" value="{{ old('url', $application->url ?? '') }}"
                class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500"
                placeholder="https://...">
            @error('url') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Contact + Interview Date --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Recruiter / Contact Name</label>
            <input type="text" name="contact_name" value="{{ old('contact_name', $application->contact_name ?? '') }}"
                class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500"
                placeholder="e.g. Evan Barrow">
            @error('contact_name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Interview Date</label>
            <input type="date" name="interview_date"
                value="{{ old('interview_date', isset($application) && $application->interview_date ? $application->interview_date->format('Y-m-d') : '') }}"
                class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500">
            @error('interview_date') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Status + Date --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Status <span class="text-red-400">*</span></label>
            <select name="status" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500" required>
                @foreach(\App\Models\Application::statusLabels() as $value => $label)
                    <option value="{{ $value }}" {{ old('status', $application->status ?? 'applied') === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('status') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Date Applied <span class="text-red-400">*</span></label>
            <input type="date" name="applied_at"
                value="{{ old('applied_at', isset($application) ? $application->applied_at->format('Y-m-d') : now()->format('Y-m-d')) }}"
                class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500" required>
            @error('applied_at') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Notes --}}
    <div>
        <label class="block text-sm font-medium text-gray-300 mb-1.5">Notes</label>
        <textarea name="notes" rows="4"
            class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 resize-none"
            placeholder="Recruiter name, interview rounds, anything worth remembering...">{{ old('notes', $application->notes ?? '') }}</textarea>
        @error('notes') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
    </div>

    {{-- Follow Up --}}
    <div class="flex items-center gap-3">
        <input type="checkbox" name="needs_followup" id="needs_followup" value="1"
            {{ old('needs_followup', $application->needs_followup ?? false) ? 'checked' : '' }}
            class="w-4 h-4 rounded border-gray-600 bg-gray-800 text-indigo-500 focus:ring-indigo-500">
        <label for="needs_followup" class="text-sm text-gray-300">Flag for follow up</label>
    </div>

</div>