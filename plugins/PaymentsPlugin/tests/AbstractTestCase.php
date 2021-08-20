<?php

declare(strict_types=1);

namespace EonX\PaymentsPlugin\Tests;

use EonX\PaymentsPlugin\Tests\Stubs\KernelStub;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class AbstractTestCase extends TestCase
{
    private ?KernelInterface $kernel = null;

    /**
     * @param null|string[] $configs
     */
    protected function getContainer(?array $configs = null): ContainerInterface
    {
        return $this->getKernel($configs)->getContainer();
    }

    /**
     * @param null|string[] $configs
     */
    protected function getKernel(?array $configs = null): KernelInterface
    {
        if ($this->kernel !== null) {
            return $this->kernel;
        }

        $kernel = new KernelStub($configs);
        $kernel->boot();

        return $this->kernel = $kernel;
    }
}
