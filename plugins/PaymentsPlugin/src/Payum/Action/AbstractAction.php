<?php

declare(strict_types=1);

namespace EonX\PaymentsPlugin\Payum\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;

abstract class AbstractAction implements ActionInterface
{
    /**
     * @param mixed $request
     */
    public function execute($request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $this->doExecute($request);
    }

    /**
     * @param mixed $request
     */
    abstract protected function doExecute($request): void;

    /**
     * @param mixed $input
     */
    protected function ensureArrayObject($input): ArrayObject
    {
        return ArrayObject::ensureArrayObject($input);
    }
}
