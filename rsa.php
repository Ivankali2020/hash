<?php 

function generateKeys() {
    $res = openssl_pkey_new([
        'private_key_bits' => 512,
        'private_key_type' => OPENSSL_KEYTYPE_RSA,
    ]);

    openssl_pkey_export($res, $privateKey);
    
    $publicKey = openssl_pkey_get_details($res)['key'];

    return [$publicKey,$privateKey];
}

function encryptRsaKey($publicKey,$message) {

    openssl_public_encrypt($message, $encrypted, $publicKey);
    return base64_encode($encrypted);

}

function decryptRsaKey($privateKey,$encrypted) {

    $encrypted = base64_decode($encrypted);
    openssl_private_decrypt($encrypted, $decrypted, $privateKey);
    return $decrypted;

}


