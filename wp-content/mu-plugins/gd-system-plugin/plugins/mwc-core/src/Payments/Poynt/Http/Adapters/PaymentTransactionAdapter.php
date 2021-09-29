<?php

namespace GoDaddy\WordPress\MWC\Core\Payments\Poynt\Http\Adapters;

use DateTime;
use Exception;
use GoDaddy\WordPress\MWC\Common\Configuration\Configuration;
use GoDaddy\WordPress\MWC\Common\DataSources\Contracts\DataSourceAdapterContract;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use GoDaddy\WordPress\MWC\Common\Helpers\StringHelper;
use GoDaddy\WordPress\MWC\Common\Http\Response;
use GoDaddy\WordPress\MWC\Common\Models\Address;
use GoDaddy\WordPress\MWC\Core\Payments\Models\Orders\Order;
use GoDaddy\WordPress\MWC\Core\Payments\Models\Transactions\PaymentTransaction;
use GoDaddy\WordPress\MWC\Core\Payments\Poynt\Http\ChargeRequest;
use GoDaddy\WordPress\MWC\Payments\Models\Transactions\Statuses\ApprovedTransactionStatus;
use GoDaddy\WordPress\MWC\Payments\Models\Transactions\Statuses\DeclinedTransactionStatus;

/**
 * The payment transaction adapter.
 *
 * @since 2.10.0
 */
class PaymentTransactionAdapter implements DataSourceAdapterContract
{
    /** @var string identifier for authorization payments */
    const PAYMENT_ACTION_AUTHORIZE = 'AUTHORIZE';

    /** @var string identifier for charge payments */
    const PAYMENT_ACTION_CHARGE = 'SALE';

    /** @var string authorized response status */
    const RESPONSE_STATUS_AUTHORIZED = 'AUTHORIZED';

    /** @var string captured response status */
    const RESPONSE_STATUS_CAPTURED = 'CAPTURED';

    /** @var string declined response status */
    const RESPONSE_STATUS_DECLINED = 'DECLINED';

    /** @var PaymentTransaction */
    protected $source;

    /**
     * The payment transaction adapter constructor.
     *
     * @param PaymentTransaction $transaction
     */
    public function __construct(PaymentTransaction $transaction)
    {
        $this->source = $transaction;
    }

    /**
     * Converts a payment transaction to a charge request.
     *
     * @since 2.10.0
     *
     * @return ChargeRequest
     * @throws Exception
     */
    public function convertFromSource() : ChargeRequest
    {
        $transactionTotal = $this->source->getTotalAmount();
        $transactionAmount = $transactionTotal ? $transactionTotal->getAmount() : 0;
        $transactionCurrency = $transactionTotal ? $transactionTotal->getCurrencyCode() : '';
        $paymentMethod = $this->source->getPaymentMethod();
        $paymentMethodId = $paymentMethod ? $paymentMethod->getRemoteId() : '';

        $transactionData = [
            'context'  => [
                'businessId' => Configuration::get('payments.poynt.businessId', ''),
                'sourceApp'  => Configuration::get('payments.poynt.api.source', ''),
            ],
            'amounts'       => [
                'transactionAmount' => $transactionAmount,
                'orderAmount'       => $transactionAmount,
                'currency'          => $transactionCurrency,
            ],
            'emailReceipt' => false,
            'fundingSource' => [
                'cardToken'    => $paymentMethodId,
                'entryDetails' => [
                    'customerPresenceStatus' => 'ECOMMERCE',
                    'entryMode'              => 'KEYED',
                ],
            ],
            'notes'      => $this->source->getNotes() ?? '',
            'references' => [
                [
                    'type'       => 'CUSTOM',
                    'customType' => 'POYNT_COLLECT',
                    'id'         => StringHelper::generateUuid4(),
                ],
            ],
        ];

        /** @var Order $order */
        if ($order = $this->source->getOrder()) {

            $adaptedBillingAddress = $this->getAdaptedAddress($order->getBillingAddress());

            if ($this->hasAdaptedAddress($adaptedBillingAddress)) {
                $transactionData['fundingSource']['verificationData'] = $this->getVerificationData($adaptedBillingAddress);
            }

            $adaptedShippingAddress = $this->getAdaptedAddress($order->getShippingAddress());

            if ($this->hasAdaptedAddress($adaptedShippingAddress)) {
                $transactionData['shippingAddress'] = $adaptedShippingAddress;
            }

            if ($emailAddress = $order->getEmailAddress()) {
                $transactionData['receiptEmailAddress'] = $emailAddress;
            }

            $transactionData['references'][] = [
                'type'       => 'CUSTOM',
                'customType' => 'EXTERNAL_ORDER_ID',
                'id'         => $order->getNumber(),
            ];

            $transactionData['references'][] = [
                'type'       => 'CUSTOM',
                'customType' => 'EXTERNAL_ORDER_URL',
                'id'         => get_admin_url(null, 'post.php?post='.$order->getId().'&action=edit'),
            ];
        }

        $transactionData['action'] = $this->source->isAuthOnly() ? self::PAYMENT_ACTION_AUTHORIZE : self::PAYMENT_ACTION_CHARGE;
        $transactionData['authOnly'] = $this->source->isAuthOnly();
        $transactionData['partialAuthEnabled'] = false;

        return (new ChargeRequest())->body($transactionData);
    }

