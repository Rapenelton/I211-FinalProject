<?php
/*
 * Author: Group 15
 * Date: April 30, 2017
 * Name: book_index_view.class.php
 * Description: the parent class that displays a search box. The search form is commented out here since the search feature is not implemented. 
 */

class AccountIndexView extends IndexView {

    public static function displayHeader($title) {
        parent::displayHeader($title)
        ?>
        <script>
            //the media type
            var type = "account";
        </script>

        <?php
    }

    public static function displayFooter() {
        parent::displayFooter();
    }
}