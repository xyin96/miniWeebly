<?php
if(isset($_GET['id'])){
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        if(validToken($_GET['api_token'])){
            $html = file_get_contents('../../pages/' . $_GET['id']);
            echo json_encode(html_to_obj($html));

        } else {
            echo 'invalid api token';
        }
    } elseif($_SERVER['REQUEST_METHOD'] === 'PUT') {
        parse_str(file_get_contents("php://input"), $vars);
        if(validToken($_GET['api_token'])){
            $html = file_get_contents('../../pages/' . $_GET['id']);
            echo $html;
            echo 'filecontents';
            $dom = new DOMDocument();
            
            if($html){
                echo 'hiii';
                $dom->loadHTML($html);          

                # remove <html><body></body></html> 
                $loadFrag = new DOMDocument;
                $body = $dom->getElementsByTagName('body')->item(0);
                foreach ($body->childNodes as $child){
                    $loadFrag->appendChild($loadFrag->importNode($child, true));
                }
                echo $loadFrag->saveHTML();
            }
            
            $elem = $dom->getElementById($_GET['target']);
            $frag = $dom->createDocumentFragment();
            $frag->appendXML($vars['data']);
            if($elem){
                switch($vars['appendMode']){
                    case 'b':
                        $elem->insertBefore($frag);
                    break;
                    case 'a':
                        $elem->insertAfter($frag);
                    break;
                    default:
                        switch($vars['mode']){
                            case 'a':
                                $elem->appendChild($frag);
                            break;
                            case 'r':
                                $elem->nodeValue = "";
                                $elem->appendChild($frag);
                            break;
                            case 'd':
                                $elem->parentNode->removeChild($elem);
                                echo 'deleting element ' . $_GET['target'] . '\n';
                            break;
                        }
                    break;
                }
                
            } else {
                echo 'invalid target element, appending to dom';
                $dom->appendChild($frag);
            }
            $con = mysqli_connect("localhost","root","blargHblargh1");
            mysqli_query($con, "USE miniWeebly");
            if(isset($vars['num_items']) && isset($vars['num_containers'])){
            mysqli_query($con, "UPDATE pages SET num_items=". $vars['num_items'] . ", num_containers=" . $vars['num_containers'] . " WHERE id=" . $_GET['id']);
            }
            if(isset($vars['title'])){
                mysqli_query($con, "UPDATE pages SET title='". $vars['title'] . "' WHERE id=" . $_GET['id']);
            }
            mysqli_close($con); 
            $dom->saveHTMLFile('../../pages/' . $_GET['id']);

        } else {
            echo 'invalid api token '.$vars['api_token'];
        }
    } elseif($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        parse_str(file_get_contents("php://input"), $vars);
        if(validToken($_GET['api_token'])){
            $con = mysqli_connect("localhost","root","blargHblargh1");
            mysqli_query($con, "USE miniWeebly");
            mysqli_query($con, "DELETE FROM pages WHERE id = " . $_GET['id']);
            mysqli_close($con);  
            unlink ('../../pages/' .$_GET['id']);
        } else {
            echo 'invalid api token: '.$vars['api_token'];
        }
    }
} else {
    echo 'no specified page';
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
function html_to_obj($html) {
    $dom = new DOMDocument();
    $dom->loadHTML($html);
    return element_to_obj($dom);
}
function element_to_obj($element) {
    $obj = array( "tag" => $element->tagName );
    foreach ($element->attributes as $attribute) {
        $obj[$attribute->name] = $attribute->value;
    }
    foreach ($element->childNodes as $subElement) {
        if ($subElement->nodeType == XML_TEXT_NODE) {
            $obj["html"] = $subElement->wholeText;
        }
        elseif ($subElement->nodeType == XML_CDATA_SECTION_NODE) {
            $obj["html"] = $subElement->data;
        }
        else {
            $obj["children"][] = element_to_obj($subElement);
        }
    }
    return $obj;
}
?>