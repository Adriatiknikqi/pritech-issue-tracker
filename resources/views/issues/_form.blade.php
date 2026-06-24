@if ($errors->any())
<div class="mb-4 rounded bg-red-100 px-4 py-3 text-red-800">
    <p class="font-semibold">Please fix the errors below:</p>

    <ul class="mt-2 list-disc pl-5">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="mb-4">
    <label for="project_id" class="mb-1 block font-medium">Project</label>

    <select id="project_id" name="project_id" class="w-full rounded border border-gray-300 px-3 py-2" required>
        <option value="">Select project</option>

        @foreach ($projects as $project)
        <option value="{{ $project->id }}" @selected((int) old('project_id', $issue->project_id ?? '') === $project->id)
            >
            {{ $project->name }}
        </option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label for="title" class="mb-1 block font-medium">Title</label>

    <input type="text" id="title" name="title" value="{{ old('title', $issue->title ?? '') }}"
        class="w-full rounded border border-gray-300 px-3 py-2" required>
</div>

<div class="mb-4">
    <label for="description" class="mb-1 block font-medium">Description</label>

    <textarea id="description" name="description" rows="5"
        class="w-full rounded border border-gray-300 px-3 py-2">{{ old('description', $issue->description ?? '') }}</textarea>
</div>

<div class="mb-4 grid grid-cols-1 gap-4 md:grid-cols-3">
    <div>
        <label for="status" class="mb-1 block font-medium">Status</label>

        <select id="status" name="status" class="w-full rounded border border-gray-300 px-3 py-2" required>
            <option value="open" @selected(old('status', $issue->status ?? 'open') === 'open')>
                Open
            </option>
            <option value="in_progress" @selected(old('status', $issue->status ?? '') === 'in_progress')>
                In Progress
            </option>
            <option value="closed" @selected(old('status', $issue->status ?? '') === 'closed')>
                Closed
            </option>
        </select>
    </div>

    <div>
        <label for="priority" class="mb-1 block font-medium">Priority</label>

        <select id="priority" name="priority" class="w-full rounded border border-gray-300 px-3 py-2" required>
            <option value="low" @selected(old('priority', $issue->priority ?? '') === 'low')>
                Low
            </option>
            <option value="medium" @selected(old('priority', $issue->priority ?? 'medium') === 'medium')>
                Medium
            </option>
            <option value="high" @selected(old('priority', $issue->priority ?? '') === 'high')>
                High
            </option>
        </select>
    </div>

    <div>
        <label for="due_date" class="mb-1 block font-medium">Due Date</label>

        <input type="date" id="due_date" name="due_date"
            value="{{ old('due_date', isset($issue) && $issue->due_date ? $issue->due_date->format('Y-m-d') : '') }}"
            class="w-full rounded border border-gray-300 px-3 py-2">
    </div>
</div>

<div class="flex items-center gap-3">
    <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
        Save
    </button>

    <a href="{{ route('issues.index') }}" class="text-gray-600 hover:underline">
        Cancel
    </a>
</div>