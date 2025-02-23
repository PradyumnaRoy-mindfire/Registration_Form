var favouriteModule = (function($){
    $('.favouriteIcon').on('click',function(){
        $(".container2").show();
    })
    $('.closeFavourite').on('click',function() {
        $(".container2").hide();
    })
    $('#openForm').on('click',function() {
        $(".dropdown-form").toggle();
    })
    
    function storeFavouriteData(){
        
        $(".Favourite-btn").on('click',function(e) {
            e.preventDefault();
            let favData = {};

            let id = $("#favouriteId").val();
            let name = $("#favouriteName").val();
            let item = $("#favouriteItem").val();
                //favourite data validation
            let isValid = true;
            $("#favNameErr").text("");
            $("#favItemErr").text("");

            if (name === "") {
                $("#favNameErr").text("**This field is required...");
                $("#favouriteName").addClass('errorEffect');
                
                isValid = false;
            } else if (/\d/.test(name)) {
                $("#favNameErr").text("**Name should not contain any digit...");
                $("#favouriteName").addClass('errorEffect');
                isValid = false;
            }
            if (item === "") {
                $("#favItemErr").text("**This field is required...");
                $("#favouriteItem").addClass('errorEffect');
                isValid = false;
            }



            if(isValid) {
                favData = {
                    'id' : id,
                    'name' : name,
                    'item' : item               //To use a variable as key we have take []
                }
                $.ajax({
                    url:'/test/Form/php/profile.php',
                    type:"GET",
                    data: {
                        action :'storeFavouriteData',
                        rowId : parseInt(id),
                        favData : favData
                    },
                    success: function(response) {
                        //add row in the fav table
                        var newRow = $("<tr class='temp' >''</tr>");
                        newRow.append($(`<td>${favData.id}</td>`))
                        newRow.append($(`<td>${favData.name}</td>`))
                        newRow.append($(`<td>${favData.item}</td>`))
                        newRow.append($(`<i class="fa-solid fa-trash  btnDelete" style="color: #ff0a0a;"></i>`));
                        $(".emptyRow").before(newRow);
                        $("#favouriteId").val(parseInt(id)+1);
                    }
                });

                
                $("#favouriteForm")[0].reset();
            }
        });
    }
    
    function favouriteDelete(){
        $(".container2").on('click', '.btnDelete', function() {
            var row = $(this).closest('tr'); 
            var slno = row.find('td:eq(0)').text();
            var id = row.index();
            $.ajax({
                url: '/test/Form/php/deleteFavourite.php', 
                type: 'GET', //  GET request sending to php
                data: {
                    
                    action: 'delete', 
                    id: slno,// in array it is 0-base indexing and row in table row 1-base indexing
                },
                success: function(response) {
                    // if the deletion is successful
                    row.remove();
                }
                
            });
        });
    }
    
    function logOut() {
        $('.logoutIcon').on('click',function() {
                //confirmation message
            pageModule.displayLogoutPopup('.logputPopup');
            $('#btnLogoutPopup').on('click',function() {
                $(".container").removeClass("doBlur");
                $('.logoutPopup').hide(500);

                $.ajax({
                    url:'/test/Form/php/profile.php',
                    type : 'GET',
                    data : {
                        action : 'logout'
                    },
                    success : function(){
                        window.location.href = `http://${window.location.hostname}//Form/login`;
                    }
                });
            });

            $('#btnCancelPopup').on('click',function() {
                $(".container").removeClass("doBlur");
                $('.logoutPopup').hide(500);
            });
            
            
        });
    }

    function init(){
       favouriteDelete();
       logOut();
       storeFavouriteData();
    }
    return {
        init:init,
    }
})(jQuery);