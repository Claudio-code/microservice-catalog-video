<?php
/*
 * This document has been generated with
 * https://mlocati.github.io/php-cs-fixer-configurator/#version:2.16.1|configurator
 * you can change this configuration by importing this file.
 */
return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        'array_indentation' => true,
        'array_syntax' => ['syntax'=>'short'],
        'blank_line_after_namespace' => true,
        'braces' => true,
        'class_attributes_separation' => ['elements'=>['method']],
        'class_definition' => true,
        'concat_space' => ['spacing'=>'one'],
        'elseif' => true,
        'encoding' => true,
        'full_opening_tag' => true,
        'function_declaration' => true,
        'indentation_type' => true,
        'line_ending' => true,
        'lowercase_constants' => true,
        'lowercase_keywords' => true,
        'magic_constant_casing' => true,
        'method_argument_space' => ['ensure_fully_multiline'=>true,'on_multiline'=>'ensure_fully_multiline'],
        'no_blank_lines_after_class_opening' => true,
        'no_closing_tag' => true,
        'no_empty_comment' => true,
        'no_empty_phpdoc' => true,
        'no_empty_statement' => true,
        'no_extra_blank_lines' => true,
        'no_spaces_after_function_name' => true,
        'no_spaces_inside_parenthesis' => true,
        'no_superfluous_phpdoc_tags' => true,
        'no_trailing_comma_in_singleline_array' => true,
        'no_trailing_whitespace' => true,
        'no_trailing_whitespace_in_comment' => true,
        'no_unused_imports' => true,
        'no_whitespace_in_blank_line' => true,
        'normalize_index_brace' => true,
        'object_operator_without_whitespace' => true,
        'ordered_class_elements' => ['order'=>['use_trait','constant_public','constant_protected','constant_private','property_static','property_public','property_protected','property_private']],
        'ordered_imports' => true,
        'phpdoc_order' => true,
        'phpdoc_types' => true,
        'psr4' => true,
        'return_type_declaration' => true,
        'single_blank_line_at_eof' => true,
        'single_class_element_per_statement' => true,
        'single_import_per_statement' => true,
        'single_line_after_imports' => true,
        'single_quote' => true,
        'switch_case_semicolon_to_colon' => true,
        'switch_case_space' => true,
        'ternary_operator_spaces' => true,
        'ternary_to_null_coalescing' => true,
        'trailing_comma_in_multiline_array' => true,
        'visibility_required' => true,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('vendor')
            ->in(__DIR__ . '/src')
            ->in(__DIR__ . '/tests')
    )
;
