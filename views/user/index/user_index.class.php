<?php
/*
 * Author: Raleigh Stelle
 * Date: 4/5/2017
 * Name: user_index.class.php
 * Description: Display the array of users.
 */

//Book index view class
class UserIndex extends UserIndexView {
    /*
     * the display method accepts an array of user objects and displays
     * them in a grid.
     */

    public function display($users) {
        //display page header
        parent::displayHeader("List All Users");
        ?>
        <h2>All Users</h2>



        <script>
        //the media type
            var media = "account";
        </script>
        <!--create the search bar -->
        
        <div id="searchbar">
            <form method="get" action="<?= BASE_URL ?>/user/search">
                <input type="text" name="query-terms" id="searchtextbox" placeholder="Search by first name" autocomplete="off">
                <input type="submit" value="Go"/>
            </form>
            <div id="suggestionDiv"></div>
        </div>

        <div class="grid-container">
            <?php
            if ($users === 0) {
                echo "No user was found.<br><br><br><br><br>";
            } else {
                //display users in a grid; six users per row
                foreach ($users as $i => $user) {
                    $client_id = $user->getClient_id();
                    $first_name = $user->getFirst_name();
                    $last_name = $user->getLast_name();
                    $birth_date = new \DateTime($user->getBirth_date());
                    $email = $user->getEmail();
                    $ssn = $user->getSsn();
                    if ($i % 6 == 0) {
                        echo "<div class='row'>";
                    }

                    echo "<div class='col'><p><a href='", BASE_URL, "/users/detail/$client_id'></a><span>ID: " . $client_id . "<br>$first_name " . $last_name . "<br>Date of Birth: " . $birth_date->format('m-d-Y') . "<br>Email: " . $email . "<br>SSN: " . $ssn . "</span></p></div>";
                    ?>
                    <?php
                    if ($i % 6 == 5 || $i == count($users) - 1) {
                        echo "</div>";
                    }
                }
            }
            ?>  

            <a href="../../index/">Back to Home</a>

        </div>

        <?php
        //display page footer
        // parent::displayFooter();
    }

//end of display method
}
