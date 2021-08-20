<?php

declare(strict_types=1);

namespace EonX\PaymentsPlugin\Tests;

use Symfony\Component\HttpKernel\KernelInterface;

final class PaymentsPluginTest extends AbstractTestCase
{
    public function testSanity(): void
    {
        // Trigger kernel to boot
        $kernel = $this->getKernel();

        self::assertInstanceOf(KernelInterface::class, $kernel);
    }
}
