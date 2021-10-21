<?php

namespace GoDaddy\WordPress\MWC\Core\WooCommerce\Payments\GoDaddyPayments\Frontend\Admin;

use Exception;
use GoDaddy\WordPress\MWC\Common\Configuration\Configuration;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use GoDaddy\WordPress\MWC\Common\Helpers\StringHelper;
use GoDaddy\WordPress\MWC\Common\Http\Response;
use GoDaddy\WordPress\MWC\Common\Models\User;
use GoDaddy\WordPress\MWC\Common\Register\Register;
use GoDaddy\WordPress\MWC\Common\Repositories\ManagedWooCommerceRepository;
use GoDaddy\WordPress\MWC\Core\Payments\Poynt;
use GoDaddy\WordPress\MWC\Core\Payments\Poynt\Onboarding;
use GoDaddy\WordPress\MWC\Core\WooCommerce\Payments\Events\Producers\OnboardingEventsProducer;

/**
 * Class Notices.
 *
 * TODO: consider converting this class into a general notice handler (rendering and Ajax) for core notices {@wvega 2021-05-28}
 */
class Notices
{
    /** @var string action used to dismiss a notice */
    const ACTION_DISMISS_NOTICE = 'mwc_dismiss_notice';

    /** @var string path for the GoDaddy Payments plugin */
    const GODADDY_PAYMENTS_PLUGIN_PATH = 'godaddy-payments/godaddy-payments.php';

    /** @var array registered admin notices */
    protected $notices = [];

    /**
     * Notices constructor.
     */
    public function __construct()
    {
        $this->registerHooks();
    }

    /**
     * Adds a notice for display.
     *
     * @param array $data
     */
    protected function registerNotice(array $data)
    {
        if (empty($data['id'])) {
            return;
        }

        $this->notices[$data['id']] = $data;
    }

