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
    <label for="name" class="mb-1 block font-medium">Name</label>

    <input type="text" id="name" name="name" value="{{ old('name', $project->name ?? '') }}"
        class="w-full rounded border border-gray-300 px-3 py-2" required>
</div>

<div class="mb-4">
    <label for="description" class="mb-1 block font-medium">Description</label>

    <textarea id="description" name="description" rows="5"
        class="w-full rounded border border-gray-300 px-3 py-2">{{ old('description', $project->description ?? '') }}</textarea>
</div>

<div class="mb-4 grid grid-cols-1 gap-4 md:grid-cols-2">
    <div>
        <label for="start_date" class="mb-1 block font-medium">Start Date</label>

        <input type="date" id="start_date" name="start_date"
            value="{{ old('start_date', isset($project) && $project->start_date ? $project->start_date->format('Y-m-d') : '') }}"
            class="w-full rounded border border-gray-300 px-3 py-2">
    </div>

    <div>
        <label for="deadline" class="mb-1 block font-medium">Deadline</label>

        <input type="date" id="deadline" name="deadline"
            value="{{ old('deadline', isset($project) && $project->deadline ? $project->deadline->format('Y-m-d') : '') }}"
            class="w-full rounded border border-gray-300 px-3 py-2">
    </div>
</div>

<div class="flex items-center gap-3">
    <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
        Save
    </button>

    <a href="{{ route('projects.index') }}" class="text-gray-600 hover:underline">
        Cancel
    </a>
</div>