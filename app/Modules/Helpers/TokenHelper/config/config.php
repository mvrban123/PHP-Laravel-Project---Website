<?php
return array(
    'jwt' => array(
        'key'       => "CREATE YOUR KEY",     // Key for signing the JWT's, I suggest generate it with base64_encode(openssl_random_pseudo_bytes(64))
        'algorithm' => 'HS512' // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
        ),
    'database' => array(
        'user'     => 'SET USER NAME', // Database username
        'password' => 'SET PASSWORD', // Database password
        'host'     => 'localhost', // Database host
        'name'     => 'SET DB SCHEMA', // Database schema name (e.g. obitelji_m_app)
    ),
    'serverName' => 'obitelji3plus.hr', // Server name (e.g. obitelji3plus.hr)
    'allowedInactivityPeriod' => 300 // Allowed inactivty period in seconds
);

?>