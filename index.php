<?php 

include_once('rsa.php');

function decorationText($text,$line = 30){
    echo "\033[34m" . str_repeat("=", $line) . "\033[0m\n"; // Blue line separator
    echo "\033[1;32m" . $text . "\033[0m\n"; // Bold green title
    echo "\033[34m" . str_repeat("=", $line) . "\033[0m\n"; //
}

$loop = true;
while($loop){
   
    decorationText('RSA Encryption And Decryption And MD5 and SHA1',50);
    echo " Type 1 for all hash \n Type 2 for custom hash \n Type 3 for generate RSA keys:  \n Type 4 for encrypt RSA keys:  \n Type 5 for decrypt RSA keys:  \n Type 6 for exit \n";

    fscanf(STDIN, "%s\n", $type);

    if($type == null){
        echo "\033[1;32m" .'Thanks for using this tool'. "\033[0m\n";
        echo '\n';
        return;
    }

    match ((int)$type) {
        1 => hashAllData(),
        2 => customHash(),
        3 => outputRsaKeys(),
        4 => encryptOutMessage(),
        5 => decrptyOutMessage(),
        6 => exitWhile(),
    };
}

function exitWhile(){
    global $loop;
    $loop  = false;
}

$keysStoresGloble; 
function outputRsaKeys(){
    global $keysStoresGloble; 
    list($publicKey, $privateKey) = generateKeys();

    $keysStoresGloble['privateKey'] = $privateKey; // Store private key
    $keysStoresGloble['publicKey'] = $publicKey; 
    echo "Private Key: \n" . $keysStoresGloble['privateKey'] . "\n";
    echo "Public Key: \n" . $keysStoresGloble['publicKey'] . "\n";

}

function encryptOutMessage()
{
    global $keysStoresGloble; 

    if (!$keysStoresGloble['publicKey']) {
        decorationText("Please generate RSA keys first.",0);
        return;
    }
    
    echo 'Write Message To Encrypt : ';
    fscanf(STDIN, "%s\n", $message);

    if($message == null){
        decorationText('Something went wrong',0);
        return;
    }

    $encryptData = encryptRsaKey($keysStoresGloble['publicKey'],$message);

    decorationText('Encrypted Message',0);
    decorationText($encryptData,0);
}

function decrptyOutMessage()
{
    global $keysStoresGloble; 

    if (!$keysStoresGloble['privateKey']) {
        decorationText("Please generate RSA keys first.",0);
        return;
    }

    echo 'Enter Encrypt Hash : ';
    fscanf(STDIN, "%s\n", $message);

    if($message == null){
        decorationText('Something went wrong',0);
        return;
    }

    $descryptMessage = decryptRsaKey($keysStoresGloble['privateKey'],$message);
    
    decorationText('Descrypted Message',0);
    decorationText($descryptMessage,0);
}



function hashAllData(){
    $array = ['Hello','Hello World','Hello World1','Hello World!','Hello World Now'];
    
    
    foreach($array as $arr){
        printOutMessage($arr);
    }
    
}

function customHash() {
    echo "Enter value: ";
    fscanf(STDIN, "%s\n", $input);
    printOutMessage($input);
}

function printOutMessage($value){
    echo "\n";
    echo "MD5 : ";
    echo  "\033[1;32m" . md5($value) . "\033[0m\n";
    echo "\n";
    echo "SHA 1 : ";
    echo  "\033[1;32m" . sha1($value) . "\033[0m\n";
    echo "\n";
}


