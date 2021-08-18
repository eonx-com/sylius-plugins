<?php
declare(strict_types=1);

namespace EonX\PaymentsPlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class PaymentsPlugin extends Bundle
{
    use SyliusPluginTrait;
}
