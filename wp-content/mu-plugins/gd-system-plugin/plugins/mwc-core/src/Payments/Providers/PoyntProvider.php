<?php

namespace GoDaddy\WordPress\MWC\Core\Payments\Providers;

use GoDaddy\WordPress\MWC\Core\Payments\Poynt\Gateways\PaymentMethodsGateway;
use GoDaddy\WordPress\MWC\Core\Payments\Poynt\Gateways\TransactionsGateway;
use GoDaddy\WordPress\MWC\Payments\Providers\AbstractProvider;
use GoDaddy\WordPress\MWC\Payments\Traits\HasPaymentMethodsTrait;
use GoDaddy\WordPress\MWC\Payments\Traits\HasTransactionsTrait;

/**
 * Poynt payment method provider.
 *
 * @since 2.10.0
 */
class PoyntProvider extends AbstractProvider
{
    use HasPaymentMethodsTrait;
    use HasTransactionsTrait;

    /** @var string provider label */
    protected $label = 'GoDaddy Payments';

    /** @var string provider name */
    protected $name = 'poynt';

    public function __construct()
    {
        $this->paymentMethodsGateway = PaymentMethodsGateway::class;
        $this->transactionsGateway = TransactionsGateway::class;
    }
}
