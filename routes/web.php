<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\TagController;

Route::get('/', function () {
    return redirect()->route('projects.index');
});

Route::resource('projects', ProjectController::class);
Route::resource('issues', IssueController::class);
Route::resource('tags', TagController::class)->only([
    'index',
    'store',
]);
Route::post('/issues/{issue}/tags/{tag}', [IssueController::class, 'attachTag'])
    ->name('issues.tags.attach');

Route::delete('/issues/{issue}/tags/{tag}', [IssueController::class, 'detachTag'])
    ->name('issues.tags.detach');
