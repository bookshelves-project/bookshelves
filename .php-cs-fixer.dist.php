<?php

/**
 * Rules
 * https://mlocati.github.io/php-cs-fixer-configurator.
 */
$rules = [
    '@PhpCsFixer' => true,
    'no_empty_comment' => false,
    'no_extra_blank_lines' => [
        'tokens' => [
            'extra',
            'throw',
            'use',
        ],
    ],
    'not_operator_with_successor_space' => true,
    'php_unit_method_casing' => false,
    'single_line_comment_style' => false,
    'phpdoc_single_line_var_spacing' => true,
    'php_unit_internal_class' => false,
    'php_unit_test_class_requires_covers' => false,
    'lambda_not_used_import' => false,
    'return_assignment' => true,
    'phpdoc_to_comment' => false,
    'ordered_imports' => [
        'imports_order' => [
            'class', 'function', 'const',
        ],
        'sort_algorithm' => 'alpha',
    ],
    'array_indentation' => true,
    'array_syntax' => true,
    'blank_line_after_opening_tag' => true,
    'blank_line_before_statement' => false,
    'no_unused_imports' => true,
];

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__.'/app',
        __DIR__.'/config',
        __DIR__.'/database',
        __DIR__.'/resources',
        __DIR__.'/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
;

$config = new PhpCsFixer\Config();

return $config->setFinder($finder)
    ->setRules($rules)
    ->setRiskyAllowed(true)
    ->setUsingCache(true)
;
