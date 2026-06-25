<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@example.com',
        ]);

        $tags = collect([
            ['name' => 'Bug', 'color' => 'red'],
            ['name' => 'Feature', 'color' => 'blue'],
            ['name' => 'Urgent', 'color' => 'yellow'],
            ['name' => 'Backend', 'color' => 'green'],
            ['name' => 'Frontend', 'color' => 'purple'],
        ])->map(fn(array $tag) => Tag::create($tag));

        Project::factory()
            ->count(4)
            ->create()
            ->each(function (Project $project) use ($tags) {
                Issue::factory()
                    ->count(5)
                    ->create([
                        'project_id' => $project->id,
                    ])
                    ->each(function (Issue $issue) use ($tags) {
                        $issue->tags()->attach(
                            $tags->random(rand(1, 3))->pluck('id')->toArray()
                        );

                        Comment::factory()
                            ->count(rand(2, 6))
                            ->create([
                                'issue_id' => $issue->id,
                            ]);
                    });
            });
    }
}
