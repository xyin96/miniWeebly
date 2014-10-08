<?php
if(validToken($_GET['api_token'])){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $con = mysqli_connect("localhost","root","blargHblargh1");
        mysqli_query($con, "USE miniWeebly");
        mysqli_query($con, "INSERT INTO pages (title, num_items, num_containers) VALUES ('" . $_POST['title'] . "', 0, 0)");
        $result = mysqli_query($con, "SELECT MAX(id) FROM pages");
        $data = mysqli_fetch_array($result);
        echo $data['MAX(id)'];
        mysqli_close($con);
    } else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $con = mysqli_connect("localhost","root","blargHblargh1");
        mysqli_query($con, "use miniWeebly");
        $sth = mysqli_query($con, "SELECT * from pages");
        $rows = array();
        while($r = mysqli_fetch_assoc($sth)) {
            $rows[] = $r;
        }
        print json_encode($rows);
        mysqli_close($con);
    }
}

function validToken($api_token){
    $con = mysqli_connect("localhost","root","blargHblargh1");
    mysqli_query($con, "USE miniWeebly");
    $result = mysqli_query($con, "SELECT * FROM auth WHERE api_token = '" . $api_token . "'");
    if(mysqli_num_rows($result) > 0){
        return true;
    } else {
        return false;
    }
    mysqli_close($con); 
}
?>