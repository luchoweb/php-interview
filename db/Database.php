<?php

namespace db;

use \PDO;

class Database {

    private function sqlQuery($query)
    {
        include "db/config.php";
        $conn = new PDO('mysql:host='.$server.';dbname='.$database.'', ''.$user.'', ''.$password.'');
        $result = $conn->query($query, PDO::FETCH_ASSOC);
        $conn = null;

        return $result;
    }

    public function updateTokens($code, $accessToken, $refreshToken)
    {
        $save = self::sqlQuery("UPDATE tokens SET code = '{$code}', accessToken = '{$accessToken}', refreshToken = '{$refreshToken}' WHERE id = 1");

        if ( $save ) {
            return array("status" => 200);
        } else {
            return array("status" => 500);
        }
    }

    public function getTokens()
    {
        $tokens = self::sqlQuery("SELECT * FROM tokens");

        $tokensArray = array();

        foreach($tokens as $key => $token) {
            $tokensArray[$key] = $token;
        }

        return $tokensArray[0];
    }

    public function saveSubscriber($typeAction, $subscriberEmail, $subscriberName)
    {
        $sqlQuery = $typeAction == "save" ? "INSERT INTO subscribers (email, full_name) VALUE ('{$subscriberEmail}', '{$subscriberName}')" : "UPDATE subscribers SET email = '{$subscriberEmail}', full_name = '{$subscriberName}' WHERE email = '{$subscriberEmail}'";

        $saveSubscriber = self::sqlQuery($sqlQuery );

        if ( $saveSubscriber ) {
            return array("status" => 200);
        } else {
            return array("status" => 500);
        }
    }
}