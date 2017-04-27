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

    public function display($accounts) {
//display page header
        parent::displayHeader("Account Details");
        if ($accounts === 0) {
            echo "No account was found.<br><br><br><br><br>";
        } else {
            //display accounts in a grid; six accounts per row
            foreach ($accounts as $i => $account) {
                $accountNumber = $account->getAccount_number();
                $balance = $account->getBalance();
                $routingNumber = $account->getRouting_number();
                $accountType = $account->getAccount_type();
                if ($i % 6 == 0) {
                    echo "<div class='row'>";
                }


                echo "<div class='col'><p><span>Account Number: " . $accountNumber . "<br>Balance: " . $balance . "<br>Routing Number: " . $routingNumber . "<br>Account Type: " . $accountType . "</span></p></div>";
                ?>
                <?php
                if ($i % 6 == 5 || $i == count($accounts) - 1) {
                    echo "</div>";
                }
            }
        }
        ?>

        <a href="<?= BASE_URL ?>/index">Back to Home</a>

        <?php
        parent::displayFooter();
    }

}
