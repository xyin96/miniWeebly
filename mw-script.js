var currPage = -1;
var moID;
var tempChanged = false;
var moIDt;
var currID = 0;
var containerID = 0;
var timer;
var drag = false;
var mouseX = 0;
var mouseY = 0;
$(function() {
    $.get('functions.php?navBar=1', function(data, status){$(".preview-content-nav").html(data)});
    $('.preview-content-img').each(function(){
        $(this).html('<img src="' + $(this).attr('imgsrc') + '" />');
    });
    $(document).mouseover(function(event, ui){
        moID = event.target.id;
        if(drag){
            if(moID !== 'tempDemo' && (moID !== null) ){
                if($("#tempDemo").length){
                    var par = $("#tempDemo").parent();
                    if(par.attr('id').indexOf('container') !== -1){
                        $('#' + par.attr('id') + " > div").css("width", "9000px");
                        $('#' + par.attr('id') + " > div").css("display", "table-cell");
                    }
                    $("#tempDemo").remove();
                }
                    
                if(moID == 'previewContent'){
                    $('#previewContent').append("<div id='tempDemo'></div>");
                } else if(moID.indexOf("item") !== -1){
                    var par = $('#' + moID).parent();
                    if(event.clientY > $('#' + moID).position().top + $('#' + moID).height()*9/10) {
                        par.after("<div id='tempDemo'></div>");
                        console.log("bottom");
                    } else if(event.clientY < $('#' + moID).position().top + $('#' + moID).height()/10) {
                        par.before("<div id='tempDemo'></div>");
                        console.log("top");
                    } else if(event.clientX < $('#' + moID).position().left + 240 + $('#' + moID).width()/2){
                        $('#' + moID).before("<div id='tempDemo'></div>");
                        $('#' + par.attr('id') + " > div").css("display", "table-cell");
                        $('#' + par.attr('id') + " > div").css("width", "9000px");
                    } else if(event.clientX > $('#' + moID).position().left + 240 + $('#' + moID).width()/2){
                        $('#' + moID).after("<div id='tempDemo'></div>");
                        $('#' + par.attr('id') + " > div").css("display", "table-cell");
                        $('#' + par.attr('id') + " > div").css("width", "9000px");
                    } 
                } else if(moID.indexOf("container") !== -1){
                    console.log($('#' + moID).width()/2);
                    if(event.clientY > $('#' + moID).position().top + $('#' + moID).height()*9/10) {
                        $('#' + moID).after("<div id='tempDemo'></div>");
                        console.log("top");
                    } else if(event.clientY < $('#' + moID).position().top + $('#' + moID).height()*1/10) {
                        $('#' + moID).before("<div id='tempDemo'></div>");
                        console.log("bottom");
                    } else if(event.clientX > $('#' + moID).position().left + $('#' + moID).width()*1/2){
                        $('#' + moID).append("<div id='tempDemo' style='display:table-cell;'></div>");
                        $('#' + $('#' + moID).attr('id') + " > div").css("display", "table-cell");
                        $('#' + $('#' + moID).attr('id') + " > div").css("width", "9000px");
                        console.log("right");
                    } else if(event.clientX < $('#' + moID).position().left + $('#' + moID).width()*1/2) {
                        $('#' + moID).prepend("<div id='tempDemo' style='display:table-cell;'></div>");
                        $('#' + $('#' + moID).attr('id') + " > div").css("display", "table-cell");
                        $('#' + $('#' + moID).attr('id') + " > div").css("width", "9000px");
                        console.log("left");
                    }
                    currID++;
                }
            }
        }
    });
    $(document).mouseout(function(event, ui){
        $('#' + event.target.id).css('cursor','auto'); 
    });
    $(document).mousemove(function(event, ui){
        if(drag){
            $('#' + event.target.id).css('cursor','move');
        }
    });
    $(document).mouseup(function(event, ui){drag = false;});
    $("#previewContent").on('keyup', function(event, ui){
        if(event.target.id == 'addPageTitle'){
            if(event.target.innerHTML.length > 30){
                event.preventDefault();
            }
        }
        clearInterval(timer); 
        timer = setTimeout(function(){
            console.log(event.target.id);
            $.ajax({
                type: "PUT",
                url: 'api/4d35204677373410cc4a48bf915344bf/page/' + currPage + '/' + event.target.id,
                data: {mode:'r',
                       data: event.target.textContent,
                },
                async: false
            });
        }, 2500);
    });

    $('#addTextDiv').draggable({helper: function() {
        drag = true;
        return $(this).clone().css('pointer-events', 'none').appendTo("body").show();
    }});
    $('#addTitleDiv').draggable({helper: function() {
        drag = true;
        return $(this).clone().css('pointer-events', 'none').appendTo("body").show();
    }});
    $('#addImageDiv').draggable({helper: function() {
        drag = true;
        return $(this).clone().css('pointer-events', 'none').appendTo("body").show();
    }});
    $('#addNavDiv').draggable({helper: function() {
        drag = true;
        return $(this).clone().css('pointer-events', 'none').appendTo("body").show();
    }});
    
    $("#previewContent").click(function(event, ui){
        console.log(Math.abs($("#" + moID).position().left - event.clientX + $("#" + moID).width()), Math.abs($("#" + moID).position().top - event.clientY));
        if(Math.abs($("#" + moID).position().left - event.clientX + $("#" + moID).width()) < 25 && Math.abs($("#" + moID).position().top - event.clientY) < 25){
            $("#" + moID).css("background-image","url('/assets/Sprites/delete_element_confirm_icon.png')");
            $("#" + moID).animate({opacity: 0}, 100);
            var par = $("#" + moID).parent();
            if(par.attr('id') !== null){
                if(par.attr('id').indexOf('container') !== -1){
                    $('#' + par.attr('id') + " > div").css("width", "9000px");
                }
                setTimeout(function(){
                    if($('#' + par.attr('id') + " > div").length == 0){
                        par.remove();
                        $.ajax({
                            type: "PUT",
                            url: 'api/4d35204677373410cc4a48bf915344bf/page/' + currPage + '/' + par.attr('id'),
                            data: {mode:'d'},
                            async: false
                        });
                    } else {
                         $("#" + moID).remove();
                        $.ajax({
                            type: "PUT",
                            url: 'api/4d35204677373410cc4a48bf915344bf/page/' + currPage + '/' + moID,
                            data: {mode:'d'},
                            async: false
                        });
                    }
                }, 100);
            }

        }
    });

    $('#previewContent').droppable({
        drop:function(event, ui){
            console.log(event.clientX, event.clientY);
            console.log(moID);
            var par = $("#tempDemo").parent();
            console.log(par.attr('id'));
            if(par.attr('id') !== null){
                if(par.attr('id').indexOf("container") !== -1){
                    var newcontent = getContents(ui.draggable.attr('id'));
                    $("#tempDemo").replaceWith(newcontent);
                    $('#' + par.attr('id') + " > div").css("width", 9000);
                    $('#' + par.attr('id') + " > div").css("display", "table-cell");
                    $.ajax({
                        type: "PUT",
                        url: 'api/4d35204677373410cc4a48bf915344bf/page/' + currPage + '/' + par.attr('id'),
                        data: {mode:'r',
                               data: par.html(),
                               itemID: currID,
                               containerID: containerID
                        },
                        async: false
                    });
                } else {
                    var newcontent = getContents(ui.draggable.attr('id'));
                    $("#tempDemo").replaceWith(getContents(ui.draggable.attr('id')));
                    $('#item' + (currID)).wrap("<div id='container" + containerID + "' class='preview-content-container'>");
                    var cont = $("#container" + containerID);
                    containerID++;
                    $.ajax({
                        type: "PUT",
                        url: 'api/4d35204677373410cc4a48bf915344bf/page/' + currPage + '/',
                        data: {mode:'a',
                               data: cont[0].outerHTML,
                               num_items: currID,
                               num_containers: containerID
                              },
                        async: false
                    });
                }
                $('.preview-content-img').each(function(){
                    $(this).html('<img src="' + $(this).attr('imgsrc') + '" />');
                });
            }
            
        }
    });
    

    $( "#addPageConfirm" ).click(function() {
        createFile();
    });
});


