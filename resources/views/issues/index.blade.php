@extends('layouts.app')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold">Issues</h1>
        <p class="text-gray-600">Manage and filter all issues.</p>
    </div>

    <a href="{{ route('issues.create') }}" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
        Create Issue
    </a>
</div>

<div class="mb-6 rounded bg-white p-4 shadow">
    <form method="GET" action="{{ route('issues.index') }}" class="grid grid-cols-1 gap-4 md:grid-cols-4">
        <div>
            <label for="status" class="mb-1 block font-medium">Status</label>

            <select name="status" id="status" class="w-full rounded border border-gray-300 px-3 py-2">
                <option value="">All statuses</option>
                <option value="open" @selected(request('status')==='open' )>Open</option>
                <option value="in_progress" @selected(request('status')==='in_progress' )>In Progress</option>
                <option value="closed" @selected(request('status')==='closed' )>Closed</option>
            </select>
        </div>

        <div>
            <label for="priority" class="mb-1 block font-medium">Priority</label>

            <select name="priority" id="priority" class="w-full rounded border border-gray-300 px-3 py-2">
                <option value="">All priorities</option>
                <option value="low" @selected(request('priority')==='low' )>Low</option>
                <option value="medium" @selected(request('priority')==='medium' )>Medium</option>
                <option value="high" @selected(request('priority')==='high' )>High</option>
            </select>
        </div>

        <div>
            <label for="tag" class="mb-1 block font-medium">Tag</label>

            <select name="tag" id="tag" class="w-full rounded border border-gray-300 px-3 py-2">
                <option value="">All tags</option>

                @foreach ($tags as $tag)
                <option value="{{ $tag->id }}" @selected((string) request('tag')===(string) $tag->id)>
                    {{ $tag->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end gap-2">
            <button type="submit" class="rounded bg-gray-900 px-4 py-2 text-white hover:bg-black">
                Filter
            </button>

            <a href="{{ route('issues.index') }}" class="rounded bg-gray-200 px-4 py-2 text-gray-800 hover:bg-gray-300">
                Reset
            </a>
        </div>
    </form>
</div>

<div class="overflow-hidden rounded bg-white shadow">
    <table class="w-full border-collapse">
        <thead class="bg-gray-50">
            <tr>
                <th class="border-b px-4 py-3 text-left">Title</th>
                <th class="border-b px-4 py-3 text-left">Project</th>
                <th class="border-b px-4 py-3 text-left">Status</th>
                <th class="border-b px-4 py-3 text-left">Priority</th>
                <th class="border-b px-4 py-3 text-left">Tags</th>
                <th class="border-b px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($issues as $issue)
            <tr>
                <td class="border-b px-4 py-3">
                    <a href="{{ route('issues.show', $issue) }}" class="font-medium text-blue-600 hover:underline">
                        {{ $issue->title }}
                    </a>
                </td>

                <td class="border-b px-4 py-3">
                    <a href="{{ route('projects.show', $issue->project) }}" class="text-blue-600 hover:underline">
                        {{ $issue->project->name }}
                    </a>
                </td>

                <td class="border-b px-4 py-3">
                    {{ str_replace('_', ' ', ucfirst($issue->status)) }}
                </td>

                <td class="border-b px-4 py-3">
                    {{ ucfirst($issue->priority) }}
                </td>

                <td class="border-b px-4 py-3">
                    @forelse ($issue->tags as $tag)
                    <span class="mr-1 rounded bg-gray-100 px-2 py-1 text-sm">
                        {{ $tag->name }}
                    </span>
                    @empty
                    <span class="text-gray-500">No tags</span>
                    @endforelse
                </td>

                <td class="border-b px-4 py-3 text-right">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('issues.edit', $issue) }}" class="text-blue-600 hover:underline">
                            Edit
                        </a>

                        <form action="{{ route('issues.destroy', $issue) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this issue?');">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="text-red-600 hover:underline">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                    No issues found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $issues->links() }}
</div>
@endsection