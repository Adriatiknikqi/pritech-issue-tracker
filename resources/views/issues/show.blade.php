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

    <div class="mb-4 flex gap-2">
        <select id="available-tags" class="rounded border border-gray-300 px-3 py-2">
            <option value="">Select tag</option>

            @foreach ($availableTags as $tag)
            <option value="{{ $tag->id }}">
                {{ $tag->name }}
            </option>
            @endforeach
        </select>

        <button type="button" id="attach-tag-button" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
            Attach Tag
        </button>
    </div>

    <div id="attached-tags" class="flex flex-wrap gap-2">
        @forelse ($issue->tags as $tag)
        <span id="tag-{{ $tag->id }}" class="inline-flex items-center gap-2 rounded bg-gray-100 px-3 py-1 text-sm">
            {{ $tag->name }}

            <button type="button" class="detach-tag text-red-600 hover:underline" data-tag-id="{{ $tag->id }}"
                data-tag-name="{{ $tag->name }}">
                Remove
            </button>
        </span>
        @empty
        <p id="no-tags-message" class="text-gray-500">No tags attached yet.</p>
        @endforelse
    </div>
</div>

<div class="rounded bg-white p-6 shadow">
    <h2 class="mb-4 text-xl font-semibold">Comments</h2>

    <form id="comment-form" class="mb-6">
        <div id="comment-errors" class="mb-4 hidden rounded bg-red-100 px-4 py-3 text-red-800"></div>

        <div class="mb-4">
            <label for="author_name" class="mb-1 block font-medium">Author Name</label>

            <input type="text" id="author_name" name="author_name"
                class="w-full rounded border border-gray-300 px-3 py-2">
        </div>

        <div class="mb-4">
            <label for="body" class="mb-1 block font-medium">Comment</label>

            <textarea id="body" name="body" rows="4" class="w-full rounded border border-gray-300 px-3 py-2"></textarea>
        </div>

        <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
            Add Comment
        </button>
    </form>

    <div id="comments-list" class="space-y-4"></div>

    <button type="button" id="load-more-comments"
        class="mt-4 hidden rounded bg-gray-200 px-4 py-2 text-gray-800 hover:bg-gray-300">
        Load More Comments
    </button>
</div>

<script>
    const issueId = @json($issue->id);
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const attachButton = document.getElementById('attach-tag-button');
    const availableTags = document.getElementById('available-tags');
    const attachedTags = document.getElementById('attached-tags');

    attachButton.addEventListener('click', async () => {
        const tagId = availableTags.value;
        const selectedOption = availableTags.options[availableTags.selectedIndex];

        if (!tagId) {
            return;
        }

        const response = await fetch(`/issues/${issueId}/tags/${tagId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
        });

        if (!response.ok) {
            return;
        }

        const data = await response.json();

        document.getElementById('no-tags-message')?.remove();

        const tagElement = document.createElement('span');
        tagElement.id = `tag-${data.tag.id}`;
        tagElement.className = 'inline-flex items-center gap-2 rounded bg-gray-100 px-3 py-1 text-sm';
        tagElement.innerHTML = `
            ${data.tag.name}
            <button
                type="button"
                class="detach-tag text-red-600 hover:underline"
                data-tag-id="${data.tag.id}"
                data-tag-name="${data.tag.name}"
            >
                Remove
            </button>
        `;

        attachedTags.appendChild(tagElement);

        selectedOption.remove();
        availableTags.value = '';
    });

    attachedTags.addEventListener('click', async (event) => {
        if (!event.target.classList.contains('detach-tag')) {
            return;
        }

        const tagId = event.target.dataset.tagId;
        const tagName = event.target.dataset.tagName;

        const response = await fetch(`/issues/${issueId}/tags/${tagId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
        });

        if (!response.ok) {
            return;
        }

        document.getElementById(`tag-${tagId}`)?.remove();

        const option = document.createElement('option');
        option.value = tagId;
        option.textContent = tagName;
        availableTags.appendChild(option);

        if (!attachedTags.querySelector('span')) {
            attachedTags.innerHTML = '<p id="no-tags-message" class="text-gray-500">No tags attached yet.</p>';
        }
    });
     const commentForm = document.getElementById('comment-form');
    const commentsList = document.getElementById('comments-list');
    const commentErrors = document.getElementById('comment-errors');
    const loadMoreCommentsButton = document.getElementById('load-more-comments');

    let commentsPage = 1;
    let lastCommentsPage = 1;

    function escapeHtml(value) {
        return String(value)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function renderComment(comment, prepend = false) {
        const commentElement = document.createElement('div');
        commentElement.className = 'rounded border border-gray-200 p-4';

        commentElement.innerHTML = `
            <div class="mb-2 flex items-center justify-between">
                <p class="font-medium">${escapeHtml(comment.author_name)}</p>
                <p class="text-sm text-gray-500">${new Date(comment.created_at).toLocaleString()}</p>
            </div>

            <p class="whitespace-pre-line text-gray-700">${escapeHtml(comment.body)}</p>
        `;

        if (prepend) {
            commentsList.prepend(commentElement);
        } else {
            commentsList.appendChild(commentElement);
        }
    }

    async function loadComments(page = 1) {
        const response = await fetch(`/issues/${issueId}/comments?page=${page}`, {
            headers: {
                'Accept': 'application/json',
            },
        });

        if (!response.ok) {
            return;
        }

        const data = await response.json();

        commentsPage = data.current_page;
        lastCommentsPage = data.last_page;

        data.data.forEach((comment) => {
            renderComment(comment);
        });

        if (commentsPage < lastCommentsPage) {
            loadMoreCommentsButton.classList.remove('hidden');
        } else {
            loadMoreCommentsButton.classList.add('hidden');
        }
    }

    commentForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        commentErrors.classList.add('hidden');
        commentErrors.innerHTML = '';

        const formData = new FormData(commentForm);

        const response = await fetch(`/issues/${issueId}/comments`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: formData,
        });

        const data = await response.json();

        if (response.status === 422) {
            const errors = Object.values(data.errors).flat();

            commentErrors.innerHTML = `
                <p class="font-semibold">Please fix the errors below:</p>
                <ul class="mt-2 list-disc pl-5">
                    ${errors.map((error) => `<li>${escapeHtml(error)}</li>`).join('')}
                </ul>
            `;

            commentErrors.classList.remove('hidden');
            return;
        }

        if (!response.ok) {
            return;
        }

        renderComment(data.comment, true);
        commentForm.reset();
    });

    loadMoreCommentsButton.addEventListener('click', () => {
        if (commentsPage < lastCommentsPage) {
            loadComments(commentsPage + 1);
        }
    });

    loadComments();
</script>
@endsection