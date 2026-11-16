<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

pest()->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->in('Browser', 'Feature', 'Unit', './');

// Configura o Playwright para usar o Microsoft Edge nativo do Windows
pest()->browser()->channel('msedge');

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

function something()
{
    // ..
}
