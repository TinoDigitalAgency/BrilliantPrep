<?php

namespace GoDaddy\WordPress\MWC\Core\WooCommerce\Payments;

use Exception;
use GoDaddy\WordPress\MWC\Common\Configuration\Configuration;
use GoDaddy\WordPress\MWC\Common\Enqueue\Enqueue;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use GoDaddy\WordPress\MWC\Common\Helpers\StringHelper;
use GoDaddy\WordPress\MWC\Common\Register\Register;
use GoDaddy\WordPress\MWC\Common\Repositories\WooCommerce\OrdersRepository;
use GoDaddy\WordPress\MWC\Common\Repositories\WordPressRepository;
use GoDaddy\WordPress\MWC\Core\Payments\Adapters\OrderAdapter;
use GoDaddy\WordPress\MWC\Core\Payments\Models\Orders\Order;
use GoDaddy\WordPress\MWC\Payments\Models\Transactions\CaptureTransaction;
use GoDaddy\WordPress\MWC\Payments\Models\Transactions\Statuses\ApprovedTransactionStatus;
use WC_Order;

/**
 * Captures handler.
 */
class Captures
{
    /** @var string action capture order. */
    const ACTION_CAPTURE_ORDER = 'mwc_payments_capture_order';

    /**
     * Captures constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->registerHooks();

        // TODO: limit loading and handling to Core gateways, if any {@cwiseman 2021-05-16}
    }

    /**
     * Handles capture order ajax request.
     *
     * @since 2.10.0
     */
    public function ajaxCaptureOrder()
    {
        try {
            $nonce = StringHelper::sanitize((string) ArrayHelper::get($_POST, 'nonce'));

            if (! wp_verify_nonce($nonce, static::ACTION_CAPTURE_ORDER)) {
                throw new Exception('Invalid permission.');
            }

            $wooOrder = wc_get_order((int) ArrayHelper::get($_POST, 'orderId'));

            if (! $wooOrder instanceof WC_Order) {
                throw new Exception('Order not found.');
            }

            $results = $this->captureOrder($wooOrder);

            if (! $results->getStatus() instanceof ApprovedTransactionStatus) {
                throw new Exception($results->getResultMessage());
            }

            wp_send_json_success();
        } catch (Exception $exception) {
            wp_send_json_error([
                'message' => 'Order could not be captured. '.$exception->getMessage(),
            ]);
        }
    }

    /**
     * Captures a WooCommerce order.
     *
     * @since 2.10.0
     *
     * @param WC_Order $order
     *
     * @return CaptureTransaction
     * @throws Exception
     */
    protected function captureOrder(WC_Order $order) : CaptureTransaction
    {
        $gateway = ArrayHelper::get(CorePaymentGateways::getPaymentGateways(), $order->get_payment_method(), '');

        if (is_null($gateway) || $gateway === '') {
            throw new Exception('No gateway found for Order');
        }

        // Instantiate a new object if gateway is the class name
        if (is_string($gateway)) {
            $gateway = new $gateway;
        }

        $transaction = $gateway->processCapture($gateway->getTransactionForCapture($order));

        // if the original auth amount has been captured, complete payment
        if (
               $transaction->getStatus() instanceof ApprovedTransactionStatus
            && $transaction->getTotalAmount()
            && $transaction->getOrder()
            && $transaction->getTotalAmount()->getAmount() >= $transaction->getOrder()->getTotalAmount()->getAmount()
        ) {

            // prevent stock from being reduced when payment is completed as this is done when the charge was authorized
            add_filter('woocommerce_payment_complete_reduce_order_stock', '__return_false', 100);

            // complete the order
            $order->payment_complete();
        }

        return $transaction;
    }

    /**
     * Enqueues the scripts.
     *
     * @since 2.10.0
     *
     * @param mixed $hookSuffix
     *
     * @throws Exception
     */
    public function enqueueScripts($hookSuffix)
    {
        if ('post.php' !== $hookSuffix || 'shop_order' !== get_post_type()) {
            return;
        }

        Enqueue::script()
            ->setHandle('mwc-payments-captures')
            ->setSource(WordPressRepository::getAssetsUrl('js/payments/captures.js'))
            ->setDependencies(['jquery'])
            ->execute();
    }

    /**
     * Handle bulk actions.
     *
     * @since 2.10.0
     *
     * @param mixed $redirectTo
     * @param mixed $action
     * @param mixed $ids
     *
     * @return mixed
     */
    public function handleBulkActions($redirectTo, $action, $ids)
    {
        if (static::ACTION_CAPTURE_ORDER === $action) {
            foreach ($ids as $id) {
                if ($order = wc_get_order($id)) {
                    $this->maybeCaptureOrder($order);
                }
            }
        }

        return $redirectTo;
    }

    /**
     * Registers the bulk capture orders action.
     *
     * @since 2.10.0
     *
     * @param $actions
     * @return mixed
     */
    public function maybeAddBulkActions($actions)
    {
        if (ArrayHelper::accessible($actions)) {
            $actions[static::ACTION_CAPTURE_ORDER] = __('Capture Charge', 'mwc-core');
        }

        return $actions;
    }

