<?php 

require 'block.php';

function decorationText($text,$line = 30){
    echo "\033[34m" . str_repeat("=", $line) . "\033[0m\n"; // Blue line separator
    echo "\033[1;32m" . $text . "\033[0m\n"; // Bold green title
    echo "\033[34m" . str_repeat("=", $line) . "\033[0m\n"; //
}

$myBlockChain = new Blockchain();

$loop = true;
while($loop){
   

    $titles = ['Show All Chains', 'Add Block', 'Change Difficulty', 'Check Valid Chain', 'Exit'];

    foreach($titles as $key => $value){
        echo "\n";
        echo $key + 1 . ". " . $value . "\n";
    }
    echo "\n";
    echo "Choose Option : ";

    fscanf(STDIN, "%s\n", $type);

    if($type == null){
        echo "\033[1;32m" .'Thanks for using this tool'. "\033[0m\n";
        echo '\n';
        return;
    }

    match ((int)$type) {
        1 => showAllChain(),
        2 => addBLock(),
        3 => changeDifficulty(),
        4 => isChainValid(),
        5 => exitWhile(),
    };
}

function exitWhile(){
    global $loop;
    $loop  = false;
}

function isChainValid()
{
    global $myBlockChain;

    if($myBlockChain->isChainValid()){
        echo decorationText('Chain is valid',20);
    }else{
        echo decorationText('Chain Not valid',20);
    }
}

function changeDifficulty(){
    global $myBlockChain;
    echo "Enter new difficulty: ";
    fscanf(STDIN, "%s\n", $difficulty);
    $myBlockChain->difficulty = $difficulty;
    echo "Changed difficulty to " . $myBlockChain->difficulty . "\n";
}

function addBlock(){
    global $myBlockChain;

    echo decorationText('Sender Name',20);
    echo "\n";
    fscanf(STDIN, "%s\n", $senderName);
    echo decorationText('Receiver Name',20);
    echo "\n";
    fscanf(STDIN, "%s\n", $receiverName);
    echo decorationText('Amount',20);
    echo "\n";
    fscanf(STDIN, "%s\n", $amount);

    $myBlockChain->addBlock(new Block(count($myBlockChain->chain), time(), ['sender' => $senderName, 'recipient' => $receiverName, 'amount' => $amount]));
}

function showAllChain(){
    global $myBlockChain;
    echo "Displaying the blockchain:\n";

    foreach ($myBlockChain->chain as $block) {
        echo "-------------------\n";
        echo "Block #" . $block->index . "\n";
        echo "Hash: " . $block->hash . "\n";
        echo "Previous Hash: " . $block->previousHash . "\n";
        echo "Transactions: " . json_encode($block->transactions) . "\n";
        echo "-------------------\n";
    }
}
