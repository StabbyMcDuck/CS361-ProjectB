<?php
include('configuration.php');

function printHeader($active = null) {
    ?>
<div class="header clearfix">
    <nav>
        <ul class="nav nav-pills pull-right">
            <li role="presentation"<?php
    if ($active == "index.php") {
        echo " class =\"active\"";
    }
             ?>>
                <a href="http://web.engr.oregonstate.edu/~imhoffr/CS361-ProjectB-master/">Home</a>
            </li>
            <li role="presentation">
                <a href="http://example.com">Example Link</a>
            </li>
            <?php
    if(session_status() == PHP_SESSION_NONE){            
        session_start();
    }
    
    if (isset($_SESSION['id'])) {
            ?>
            <li role="presentaton">
                <a href="http://web.engr.oregonstate.edu/~imhoffr/CS361-ProjectB-master/session/destroy.php">Log Out</a>
            </li>
            <?php
    }
            ?>
        </ul>
    </nav>
                
    <h2 class="text-muted">Grocery Shopper Price Chopper</h2>
</div> <!-- header clearfix -->
    <?php
}
?>