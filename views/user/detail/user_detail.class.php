<?php
/*
 * Author: Raleigh Stelle
 * Date: 4/5/2017
 * Name: account_detail.class.php
 * Description: This class defines a method "display".
 *              The method accepts a Account object and displays the details of the account in a table.
 */
//User detail view class
class UserDetail extends UserIndexView {

    public function display($user, $confirm = "") {
        //display page header
        parent::displayHeader("User Details");

        //retrieve account details by calling get methods
        $client_id = $user->getClient_id();
        $first_name = $user->getFirst_name();
        $last_name = $user->getLast_name();
        $email = $user->getEmail();
        $birth_date = new \DateTime($user->getBirth_date());
        $ssn = $user->getSsn();
        //$image = $user->getImage();

        //if (strpos($image, "http://") === false AND strpos($image, "https://") === false) {
         //   $image = BASE_URL . '/' . BOOK_IMG . $image;
        //}
        ?>

        <div id="main-header">User Details</div>
        <hr>
        <!-- display user details in a table -->
        <table id="detail">
            <tr>
                <td style="width: 150px;">
                    <img src="<?= $image ?>" alt="<?= $first_name ?>" />
                </td>
                <td style="width: 130px;">
                    <p><strong>First Name:</strong></p>
                    <p><strong>Last Name:</strong></p>
                    <p><strong>Email:</strong></p>
                    <p><strong>Birth Date:</strong></p>
                    <p><strong>SSN:</strong></p>
                </td>
                <td>
                    <p><?= $first_name ?></p>
                    <p><?= $last_name ?></p>
                    <p><?= $email ?></p>
                    <p><?= $birth_date->format('m-d-Y') ?></p>
                    <p><?= $ssn ?></p>
                    <p class="media-description"><?= $client_id ?></p>
                </td>
            </tr>
        </table>
        <a href="<?= BASE_URL ?>/user/index">Go to user list</a>

        <?php
        //display page footer
        parent::displayFooter();
    }
    
//end of display method
}
