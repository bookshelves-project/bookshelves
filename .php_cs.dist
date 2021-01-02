<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('bootstrap/cache')
    ->exclude('node_modules')
    ->exclude('storage')
    ->in(__DIR__)
    ->notName('*.blade.php')
    ->notName('.phpstorm.meta.php')
    ->notName('_ide_*.php')
;

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        'array_indentation' => true,
        'binary_operator_spaces' => ['operators' => ['=>' => 'align']],
        'increment_style' => ['style' => 'post'],
        'linebreak_after_opening_tag' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'not_operator_with_successor_space' => true,
        'ordered_imports' => ['sortAlgorithm' => 'length'],
        'phpdoc_order' => true,
        'simplified_null_return' => true,
        'no_superfluous_phpdoc_tags' => false,
    ])
    ->setFinder($finder)
;
