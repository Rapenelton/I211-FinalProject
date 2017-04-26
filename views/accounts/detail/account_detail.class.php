<?php
/*
 * Author: Raleigh Stelle
 * Date: 4/5/2017
 * Name: account_detail.class.php
 * Description: This class defines a method "display".
 *              The method accepts a Account object and displays the details of the account in a table.
 */
//Account detail view class
class AccountDetail extends AccountIndexView {

    public function display($account, $confirm = "") {
        //display page header
        parent::displayHeader("Account Details");

        //retrieve account details by calling get methods
        $account_number = $account->getAccount_number();
        $balance = $account->getBalance();
        $routing_number = $account->getRouting_number();
        //$image = $account->getImage();
        $account_type = $account->getAccount_type();

        //if (strpos($image, "http://") === false AND strpos($image, "https://") === false) {
        //$image = BASE_URL . '/' . BOOK_IMG . $image;
        //}
        ?>
        <!-- display account details in a table -->
        <br>
        <strong>Account Number: </strong> <?= $account_number ?> <br>
        <strong>Balance: </strong> <?= $balance ?> <br>
        <strong>Routing Number: </strong> <?= $routing_number ?> <br>
        <strong>Account Type: </strong> <?= $account_type ?> <br>
        
        <br><br>
        <a href="<?= BASE_URL ?>../index">Back to Home</a>

        <?php
        //display page footer
        parent::displayFooter();
    }

//end of display method
}
