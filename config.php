<?php

// Show errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Default Timezone
date_default_timezone_set('America/Bogota');

// APP INFO
const ROOT_PATH = "/php-interview";
const APP_VERSION = "0.0.1";

// AWEBER
const AWEBER_CLIENT_ID = "pWZbNYgD6ny9InXU8tR5jwWkdO97Fouv";
const AWEBER_CLIENT_SECRET = "GUoF2xXIVKBK7wJcjBAiuMdobTEJ6zhi";
const AWEBER_ACCOUNT_ID = "1788138";
const AWEBER_LIST_ID = "6081642";
const AWEBER_AUTH_URL = "https://auth.aweber.com/oauth2/authorize";
const AWEBER_TOKEN_URL = "https://auth.aweber.com/oauth2/token";
const AWEBER_REDIRECT_URI = "http://localhost/php-interview";
const AWEBER_URL_RESOURCE_OWNER_DETAILS = "https://api.aweber.com/1.0/accounts";
const AWEBER_SCOPE = [
  'account.read',
  'list.read',
  'subscriber.read',
  'subscriber.write',
  'email.read'
];