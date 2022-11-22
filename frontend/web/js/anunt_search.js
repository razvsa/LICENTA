(function($){
    $('body').on('beforeSubmit', 'form#anunt_search', function(event) {
        console.log("aici");
        var form = $(this);
        if (form.find('.has-error').length) {
            return false;
        }
        $.get(
            form.attr('action'),
            form.serialize()
        ).done(function(result){

            var url = form.attr('action') + '?' + form.serialize();
            $.pjax.reload("#anunt_search_pjax",{url: url});  //Reload GridView

        }).fail(function(){
            var url = form.attr('action');
            $.pjax.reload("#anunt_search_pjax",{ push: false,  url: url});
        });
        return false;
    });
}) (jQuery);