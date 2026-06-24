@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Edit Issue</h1>
    <p class="text-gray-600">Update the issue information.</p>
</div>

<div class="rounded bg-white p-6 shadow">
    <form action="{{ route('issues.update', $issue) }}" method="POST">
        @csrf
        @method('PUT')

        @include('issues._form')
    </form>
</div>
@endsection