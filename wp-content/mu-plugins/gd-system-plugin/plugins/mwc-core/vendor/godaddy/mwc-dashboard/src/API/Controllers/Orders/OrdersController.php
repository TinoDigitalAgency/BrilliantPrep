<?php

namespace GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Orders;

use Exception;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use GoDaddy\WordPress\MWC\Common\Http\Response;
use GoDaddy\WordPress\MWC\Dashboard\API\Controllers\AbstractController;
use GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Traits\AdaptsShipmentDataTrait;
use GoDaddy\WordPress\MWC\Dashboard\API\Controllers\Traits\RequiresWooCommercePermissionsTrait;
use GoDaddy\WordPress\MWC\Dashboard\Shipping\DataStores\ShipmentTracking\OrderFulfillmentDataStore;
use GoDaddy\WordPress\MWC\Shipping\Models\Orders\FulfillmentStatuses\FulfilledFulfillmentStatus;
use GoDaddy\WordPress\MWC\Shipping\Models\Orders\OrderFulfillment;
use WP_REST_Request;

/**
 * OrdersController controller class.
 */
class OrdersController extends AbstractController
{
    use AdaptsShipmentDataTrait;
    use RequiresWooCommercePermissionsTrait;

    /**
     * Route.
     *
     * @var string
     */
    protected $route = 'orders';

    /**
     * Registers the API routes for the orders endpoint.
     *
     * @internal
     * @since x.y.z
     */
    public function registerRoutes()
    {
        register_rest_route($this->namespace, "/{$this->route}", [
            [
                'methods'             => 'GET',
                'callback'            => [$this, 'getItems'],
                'permission_callback' => [$this, 'getItemsPermissionsCheck'],
            ],
            'args' => [
                'include' => [
                    'required'          => false,
                    'type'              => 'string',
                    'validate_callback' => 'rest_validate_request_arg',
                    'sanitize_callback' => 'rest_sanitize_request_arg',
                ],
                'query' => [
                    'required'          => false,
                    'type'              => 'string',
                    'validate_callback' => 'rest_validate_request_arg',
                    'sanitize_callback' => 'rest_sanitize_request_arg',
                ],
            ],
            'schema' => [$this, 'getItemSchema'],
        ]);
    }

    /**
     * Gets the schema for REST items provided by the controller.
     *
     * @internal
     * @since x.y.z
     *
     * @return array
     */
    public function getItemSchema() : array
    {
        return [
            '$schema' => 'http://json-schema.org/draft-04/schema#',
            'title'   => 'orders',
            'type'    => 'array',
            'items'   => [
                'type'       => 'object',
                'properties' => [
                    'id'        => [
                        'description' => __('The order ID.', 'mwc-dashboard'),
                        'type'        => 'integer',
                        'context'     => ['view', 'edit'],
                        'readonly'    => true,
                    ],
                    'fulfilled' => [
                        'description' => __('Whether or not the order has been fulfilled.', 'mwc-dashboard'),
                        'type'        => 'bool',
                        'context'     => ['view', 'edit'],
                        'readonly'    => true,
                    ],
                    'shipments' => [
                        'description' => __('The shipments for the order.', 'mwc-dashboard'),
                        'type'        => 'array',
                        'items'       => [
                            'type'       => 'object',
                            'properties' => [
                                'id'               => [
                                    'description' => __('The shipment ID.', 'mwc-dashboard'),
                                    'type'        => 'string',
                                    'context'     => ['view', 'edit'],
                                    'readonly'    => true,
                                ],
                                'orderId'          => [
                                    'description' => __('The order ID.', 'mwc-dashboard'),
                                    'type'        => 'integer',
                                    'context'     => ['view', 'edit'],
                                    'readonly'    => true,
                                ],
                                'createdAt'        => [
                                    'description' => __("The shipment's creation date.", 'mwc-dashboard'),
                                    'type'        => 'string',
                                    'context'     => ['view', 'edit'],
                                    'readonly'    => true,
                                ],
                                'updatedAt'        => [
                                    'description' => __("The shipment's last updated date.", 'mwc-dashboard'),
                                    'type'        => 'string',
                                    'context'     => ['view', 'edit'],
                                    'readonly'    => true,
                                ],
                                'shippingProvider' => [
                                    'description' => __('The shipping provider for the shipment.', 'mwc-dashboard'),
                                    'type'        => 'string',
                                    'context'     => ['view', 'edit'],
                                    'readonly'    => true,
                                ],
                                'trackingNumber'   => [
                                    'description' => __("The shipment's tracking number.", 'mwc-dashboard'),
                                    'type'        => 'string',
                                    'context'     => ['view', 'edit'],
                                    'readonly'    => true,
                                ],
                                'trackingUrl'      => [
                                    'description' => __("The shipment's tracking URL.", 'mwc-dashboard'),
                                    'type'        => 'string',
                                    'context'     => ['view', 'edit'],
                                    'readonly'    => true,
                                ],
                                'items'            => [
                                    'description' => __('The items included in the shipment.', 'mwc-dashboard'),
                                    'type'        => 'array',
                                    'items'       => [
                                        'type'       => 'object',
                                        'properties' => [
                                            'id'          => [
                                                'description' => __("The item's ID.", 'mwc-dashboard'),
                                                'type'        => 'integer',
                                                'context'     => ['view', 'edit'],
                                                'readonly'    => true,
                                            ],
                                            'productId'   => [
                                                'description' => __("The product's ID.", 'mwc-dashboard'),
                                                'type'        => 'integer',
                                                'context'     => ['view', 'edit'],
                                                'readonly'    => true,
                                            ],
                                            'variationId' => [
                                                'description' => __("The product's variation ID.", 'mwc-dashboard'),
                                                'type'        => 'integer',
                                                'context'     => ['view', 'edit'],
                                                'readonly'    => true,
                                            ],
                                            'quantity'    => [
                                                'description' => __("The item's quantity.", 'mwc-dashboard'),
                                                'type'        => 'number',
                                                'context'     => ['view', 'edit'],
                                                'readonly'    => true,
                                            ],
                                        ],
                                    ],
                                    'context'     => ['view', 'edit'],
                                    'readonly'    => true,
                                ],
                            ],
                        ],
                        'context'     => ['view', 'edit'],
                        'readonly'    => true,
                    ],
                ],
            ],
        ];
    }

