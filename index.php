<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//load application settings
require_once ("application/config.php");

//load autoloader
require_once ("application/autoloader.class.php");

//load the displather that dissects a request URL
new Dispatcher();
