<?php
$SERVER_IP = "localhost";
    if($_GET['navBar']){
        $con = mysqli_connect($SERVER_IP,"root","blargHblargh1");
        mysqli_query($con, "USE miniWeebly;");
        $result = mysqli_query($con, "SELECT * FROM pages");
        $counter = 0;
        echo '<center>';
        while($row = mysqli_fetch_array($result)) {
            echo '<div class="preview-content-nav-item" onclick="location.href=\'?p=' . (++$counter) . '\'">';
            echo '<div class="toolbar-page-list-item-title"> ' . $row['title'] . '</div>';
            echo '</div>';
        }
        echo '</center>';
        mysqli_close($con);
    }
?>