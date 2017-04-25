<?php
/*
 * Author: Group 15
 * Date: April 30, 2017
 * Name: book_index_view.class.php
 * Description: the parent class that displays a search box. The search form is commented out here since the search feature is not implemented. 
 */

class UserIndexView extends IndexView {

    public static function displayHeader($user) {
        parent::displayHeader($user)
        ?>
        <script>
            //the media type
            var media = "user";
        </script>
        <!--create the search bar -->
        <!--
        <div id="searchbar">
            <form method="get" action="<?= BASE_URL ?>/book/search">
                <input type="text" name="query-terms" id="searchtextbox" placeholder="Search books by title" autocomplete="off">
                <input type="submit" value="Go"/>
            </form>
            <div id="suggestionDiv"></div>
        </div> -->
        <?php
    }

    public static function displayFooter() {
        parent::displayFooter();
    }
}