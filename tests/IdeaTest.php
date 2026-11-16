<?php

use App\Models\User;
use App\Models\Idea;



it('criar nova ideia', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    visit('/ideas')
        ->click('@create-idea-button')
        ->fill('title', 'Some Example Title')
        ->click('@button-status-completed')
        ->fill('description', 'exemplo de descricao')
        ->fill('@new-link', 'http://laracasts.com')
        ->click('@submit-new-link-button')
        ->fill('@new-link', 'http://laravel.com')
        ->click('@submit-new-link-button')
        ->fill('@new-step', 'faça algo')
        ->click('@submit-new-step-button')
        ->fill('@new-step', 'faça outa coisa')
        ->click('@submit-new-step-button')
        ->click('Create')
        ->assertPathIs('/ideas');

    // Acedemos diretamente através do utilizador autenticado ($user->ideas)
    expect($user->ideas()->first()->toArray())->toMatchArray([
        'title' => 'Some Example Title',
        'status' => 'completed',
        'description' => 'exemplo de descricao',
        'links' => ['http://laracasts.com', 'http://laravel.com'],
    ]);

    expect($user->ideas()->first()->steps)->toHaveCount(2);
});


it('edits an existing new idea', function () {
    $this->actingAs($user = User::factory()->create());

    $idea = Idea::factory()->for($user)->create();

    visit(route('idea.show', $idea))
        ->click('@edit-idea-button')
        ->fill('@title', 'Some Example Title')
        ->click('@button-status-completed')
        ->fill('description', 'An example description')
        ->fill('@new-link', 'https://laracasts.com')
        ->click('@submit-new-link-button')
        ->fill('@new-link', 'https://laravel.com')
        ->click('@submit-new-link-button')
        ->fill('@new-step', 'Do a thing')
        ->click('@submit-new-step-button')
        ->fill('@new-step', 'Do another thing')
        ->click('@submit-new-step-button')
        ->click('Create')
        ->assertPathIs('/ideas');

    // Acedemos diretamente através do utilizador autenticado ($user->ideas)
    expect($user->ideas()->first()->toArray())->toMatchArray([
        'title' => 'Some Example Title',
        'status' => 'completed',
        'description' => 'exemplo de descricao',
        'links' => ['http://laracasts.com', 'http://laravel.com'],
    ]);

    expect($user->ideas()->first()->steps)->toHaveCount(2);
});
