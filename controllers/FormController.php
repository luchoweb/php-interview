<?php

namespace controllers;

use views\Home as HomeView;
use db\Database as db;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use League\OAuth2\Client\Provider\GenericProvider as GenericProvider;

class FormController
{
    public function index()
    {
        $this->getTokens();

        HomeView::setForm('addSubscribers');
    }

    public function getTokens()
    {
        $client = new HttpClient();

        $tokens = db::getTokens();

        $provider = new GenericProvider([
            'clientId' => AWEBER_CLIENT_ID,
            'clientSecret' => AWEBER_CLIENT_SECRET,
            'redirectUri' => AWEBER_REDIRECT_URI,
            'scopes' => AWEBER_SCOPE,
            'scopeSeparator' => ' ',
            'urlAuthorize' => AWEBER_AUTH_URL,
            'urlAccessToken' => AWEBER_TOKEN_URL,
            'urlResourceOwnerDetails' => AWEBER_URL_RESOURCE_OWNER_DETAILS
        ]);
    
        $authorizationUrl = $provider->getAuthorizationUrl();
        //echo "<br><br>".$authorizationUrl."<br><br>";

        if ( isset($_GET['code']) ) {
            $_SESSION['CODE'] = $_GET['code'];

            $token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);

            $accessToken = $token->getToken();
            $refreshToken = $token->getRefreshToken();

            db::updateTokens($_SESSION['CODE'], $accessToken, $refreshToken);
            
        } else {
            $response = $client->post(
                AWEBER_TOKEN_URL, [
                    'auth' => [
                        AWEBER_CLIENT_ID, AWEBER_CLIENT_SECRET
                    ],
                    'json' => [
                        'grant_type' => 'refresh_token',
                        'refresh_token' => $tokens['refreshToken']
                    ]
                ]
            );

            $body = $response->getBody();
            $newCreds = json_decode($body, true);
            $accessToken = $newCreds['access_token'];
            $refreshToken = $newCreds['refresh_token'];

            db::updateTokens($tokens['code'], $accessToken, $refreshToken);
        }
    
        $_SESSION['ACCESS_TOKEN'] = $accessToken;
        $_SESSION['REFRESH_TOKEN'] = $refreshToken;
    }

    public function addSubscriber($subscriberEmail, $subscriberName, $subscriberTerms)
    {
        self::getTokens();

        $client = new HttpClient();

        $findSubscriber = self::findSubscriber($subscriberEmail);
        $existingSubscriberEmail = $findSubscriber["entries"][0]["email"];

        $body = [
            'email' => $subscriberEmail,
            'name' => $subscriberName,
            'tags' => [
                'test_new_sub',
            ],
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '. $_SESSION['ACCESS_TOKEN']
        ];

        $method = "post";

        $url = AWEBER_URL_RESOURCE_OWNER_DETAILS."/".AWEBER_ACCOUNT_ID."/lists/".AWEBER_LIST_ID."/subscribers";

        if  ( $existingSubscriberEmail ) {
            // To validate an error in the .log file, please change subscriber_email to email
            $params = ['subscriber_email' => $existingSubscriberEmail];
            $url .= "?". http_build_query($params);
            $method = "patch";
            $body["tags"] = [
                "add" => ["test_existing_sub"],
                "remove" => ["test_new_sub"]
            ];
        }

        if ( $subscriberTerms == "accepted" ) {
            $currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            $body["custom_fields"] = [
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                "subscribe_date" => date('m/d/Y'),
                "subscribe_time" => date('H:i:s'),
                "subscribe_url" => $currentUrl
            ];
        }

        try {
            $response = $client->request($method, $url, ['json' => $body, 'headers' => $headers]);
            
            $typeActionSave = !$existingSubscriberEmail ? 'save' : 'update';
            db::saveSubscriber($typeActionSave, $subscriberEmail, $subscriberName);

            if ( $response->getStatusCode() < 400 ) {
                self::logger($subscriberEmail, "Subscriber was created/updated successfully");
                Header("Location: ".ROOT_PATH."?added");
            }
        } catch (RequestException $e) {
            $errorMsg = $e->getRequest();
            if ($e->hasResponse()) {
                $errorMsg = $e->getResponse();
            }
            self::logger($subscriberEmail, "Error: {$errorMsg->getReasonPhrase()} {$errorMsg->getStatusCode()}");

            Header("Location: ".ROOT_PATH."?error");
        }
    }

    public function findSubscriber($subscriberEmail)
    {
        $client = new HttpClient();

        $url = AWEBER_URL_RESOURCE_OWNER_DETAILS."/".AWEBER_ACCOUNT_ID;
        
        $params = [
            'ws.op' => 'findSubscribers',
            'email' => $subscriberEmail
        ];

        $headers = [
            'Authorization' => 'Bearer '. $_SESSION['ACCESS_TOKEN']
        ];

        $findUrl = $url . '?' . http_build_query($params);
        $response = $client->get($findUrl, ['headers' => $headers]);
        $body = json_decode($response->getBody(), true);

        return $body;
    }

    private function logger($subscriberEmail, $msg)
    {
        $log = "{$subscriberEmail} - ".date('m/d/Y H:i:s')." - {$msg}\r\n";
        file_put_contents($_SERVER['DOCUMENT_ROOT'].ROOT_PATH."/logs/form.log", $log, FILE_APPEND | LOCK_EX);
    }
}
