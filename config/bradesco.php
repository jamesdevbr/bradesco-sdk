<?php

/**
 * Configuration settings for integration with Bradesco
 */

return [
    'mode' => strtolower(env('BRADESCO_MODE', 'sandbox')),

    'merchant_id' => env('BRADESCO_MERCHANT_ID'),
    'email' => env('BRADESCO_EMAIL'),
    'security_key' => env('BRADESCO_SECURITY_KEY'),

    /**
     * Configuration for PIX only
     */
    'pix_token_confirmation' => env('BRADESCO_PIX_TOKEN_CONFIRMATION'),


    /**
     * Optional configuration in case you want to use the
     * SimulatePayment Command to be sent to this URL
     */
    'pix_notification_url' => env('BRADESCO_PIX_NOTIFICATION_URL', '/bradesco/pix/notification'),

    /**
     * Encryption key generated in Bradesco's manager.
     * It is used to receive notifications from SPS Notifica.
     * Currently, it is only being used for automatic PIX clearance.
     */
    'notification_encrypt_key' => env('BRADESCO_NOTIFICATION_ENCRYPT_KEY'),
];
