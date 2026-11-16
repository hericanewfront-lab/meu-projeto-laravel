<?php

use App\Models\User;

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
        ->click('Create')
        ->assertPathIs('/ideas');

    expect($user->ideas()->first()->toArray())->toMatchArray([
        'title' => 'Some Example Title',
        'status' => 'completed',
        'description' => 'exemplo de descricao',
        'links' => ['https://laracasts.com'],
    ]);
});
