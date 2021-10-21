<?php

return [
    /*
     *--------------------------------------------------------------------------
     * Features Settings
     *--------------------------------------------------------------------------
     *
     * The following settings determine whether a given feature is available or not
     */
    'email_notifications'      => defined('ENABLE_MWC_EMAIL_NOTIFICATIONS') && ENABLE_MWC_EMAIL_NOTIFICATIONS,
    'sequential_order_numbers' => ! (defined('DISABLE_MWC_SEQUENTIAL_ORDER_NUMBERS') && DISABLE_MWC_SEQUENTIAL_ORDER_NUMBERS),
    'url_coupons'              => ! (defined('DISABLE_MWC_URL_COUPONS') && DISABLE_MWC_URL_COUPONS),
    'cost_of_goods'            => ! (defined('DISABLE_MWC_COST_OF_GOODS') && DISABLE_MWC_COST_OF_GOODS),
    'google_analytics'         => defined('ENABLE_MWC_GOOGLE_ANALYTICS') && ENABLE_MWC_GOOGLE_ANALYTICS,
];