    /**
     * Registers the notices that should be displayed.
     *
     * TODO: this method definitely needs to be broken up, and hopefully removed if we reactify these notices {@cwiseman 2021-05-24}
     */
    public function registerNotices()
    {
        // only an error notice if beginning onboarding fails
        if (ArrayHelper::get($_GET, 'onboardingError')) {
            $this->registerNotice([
                'dismissible' => true,
                'id'          => 'mwc-payments-godaddy-onboarding-error',
                'message'     => __('There was an error connecting to GoDaddy Payments. Please try again.', 'mwc-core'),
                'type'        => 'error',
            ]);

            return;
        }

        $status = Onboarding::getStatus();

        switch ($status) {

            case Onboarding::STATUS_CONNECTED:
                if ($this->isGatewayEnabled()) {
                    $message = sprintf(
                        __('%1$sGoDaddy Payments successfully enabled!%2$s GoDaddy Payments is now available to your customers at checkout.', 'mwc-core'),
                        '<strong>', '</strong>'
                    );
                } else {
                    $message = sprintf(
                        __('%1$sGoDaddy Payments is now connected to your store!%2$s Enable the payment method to add it to your checkout. %3$sEnable GoDaddy Payments%4$s', 'mwc-core'),
                        '<strong>', '</strong>',
                        '<a href="'.esc_url(OnboardingEventsProducer::getEnablePaymentMethodUrl()).'">', '</a>'
                    );
                }
                $id = 'connected';
                $type = 'success';
                break;

            case Onboarding::STATUS_DISCONNECTED:
                $message = sprintf(
                    __('%1$sYour GoDaddy Payments account has been closed.%2$s The payment method has been disabled so it will not appear on your checkout. Please set up your account to resume processing payments.', 'mwc-core'),
                    '<strong>', '</strong>'
                );
                $id = 'disconnected';
                $type = 'success';
                break;

            case Onboarding::STATUS_INCOMPLETE:
                $message = sprintf(
                    __('%1$sIt looks like you didn\'t finish your GoDaddy Payments application. You\'re just a few minutes from processing payments.%2$s %3$sResume%4$s', 'mwc-core'),
                    '<strong>', '</strong>',
                    '<a href="'.esc_url(OnboardingEventsProducer::getOnboardingStartUrl('admin_notice_resume_link')).'">', '</a>'
                );
                $id = 'incomplete';
                $type = 'success';
                break;

            case Onboarding::STATUS_SUSPENDED:
                $message = sprintf(
                    __('%1$sYour GoDaddy Payments account needs attention.%2$s The payment method has been disabled so it will not appear on your checkout. Please check your email for next steps.', 'mwc-core'),
                    '<strong>', '</strong>'
                );
                $id = 'suspended';
                $type = 'warning';
                break;

            case Onboarding::STATUS_TERMINATED:
                $message = sprintf(
                    __('%1$sYour GoDaddy Payments account has been terminated.%2$s The payment method has been disabled so it will not appear on your checkout. Please check your email for more information.', 'mwc-core'),
                    '<strong>', '</strong>'
                );
                $id = 'terminated';
                $type = 'error';
                break;
        }

        if (! empty($message)) {
            $this->registerNotice([
                'dismissible' => true,
                'id'          => "mwc-payments-godaddy-{$id}",
                'message'     => $message,
                'type'        => $type,
            ]);
        }

        if (
            ! Configuration::get('payments.poynt.onboarding.hasBankAccount', false)
            && Configuration::get('payments.poynt.onboarding.hasFirstPayment', false)
            && Configuration::get('payments.poynt.onboarding.depositsEnabled')
        ) {
            $this->registerNotice([
                'dismissible' => false,
                'id'          => 'mwc-payments-godaddy-link-bank-account',
                'message'     => sprintf(
                    __('Congratulations! To receive your payouts, please link your bank account to GoDaddy Payments. %1$sLink Bank Account%2$s', 'mwc-core'),
                    '<a href="'.esc_url(add_query_arg([
                        'businessId' => Poynt::getBusinessId(),
                        'openBankAccount' => 'true',
                    ], Poynt::getHubUrl())).'">', '</a>'
                ),
                'type' => 'success',
            ]);
        }

        $this->registerPoyntPluginNotices();

        // remaining notices only display if the gateway is connected & enabled
        if (! $this->isGatewayEnabled() || ! Onboarding::canEnablePaymentGateway(Onboarding::getStatus())) {
            return;
        }

        if ('US' !== WC()->countries->get_base_country()) {
            $this->registerNotice([
                'dismissible' => false,
                'id'          => 'mwc-payments-godaddy-non-us',
                'message'     => sprintf(
                    __('GoDaddy Payments is available for United States-based businesses. Please %1$supdate your Store Address%2$s if you are in the U.S.', 'mwc-core'),
                    '<a href="'.esc_url(admin_url('admin.php?page=wc-settings')).'">', '</a>'
                ),
                'type' => 'warning',
            ]);
        }

        if ('USD' !== get_woocommerce_currency()) {
            $this->registerNotice([
                'dismissible' => false,
                'id'          => 'mwc-payments-godaddy-non-usd',
                'message'     => sprintf(
                    __('GoDaddy Payments requires U.S. dollar transactions. Please %1$schange your Currency%2$s in order to use the payment method.', 'mwc-core'),
                    '<a href="'.esc_url(admin_url('admin.php?page=wc-settings')).'">', '</a>'
                ),
                'type' => 'warning',
            ]);
        }

        if (ManagedWooCommerceRepository::isStagingEnvironment()) {
            $this->registerNotice([
                'dismissible' => true,
                'id'          => 'mwc-payments-godaddy-staging',
                'message'     => __('WooCommerce charges or authorizations/captures as well as refunds and voids made in your Staging site will process normally in your GoDaddy Payments account.', 'mwc-core'),
                'type'        => 'warning',
            ]);
        }
    }

    /**
     * Determins whether the GoDaddy Payments gateway is enabled.
     *
     * We need to check the configuration value when the notices are being registered to make sure
     * we catch the new settings values after the form in the settings page is saved.
     *
     * @return bool
     */
    protected function isGatewayEnabled() : bool
    {
        // TODO: update the provider name if we rename poynt to godaddy-payments or something else {@wvega 2021-05-29}
        return Configuration::get('payments.poynt.enabled', false);
    }

    /**
     * Register admin notices that should be rendered if the Poynt plugin is active.
     */
    protected function registerPoyntPluginNotices()
    {
        if (! $this->isPluginActive(static::GODADDY_PAYMENTS_PLUGIN_PATH)) {
            return;
        }

        $this->registerNotice([
            'dismissible' => true,
            'id'          => 'mwc-payments-godaddy-payments-already-included',
            'message'     => sprintf(
                __('GoDaddy Payments (Poynt) is included for Managed WordPress customers without a separate plugin! Go to %1$sPayments settings%2$s to enable it.', 'mwc-core'),
                '<a href="'.esc_url(admin_url('admin.php?page=wc-settings&tab=checkout')).'">', '</a>'
            ),
            'type'        => 'info',
        ]);
    }

