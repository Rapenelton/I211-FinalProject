<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$page_title = "Error";
//display header
IndexView::displayHeader($page_title);

?>
<div id = "main-header">Error</div>
<hr>
<table style = "width: 100%; border: none">
    <tr>
        <td style = "vertical-align: middle; text-align: center; width:100px">
            <img src = '<?= BASE_URL ?>/www/img/error.jpg' style = "width: 80px; border: none"/>
        </td>
        <td style = "text-align: left; vertical-align: top;">
            <h3> Sorry, but an error has occurred.</h3>
            <div style = "color: red">
                <?= urldecode($message)
                ?>
            </div>
            <br>
        </td>
    </tr>
</table>
<br><br><br><br><hr>
<a href="<?= BASE_URL ?>/account/index">Back to Account list</a>

<?php
//display footer
IndexView::displayFooter();