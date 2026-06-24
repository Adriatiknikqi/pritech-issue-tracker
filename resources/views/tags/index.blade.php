@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Tags</h1>
    <p class="text-gray-600">Create and manage issue tags.</p>
</div>

<div class="mb-6 rounded bg-white p-6 shadow">
    <h2 class="mb-4 text-xl font-semibold">Create Tag</h2>

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

    <form action="{{ route('tags.store') }}" method="POST" class="grid grid-cols-1 gap-4 md:grid-cols-3">
        @csrf

        <div>
            <label for="name" class="mb-1 block font-medium">Name</label>

            <input type="text" id="name" name="name" value="{{ old('name') }}"
                class="w-full rounded border border-gray-300 px-3 py-2" required>
        </div>

        <div>
            <label for="color" class="mb-1 block font-medium">Color</label>

            <input type="text" id="color" name="color" value="{{ old('color') }}"
                placeholder="Example: blue, red, #2563eb" class="w-full rounded border border-gray-300 px-3 py-2">
        </div>

        <div class="flex items-end">
            <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                Create Tag
            </button>
        </div>
    </form>
</div>

<div class="overflow-hidden rounded bg-white shadow">
    <table class="w-full border-collapse">
        <thead class="bg-gray-50">
            <tr>
                <th class="border-b px-4 py-3 text-left">Name</th>
                <th class="border-b px-4 py-3 text-left">Color</th>
                <th class="border-b px-4 py-3 text-left">Issues Count</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($tags as $tag)
            <tr>
                <td class="border-b px-4 py-3 font-medium">
                    {{ $tag->name }}
                </td>

                <td class="border-b px-4 py-3">
                    {{ $tag->color ?? '-' }}
                </td>

                <td class="border-b px-4 py-3">
                    {{ $tag->issues_count }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="px-4 py-6 text-center text-gray-500">
                    No tags found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $tags->links() }}
</div>
@endsection