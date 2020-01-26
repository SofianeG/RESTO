'use strict' ;


function onRemoveButtonClick(event)
{
    event.preventDefault();
    if(confirm("êtes vous sûr de vouloir supprimer cet élément ?"))
    {
        let url = $(this).data('url');
        let sendData =  {
            id: $(this).data('id')
        };

        $.getJSON(url, sendData, onRemoved.bind($(this))) ;
    }
}

function onRemoved(data)
{
    let container = $(this).parents(".removable-container");
    container.fadeOut("slow" , function ()
                        {
                            container.remove();
                        }) ;
}

$(function () {
    $(".ajax-remove-button").on('click', onRemoveButtonClick) ;
});
