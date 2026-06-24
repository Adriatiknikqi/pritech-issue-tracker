@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Create Issue</h1>
    <p class="text-gray-600">Add a new issue to a project.</p>
</div>

<div class="rounded bg-white p-6 shadow">
    <form action="{{ route('issues.store') }}" method="POST">
        @csrf

        @include('issues._form')
    </form>
</div>
@endsection