function createFile(){
    var data =  {title: $("#addPageTitle").html()};
    $.ajax({
        type: "POST",
        url: '/api/4d35204677373410cc4a48bf915344bf/pages/',
        data: data,
        success: function(data){
            $( "#pageList" ).append( "<div class='toolbar-page-list-item' onclick='document.location=\"?p=" + data + "\"'><div><img src='assets/Sprites/delete_page_icon.png' class='toolbar-page-list-item-icon' /><img src='assets/Sprites/edit_page_icon.png' class='toolbar-page-list-item-icon' /></div><div class='toolbar-page-list-item-title' contenteditable>" + $("#addPageTitle").html() + "</div></div>" );
        }
    });
}

function editPageTitle(pageid){
    var newTitle = prompt("Please enter your name", "Harry Potter");
    if (newTitle != null) {
        document.getElementById("listItemTitle" + pageid).innerHTML = newTitle;
        var data =  {title: newTitle};
        $.ajax({
            type: "PUT",
            url: '/api/4d35204677373410cc4a48bf915344bf/page/' + pageid,
            data: data,
        });
    }

}

function deletePage(pageid){
    $.ajax({
        type: "DELETE",
        url: '/api/4d35204677373410cc4a48bf915344bf/page/' + pageid,
        async: false
    });
    document.location = "?p=-1";
}


function getContents(id){
    currID++;
    if(id == "addTitleDiv"){
        return "<div id='item" + currID + "' class='preview-content-title' contenteditable='true'>Click to edit title</div>";
    } else if (id == "addImageDiv"){
        return "<div id='item" + currID + "' class='preview-content-img' style='vertical-align:middle; text-align:center' style='vertical-align:middle' imgsrc='assets/Sprites/image_icon.png'></div>";
    } else if (id == "addTextDiv"){
        return "<div id='item" + currID + "' class='preview-content-text' contenteditable='true'>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</td>";
    } else if (id == "addNavDiv"){
        return "<div id='item" + currID + "' class='preview-content-nav'></div>";
    }
}

function signinCallback(authResult) {
  if (authResult['status']['signed_in']) {
    // Update the app to reflect a signed in user
    // Hide the sign-in button now that the user is authorized, for example:
    document.getElementById('signinButton').setAttribute('style', 'display: none');
    document.getElementById('mainContent').setAttribute('style', 'display:auto');
      gapi.client.load('plus','v1', function(){
         var request = gapi.client.plus.people.get({
           'userId': 'me'
         });
         request.execute(function(resp) {
             console.log(resp);
           console.log('Retrieved profile for:' + resp.emails[0].value);
             var data =  {email:resp.emails[0].value};
            $.ajax({
                type: "POST",
                url: '/api/auth/',
                data: data,
                success:function(data){
                    $("#api_token").html(data);
                }
            });
         });
        });
  } else {
    // Update the app to reflect a signed out user
    // Possible error values:
    //   "user_signed_out" - User is signed-out
    //   "access_denied" - User denied access to your app
    //   "immediate_failed" - Could not automatically log in the user
    console.log('Sign-in state: ' + authResult['error']);
      document.getElementById('mainContent').setAttribute('style', 'display:none');
  }
}