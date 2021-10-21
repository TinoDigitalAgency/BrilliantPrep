<?php

namespace GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\DataProviders;

use Exception;
use GoDaddy\WordPress\MWC\Core\Payments\Models\Orders\Order;

/**
 * A provider to handle data for email notification components that represent the hooks that are normally triggered from WooCommerce order email templates.
 *
 * See the admin new order WooCommerce template for hooks that this provider intends to retrieve.
 */
class EmailOrderHooksDataProvider extends OrderDataProvider
{
    /** @var Order|null object to gather data for */
    protected $dataSourceOrder;

    /**
     * Gets order hooks data.
     *
     * @return array
     * @throws Exception
     */
    public function getData() : array
    {
        $placeholders = $this->getHookNames();
        $output = array_flip($placeholders);

        foreach ($placeholders as $placeholder) {
            ob_start();

            do_action(
                $placeholder,
                $this->getWooCommerceOrder($this->dataSourceOrder ?? $this->getOrder()),
                $this->emailNotification->isSentToAdministrator(),
                false,
                $this->emailNotification->getWooCommerceEmail()
            );

            $output[$placeholder] = ob_get_clean();
        }

        return ['internal' => ['custom_components' => $output]];
    }

    /**
     * Gets the name of the email order hooks.
     *
     * @return string[]
     */
    protected function getHookNames() : array
    {
        return [
            'woocommerce_email_order_details',
            'woocommerce_email_customer_details',
            'woocommerce_email_order_meta',
        ];
    }

    /**
     * Gets order hooks preview data.
     *
     * @return array
     * @throws Exception
     */
    public function getPreviewData() : array
    {
        $this->dataSourceOrder = $this->getWooCommerceOrder($this->getPreviewOrder());
        $previewData = $this->getData();
        $this->dataSourceOrder = $this->getOrder();

        return $previewData;
    }

    /**
     * Gets order hooks placeholders.
     *
     * @return string[]
     */
    public function getPlaceholders() : array
    {
        return [];
    }
}
