$(document).ready( function() {

    //FUNCTION AJAX
    function reqAjax(){
        $.ajax({
            async: true,
            type: 'POST',
            url: "{{ path('ajouter_panier', {'id' : app.request.get('_route_params')['id']}) }}",
            success: function (data) {
                if(data == "1"){
                    alert('Article ajouté au panier !');
                    return;
                } else {
                    alert('Il y a eu un problème ! -> '+data);
                    return;
                }
            },
            complete : function(){
                // do
            }
        });
    }
    $('#addPanier').click(function(){
        reqAjax();
    });
});