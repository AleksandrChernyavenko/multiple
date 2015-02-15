/**
 * Created by Александр on 15.02.2015.
 */

$('*[data-toggle="glossary-popover"]').on('click',function(){
    var e=$(this);
    $.get(e.data('ajaxload'),function(response){

        var options = {
            title: response.title,
            content: response.description,
            html: true
        };
        e.popover(options).popover('show');
    });
    e.unbind('click');
    return false;
});