    /**
     * May add a capture button to order.
     *
     * @since x.y.x
     *
     * @param mixed $order
     */
    public function maybeAddCaptureButton($order)
    {
        if (! $order instanceof WC_Order || 'shop_order' !== get_post_type($order->get_id())) {
            return;
        }

        try {
            $this->renderCaptureButton($order);
        } catch (Exception $exception) {
            // TODO: Sentry logging {@cwiseman 2021-05-16}
        }
    }

    /**
     * May capture paid orders.
     *
     * @since 2.10.0
     *
     * @param mixed $orderId
     * @param mixed $oldStatus
     * @param mixed $newStatus
     */
    public function maybeCapturePaidOrder($orderId, $oldStatus, $newStatus)
    {
        $paidStatuses = OrdersRepository::getPaidStatuses();

        if (ArrayHelper::contains($paidStatuses, $oldStatus) || ! ArrayHelper::contains($paidStatuses, $newStatus)) {
            return;
        }

        if ($order = wc_get_order($orderId)) {

            // only proceed if the feature is enabled
            if (! Configuration::get('payments.'.$order->get_payment_method().'.capturePaidOrders', true)) {
                return;
            }

            $this->maybeCaptureOrder($order);
        }
    }

    /**
     * May capture an order.
     *
     * @since 2.10.0
     *
     * @param WC_Order $order
     * @return bool
     */
    protected function maybeCaptureOrder(WC_Order $order) : bool
    {
        try {
            $paymentGateways = CorePaymentGateways::getPaymentGateways();

            if (! ArrayHelper::has($paymentGateways, $order->get_payment_method())) {
                return false;
            }

            $coreOrder = $this->convertOrder($order);

            if ($coreOrder->isCaptured() || ! $coreOrder->isReadyForCapture()) {
                return false;
            }

            $captureTransaction = $this->captureOrder($order);

            return $captureTransaction->getStatus() instanceof ApprovedTransactionStatus;
        } catch (Exception $exception) {

            // @TODO implement exception handling {@acastro1 2021-05-13}

            return false;
        }
    }

    /**
     * Renders capture payment button for order.
     *
     * @since 2.10.0
     *
     * @param WC_Order $order
     *
     * @throws Exception
     */
    protected function renderCaptureButton(WC_Order $order)
    {
        $coreOrder = $this->convertOrder($order);

        if (! $coreOrder->isReadyForCapture()) {
            return;
        }

        $tooltip = '';
        $buttonClasses = ['button', 'mwc-payments-capture'];

        if ($coreOrder->isCaptured()) {
            $buttonClasses = ArrayHelper::combine($buttonClasses, ['tips', 'disabled']);
            $tooltip = __('This charge has been fully captured', 'mwc-core');
        } else {
            $buttonClasses[] = 'button-primary';
        } ?>
        <button
            type="button"
            class="<?php echo esc_attr(implode(' ', $buttonClasses)); ?> <?php echo $tooltip ? 'data-tip="'.esc_attr($tooltip).'"' : ''; ?>"
        >
            <?php esc_html_e('Capture Charge', 'mwc-core'); ?>
        </button>
        <?php

        wc_enqueue_js(sprintf('window.mwc_payments_captures_handler = new MWCPaymentsCaptureHandler(%s)', ArrayHelper::jsonEncode([
            'action' => static::ACTION_CAPTURE_ORDER,
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce(static::ACTION_CAPTURE_ORDER),
            'orderId' => $coreOrder->getId(),
            'i18n' => [
                'ays' => __('Are you sure you wish to process this capture? The action cannot be undone.', 'mwc-core'),
                'errorMessage' => __('Something went wrong, and the capture could not be completed. Please try again.', 'mwc-core'),
            ],
        ])));
    }

    /**
     * Converts WooCommerce order to native order object.
     *
     * @since 2.10.0
     *
     * @param WC_Order $order
     * @return Order
     * @throws Exception
     */
    protected function convertOrder(WC_Order $order) : Order
    {
        return (new OrderAdapter($order))->convertFromSource();
    }

    /**
     * Register captures actions.
     *
     * @throws Exception
     */
    protected function registerHooks()
    {
        Register::action()
            ->setGroup('admin_enqueue_scripts')
            ->setHandler([$this, 'enqueueScripts'])
            ->execute();

        Register::action()
            ->setGroup('woocommerce_order_status_changed')
            ->setArgumentsCount(3)
            ->setHandler([$this, 'maybeCapturePaidOrder'])
            ->execute();

        Register::filter()
            ->setGroup('handle_bulk_actions-edit-shop_order')
            ->setArgumentsCount(3)
            ->setHandler([$this, 'handleBulkActions'])
            ->execute();

        Register::filter()
            ->setGroup('bulk_actions-edit-shop_order')
            ->setHandler([$this, 'maybeAddBulkActions'])
            ->execute();

        Register::action()
            ->setGroup('wp_ajax_'.static::ACTION_CAPTURE_ORDER)
            ->setHandler([$this, 'ajaxCaptureOrder'])
            ->execute();

        Register::action()
            ->setGroup('woocommerce_order_item_add_action_buttons')
            ->setHandler([$this, 'maybeAddCaptureButton'])
            ->execute();
    }
}
