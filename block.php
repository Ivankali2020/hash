<?php

class Block {
    public $index;
    public $timestamp;
    public $transactions;
    public $previousHash;
    public $hash;
    public $nonce;

    public function __construct($index, $timestamp, $transactions, $previousHash = '') {
        $this->index = $index;
        $this->timestamp = $timestamp;
        $this->transactions = $transactions;
        $this->previousHash = $previousHash;
        $this->nonce = 0;
        $this->hash = $this->calculateHash();
    }

    // Calculate hash for the block
    public function calculateHash() {
        return hash('sha256', $this->index . $this->timestamp . json_encode($this->transactions) . $this->previousHash . $this->nonce);
    }

    // Proof-of-work algorithm
    public function mineBlock($difficulty) {
        $target = str_repeat('0', $difficulty);
        while (substr($this->hash, 0, $difficulty) !== $target) {
            $this->nonce++;
            $this->hash = $this->calculateHash();
        }
        echo "Block mined: " . $this->hash . "\n";
    }
}

class Blockchain {
    public $chain = [];
    public $difficulty;

    public function __construct() {
        $this->chain = [$this->createGenesisBlock()];
        $this->difficulty = 4; // Adjust for faster or slower mining
    }

    // Create the first block (Genesis block)
    private function createGenesisBlock() {
        return new Block(0, time(), 'Genesis Block', '0');
    }

    // Get the latest block in the chain
    public function getLatestBlock() {
        return $this->chain[count($this->chain) - 1];
    }

    // Add a new block to the chain
    public function addBlock($newBlock) {
        $newBlock->previousHash = $this->getLatestBlock()->hash;
        echo "Block minning ...... \n";
        $newBlock->mineBlock($this->difficulty);
        $this->chain[] = $newBlock;
    }

    // Check if the blockchain is valid
    public function isChainValid() {
        for ($i = 1; $i < count($this->chain); $i++) {
            $currentBlock = $this->chain[$i];
            $previousBlock = $this->chain[$i - 1];

            // Validate the hash of the current block
            if ($currentBlock->hash !== $currentBlock->calculateHash()) {
                return false;
            }

            // Validate the hash of the previous block
            if ($currentBlock->previousHash !== $previousBlock->hash) {
                return false;
            }
        }
        return true;
    }
}

?>