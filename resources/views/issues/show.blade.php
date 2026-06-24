@extends('layouts.app')

@section('content')
<div class="mb-6 flex items-start justify-between">
    <div>
        <h1 class="text-2xl font-bold">{{ $issue->title }}</h1>

        <p class="mt-2 text-gray-600">
            Project:
            <a href="{{ route('projects.show', $issue->project) }}" class="text-blue-600 hover:underline">
                {{ $issue->project->name }}
            </a>
        </p>
    </div>

    <div class="flex gap-2">
        <a href="{{ route('issues.edit', $issue) }}" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
            Edit
        </a>

        <a href="{{ route('issues.index') }}" class="rounded bg-gray-200 px-4 py-2 text-gray-800 hover:bg-gray-300">
            Back
        </a>
    </div>
</div>

<div class="mb-6 rounded bg-white p-6 shadow">
    <h2 class="mb-4 text-xl font-semibold">Issue Details</h2>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <div>
            <p class="text-sm text-gray-500">Status</p>
            <p class="font-medium">{{ str_replace('_', ' ', ucfirst($issue->status)) }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Priority</p>
            <p class="font-medium">{{ ucfirst($issue->priority) }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Due Date</p>
            <p class="font-medium">{{ $issue->due_date?->format('Y-m-d') ?? '-' }}</p>
        </div>
    </div>

    <div class="mt-6">
        <p class="text-sm text-gray-500">Description</p>
        <p class="mt-1 whitespace-pre-line">
            {{ $issue->description ?: 'No description provided.' }}
        </p>
    </div>
</div>

<div class="mb-6 rounded bg-white p-6 shadow">
    <h2 class="mb-4 text-xl font-semibold">Tags</h2>

    @forelse ($issue->tags as $tag)
    <span class="mr-2 inline-block rounded bg-gray-100 px-3 py-1 text-sm">
        {{ $tag->name }}
    </span>
    @empty
    <p class="text-gray-500">No tags attached yet.</p>
    @endforelse
</div>

<div class="rounded bg-white p-6 shadow">
    <h2 class="mb-4 text-xl font-semibold">Comments</h2>

    <p class="text-gray-500">
        Comments will be loaded here.
    </p>
</div>
@endsection