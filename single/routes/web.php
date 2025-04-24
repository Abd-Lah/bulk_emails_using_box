<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\EmailForm::class);
Route::get('/email-content', \App\Livewire\ContentEditor::class)->name('email-content');
