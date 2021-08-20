<?php

declare(strict_types=1);

namespace EonX\PaymentsPlugin\Payum;

use EonX\PaymentsPlugin\Payum\Action\ConvertPaymentAction;
use EonX\PaymentsPlugin\Payum\Action\StatusAction;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;

final class EonXPaymentsGatewayFactory extends GatewayFactory
{
    /**
     * @var string
     */
    public const FACTORY_NAME = 'eonx_payments';

    /**
     * @var string
     */
    public const FACTORY_TITLE = 'EonX Payments';

    /**
     * @param \Payum\Core\Bridge\Spl\ArrayObject<mixed> $config
     */
    protected function populateConfig(ArrayObject $config): void
    {
        $config->defaults([
            'payum.factory_name' => self::FACTORY_NAME,
            'payum.factory_title' => self::FACTORY_TITLE,

            'payum.action.convert_payment' => new ConvertPaymentAction(),
            'payum.action.status' => new StatusAction(),
        ]);
    }
}
