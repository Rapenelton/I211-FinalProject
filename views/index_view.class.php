<?php
/*
 * Author: Louie Zhu
 * Date: Mar 6, 2016
 * Name: index_view.class.php
 * Description: the parent class for all view classes. The two functions display page header and footer.
 */

class IndexView {

    //this method displays the page header
    static public function displayHeader($page_title) {
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <title> <?php echo $page_title ?> </title>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
                <link rel='shortcut icon' href='<?= BASE_URL ?>/www/img/favicon.ico' type='image/x-icon' />
                <link type='text/css' rel='stylesheet' href='<?= BASE_URL ?>/www/css/style.css' />
                <script>
                    //create the JavaScript variable for the base url
                    var base_url = "<?= BASE_URL ?>";
                </script>
            </head>
            <body>
                <div id="top"></div>
                <div id='wrapper'>
                    <div id="banner">
                        <a href="<?= BASE_URL ?>/index.php" style="text-decoration: none" title="Cash Money Bank">
                            <div id="left">
                                <img src='<?= BASE_URL ?>/www/img/money.jpg' style="height: 130px; width: 180px; border: none; float: left; padding-right: 10px" />
                                <span style='color: #074900; font-size: 45pt; font-weight: bold; vertical-align: top'>
                                    Cash Money Bank
                                </span>
                                <div style='color: #FFA500; background-color: #d0fcc7; font-size: 20pt; font-weight: bold'>We keep your money protected.</div>
                            </div>
                            <br>
                            <br>
                        </a>

                    </div>
                    <?php
                }

//end of displayHeader function
                //this method displays the page footer
                public static function displayFooter() {
                    ?>
                    <br><br><br>
                    <div id="push"></div>
                </div>
                <div id="footer"><br>&copy 2017 Cash Money Bank. All Rights Reserved.</div>
                <script type="text/javascript" src="<?= BASE_URL ?>/www/js/ajax_autosuggestion.js"></script>
            </body>
        </html>
        <?php
    }

//end of displayFooter function
}