    /**
     * Determines whether the given plugin is active.
     *
     * TODO: add this method to the WordPressRepository or make it possible to create PluginExtension objects from installed (non-managed) plugins {@wvega 2021-06-03}
     *
     * @param string path to the plugin file relative to the plugins directory
     *
     * @return bool
     */
    protected function isPluginActive(string $path) : bool
    {
        return is_plugin_active($path);
    }

    /**
     * Registers the hooks.
     */
    protected function registerHooks()
    {
        Register::action()
            ->setGroup('admin_init')
            ->setHandler([$this, 'registerNotices'])
            ->execute();

        Register::action()
            ->setGroup('admin_notices')
            ->setHandler([$this, 'renderNotices'])
            ->execute();

        Register::action()
            ->setGroup('wp_ajax_'.static::ACTION_DISMISS_NOTICE)
            ->setHandler([$this, 'handleDismissNoticeRequest'])
            ->execute();
    }

    /**
     * Renders the notices.
     */
    public function renderNotices()
    {
        if (! $user = User::getCurrent()) {
            return;
        }

        foreach ($this->notices as $data) {
            if (! $this->shouldRenderNotice($user, $data)) {
                continue;
            }

            $this->renderNotice($data);
        }
    }

    /**
     * Determines whether a notice should be rendered for the given user.
     *
     * @param User $user a user object
     * @param array $data notice data
     *
     * @return bool
     */
    public function shouldRenderNotice(User $user, array $data) : bool
    {
        return ! ArrayHelper::get($data, 'dismissible', true) || ! $this->isNoticeDismissed($user, ArrayHelper::get($data, 'id', ''));
    }

    /**
     * Renders a notice.
     *
     * @param array $data
     *
     * @throws Exception
     */
    protected function renderNotice(array $data)
    {
        if (empty($data['message'])) {
            return;
        }

        $classes = ArrayHelper::combine([
            'notice',
            'notice-'.ArrayHelper::get($data, 'type', 'info'),
        ], ArrayHelper::wrap(ArrayHelper::get($data, 'classes', [])));

        if (! empty($data['dismissible'])) {
            $classes[] = 'is-dismissible';
        } ?>
        <div
            class="<?php echo esc_attr(implode(' ', $classes)); ?>"
            data-message-id="<?php echo esc_attr(ArrayHelper::get($data, 'id', '')); ?>"
        >
            <p><?php echo wp_kses_post($data['message']); ?></p>
        </div>
        <?php
    }

    /**
     * Handles the dismiss notice Ajax request.
     *
     * TODO: can we abstract notice handling and provide something like the API below: {@wvega 2021-05-28}.
     *
     * $user->notices()->dismiss('message-id')
     * $user->notices()->isDismissed('message-id')
     * $user->notices()->restore('message-id')
     */
    public function handleDismissNoticeRequest()
    {
        if (! $user = User::getCurrent()) {
            (new Response())->body(['success' => false])->send();
        }

        if (! $messsageId = StringHelper::sanitize(ArrayHelper::get(ArrayHelper::wrap($_REQUEST), 'messageId', ''))) {
            (new Response())->body(['success' => false])->send();
        }

        $this->dismissNotice($user, $messsageId);

        (new Response())->body(['success' => true])->send();
    }

    /**
     * Marks a notice as dismissed for the given user.
     *
     * @param User $user a user object
     * @param string $messsageId an identifier for the notice
     */
    protected function dismissNotice(User $user, string $messageId)
    {
        $dismissedNotices = $this->getDismissedNotices($user);

        ArrayHelper::set($dismissedNotices, $messageId, true);

        $this->updateDismissedNotices($user, $dismissedNotices);
    }

    /**
     * Gets an array of dismissed notices for the given user.
     *
     * The keys of the array are notice identifier and the value indicates whether
     * the notice is currently dismissed or not.
     *
     * @param User $user a user object
     */
    protected function getDismissedNotices(User $user) : array
    {
        return ArrayHelper::wrap(get_user_meta($user->getId(), '_mwc_dismissed_notices', true));
    }

    /**
     * Stores the array of dismissed notices for the given user.
     *
     * @param User $user a user object
     * @param array $dismissedNotices dismissed no tices for the user
     */
    public function updateDismissedNotices(User $user, array $dismissedNotices)
    {
        update_user_meta($user->getId(), '_mwc_dismissed_notices', $dismissedNotices);
    }

    /**
     * Determines whether the given notice is dismissed for the given user.
     *
     * @param User $user a user object
     * @param string $messsageId an identifier for the notice
     *
     * @return bool
     */
    protected function isNoticeDismissed(User $user, $messsageId) : bool
    {
        return ArrayHelper::get($this->getDismissedNotices($user), $messsageId, false);
    }
}
