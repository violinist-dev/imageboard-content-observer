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
        'align_multiline_comment' => [
            'comment_type' => 'all_multiline',
        ],
        'array_indentation' => true,
        'array_syntax' => [
            'syntax' => 'short'
        ],
        'backtick_to_shell_exec' => true,
        'binary_operator_spaces' => [
            'default' => 'single_space',
        ],
        'blank_line_after_namespace' => true,
        'blank_line_after_opening_tag' => true,
        'blank_line_before_statement' => [
            'statements' => [
                'break',
                'case',
                'continue',
                'declare',
                'default',
                'die',
                'do',
                'exit',
                'for',
                'foreach',
                'goto',
                'if',
                'include',
                'include_once',
                'require',
                'require_once',
                'return',
                'switch',
                'throw',
                'try',
                'while',
                'yield',
            ],
        ],
        'braces' => [
            'allow_single_line_closure' => false,
            'position_after_anonymous_constructs' => 'same',
            'position_after_control_structures' => 'same',
            'position_after_functions_and_oop_constructs' => 'next',
        ],
        'cast_spaces' => [
            'space' => 'single',
        ],
        'class_attributes_separation' => [
            'elements' => [
                'method',
                'property'
            ],
        ],
        'class_definition' => [
            'multi_line_extends_each_single_line' => true,
            'single_item_single_line' => true,
            'single_line' => true,
        ],
        'class_keyword_remove' => false,
        'combine_consecutive_issets' => true,
        'combine_nested_dirname' => false,
        'comment_to_phpdoc' => true,
        'compact_nullable_typehint' => false,
        'concat_space' => [
            'spacing' => 'one'
        ],
        'date_time_immutable' => true,
        'declare_equal_normalize' => [
            'space' => 'none'
        ],
        // 'declare_strict_types' => true,
        'dir_constant' => true,
        'doctrine_annotation_array_assignment' => [
            // 'ignored_tags' => [],
            'operator' => '=',
        ],
        'doctrine_annotation_braces' => [
            // 'ignored_tags' => [],
            'syntax' => 'with_braces'
        ],
        'doctrine_annotation_indentation' => [
            // 'ignored_tags' => [],
            'indent_mixed_lines' => true,
        ],
        'doctrine_annotation_spaces' => [
            'after_argument_assignments' => false,
            'after_array_assignments_colon' => true,
            'after_array_assignments_equals' => false,
            'around_commas' => true,
            'around_parentheses' => true,
            'before_argument_assignments' => false,
            'before_array_assignments_colon' => false,
            'before_array_assignments_equals' => false,
            // 'ignored_tags' => [],
        ],
        'elseif' => true,
        'encoding' => true,
        'ereg_to_preg' => true,
        'error_suppression' => [
            'mute_deprecation_error' => false,
            'noise_remaining_usages' => false,
            'noise_remaining_usages_exclude' => [],
        ],
        'escape_implicit_backslashes' => [
            'double_quoted' => true,
            'heredoc_syntax' => true,
            'single_quoted' => false,
        ],
        'explicit_indirect_variable' => true,
        'explicit_string_variable' => true,
        'final_internal_class' => false,
        'fopen_flag_order' => true,
        'fopen_flags' => true,
        'full_opening_tag' => true,
        'fully_qualified_strict_types' => true,
        'function_declaration' => [
            'closure_function_spacing' => 'one',
        ],
        'function_to_constant' => [
            'functions' => [
                'get_called_class',
                'get_class',
                'php_sapi_name',
                'phpversion',
                'pi'
            ],
        ],
        'function_typehint_space' => true,
        'general_phpdoc_annotation_remove' => [
            'annotations' => [],
        ],
        'header_comment' => false, // TODO: Add header copyright
        'heredoc_to_nowdoc' => true,
        'implode_call' => true,
        'include' => true,
        'increment_style' => [
            'style' => 'post',
        ],
        'is_null' => [
            'use_yoda_style' => false,
        ],
        'line_ending' => true,
        'linebreak_after_opening_tag' => true,
        'list_syntax' => [
            'syntax' => 'short',
        ],
        'logical_operators' => false,
        'lowercase_cast' => true,
        'lowercase_constants' => true,
        'lowercase_keywords' => true,
        'lowercase_static_reference' => true,
        'magic_constant_casing' => true,
        'magic_method_casing' => true,
        'mb_str_functions' => true,
        'method_argument_space' => [
            'keep_multiple_spaces_after_comma' => false,
            'on_multiline' => 'ensure_fully_multiline',
        ],
        'method_chaining_indentation' => true,
        'modernize_types_casting' => true,
        'multiline_comment_opening_closing' => true,
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'no_multi_line',
        ],
        'native_constant_invocation' => false,
        'native_function_casing' => true,
        'native_function_invocation' => false,
        'new_with_braces' => true,
        'no_alias_functions' => [
            'sets' => [
                '@internal',
                '@IMAP',
                '@mbreg',
                '@all'
            ],
        ],
        'no_alternative_syntax' => true,
        'no_binary_string' => true,
        'no_blank_lines_after_class_opening' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_blank_lines_before_namespace' => false,
        'no_break_comment' => [
            'comment_text' => 'no break',
        ],
        'no_closing_tag' => true,
        'no_empty_comment' => true,
        'no_empty_phpdoc' => true,
        'no_empty_statement' => true,
        'no_extra_blank_lines' => [
            'tokens' => [
                'extra',
            ],
        ],
        'no_homoglyph_names' => true,
        'no_leading_import_slash' => true,
        'no_leading_namespace_whitespace' => true,
        'no_mixed_echo_print' => [
            'use' => 'echo',
        ],
        'no_multiline_whitespace_around_double_arrow' => true,
        // 'no_null_property_initialization' => true,
        'no_php4_constructor' => true,
        'no_short_bool_cast' => true,
        'no_short_echo_tag' => true,
        'no_singleline_whitespace_before_semicolons' => true,
        'no_spaces_after_function_name' => true,
        'no_spaces_around_offset' => [
            'positions' => [
                'inside',
                'outside',
            ],
        ],
        'no_spaces_inside_parenthesis' => true,
        'no_superfluous_elseif' => false,
        'no_superfluous_phpdoc_tags' => false,
        'no_trailing_comma_in_list_call' => false,
        'no_trailing_comma_in_singleline_array' => true,
        'no_trailing_whitespace' => true,
        'no_trailing_whitespace_in_comment' => true,
        'no_unneeded_control_parentheses' => [
            'statements' => [
                'break',
                'clone',
                'continue',
                'echo_print',
                'return',
                'switch_case',
                'yield',
            ],
        ],
        'no_unneeded_curly_braces' => true,
        'no_unneeded_final_method' => true,
        'no_unreachable_default_argument_value' => false,
        'no_unset_on_property' => true,
        'no_unused_imports' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'no_whitespace_before_comma_in_array' => true,
        'no_whitespace_in_blank_line' => true,
        'non_printable_character' => [
            'use_escape_sequences_in_strings' => true,
        ],
        'normalize_index_brace' => true,
        'not_operator_with_space' => false,
        'not_operator_with_successor_space' => false,
        'object_operator_without_whitespace' => true,
        'ordered_class_elements' => [
            'sortAlgorithm' => 'alpha',
            'order' => [
                'use_trait',

                'constant',
                'constant_public',
                'constant_protected',
                'constant_private',

                'property_static',
                'property_public_static',
                'property',
                'property_public',
                'property_protected_static',
                'property_protected',
                'property_private_static',
                'property_private',

                'construct',

                'method_public_static',
                'method',
                'method_public',
                'method_protected_static',
                'method_protected',
                'method_private_static',
                'method_private',

                'magic',
                'destruct',
                'phpunit'
            ],
        ],
        'ordered_imports' => [
            'imports_order' => [
                \PhpCsFixer\Fixer\Import\OrderedImportsFixer::IMPORT_TYPE_CLASS,
                \PhpCsFixer\Fixer\Import\OrderedImportsFixer::IMPORT_TYPE_CONST,
                \PhpCsFixer\Fixer\Import\OrderedImportsFixer::IMPORT_TYPE_FUNCTION
            ],
            'sort_algorithm' => \PhpCsFixer\Fixer\Import\OrderedImportsFixer::SORT_ALPHA,
        ],
        // TODO: Add PHPUnit fixers
        'phpdoc_add_missing_param_annotation' => [
            'only_untyped' => false,
        ],
        'phpdoc_align' => [
            'align' => 'vertical',
            'tags' => [
                'param',
                'return',
                'throws',
                'type',
                'var',
            ],
        ],
        'phpdoc_annotation_without_dot' => true,
        'phpdoc_indent' => true,
        'phpdoc_inline_tag' => true,
        'phpdoc_no_access' => true,
        'phpdoc_no_alias_tag' => true, // it's array, use defaults
        'phpdoc_no_empty_return' => true,
        'phpdoc_no_package' => true,
        'phpdoc_no_useless_inheritdoc' => true,
        'phpdoc_order' => true,
        'phpdoc_return_self_reference' => true, // it's array, use defaults
        'phpdoc_scalar' => true, // it's array, use defaults
        'phpdoc_separation' => true,
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_summary' => true,
        'phpdoc_to_comment' => true,
        // 'phpdoc_to_return_type' => true,
        'phpdoc_trim' => true,
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'phpdoc_types' => true,
        // 'phpdoc_types_order'
        'phpdoc_var_without_name' => true,
        'pow_to_exponentiation' => true,
        'protected_to_private' => false,
        'psr0' => false,
        'psr4' => true,
        'random_api_migration' => true,
        'return_assignment' => false,
        'return_type_declaration' => [
            'space_before' => 'none',
        ],
        'self_accessor' => true,
        'semicolon_after_instruction' => true,
        'set_type_to_cast' => true,
        'short_scalar_cast' => true,
        'simplified_null_return' => false,
        'single_blank_line_at_eof' => true,
        'single_blank_line_before_namespace' => true,
        'single_class_element_per_statement' => true, // use defaults
        'single_import_per_statement' => true,
        'single_line_after_imports' => true,
        'single_line_comment_style' => true, // use defaults
        'single_quote' => [
            'strings_containing_single_quote_chars' => true,
        ],
        'space_after_semicolon' => [
            'remove_in_empty_for_expressions' => true,
        ],
        'standardize_increment' => true,
        'standardize_not_equals' => true,
        'static_lambda' => false,
        'strict_comparison' => true,
        // 'strict_param' => true, // TODO: Enable this
        'string_line_ending' => true,
        'switch_case_semicolon_to_colon' => true,
        'switch_case_space' => true,
        'ternary_operator_spaces' => true,
        'ternary_to_null_coalescing' => true,
        'trailing_comma_in_multiline_array' => true,
        'trim_array_spaces' => true,
        'unary_operator_spaces' => true,
        'visibility_required' => [
            'property',
            'method',
            'const',
        ],
        'void_return' => true,
        'whitespace_after_comma_in_array' => true,
        'yoda_style' => false,
    ])
    ->setFinder($finder)
    ;
