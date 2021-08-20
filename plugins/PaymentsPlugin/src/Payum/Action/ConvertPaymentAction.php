<?php

declare(strict_types=1);

namespace EonX\PaymentsPlugin\Payum\Action;

use Payum\Core\Model\PaymentInterface;
use Payum\Core\Request\Convert;

final class ConvertPaymentAction extends AbstractAction
{
    public function supports($request): bool
    {
        return $request instanceof Convert
            && $request->getSource() instanceof PaymentInterface
            && $request->getTo() == 'array';
    }

    /**
     * @param \Payum\Core\Request\Convert $request
     */
    protected function doExecute($request): void
    {
        $details = $this->ensureArrayObject($request->getSource()->getDetails());

        // TODO: Implement convert logic...

        $request->setResult((array)$details);
    }
}