    /**
     * Gets the verification data.
     *
     * @since 2.14.0
     *
     * @param array $adaptedAddress
     * @return array
     */
    private function getVerificationData(array $adaptedAddress) : array
    {
        return [
            'cardHolderBillingAddress' => $adaptedAddress,
        ];
    }

    /**
     * Converts an address to array format.
     *
     * @since 2.14.0
     *
     * @param Address $address
     * @return array
     */
    private function getAdaptedAddress(Address $address) : array
    {
        $lines = $address->getLines();

        return [
            'line1'       => $lines[0] ?? '',
            'line2'       => $lines[1] ?? '',
            'city'        => $address->getLocality(),
            'territory'   => $address->getAdministrativeDistricts()[0] ?? '',
            'postalCode'  => $address->getPostalCode(),
            'countryCode' => $address->getCountryCode(),
        ];
    }

    /**
     * Determines whether an adapted address is not empty.
     *
     * @since 2.14.0
     *
     * @param array $adaptedAddress
     * @return bool
     */
    private function hasAdaptedAddress(array $adaptedAddress) : bool
    {
        return 0 !== count(array_filter($adaptedAddress));
    }

    /**
     * Converts an HTTP response to a payment transaction.
     *
     * @since 2.10.0
     *
     * @param Response $response
     * @return PaymentTransaction
     * @throws Exception
     */
    public function convertToSource(Response $response = null) : PaymentTransaction
    {
        if (null === $response) {
            return $this->source;
        }

        $responseBody = $response->getBody() ?? [];

        switch (ArrayHelper::get($responseBody, 'status', '')) {
            case self::RESPONSE_STATUS_AUTHORIZED:
                $this->source->setStatus(new ApprovedTransactionStatus());
                $this->source->setAuthOnly(true);
                break;
            case self::RESPONSE_STATUS_CAPTURED:
                $this->source->setStatus(new ApprovedTransactionStatus());
                $this->source->setAuthOnly(false);
                break;
            case self::RESPONSE_STATUS_DECLINED:
            default:
                $this->source->setStatus(new DeclinedTransactionStatus());
                break;
        }

        $this->source->setRemoteId((string) ArrayHelper::get($responseBody, 'id', ''));
        $this->source->setResultCode((string) ArrayHelper::get((array) ArrayHelper::get($responseBody, 'processorResponse', []), 'approvalCode', ''));
        $this->source->setResultMessage((string) ArrayHelper::get((array) ArrayHelper::get($responseBody, 'processorResponse', []), 'statusMessage', ''));

        if ($createdAt = ArrayHelper::get($responseBody, 'createdAt')) {
            $this->source->setCreatedAt(new DateTime((string) $createdAt));
        }
        if ($updatedAt = ArrayHelper::get($responseBody, 'updatedAt')) {
            $this->source->setUpdatedAt(new DateTime((string) $updatedAt));
        }

        return $this->source;
    }
}
