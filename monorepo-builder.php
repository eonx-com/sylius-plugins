<?php

declare(strict_types=1);

use EonX\PluginsMonorepo\Release\GenerateReleaseNotesWorker;
use EonX\PluginsMonorepo\Release\PluginsListInReadmeReleaseWorker;
use EonX\PluginsMonorepo\Release\PushNextDevReleaseWorker;
use EonX\PluginsMonorepo\Release\TagVersionReleaseWorker;
use EonX\PluginsMonorepo\Release\UpdateChangelogWorker;
use EonX\PluginsMonorepo\Release\UpdateTagInGithubWorkflow;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\ChangelogLinker\ValueObject\Option as ChangelogLinkerOption;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\AddTagToChangelogReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetCurrentMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetNextMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateBranchAliasReleaseWorker;
use Symplify\MonorepoBuilder\Split\ValueObject\ConvertFormat;
use Symplify\MonorepoBuilder\ValueObject\Option;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set(ChangelogLinkerOption::AUTHORS_TO_IGNORE, ['natepage']);
    $parameters->set(ChangelogLinkerOption::NAMES_TO_URLS, []);
    $parameters->set(ChangelogLinkerOption::PACKAGE_ALIASES, []);
    $parameters->set('env(GITHUB_TOKEN)', null);
    $parameters->set(ChangelogLinkerOption::GITHUB_TOKEN, '%env(GITHUB_TOKEN)%');
    $parameters->set(ChangelogLinkerOption::REPOSITORY_NAME, 'eonx-com/sylius-plugins');
    $parameters->set(ChangelogLinkerOption::REPOSITORY_URL, 'https://github.com/eonx-com/sylius-plugins');

    $parameters->set(Option::DIRECTORIES_TO_REPOSITORIES_CONVERT_FORMAT, ConvertFormat::PASCAL_CASE_TO_KEBAB_CASE);
    $parameters->set(Option::DIRECTORIES_TO_REPOSITORIES, [
        'plugins/*' => 'git@github.com:eonx-com/*.git',
    ]);

    $services = $containerConfigurator->services();
    $services->defaults()
        ->autoconfigure()
        ->autowire()
        ->public();

    $services->load('Symplify\\ChangelogLinker\\', __DIR__ . '/vendor/symplify/changelog-linker/src')
        ->exclude([
            __DIR__ . '/vendor/symplify/changelog-linker/src/HttpKernel',
            __DIR__ . '/vendor/symplify/changelog-linker/src/DependencyInjection/CompilerPass',
            __DIR__ . '/vendor/symplify/changelog-linker/src/Exception',
            __DIR__ . '/vendor/symplify/changelog-linker/src/ValueObject',
        ]);

    $services->set(ClientInterface::class, Client::class);

    # release workers - in order to execute
    $services->set(GenerateReleaseNotesWorker::class);
    $services->set(UpdateChangelogWorker::class);
    $services->set(AddTagToChangelogReleaseWorker::class);
    $services->set(UpdateTagInGithubWorkflow::class);
    $services->set(PluginsListInReadmeReleaseWorker::class);
    $services->set(SetCurrentMutualDependenciesReleaseWorker::class);
    $services->set(TagVersionReleaseWorker::class);
    $services->set(SetNextMutualDependenciesReleaseWorker::class);
    $services->set(UpdateBranchAliasReleaseWorker::class);
    $services->set(PushNextDevReleaseWorker::class);
};
