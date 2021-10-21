<?php

namespace GoDaddy\WordPress\MWC\Core\Payments\Poynt\Http\Adapters;

use Exception;
use GoDaddy\WordPress\MWC\Common\DataSources\Contracts\DataSourceAdapterContract;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use GoDaddy\WordPress\MWC\Common\Http\Response;
use GoDaddy\WordPress\MWC\Core\Payments\Poynt\Http\VoidTransactionRequest;
use GoDaddy\WordPress\MWC\Payments\Models\Transactions\Statuses\ApprovedTransactionStatus;
use GoDaddy\WordPress\MWC\Payments\Models\Transactions\Statuses\DeclinedTransactionStatus;
use GoDaddy\WordPress\MWC\Payments\Models\Transactions\VoidTransaction;

/**
 * The void transaction adapter.
 *
 * @since 2.10.0
 */
class VoidTransactionAdapter implements DataSourceAdapterContract
{
    /** @var string voided response status */
    const RESPONSE_STATUS_VOIDED = 'VOIDED';

    /** @var VoidTransaction */
    protected $source;

    /**
     * Void transaction adapter constructor.
     *
     * @since 2.10.0
     *
     * @param VoidTransaction $transaction
     */
    public function __construct(VoidTransaction $transaction)
    {
        $this->source = $transaction;
    }

    /**
     * Converts a void transaction to a void transaction request.
     *
     * @since 2.10.0
     *
     * @return VoidTransactionRequest
     * @throws Exception
     */
    public function convertFromSource() : VoidTransactionRequest
    {
        return new VoidTransactionRequest($this->source->getRemoteParentId());
    }

    /**
     * Converts an HTTP response to a void transaction.
     *
     * @since 2.10.0
     *
     * @param Response|null $response
     * @return VoidTransaction
     */
    public function convertToSource(Response $response = null) : VoidTransaction
    {
        if (is_null($response)) {
            return $this->source;
        }

        $responseBody = $response->getBody() ?? [];

        $this->source->setResultCode((string) ArrayHelper::get($responseBody, 'processorResponse.statusCode', ''));

        if ($message = (string) ArrayHelper::get($responseBody, 'processorResponse.statusMessage', '')) {
            $this->source->setResultMessage($message);
        } else {
            $this->source->setResultMessage((string) ArrayHelper::get($responseBody, 'message', ''));
        }

        $this->source->setRemoteId((string) ArrayHelper::get($responseBody, 'id', ''));

        if (self::RESPONSE_STATUS_VOIDED === ArrayHelper::get($responseBody, 'status')) {
            $this->source->setStatus(new ApprovedTransactionStatus());
        } else {
            $this->source->setstatus(new DeclinedTransactionStatus());
        }

        return $this->source;
    }
}
