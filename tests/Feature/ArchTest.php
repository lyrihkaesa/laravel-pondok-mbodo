<?php

declare(strict_types=1);

test('globals')
    ->expect(['dd', 'dump', 'ray', 'var_dump'])
    ->not->toBeUsed();

// test('app')
//     ->expect('App')
//     ->toUseStrictTypes();

test('the codebase does not reference env variables outside of config files')
    ->expect('env')
    ->not->toBeUsed();
