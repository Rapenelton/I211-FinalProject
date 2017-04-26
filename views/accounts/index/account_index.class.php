<?php
/*
 * Author: Raleigh Stelle
 * Date: 4/5/2017
 * Name: account_index.class.php
 * Description: Display the array of accounts.
 */

//Book index view class
class AccountIndex extends AccountIndexView {
    /*
     * the display method accepts an array of account objects and displays
     * them in a grid.
     */

    public function display($accounts) {
        //display page header
        parent::displayHeader("List All Accounts");
        ?>
        <h2>All Accounts</h2>

        <script>
        //the media type
            var media = "account";
        </script>
        <!--create the search bar -->

        <div id="searchbar">
            <form method="get" action="<?= BASE_URL ?>/account/search/">
                <input type="text" name="query-terms" id="searchtextbox" placeholder="Search by account #" autocomplete="off">
                <input type="submit" value="Go"/>
            </form>

            <div id="suggestionDiv"></div>
        </div> 

        <div class="grid-container">
            <?php
            if ($accounts === 0) {
                echo "No account was found.<br><br><br><br><br>";
            } else {
                //display accounts in a grid; six accounts per row
                foreach ($accounts as $i => $account) {
                    $id = $account->getID();
                    $client_id = $account->getClient_id();
                    $balance = $account->getBalance();
                    $account_number = $account->getAccount_number();
                    $routing_number = $account->getRouting_number();
                    $account_type = $account->getAccount_type();
                    if ($i % 6 == 0) {
                        echo "<div class='row'>";
                    }

                    echo "<div class='col'><p><a href='", BASE_URL, "/accounts/detail/$id'></a><span>ID: " . $id . "<br>Client ID: $client_id   <br>Balance: $$balance  <br>Routing Number: $routing_number<br>Account Number: " . $account_number . "<br>Account Type: " . $account_type . "</span></p></div>";
                    ?>
                    <?php
                    if ($i % 6 == 5 || $i == count($accounts) - 1) {
                        echo "</div>";
                    }
                }
            }
            ?>  

            <a href="<?= BASE_URL ?>/index">Back to Home</a>

        </div>

        <?php
        //display page footer
        // parent::displayFooter();
    }

//end of display method
}
