$(document).ready(function(){
    $('.dropdown-menu li a').click(function(){
        var numberPostByPage = $(this).text();
        
        $.ajax({
            type: 'post',
            url: "paginationProcess.php",
            data: {'numberPostByPage' : numberPostByPage},
            cache: false,
            dataType: "json",
            success: function(data) {
                var ajaxDisplay = document.getElementById('displayData');
                ajaxDisplay.innerHTML = data['newPosts'];
                
                //By selecting this action, the initial post page will get refresh
                if($('#initPostDiv').length) {
                    var initDisplay = document.getElementById('initPostDiv');
                    initDisplay.innerHTML = "";
                }                
            },
            error: function(jqXHR,textStatus,errorThrown) {
                console.log('exception is: ' + errorThrown);
            }
        }); //end ajax call
    });
    
    $('.next').on("click", function(){       
        $.ajax({
            type: 'post',
            url: "paginationProcess.php",
            data: {
                'actionPage' : 'next'
            },
            cache: false,
            dataType: "json",
            success: function(data) {
                var ajaxDisplay = document.getElementById('displayData');
                ajaxDisplay.innerHTML = data['newPosts'];
                    
                //By selecting this action, the initial post page will get refresh
                if ($('#initPostDiv').length) {
                    var initDisplay = document.getElementById('initPostDiv');
                    initDisplay.innerHTML = "";
                }
                
                if (data['previousDisplay']) $('.previous').show();
            },
            error: function(jqXHR,textStatus,errorThrown) {
                console.log('exception is: ' + errorThrown);
            }
        }); //end ajax call
    });
    
    $('.previous').click(function(){   
        $.ajax({
            type: 'post',
            url: "paginationProcess.php",
            data: {
                'actionPage' : 'previous'
            },
            cache: false,
            dataType: "json",
            success: function(data) {
                var ajaxDisplay = document.getElementById('displayData');
                ajaxDisplay.innerHTML = data['newPosts'];
                
                //By selecting this action, the initial post page will get refresh
                if ($('#initPostDiv').length) {
                    var initDisplay = document.getElementById('initPostDiv');
                    initDisplay.innerHTML = "";
                }
                
                if (!data['previousDisplay']) $('.previous').hide();
            },
            error: function(jqXHR,textStatus,errorThrown) {
                console.log('exception is: ' + errorThrown);
            }
        }); //end ajax call
    });
});