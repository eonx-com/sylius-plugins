<?php

declare(strict_types=1);

use EonX\PaymentsPlugin\ConstantsInterface;
use EonX\PaymentsPlugin\Form\Type\EonXPaymentsGatewayConfigurationType;
use EonX\PaymentsPlugin\Payum\EonXPaymentsGatewayFactory;
use Payum\Core\Bridge\Symfony\Builder\GatewayFactoryBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    // Sylius Admin Form
    $services
        ->set(EonXPaymentsGatewayConfigurationType::class)
        ->tag('sylius.gateway_configuration_type', [
            'type' => EonXPaymentsGatewayFactory::FACTORY_NAME,
            'label' => EonXPaymentsGatewayFactory::FACTORY_TITLE,
        ])
        ->tag('form.type');

    // Payum
    $services
        ->set(ConstantsInterface::SERVICE_GATEWAY_FACTORY_BUILDER, GatewayFactoryBuilder::class)
        ->arg('$gatewayFactoryClass', EonXPaymentsGatewayFactory::class)
        ->tag('payum.gateway_factory_builder', ['factory' => EonXPaymentsGatewayFactory::FACTORY_NAME]);


};
