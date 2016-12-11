<?php
    session_start();
    
    if (!empty($_POST['actionPage'])) {
        if($_POST['actionPage'] == 'next') {
            $_SESSION['page'] += 1;
        }
        if ($_POST['actionPage'] == 'previous') {
            $_SESSION['page'] -= 1;
        }    
    }
        
    if (!empty($_POST['numberPostByPage']))  {
        $_SESSION['postPerPage'] = $_POST['numberPostByPage'];
    }

    $response = file_get_contents('http://www.envano.com/wp-json/posts?filter[posts_per_page]=' . $_SESSION['postPerPage'] . '&page=' .  $_SESSION['page']);
    $response2 = json_decode($response, true);
        
    $responseDiv = '';    
    $featureImageFirstPost = true;

    foreach($response2 as $val) {
        if ($featureImageFirstPost) {
            $responseDiv = $responseDiv . "<div class='row'><div class='col-md-12'>";
            $responseDiv = $responseDiv . "<img class='img-responsive img-thumbnail' src='" . $val['featured_image']['source'] . "'></img><br>";
            $responseDiv = $responseDiv . "</div></div>";
            $featureImageFirstPost = false;
        }

        $responseDiv = $responseDiv . "<div class='row'>";

        $responseDiv = $responseDiv . "<div class='col-md-3'>";                                            
        $responseDiv = $responseDiv . "<br><img class='img-responsive img-rounded portraitAuthor' src='" . $val['author']['avatar'] . "'></img><br>";                                            
        $author = explode(",", $val['author']['name']);
        $authorName = isset($author[0] )? $author[0] : '';
        $authorRole = isset($author[1] )? $author[1] : '';
        $responseDiv = $responseDiv .  $authorName . "<br>" . $authorRole;
        $responseDiv = $responseDiv . "</div>";
        
        $responseDiv = $responseDiv . "<div class='col-md-9'>";
        $responseDiv = $responseDiv . "<h3><b>" . $val['title'] . '</b></h3><p>';                                           
        $newDate = explode("T", $val['date']);
        $newDateFormat = date_create($newDate[0]);
        $responseDiv = $responseDiv . date_format($newDateFormat , "F d, Y") . '</p>';
        $responseDiv = $responseDiv . "<br>" . $val['excerpt'] . '<br>';
        $responseDiv = $responseDiv . "</div>";

        $responseDiv = $responseDiv . "</div>";

        $responseDiv = $responseDiv . "<div class='row'><div class='col-md-12' style='height: 1px; background-color: black;'><hr></div></div>";
    }
    
    if($_SESSION['page'] == 1) {
        $jsonData = array('previousDisplay' => false, 'newPosts' =>$responseDiv);
        echo json_encode($jsonData);
    } else {
        $jsonData = array('previousDisplay' => true, 'newPosts' =>$responseDiv);        
        echo json_encode($jsonData);
    }
?>