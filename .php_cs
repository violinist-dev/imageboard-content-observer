<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('var')
    ->exclude('bin')
    ->exclude('vendor')
    ->exclude('.idea')
    ->in(__DIR__)
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        'concat_space' => ['spacing' => 'one'],
        'yoda_style' => false,
    ])
    ->setFinder($finder)
    ;
