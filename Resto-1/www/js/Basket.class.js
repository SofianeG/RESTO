'use stric';


function onAddBasket(event)
{

    event.preventDefault();

    let url = $(this).data('url');
    let sendData =  {
        id: $(this).data('id')
    };

    $.getJSON(url, sendData, addedToBasket.bind($(this))) ;
}

function addedToBasket(data)
{

}


$(function () {
    $(".add-to-basket").on('click', onAddBasket) ;
});

