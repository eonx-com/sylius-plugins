<?php

declare(strict_types=1);

use EonX\EasyQuality\Sniffs\ControlStructures\NoElseSniff;
use EonX\EasyQuality\Sniffs\ControlStructures\NoNotOperatorSniff;
use EonX\EasyQuality\Sniffs\Namespaces\Psr4Sniff;
use PHP_CodeSniffer\Standards\PSR12\Sniffs\Files\FileHeaderSniff;
use PhpCsFixer\Fixer\CastNotation\CastSpacesFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocVarWithoutNameFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitStrictFixer;
use PhpCsFixer\Fixer\ReturnNotation\ReturnAssignmentFixer;
use PhpCsFixer\Fixer\Whitespace\MethodChainingIndentationFixer;
use SlevomatCodingStandard\Sniffs\Classes\UnusedPrivateElementsSniff;
use SlevomatCodingStandard\Sniffs\Exceptions\ReferenceThrowableOnlySniff;
use SlevomatCodingStandard\Sniffs\TypeHints\NullTypeHintOnLastPositionSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\ParameterTypeHintSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\ReturnTypeHintSniff;
use SlevomatCodingStandard\Sniffs\Variables\UnusedVariableSniff;
use SlevomatCodingStandard\Sniffs\Variables\UselessVariableSniff;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayOpenerNewlineFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\StandaloneLineInMultilineArrayFixer;
use Symplify\CodingStandard\Fixer\Commenting\ParamReturnAndVarTagMalformsFixer;
use Symplify\CodingStandard\Fixer\Commenting\RemoveSuperfluousDocBlockWhitespaceFixer;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\CodingStandard\Fixer\Spacing\MethodChainingNewlineFixer;
use Symplify\CodingStandard\Fixer\Spacing\RemoveSpacingAroundModifierAndConstFixer;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PATHS, [
        __DIR__ . '/plugins',
        __DIR__ . '/changelog-linker.php',
        __DIR__ . '/monorepo-builder.php',
        __DIR__ . '/ecs.php',
    ]);

    $parameters->set(Option::EXCLUDE_PATHS, [
        'plugins/*/var/*php',
        '*/vendor/*.php',
    ]);

    $parameters->set(Option::SETS, [
        SetList::COMMON,
        SetList::CLEAN_CODE,
        SetList::PHP_70,
        SetList::PHP_71,
        SetList::PSR_12,
        SetList::DEAD_CODE,
        SetList::ARRAY,
    ]);

    $parameters->set(Option::SKIP, [
        NotOperatorWithSuccessorSpaceFixer::class => null,
        CastSpacesFixer::class => null,
        OrderedClassElementsFixer::class => null,
        NoSuperfluousPhpdocTagsFixer::class => null,
        PhpdocVarWithoutNameFixer::class => null,
        PhpUnitStrictFixer::class => null,
        BlankLineAfterOpeningTagFixer::class => null,

        MethodChainingIndentationFixer::class => ['*/Configuration.php'],

        MethodChainingNewlineFixer::class => [
            // bug, to be fixed in symplify
            '*/Configuration.php',
        ],
        NullTypeHintOnLastPositionSniff::class . '.NullTypeHintNotOnLastPosition' => null,
        ParameterTypeHintSniff::class . '.MissingAnyTypeHint' => null,
        ReturnTypeHintSniff::class . '.MissingTraversableTypeHintSpecification' => null,
        ParameterTypeHintSniff::class . '.MissingTraversableTypeHintSpecification' => null,
        ReturnTypeHintSniff::class . '.MissingAnyTypeHint' => null,
        ParameterTypeHintSniff::class . '.MissingNativeTypeHint' => [],
        ParameterTypeHintSniff::class . '.UselessAnnotation' => [],
        ReturnTypeHintSniff::class . '.MissingNativeTypeHint' => [],
        ReturnTypeHintSniff::class . '.UselessAnnotation' => [],
        UselessVariableSniff::class . '.UselessVariable' => [],
        UnusedPrivateElementsSniff::class . '.WriteOnlyProperty' => [],
        UnusedVariableSniff::class . '.UnusedVariable' => [],
        ReferenceThrowableOnlySniff::class . '.ReferencedGeneralException' => [],
        ReturnAssignmentFixer::class => [],
    ]);

    $services = $containerConfigurator->services();
    $services->set(FileHeaderSniff::class);

    $services->set(MethodChainingNewlineFixer::class);

    $services->set(YodaStyleFixer::class)
        ->call('configure', [
            [
                'equal' => false,
                'identical' => false,
                'less_and_greater' => false,
            ],
        ]);

    $services->set(NoElseSniff::class);
    $services->set(NoNotOperatorSniff::class);
    $services->set(Psr4Sniff::class);

    // sypmlify rules - see https://github.com/symplify/coding-standard/blob/master/docs/phpcs_fixer_fixers.md
    // arrays
    $services->set(ArrayOpenerNewlineFixer::class);
    $services->set(StandaloneLineInMultilineArrayFixer::class);

    // annotations
    $services->set(ParamReturnAndVarTagMalformsFixer::class);

    // extra spaces
    $services->set(RemoveSuperfluousDocBlockWhitespaceFixer::class);
    $services->set(RemoveSpacingAroundModifierAndConstFixer::class);

    // line length 120
    $services->set(LineLengthFixer::class);
};
