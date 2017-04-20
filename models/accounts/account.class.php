<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Account {
    
    private $id, $client_id, $account_number, $balance, $routing_number, $account_type;
    
    public function __construct($id, $client_id, $account_number, $balance, $routing_number, $account_type) {
        $this->id = $id;
        $this->client_id = $client_id;
        $this->account_number = $account_number;
        $this->balance = $balance;
        $this->routing_number = $routing_number;
        $this->account_type = $account_type;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getClient_id() {
        return $this->client_id;
    }

    public function getAccount_number() {
        return $this->account_number;
    }

    public function getBalance() {
        return $this->balance;
    }

    public function getRouting_number() {
        return $this->routing_number;
    }

    public function getAccount_type() {
        return $this->account_type;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
}

    