    /**
     * Sends a REST response with orders.
     *
     * @internal
     * @since x.y.z
     *
     * @param WP_REST_Request $request
     * @return void
     *
     * @throws Exception
     */
    public function getItems(WP_REST_Request $request)
    {
        $orderIds = [];
        $resources = [];

        if (! empty($queryParam = $request->get_param('query'))) {
            $query = json_decode($queryParam, true);
            $orderIds = ArrayHelper::wrap(ArrayHelper::get($query, 'ids'));
            $resources = ArrayHelper::wrap(ArrayHelper::get($query, 'includes'));
        }

        if (empty($orderIds)) {
            $orderIds = wc_get_orders([
                'limit' => 20,
                'orderby' => 'date',
                'order' => 'DESC',
                'return' => 'ids',
            ]);
        }

        $responseData = [];
        $dataStore = new OrderFulfillmentDataStore();

        foreach ($orderIds as $orderId) {
            $fulfillment = $dataStore->read($orderId);

            if ($fulfillment) {
                $responseData[] = $this->prepareItem($fulfillment, $resources);
            }
        }

        (new Response)
            ->body(['orders' => $responseData])
            ->success(200)
            ->send();
    }

    /**
     * Prepares the given order object for API response.
     *
     * @since x.y.z
     *
     * @param OrderFulfillment $fulfillment
     * @param array $resources
     * @return array
     *
     * @throws Exception
     */
    protected function prepareItem(OrderFulfillment $fulfillment, array $resources = []) : array
    {
        $order = $fulfillment->getOrder();

        $itemData = [
            'id' => $order->getId(),
            'fulfilled' => $order->getFulfillmentStatus() instanceof FulfilledFulfillmentStatus,
        ];

        if (ArrayHelper::contains($resources, 'shipments')) {
            $itemData['shipments'] = $this->prepareShipmentItems($fulfillment);
        }

        return $itemData;
    }

    /**
     * Prepares the shipment items in the given fulfillment object for API response.
     *
     * @since x.y.z
     *
     * @param OrderFulfillment $fulfillment
     * @return array
     *
     * @throws Exception
     */
    protected function prepareShipmentItems(OrderFulfillment $fulfillment) : array
    {
        $shipmentData = [];

        foreach ($fulfillment->getShipments() as $shipment) {
            $shipmentData[] = $this->getShipmentData($shipment);
        }

        return $shipmentData;
    }
}
