<?php

declare(strict_types=1);

namespace EonX\PaymentsPlugin\Tests;

use EonX\PaymentsPlugin\ConstantsInterface;
use EonX\PaymentsPlugin\Form\Type\EonXPaymentsGatewayConfigurationType;
use Payum\Core\Bridge\Symfony\Builder\GatewayFactoryBuilder;

final class PaymentsPluginTest extends AbstractTestCase
{
    public function testSanity(): void
    {
        $container = $this->getContainer();

        self::assertInstanceOf(
            EonXPaymentsGatewayConfigurationType::class,
            $container->get(EonXPaymentsGatewayConfigurationType::class)
        );

        self::assertInstanceOf(
            GatewayFactoryBuilder::class,
            $container->get(ConstantsInterface::SERVICE_GATEWAY_FACTORY_BUILDER)
        );
    }
}
