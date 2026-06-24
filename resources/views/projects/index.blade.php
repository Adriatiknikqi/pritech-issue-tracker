@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold">Projects</h1>
        <p class="text-gray-600">Manage all projects in the issue tracker.</p>
    </div>

    <a href="{{ route('projects.create') }}" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
        Create Project
    </a>
</div>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full border-collapse">
        <thead class="bg-gray-50">
            <tr>
                <th class="border-b px-4 py-3 text-left">Name</th>
                <th class="border-b px-4 py-3 text-left">Start Date</th>
                <th class="border-b px-4 py-3 text-left">Deadline</th>
                <th class="border-b px-4 py-3 text-left">Issues</th>
                <th class="border-b px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($projects as $project)
            <tr>
                <td class="border-b px-4 py-3">
                    <a href="{{ route('projects.show', $project) }}" class="font-medium text-blue-600 hover:underline">
                        {{ $project->name }}
                    </a>
                </td>

                <td class="border-b px-4 py-3">
                    {{ $project->start_date?->format('Y-m-d') ?? '-' }}
                </td>

                <td class="border-b px-4 py-3">
                    {{ $project->deadline?->format('Y-m-d') ?? '-' }}
                </td>

                <td class="border-b px-4 py-3">
                    {{ $project->issues_count }}
                </td>

                <td class="border-b px-4 py-3 text-right">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('projects.edit', $project) }}" class="text-blue-600 hover:underline">
                            Edit
                        </a>

                        <form action="{{ route('projects.destroy', $project) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this project?');">
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
                <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                    No projects found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $projects->links() }}
</div>
@endsection