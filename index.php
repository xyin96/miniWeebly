
<html>
<head>
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    <script src="jquery.ui.touch-punch.min.js"></script>
    <script type="text/javascript">
        (function() {
           var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
           po.src = 'https://apis.google.com/js/client:plusone.js';
           var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
         })();
    </script>
    <!--<script>(function(a){(jQuery.browser=jQuery.browser||{}).mobile=/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))})(navigator.userAgent||navigator.vendor||window.opera);</script>-->
    <script src="mw-script.js"></script>
    <style>@import "styles.css"</style>
</head>
<body>
    <div id="mainContent">
    <div class="header-wrap">
        <div class="logo" onclick='document.location="/"'>
            <img src="assets/Sprites/Weebly-Logo.png"  width="39" height="39" alt=""/>
        </div>
	</div>
    
    <div class="toolbar-wrap">
    		<div class="header-filler"></div>
    		<div class="toolbar-content">
            	<div class="toolbar-content-accordian">
                	<div class="toolbar-content-accordian-panel">
                    	<div class="toolbar-content-accordian-panel-header">PAGES</div>
                            <div class="toolbar-content-accordian-panel-body">
                                <div class="toolbar-page-list">
                                    <div id="pageList">
                                        <?php
                                            $con = mysqli_connect("localhost","root","blargHblargh1");
                                            mysqli_query($con, "USE miniWeebly;");
                                            $result = mysqli_query($con, "SELECT * FROM pages");
                                            while ($row = mysqli_fetch_array($result)) {
                                                    echo '<div class="toolbar-page-list-item">';
                                                    echo '<div><img src="assets/Sprites/delete_page_icon.png" class="toolbar-page-list-item-icon" onclick="deletePage(' . $row['id'] . ')" /><img src="assets/Sprites/edit_page_icon.png" class="toolbar-page-list-item-icon" onclick="editPageTitle(' . $row['id'] . ')" /></div>';
                                                    echo '<div class="toolbar-page-list-item-title" id="listItemTitle' . $row['id'] . '" onclick="location.href=\'?p=' . $row['id'] . '\'"> ' . $row['title'] . '</div>';
                                                    echo '</div>';
                                            } 
                                            mysqli_close($con);
                                        ?>
                                    </div>
                                    <div class="toolbar-page-list-add" id="addPageBtn">
                                        <div><img src="assets/Sprites/add_page_icon.png" class="toolbar-page-list-add-icon" id="addPageConfirm" /></div>
                                        <div class="toolbar-page-list-item-title" id="addPageTitle" contenteditable="true" style='width:130px'>Add Page</div>
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                    <div class="toolbar-content-accordian-panel">
                    	<div class="toolbar-content-accordian-panel-header">ELEMENTS</div>
                        <div class="toolbar-content-accordian-panel-body">
                        	<img src="assets/Sprites/title_icon.png" class="toolbar-elements-item" id="addTitleDiv" />
                            <img src="assets/Sprites/text-icon.png" class="toolbar-elements-item" id="addTextDiv" />
                            <img src="assets/Sprites/image_icon.png" class="toolbar-elements-item" id="addImageDiv" />
                            <img src="assets/Sprites/nav_icon.png" class="toolbar-elements-item" id="addNavDiv" />
                        </div>
                    </div>
                    <div class="toolbar-content-accordian-panel">
                    	<div class="toolbar-content-accordian-panel-header">SETTINGS</div>
                        <div class="toolbar-content-accordian-panel-body">Templates</div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="content-wrap">
    		<div class="header-filler">
                <?php 
                    $con = mysqli_connect("localhost","root","blargHblargh1");
                    mysqli_query($con, "USE miniWeebly");
                    $resp = mysqli_query($con, "SELECT title, num_items,num_containers FROM pages WHERE id = " . $_GET['p']);
                    $row = mysqli_fetch_array($resp);
                    mysqli_close($con); 
                    if($_GET['p'] > 0){
                        echo '<script>currPage = ' . htmlspecialchars($_GET['p']) . '; currID=' . $row["num_items"] . ';containerID= ' .$row["num_containers"] . '</script>'; 
                    }
                ?>
                <div id="pagenum"></div>
            </div>
            
        	<div class="preview-content" id="previewContent">
                <?php
				    if($_GET['p'] > 0){
                        echo file_get_contents('pages/' . $_GET['p']);
                    } else {
                        $con = mysqli_connect("localhost","root","blargHblargh1");
                        mysqli_query($con, "USE miniWeebly");
                        $result = mysqli_query($con, "SELECT * FROM auth where email = " . $_POST['email']);
                        $row = mysqli_fetch_array($result);
                        echo 'Hi! To get started, add or click on a page on the left panel.';
                        echo ' ' . 'Your api token is: <b id="api_token">'.$row['api_token'].'</b>';
                    }
                ?>
                
            </div>
        </div>
    </div>
    <div id="auth">
        <center>
            <span id="signinButton" style='vertical-align:middle'>
              <span
                class="g-signin"
                data-callback="signinCallback"
                data-clientid="1060726691134-s19d75oq17arnu3mndagp8l9d25l678v.apps.googleusercontent.com"
                data-cookiepolicy="single_host_origin"
                data-requestvisibleactions="http://schema.org/AddAction"
                data-scope="https://www.googleapis.com/auth/plus.profile.emails.read">
              </span>
            </span>
            </center>
    </div>
</body>
</html>