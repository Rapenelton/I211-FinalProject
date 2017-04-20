<?php
/*
 * Author: Group 15
 * Date: April 17, 2017
 * Name: search.class.php
 * Description: this script defines the SearchAccount class. The class contains a method named display, which
 *     accepts an array of Account objects and displays them in a grid.
 */

class AccountSearch extends AccountIndexView {
    /*
     * the displays accepts an array of account objects and displays
     * them in a grid.
     */

     public function display($terms, $accounts) {
        //display page header
        parent::displayHeader("Search Results");
        ?>
        <div id="main-header"> Search Results for <i><?= $terms ?></i></div>
        <span class="rcd-numbers">
            <?php
            echo ((!is_array($accounts)) ? "( 0 - 0 )" : "( 1 - " . count($accounts) . " )");
            ?>
        </span>
        <hr>

       <!-- display all records in a grid -->
               <div class="grid-container">
            <?php
            if ($accounts === 0) {
                echo "No account was found.<br><br><br><br><br>";
            } else {
                //display accounts in a grid; six accounts per row
                foreach ($accounts as $i => $account) {
                    $id = $account->getId();
                    $client_id = $account->getClient_id();
                    $account_number = $account->getAccount_number();
                    $balance = $account->getBalance();
                    $routing_number = $account->getRouting_number();
                    $account_type = $account->getAccount_type();
                    //$image = $account->getImage();
                    //if (strpos($image, "http://") === false AND strpos($image, "https://") === false) {
                      //  $image = BASE_URL . "/" . MOVIE_IMG . $image;
                    //}
                    
                    if ($account_type == 1) {
                        $account_type = "Checking";
                    } else {
                        $account_type = "Savings";
                    }
                    if ($i % 6 == 0) {
                        echo "<div class='row'>";
                    }

                    echo "<div class='col'><p><a href='" . BASE_URL . "/account/detail/$id'><img src='" .
                    "'></a><span>ID: $client_id<br>Account Number: $account_number<br>Balance: $$balance <br>Routing Number: $routing_number<br>Account Type: $account_type" . "</span></p></div>";
                    ?>
                    <?php
                    if ($i % 6 == 5 || $i == count($accounts) - 1) {
                        echo "</div>";
                    }
                }
            }
            ?>  
        </div>
        <a href="<?= BASE_URL ?>/account/index">Go to account list</a>
        <?php
        //display page footer
        parent::displayFooter();
    }

//end of display method
}