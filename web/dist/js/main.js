$(document).ready(function () {
    $("table").on("click", ".btn-danger",function(event){
            event.preventDefault();

            if (confirm('Etes-vous sur ?')) {

                var elementA = $(this);
                var elementParentTable = elementA.closest('table');
                var linkUrl = elementA.parent().attr('href');
                // Requête Ajax
                // http://api.jquery.com/jquery.ajax/
                // The jqXHR Object => promise
                $.ajax({
                    url : linkUrl,
                    method: "GET",
                }).done(function(data){
                    elementA.closest('tr').fadeOut(700, function(){
                        //console.log($(this));
                        $(this).remove();

                        $('.alert-success').remove();

                        elementParentTable.before('<p class="alert alert-success">'+data.message+'</p>');
                        elementParentTable.before(message);
                        message.delay(3000).fadeOut()

                    })
                });


            }


        });
});