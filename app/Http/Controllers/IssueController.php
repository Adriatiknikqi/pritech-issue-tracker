<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Http\Requests\StoreIssueRequest;
use App\Http\Requests\UpdateIssueRequest;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IssueController extends Controller
{
    public function index(Request $request): View
    {
        $issues = Issue::query()
            ->with(['project', 'tags'])
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->filled('priority'), function ($query) use ($request) {
                $query->where('priority', $request->priority);
            })
            ->when($request->filled('tag'), function ($query) use ($request) {
                $query->whereHas('tags', function ($tagQuery) use ($request) {
                    $tagQuery->where('tags.id', $request->tag);
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $tags = Tag::query()
            ->orderBy('name')
            ->get();

        return view('issues.index', compact('issues', 'tags'));
    }

    public function create(): View
    {
        $projects = Project::query()
            ->orderBy('name')
            ->get();

        return view('issues.create', compact('projects'));
    }

    public function store(StoreIssueRequest $request): RedirectResponse
    {
        $issue = Issue::create($request->validated());

        return redirect()
            ->route('issues.show', $issue)
            ->with('success', 'Issue created successfully.');
    }

    public function show(Issue $issue): View
    {
        $issue->load(['project', 'tags']);
        $attachedTagIds = $issue->tags->pluck('id');

        $availableTags = Tag::query()
            ->whereNotIn('id', $attachedTagIds)
            ->orderBy('name')
            ->get();

        return view('issues.show', compact('issue', 'availableTags'));
    }

    public function edit(Issue $issue): View
    {
        $projects = Project::query()
            ->orderBy('name')
            ->get();

        return view('issues.edit', compact('issue', 'projects'));
    }

    public function update(UpdateIssueRequest $request, Issue $issue): RedirectResponse
    {
        $issue->update($request->validated());

        return redirect()
            ->route('issues.show', $issue)
            ->with('success', 'Issue updated successfully.');
    }

    public function destroy(Issue $issue): RedirectResponse
    {
        $issue->delete();

        return redirect()
            ->route('issues.index')
            ->with('success', 'Issue deleted successfully.');
    }

    public function attachTag(Issue $issue, Tag $tag)
    {
        $issue->tags()->syncWithoutDetaching([$tag->id]);

        return response()->json([
            'message' => 'Tag attached successfully.',
            'tag' => [
                'id' => $tag->id,
                'name' => $tag->name,
                'color' => $tag->color,
            ],
        ]);
    }

    public function detachTag(Issue $issue, Tag $tag)
    {
        $issue->tags()->detach($tag->id);

        return response()->json([
            'message' => 'Tag detached successfully.',
            'tag_id' => $tag->id,
        ]);
    }
}
