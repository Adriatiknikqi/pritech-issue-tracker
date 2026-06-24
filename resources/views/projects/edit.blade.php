@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Edit Project</h1>
    <p class="text-gray-600">Update the project information.</p>
</div>

<div class="rounded bg-white p-6 shadow">
    <form action="{{ route('projects.update', $project) }}" method="POST">
        @csrf
        @method('PUT')

        @include('projects._form')
    </form>
</div>
@endsection