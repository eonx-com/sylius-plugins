<?php

declare(strict_types=1);

namespace EonX\PaymentsPlugin\Payum\Action;

use ArrayAccess;
use Payum\Core\Request\Capture;

final class CaptureAction extends AbstractAction
{
    public function supports($request): bool
    {
        return $request instanceof Capture && $request->getModel() instanceof ArrayAccess;
    }

    protected function doExecute($request): void
    {
        // TODO: Implement doExecute() method.
    }
}
