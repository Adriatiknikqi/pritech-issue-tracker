@extends('layouts.app')

@section('content')
<div class="mb-6 flex items-start justify-between">
    <div>
        <h1 class="text-2xl font-bold">{{ $project->name }}</h1>

        <p class="mt-2 text-gray-600">
            {{ $project->description ?: 'No description provided.' }}
        </p>

        <div class="mt-4 flex gap-6 text-sm text-gray-700">
            <div>
                <span class="font-medium">Start Date:</span>
                {{ $project->start_date?->format('Y-m-d') ?? '-' }}
            </div>

            <div>
                <span class="font-medium">Deadline:</span>
                {{ $project->deadline?->format('Y-m-d') ?? '-' }}
            </div>
        </div>
    </div>

    <div class="flex gap-2">
        <a href="{{ route('projects.edit', $project) }}"
            class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
            Edit
        </a>

        <a href="{{ route('projects.index') }}" class="rounded bg-gray-200 px-4 py-2 text-gray-800 hover:bg-gray-300">
            Back
        </a>
    </div>
</div>

<div class="rounded bg-white p-6 shadow">
    <h2 class="mb-4 text-xl font-semibold">Issues</h2>

    @if ($project->issues->isEmpty())
    <p class="text-gray-500">No issues have been added to this project yet.</p>
    @else
    <div class="overflow-hidden rounded border border-gray-200">
        <table class="w-full border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="border-b px-4 py-3 text-left">Title</th>
                    <th class="border-b px-4 py-3 text-left">Status</th>
                    <th class="border-b px-4 py-3 text-left">Priority</th>
                    <th class="border-b px-4 py-3 text-left">Due Date</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($project->issues as $issue)
                <tr>
                    <td class="border-b px-4 py-3">
                        {{ $issue->title }}
                    </td>

                    <td class="border-b px-4 py-3">
                        {{ str_replace('_', ' ', ucfirst($issue->status)) }}
                    </td>

                    <td class="border-b px-4 py-3">
                        {{ ucfirst($issue->priority) }}
                    </td>

                    <td class="border-b px-4 py-3">
                        {{ $issue->due_date?->format('Y-m-d') ?? '-' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection