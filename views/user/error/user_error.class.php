<?php
/*
 * Author: Raleigh Stelle
 * Date: 4/5/2017
 * Name: book_error.class.php
 * Description: This is the view Error class and display method.
 */
//Book error view class
class UserError extends UserIndexView {

    public function display($message) {

        //display page header
        parent::displayHeader("Error");
        ?>

        <div id="main-header">Error</div>
        <hr>
        <table style="width: 100%; border: none">
            <tr>
                <td style="vertical-align: middle; text-align: center; width:100px">
                    <img src='<?= BASE_URL ?>/www/img/error.jpg' style="width: 80px; border: none"/>
                </td>
                <td style="text-align: left; vertical-align: top;">
                    <h3> Sorry, but an error has occurred.</h3>
                    <div style="color: red">
                        <?= urldecode($message) ?>
                    </div>
                    <br>
                </td>
            </tr>
        </table>
        <br><br><br><br><hr>
        <a href="<?= BASE_URL ?>/users/index">Back to user index</a>
        <?php
        //display page footer
        parent::displayFooter();
    }

//end of display method
}