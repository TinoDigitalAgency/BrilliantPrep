<?php

namespace GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\API\Controllers;

use Exception;
use GoDaddy\WordPress\MWC\Common\Components\Contracts\ComponentContract;
use GoDaddy\WordPress\MWC\Common\Configuration\Configuration;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use GoDaddy\WordPress\MWC\Common\Helpers\StringHelper;
use GoDaddy\WordPress\MWC\Common\Settings\Contracts\ConfigurableContract;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Contracts\EmailNotificationContract;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\DataStores\EmailNotificationDataStore;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\DataStores\OptionsSettingsDataStore;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\EmailNotifications;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Exceptions\EmailNotificationNotFoundException;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Settings\GeneralSettings;
use GoDaddy\WordPress\MWC\Dashboard\API\Controllers\AbstractController;
use InvalidArgumentException;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

/**
 * Email notifications API handler.
 */
class EmailNotificationsController extends AbstractController implements ComponentContract
{
    /** @var string */
    protected $route = 'email-notifications';

    /**
     * Initializes the controller.
     */
    public function load()
    {
        $this->registerRoutes();
    }

    /**
     * Registers the API routes for the endpoints provided by the controller.
     */
    public function registerRoutes()
    {
        register_rest_route($this->namespace, '/'.$this->route, [
            [
                'methods' => 'GET',
                'callback' => [$this, 'getItems'],
                'permission_callback' => [$this, 'getItemsPermissionsCheck'],
            ],
            [
                'methods' => 'PUT',
                'callback' => [$this, 'updateGeneralSettings'],
                'permission_callback' => [$this, 'updateItemPermissionsCheck'],
            ],
        ]);

        register_rest_route($this->namespace, "/{$this->route}/(?!categories$)(?P<emailNotificationId>[a-zA-Z0-9_-]+)", [
            [
                'methods' => 'GET',
                'callback' => [$this, 'getItem'],
                'permission_callback' => [$this, 'getItemsPermissionsCheck'],
            ],
            [
                'methods' => 'PUT',
                'callback' => [$this, 'updateItem'],
                'permission_callback' => [$this, 'updateItemPermissionsCheck'],
            ],
        ]);

        register_rest_route($this->namespace, "/{$this->route}/(?P<emailNotificationId>[a-zA-Z0-9_-]+)/reset", [
            [
                'methods' => 'POST',
                'callback' => [$this, 'resetItem'],
                'permission_callback' => [$this, 'updateItemPermissionsCheck'],
            ],
        ]);

        register_rest_route($this->namespace, '/'.$this->route.'/categories', [
            [
                'methods' => 'GET',
                'callback' => [$this, 'getCategories'],
                'permission_callback' => [$this, 'getItemsPermissionsCheck'],
            ],
        ]);
    }

    /**
     * Gets a list of email notifications.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response|WP_Error
     * @throws Exception
     */
    public function getItems(WP_REST_Request $request)
    {
        $emailNotifications = $this->getEmailNotificationDataStore()->all();

        if ($query = $request->get_param('query')) {
            $query = json_decode($query, true);
            if ($categories = $this->getFilterCategories($query)) {
                $emailNotifications = $this->filterItems($emailNotifications, $categories);
            }
        }

        return rest_ensure_response(['emailNotifications' => $this->prepareItems($emailNotifications)]);
    }

    /**
     * Gets an email notification.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response|WP_Error
     * @throws Exception
     */
    public function getItem(WP_REST_Request $request)
    {
        try {
            $emailNotification = $this->getEmailNotificationDataStore()->read(StringHelper::sanitize($request->get_param('emailNotificationId')));

            $response = ['emailNotification' => $this->prepareItem($emailNotification)];
        } catch (EmailNotificationNotFoundException $exception) {
            $response = new WP_Error($exception->getCode(), $exception->getMessage(), [
                'status' => $exception->getCode(),
            ]);
        }

        return rest_ensure_response($response);
    }

    /**
     * Gets a list of email notification categories.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response|WP_Error
     * @throws Exception
     */
    public function getCategories(WP_REST_Request $request)
    {
        $categories = [];

        foreach (EmailNotifications::getCategories() as $identifier => $label) {
            $categories[] = [
                'id'   => $identifier,
                'name' => $label,
            ];
        }

        return rest_ensure_response(['categories' => $categories]);
    }

    /**
     * Gets an instance of the email notifications data store.
     *
     * @return EmailNotificationDataStore
     */
    protected function getEmailNotificationDataStore() : EmailNotificationDataStore
    {
        return new EmailNotificationDataStore();
    }

