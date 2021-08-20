<?php

declare(strict_types=1);

namespace EonX\PaymentsPlugin\Payum\Action;

use ArrayAccess;
use Payum\Core\Request\GetStatusInterface;

final class StatusAction extends AbstractAction
{
    public function supports($request): bool
    {
        return $request instanceof GetStatusInterface && $request->getModel() instanceof ArrayAccess;
    }

    protected function doExecute($request): void
    {
        // TODO: Implement doExecute() method.
    }
}
