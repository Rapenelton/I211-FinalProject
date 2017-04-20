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
        $id = $account->getId();
        $client_id = $account->getClient_id();
        $account_number = $account->getAccount_number();
        $balance = $account->getBalance();
        $routing_number = $account->getRouting_number();
        //$image = $account->getImage();
        $account_type = $account->getAccount_type();

        //if (strpos($image, "http://") === false AND strpos($image, "https://") === false) {
            //$image = BASE_URL . '/' . BOOK_IMG . $image;
        //}
        ?>

        <div id="main-header">Account Details</div>
        <hr>
        <!-- display account details in a table -->
        <table id="detail">
            <tr>
                <td style="width: 150px;">
                    <img src="<?= $image ?>" alt="<?= $account_number ?>" />
                </td>
                <td style="width: 130px;">
                    <p><strong>Account Number:</strong></p>
                    <p><strong>Client ID:</strong></p>
                    <p><strong>Balance:</strong></p>
                    <p><strong>Routing Number:</strong></p>
                    <p><strong>Account Type:</strong></p>
                </td>
                <td>
                    <p><?= $account_number ?></p>
                    <p><?= $client_id ?></p>
                    <p><?= $balance ?></p>
                    <p><?= $routing_number ?></p>
                    <p><?= $account_type ?></p>
                    <p class="media-description"><?= $account_number ?></p>
                </td>
            </tr>
        </table>
        <a href="<?= BASE_URL ?>/account/index">Go to account list</a>

        <?php
        //display page footer
        parent::displayFooter();
    }
    
//end of display method
}
