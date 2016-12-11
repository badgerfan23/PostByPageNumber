<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="mystyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="Event.js" ></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
	<body class="divSide">
        <div class = "container">
                <div class="row">
                    <div class="col-md-2"></div>
                        <div class="col-md-8 well mainDiv" style="padding-left: 5%; padding-right: 5%;">
                            <div class="row">
                                <div class="dropdown text-right">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Posts Per Page
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="#">5</a></li>
                                        <li><a href="#">10</a></li>
                                        <li><a href="#">15</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row postScroll">
                                <p id ='displayData'></p>
                                <?php
                                    session_start();                                    
                                
                                    //initiailization code for first time page loading with default
                                    //here we count once the total number of post.
                                    $response = file_get_contents('http://www.envano.com/wp-json/posts');
                                    $response2 = json_decode($response, true);
                                    $_SESSION['totalPosts'] = count($response2);
                                    $_SESSION['postPerPage'] = 5;
                                    $_SESSION['page'] = 1;
                                    
                                    $response = file_get_contents('http://www.envano.com/wp-json/posts?filter[posts_per_page]=' . $_SESSION['postPerPage'] .'&page=1');
                                    $response2 = json_decode($response, true);
                                    
                                    echo "<div id='initPostDiv'>";

                                    $featureImageFirstPost = true;

                                    foreach($response2 as $val) {
                                        if ($featureImageFirstPost) {
                                            echo "<div class='row'><div class='col-md-12'>";
                                            echo "<img class='img-responsive img-thumbnail' src='" . $val['featured_image']['source'] . "'></img><br>";
                                            echo "</div></div>";
                                            $featureImageFirstPost = false;
                                        }

                                        echo "<div class='row'>";

                                        echo "<div class='col-md-3'>";                                            
                                        echo "<br><img class='img-responsive img-rounded portraitAuthor' src='" . $val['author']['avatar'] . "'></img><br>";                                            
                                        $author = explode(",", $val['author']['name']);
                                        $authorName = isset($author[0] )? $author[0] : '';
                                        $authorRole = isset($author[1] )? $author[1] : '';
                                        echo  $authorName . "<br>" . $authorRole;
                                        echo "</div>";
                                        
                                        echo "<div class='col-md-9'>";
                                        echo "<h3><b>" . $val['title'] . '</b></h3><p>';                                           
                                        $newDate = explode("T", $val['date']);
                                        $newDateFormat = date_create($newDate[0]);
                                        echo date_format($newDateFormat , "F d, Y") . '</p>';
                                        echo "<br>" . $val['excerpt'] . '<br>';
                                        echo "</div>";

                                        echo "</div>";

                                        echo "<div class='row'><div class='col-md-12' style='height: 1px; background-color: black;'><hr></div></div>";
                                    }
                                    echo "</div>";  
                                ?>
                            </div>
                            <div class="row">
                                <ul class="pager">
                                   <li class="previous" style="display: none;"><a href="#">Previous</a></li>
                                    <li class="next"><a href="#">Next</a></li>
                                </ul>
                            </div>
                    </div>    
                <div class="col-md-2"></div>    
            </div>    
        </div>
	</body>
</html>