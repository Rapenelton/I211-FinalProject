<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author ryanpene
 */
class User {

    private $client_id, $last_name, $first_name, $birth_date, $email, $ssn, $role;
    
    public function __construct($client_id, $last_name, $first_name, $birth_date, $email, $ssn, $role) {
        $this->client_id = $client_id;
        $this->last_name = $last_name;
        $this->first_name = $first_name;
        $this->birth_date = $birth_date;
        $this->email = $email;
        $this->ssn = $ssn;
        $this->role = $role;
    }

    public function getClient_id() {
        return $this->client_id;
    }

    public function getLast_name() {
        return $this->last_name;
    }

    public function getFirst_name() {
        return $this->first_name;
    }

    public function getBirth_date() {
        return $this->birth_date;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getSsn() {
        return $this->ssn;
    }

    public function getRole() {
        return $this->role;
    }

    //set account id
    public function setClient_iD($client_id) {
        $this->client_id = $client_id;
    }
    

}
