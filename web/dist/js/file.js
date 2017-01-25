$(document).ready(function() {
    $('#closed').on('click', function (e) {
        $('.cookies').fadeOut("slow");
        e.preventDefault();
        $.ajax({
            method: 'POST',
            url: 'http://localhost/symfony/web/app_dev.php/fr/public/accueil/cookiesAgree',
            data: 'disclaimer=1',
            success: onSuccess
        });
    });

    $('.ajouter').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            method: 'POST',
            url: 'http://localhost/symfony/web/app_dev.php/fr/ajouterProduitPanier',
            data: 'id=' + $(this).data('id') + '&qte='+$('.quantity').val(),
            dataType: 'json',
            success: panierUpdate
        });
    });

    $( ".target" ).change(function(e) {

        e.preventDefault();
        $.ajax({
            method: 'POST',
            url: 'http://localhost/symfony/web/app_dev.php/fr/updateQuantityProduitPanier',
            data: 'id=' + $(this).data('id') + '&qte='+$('[data-id="' + $(this).data('id') + '"]').val(),
            dataType: 'json',
            success: updatePanier
        });
    });

    $('.deleteFromPanier').on('click', function (e) {
        e.preventDefault();

        if (confirm('Etes-vous sur ?')) {

            var elementA = $(this);
            var elementParentTable = elementA.closest('table');
            $.ajax({
                method: 'POST',
                url: 'http://localhost/symfony/web/app_dev.php/fr/public/accueil/panierDeletebyId',
                data: 'id=' + $(this).data('id'),
                dataType: 'json',
                success: updatePanier
            }).done(function(){
                elementA.closest('tr').fadeOut(700, function(){
                    $(this).remove();

                    $('.alert-success').remove();

                    elementParentTable.before('<p class="alert alert-success">Produit supprimé</p>');
                    $('.alert-success').delay(3000).fadeOut()

                })
            });


        }

    });

    $('.js-datepicker').datepicker({
        minDate: "-100Y",
        maxDate: '0D',
        format: 'dd-mmy-yyyy'
    });

    function onSuccess(data) {
        console.log("Success" +data);
    }

    function panierUpdate(data) {
        $('.basket').html('<a href="{{path('panier')}}" class="basket"><i class="fa fa-shopping-basket" aria-hidden="true"></i>Panier: ' + data.nbArticle + ' Articles </a>');
    }

    function updatePanier(data) {
        panierUpdate(data);
        $('.PrixQte').html('<td class="PrixQte">{{ product.price*app.session.get("panier")[product.id] }}</td>');
        $('.Total').html('<td class="Total">{% set total = 0  %}{% for product in products %}{% set total = total + product.price*app.session.get("panier")[product.id] %}{% endfor %}{{ total }}</td>');

    }

});