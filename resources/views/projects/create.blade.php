@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Create Project</h1>
    <p class="text-gray-600">Add a new project to the issue tracker.</p>
</div>

<div class="rounded bg-white p-6 shadow">
    <form action="{{ route('projects.store') }}" method="POST">
        @csrf

        @include('projects._form')
    </form>
</div>
@endsection