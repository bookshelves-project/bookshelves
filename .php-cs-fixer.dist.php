<?php

$rules = [
    '@PhpCsFixer' => true,
    'no_empty_comment' => false,
    'no_extra_blank_lines' => [
        'tokens' => [
            'extra',
            'throw',
            'use',
            'use_trait',
        ]
    ],
    'not_operator_with_successor_space' => true,
    'php_unit_method_casing' => false,
    'single_line_comment_style' => false,
    'php_unit_internal_class' => false,
    'php_unit_test_class_requires_covers' => false,
];

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/resources',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

$config = new PhpCsFixer\Config();
return $config->setFinder($finder)
    ->setRules($rules)
    ->setRiskyAllowed(true)
    ->setUsingCache(true);
