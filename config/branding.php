<?php

return [
    /*
    | Admin lives on its own subdomain so its session cookie never touches
    | the public brand domains. In production this is admin.corememory.com;
    | locally it's admin.localhost (see .env BRAND_ADMIN_DEV_DOMAIN).
    */
    'admin_domain' => env('APP_ENV') === 'production'
        ? env('ADMIN_DOMAIN', 'admin.corememory.com')
        : env('BRAND_ADMIN_DEV_DOMAIN', 'admin.localhost'),
];