    /**
     * Gets an array of arrays with data representing the given email notification objects.
     *
     * @param EmailNotificationContract[] $emailNotifications email notification objects
     * @return array
     */
    protected function prepareItems(array $emailNotifications) : array
    {
        return array_map(function (EmailNotificationContract $emailNotification) {
            return $this->prepareItem($emailNotification);
        }, $emailNotifications);
    }

    /**
     * Gets an array with data representing the given email notification object.
     *
     * @param EmailNotificationContract $emailNotification email notification object
     * @return array
     */
    protected function prepareItem(EmailNotificationContract $emailNotification) : array
    {
        return [
            'id'                    => $emailNotification->getId(),
            'name'                  => $emailNotification->getName(),
            'label'                 => $emailNotification->getLabel(),
            'description'           => $emailNotification->getDescription(),
            'template'              => $emailNotification->getTemplate() ? $emailNotification->getTemplate()->getId() : null,
            'categories'            => $emailNotification->getCategories(),
            'status'                => $emailNotification->isEnabled() ? 'enabled' : 'disabled',
            'isManual'              => $emailNotification->isManual(),
            'isSentToAdministrator' => $emailNotification->isSentToAdministrator(),
            'placeholders'          => $emailNotification->getPlaceholders(),
        ];
    }

    /**
     * Updates the general email notification settings.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response|WP_Error
     */
    public function updateGeneralSettings(WP_REST_Request $request)
    {
        try {
            $settings = ArrayHelper::wrap($request->get_param('settings'));

            if (empty($settings)) {
                throw new Exception(__('The settings parameter is required.', 'mwc-core'), 400);
            }

            $this->toggleFeatureEnabledSetting($settings);
            $this->updateGeneralSettingsGroup($settings);

            return rest_ensure_response(null);
        } catch (Exception $exception) {
            return $this->getSettingsUpdateError($exception->getMessage(), $exception->getCode() ?: 400);
        }
    }

    /**
     * Updates and returns the general settings group.
     *
     * @param array $settings
     * @return GeneralSettings|ConfigurableContract
     * @throws Exception
     */
    protected function updateGeneralSettingsGroup(array $settings) : GeneralSettings
    {
        $settingsGroup = new GeneralSettings();

        // update the sender address setting value if it comes through sanitized
        if ($senderAddress = StringHelper::sanitize(ArrayHelper::get($settings, 'sender_address', ''))) {
            // TODO: update to GeneralSettings::updateSettingValue when email types are accepted {@cwiseman 2021-09-13}
            $settingsGroup->getSetting(GeneralSettings::SETTING_ID_SENDER_ADDRESS)->setValue($senderAddress);
        }

        // update the sender name setting value if it comes through sanitized
        if ($senderName = StringHelper::sanitize(ArrayHelper::get($settings, 'sender_name', ''))) {
            $settingsGroup->updateSettingValue(GeneralSettings::SETTING_ID_SENDER_NAME, $senderName);
        }

        return $this->getGeneralSettingsDataStore()->save($settingsGroup);
    }

    /**
     * Updates the feature to enabled or disabled.
     *
     * This is not an exposed setting, but the email notifications can be toggled with a PUT settings request containing an `enabled=yes|no` value
     * @see EmailNotificationsController::updateGeneralSettings()
     *
     * @param array $settings
     * @throws Exception
     */
    protected function toggleFeatureEnabledSetting(array $settings)
    {
        $enable = ArrayHelper::get($settings, 'enabled', null);

        if (true === $enable) {
            update_option('mwc_email_notifications_enabled', 'yes');
            Configuration::set('email_notifications.enabled', true);
        } elseif (false === $enable) {
            update_option('mwc_email_notifications_enabled', 'no');
            Configuration::set('email_notifications.enabled', false);
        }
    }

    /**
     * Gets the general settings group object.
     *
     * TODO: switch to using the SettingsDataStore when it exists {@cwiseman 2021-09-13}
     *
     * @return OptionsSettingsDataStore
     */
    protected function getGeneralSettingsDataStore() : OptionsSettingsDataStore
    {
        return new OptionsSettingsDataStore('mwc_email_notifications_{{setting_id}}');
    }

