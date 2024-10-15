<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\FunctionNotation\FunctionDeclarationFixer;
use PhpCsFixer\Fixer\Operator\NewWithBracesFixer;
use PhpCsFixer\Fixer\Operator\NewWithParenthesesFixer;
use PhpCsFixer\Fixer\Phpdoc\GeneralPhpdocAnnotationRemoveFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withPaths([__DIR__ . '/config', __DIR__ . '/src', __DIR__ . '/tests'])
    ->withPreparedSets(psr12: true, common: true, symplify: true, strict: true, cleanCode: true)
    ->withPhpCsFixerSets(perCS20: true)
    ->withConfiguredRule(FunctionDeclarationFixer::class, [
        'closure_function_spacing' => 'one',
    ])
    ->withSkip([
        __DIR__ . '/src/Commands/stubs',
        GeneralPhpdocAnnotationRemoveFixer::class,
        NewWithParenthesesFixer::class,
        NewWithBracesFixer::class,
    ])
    ->withRootFiles();
