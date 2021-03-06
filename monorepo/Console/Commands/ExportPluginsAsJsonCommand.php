<?php

declare(strict_types=1);

namespace EonX\PluginsMonorepo\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symplify\SmartFileSystem\Finder\FinderSanitizer;
use Symplify\SmartFileSystem\SmartFileInfo;

final class ExportPluginsAsJsonCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'export-plugins';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $composerFiles = $this->getComposerJsonFiles();
        $packages = [];

        foreach ($composerFiles as $composerFile) {
            $repoName = $this->getRepoShortname($composerFile);

            $packages[$repoName] = [
                'dir' => $this->getDir($composerFile),
                'repo' => $repoName,
            ];
        }

        \ksort($packages);

        // Remove keys
        $noKeys = [];
        foreach ($packages as $package) {
            $noKeys[] = $package;
        }

        $output->write((string)\json_encode($noKeys));

        return 0;
    }

    /**
     * @return \Symplify\SmartFileSystem\SmartFileInfo[]
     */
    private function getComposerJsonFiles(): array
    {
        $finder = (new Finder())
            ->in([__DIR__ . '/../../../plugins'])
            ->name('composer.json');

        return (new FinderSanitizer())->sanitize($finder);
    }

    private function getDir(SmartFileInfo $composerJson): string
    {
        $exploded = \explode('/', $composerJson->getRelativeDirectoryPath());

        return \end($exploded);
    }

    private function getRepoShortname(SmartFileInfo $composerJson): string
    {
        $json = \json_decode($composerJson->getContents(), true);

        return \str_replace('eonx-com/', '', $json['name']);
    }
}