    /**
     * Updates an email notification's settings.
     *
     * @param WP_REST_Request $request
     *
     * @return WP_REST_Response|WP_Error
     * @throws Exception
     */
    public function updateItem(WP_REST_Request $request)
    {
        try {
            $settings = ArrayHelper::wrap($request->get_param('settings'));

            if (empty($settings)) {
                throw new InvalidArgumentException(__('The settings parameter is required.', 'mwc-core'), 400);
            }

            $emailNotification = $this->getEmailNotificationDataStore()->read(StringHelper::sanitize($request->get_param('emailNotificationId')));

            $this->updateEmailNotificationSettings($emailNotification, $settings);

            $response = ['emailNotification' => $this->prepareItem($emailNotification)];

            // TODO: combine these to catch statements when PHP 7.1 is required {@cwiseman 2021-09-14}
        } catch (EmailNotificationNotFoundException $exception) {
            $response = $this->getSettingsUpdateError($exception->getMessage(), $exception->getCode());
        } catch (InvalidArgumentException $exception) {
            $response = $this->getSettingsUpdateError($exception->getMessage(), $exception->getCode() ?: 400);
        }

        return rest_ensure_response($response);
    }

    /**
     * Resets an email notification's settings to defaults.
     *
     * @param WP_REST_Request $request
     *
     * @return ''
     * @throws Exception
     */
    public function resetItem(WP_REST_Request $request)
    {
        try {
            $emailNotification = $this->getEmailNotificationDataStore()->read(StringHelper::sanitize($request->get_param('emailNotificationId')));

            // Update email notification settings to defaults
            foreach ($emailNotification->getSettings() as $setting) {
                if ($setting->getDefault()) {
                    $emailNotification->updateSettingValue($setting->getId(), $setting->getDefault());
                }
            }

            // Update email content settings to defaults
            if ($emailContent = $emailNotification->getContent()) {
                foreach ($emailContent->getSettings() as $setting) {
                    if ($setting->getDefault()) {
                        $emailContent->updateSettingValue($setting->getId(), $setting->getDefault());
                    }
                }
            }

            $this->getEmailNotificationDataStore()->save($emailNotification);

            // Return empty response if successful
            $response = null;
        } catch (EmailNotificationNotFoundException $exception) {
            $response = $this->getSettingsUpdateError($exception->getMessage(), $exception->getCode());
        } catch (InvalidArgumentException $exception) {
            $response = $this->getSettingsUpdateError($exception->getMessage(), $exception->getCode() ?: 400);
        }

        return rest_ensure_response($response);
    }

    /**
     * Updates the given email notification's settings with the given values.
     *
     * This loops through the given settings and first attempts to update a setting on the notification object for each
     * key. If the notification object does not have a matching setting, then the same is attempted on the content object.
     * If neither have a matching setting, the InvalidArgumentException is allowed through.
     *
     * @param EmailNotificationContract $emailNotification
     * @param array                     $settings
     * @return EmailNotificationContract
     * @throws InvalidArgumentException
     */
    protected function updateEmailNotificationSettings(EmailNotificationContract $emailNotification, array $settings) : EmailNotificationContract
    {
        foreach ($settings as $settingId => $settingValue) {
            $settingId = StringHelper::sanitize($settingId);
            $settingValue = ArrayHelper::accessible($settingValue) ? array_map(StringHelper::class.'::sanitize', $settingValue) : StringHelper::sanitize($settingValue);

            $this->updateEmailNotificationSetting($emailNotification, $settingId, $settingValue);
        }

        return $this->getEmailNotificationDataStore()->save($emailNotification);
    }

    /**
     * Updates the given notification's setting with the given value.
     *
     * @param EmailNotificationContract $emailNotification
     * @param string $settingId
     * @param mixed $settingValue
     * @return EmailNotificationContract
     */
    protected function updateEmailNotificationSetting(EmailNotificationContract $emailNotification, string $settingId, $settingValue) : EmailNotificationContract
    {
        // first check the content object for a matching setting and bail early if found, after updating
        if (($content = $emailNotification->getContent()) && $this->configurableHasSetting($content, $settingId)) {
            $emailNotification->getContent()->updateSettingValue($settingId, $settingValue);

            return $emailNotification;
        }

        // otherwise, try and update the main notification's setting
        $emailNotification->updateSettingValue($settingId, $settingValue);

        return $emailNotification;
    }

