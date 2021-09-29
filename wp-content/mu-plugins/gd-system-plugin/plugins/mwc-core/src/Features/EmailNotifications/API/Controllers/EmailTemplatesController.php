<?php

namespace GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\API\Controllers;

use Exception;
use GoDaddy\WordPress\MWC\Common\Components\Contracts\ComponentContract;
use GoDaddy\WordPress\MWC\Common\Helpers\StringHelper;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Contracts\EmailTemplateContract;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\DataStores\EmailTemplateDataStore;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Exceptions\EmailTemplateNotFoundException;
use GoDaddy\WordPress\MWC\Dashboard\API\Controllers\AbstractController;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

/**
 * Email templates API handler.
 *
 * @since x.y.z
 */
class EmailTemplatesController extends AbstractController implements ComponentContract
{
    /** @var string */
    protected $route = 'email-templates';

    /**
     * Initializes the controller.
     *
     * @since x.y.z
     */
    public function load()
    {
        $this->registerRoutes();
    }

    /**
     * Registers the API routes for the endpoints provided by the controller.
     *
     * @since x.y.z
     */
    public function registerRoutes()
    {
        register_rest_route($this->namespace, "/{$this->route}/(?P<emailTemplateId>[a-zA-Z0-9_-]+)", [
            [
                'methods' => 'GET',
                'callback' => [$this, 'getItem'],
                'permission_callback' => [$this, 'getItemsPermissionsCheck'],
            ],
        ]);
    }

    /**
     * Gets an email template.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response|WP_Error
     * @throws Exception
     */
    public function getItem(WP_REST_Request $request)
    {
        try {
            $emailTemplate = $this->getEmailTemplateDataStore()->read(StringHelper::sanitize($request->get_param('emailTemplateId')));

            $response = ['emailTemplate' => $this->prepareItem($emailTemplate)];
        } catch (EmailTemplateNotFoundException $exception) {
            $response = new WP_Error($exception->getCode(), $exception->getMessage(), [
                'status' => $exception->getCode(),
            ]);
        }

        return rest_ensure_response($response);
    }

    /**
     * Gets an instance of the email tempalte data store.
     *
     * @since x.y.z
     *
     * @return EmailTemplateDataStore
     */
    protected function getEmailTemplateDataStore() : EmailTemplateDataStore
    {
        return new EmailTemplateDataStore();
    }

    /**
     * Gets an array with data representing the given email template object.
     *
     * @since x.y.z
     *
     * @param EmailTemplateContract $emailTemplate email notification object
     * @return array
     */
    protected function prepareItem(EmailTemplateContract $emailTemplate) : array
    {
        return [
            'id'                    => $emailTemplate->getId(),
            'name'                  => $emailTemplate->getName(),
            'label'                 => $emailTemplate->getLabel(),
        ];
    }

    /**
     * Gets the schema for REST items provided by the controller.
     *
     * @since x.y.z
     *
     * @return array
     */
    public function getItemSchema() : array
    {
        return [
            '$schema' => 'http://json-schema.org/draft-04/schema#',
            'title' => 'emailTemplate',
            'type' => 'object',
            'properties' => [
                'id' => [
                    'description' => __('Unique email template ID.', 'mwc-core'),
                    'type' => 'string',
                    'context' => ['view', 'edit'],
                    'readonly' => true,
                ],
                'name' => [
                    'description' => __('Unique email template name (matches the ID).', 'mwc-core'),
                    'type' => 'string',
                    'context' => ['view', 'edit'],
                    'readonly' => true,
                ],
                'label' => [
                    'description' => __('Email template label.', 'mwc-core'),
                    'type' => 'string',
                    'context' => ['view', 'edit'],
                    'readonly' => true,
                ],
            ],
        ];
    }
}
