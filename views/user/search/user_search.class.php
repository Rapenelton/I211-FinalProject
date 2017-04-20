<?php
/*
 * Author: Louie Zhu
 * Date: Mar 6, 2016
 * Name: search.class.php
 * Description: this script defines the SearchUser class. The class contains a method named display, which
 *     accepts an array of User objects and displays them in a grid.
 */

class UserSearch extends UserIndexView {
    /*
     * the displays accepts an array of user objects and displays
     * them in a grid.
     */

     public function display($terms, $users) {
        //display page header
        parent::displayHeader("Search Results");
        ?>
        <div id="main-header"> Search Results for <i><?= $terms ?></i></div>
        <span class="rcd-numbers">
            <?php
            echo ((!is_array($users)) ? "( 0 - 0 )" : "( 1 - " . count($users) . " )");
            ?>
        </span>
        <hr>

       <!-- display all records in a grid -->
               <div class="grid-container">
            <?php
            if ($users === 0) {
                echo "No user was found.<br><br><br><br><br>";
            } else {
                //display users in a grid; six users per row
                foreach ($users as $i => $user) {
                    $first_name = $user->getFirst_name();
                    $client_id = $user->getClient_id();
                    $last_name = $user->getLast_name();
                    $ssn = $user->getSsn();
                    $email = $user->getEmail();
                    $birth_date = new \DateTime($user->getBirth_date());
                    $birth_date = $birth_date->format('m-d-Y');
                    
                    //$image = $user->getImage();
                    //if (strpos($image, "http://") === false AND strpos($image, "https://") === false) {
                      //  $image = BASE_URL . "/" . MOVIE_IMG . $image;
                    //}
                    

                    if ($i % 6 == 0) {
                        echo "<div class='row'>";
                    }

                    echo "<div class='col'><p><a href='" . BASE_URL . "/user/detail/$client_id'><img src='" .
                    "'></a><span>ID: $client_id<br>Name: $first_name  $last_name<br>SSN: $ssn <br>Birth Date: $birth_date <br>Email: $email" . "</span></p></div>";
                    ?>
                    <?php
                    if ($i % 6 == 5 || $i == count($users) - 1) {
                        echo "</div>";
                    }
                }
            }
            ?>  
        </div>
        <a href="<?= BASE_URL ?>/user/index">Go to user list</a>
        <?php
        //display page footer
        parent::displayFooter();
    }

//end of display method
}