    /**
     * Determines whether the given configurable has a setting with the given setting ID.
     *
     * @param ConfigurableContract $configurable
     * @param string $settingId
     * @return bool
     */
    protected function configurableHasSetting(ConfigurableContract $configurable, string $settingId) : bool
    {
        foreach ($configurable->getSettings() as $setting) {
            if ($settingId === $setting->getId()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Gets the email notification data store.
     *
     * @return EmailNotificationDataStore
     */
    protected function getNotificationDataStore() : EmailNotificationDataStore
    {
        return new EmailNotificationDataStore();
    }

    /**
     * Filters the categories.
     *
     * @internal
     *
     * @param EmailNotificationContract[] $emailNotifications email notification objects
     * @param array $categories
     * @return array $filteredEmailNotifications
     */
    private function filterItems(array $emailNotifications, array $categories) : array
    {
        $filteredEmailNotifications = [];
        foreach ($emailNotifications as $emailNotification) {
            if (count(array_intersect(ArrayHelper::wrap($emailNotification->getCategories()), $categories)) > 0) {
                $filteredEmailNotifications[] = $emailNotification;
            }
        }

        return $filteredEmailNotifications;
    }

    /**
     * Gets the categories from the filters parameter.
     *
     * @internal
     *
     * @param array $query
     * @return array $categories
     */
    private function getFilterCategories(array $query = null) : array
    {
        return ArrayHelper::get($query, 'filters.categories', []);
    }

    /**
     * Gets the WP-style error to return for a failed settings update.
     *
     * @param string $message
     * @param int $statusCode
     * @return WP_Error
     */
    protected function getSettingsUpdateError(string $message, int $statusCode) : WP_Error
    {
        return new WP_Error('mwc_core_email_notifications_update_settings_error', $message, [
            'status' => $statusCode,
        ]);
    }

    /**
     * Gets the schema for REST email notification items provided by the controller.
     *
     * @return array
     */
    public function getItemSchema() : array
    {
        return [
            '$schema' => 'http://json-schema.org/draft-04/schema#',
            'title' => 'emailNotification',
            'type' => 'object',
            'properties' => [
                'id' => [
                    'description' => __('Unique email notification ID.', 'mwc-core'),
                    'type' => 'string',
                    'context' => ['view', 'edit'],
                    'readonly' => true,
                ],
                'name' => [
                    'description' => __('Unique email notification name (matches the ID).', 'mwc-core'),
                    'type' => 'string',
                    'context' => ['view', 'edit'],
                    'readonly' => true,
                ],
                'label' => [
                    'description' => __('Email notification label.', 'mwc-core'),
                    'type' => 'string',
                    'context' => ['view', 'edit'],
                    'readonly' => true,
                ],
                'description' => [
                    'description' => __('Email notification description.', 'mwc-core'),
                    'type' => 'string',
                    'context' => ['view', 'edit'],
                    'readonly' => true,
                ],
                'template' => [
                    'description' => __('ID of the template used by this email notification.', 'mwc-core'),
                    'type' => 'string',
                    'context' => ['view', 'edit'],
                    'readonly' => true,
                ],
                'categories' => [
                    'description' => __('A list of categories that the email notification belongs to.', 'mwc-core'),
                    'type' => 'array',
                    'items' => [
                        'type' => 'string',
                    ],
                    'context' => ['view', 'edit'],
                    'readonly' => true,
                ],
                'status' => [
                    'description' => __('Email notification status', 'mwc-core'),
                    'type' => 'string',
                    'enum' => ['enabled', 'disabled'],
                    'context' => ['view', 'edit'],
                    'readonly' => true,
                ],
                'isManual' => [
                    'description' => __('Whether the email notification can only be sent manually.', 'mwc-core'),
                    'type' => 'boolean',
                    'context' => ['view', 'edit'],
                    'readonly' => true,
                ],
                'isSentToAdministrator' => [
                    'description' => __('Whether the email notification will be sent to administrators.', 'mwc-core'),
                    'type' => 'boolean',
                    'context' => ['view', 'edit'],
                    'readonly' => true,
                ],
                'placeholders' => [
                    'description' => __('A list of placeholders that are available for the email notification.', 'mwc-core'),
                    'type' => 'array',
                    'items' => [
                        'type' => 'string',
                    ],
                    'context' => ['view', 'edit'],
                    'readonly' => true,
                ],
            ],
        ];
    }

    /**
     * Gets the schema for REST email notification categories provided by the controller.
     *
     * @return array
     */
    public function getCategoriesSchema() : array
    {
        return [
            [
                '$schema' => 'http://json-schema.org/draft-04/schema#',
                'title' => 'categories',
                'type' => 'object',
                'properties' => [
                    'id' => [
                        'description' => __('Unique email notification category ID.', 'mwc-core'),
                        'type' => 'string',
                        'context' => ['view', 'edit'],
                        'readonly' => true,
                    ],
                    'name' => [
                        'description' => __('Email notification category name.', 'mwc-core'),
                        'type' => 'string',
                        'context' => ['view', 'edit'],
                        'readonly' => true,
                    ],
                ],
            ],
        ];
    }
}
