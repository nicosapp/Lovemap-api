<?php

return [
  'url' => env('APP_CLIENT_URL', 'http://localhost'),
  'routes' => [
    'login' =>  env('APP_CLIENT_URL') . env('CLIENT_ROUTE_LOGIN', ''),
    'account' => env('APP_CLIENT_URL') . env('CLIENT_ROUTE_ACCOUNT', ''),
  ]
];
