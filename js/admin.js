$(function(){

    $('#submitDatafariURL').on('click', function(e){
        e.preventDefault();
        let proxyUrl = $('#searchProxyUrl').val();
        let url = OC.generateUrl('/apps/datafari/settings');
        $.ajax({
            url: url,
            method: 'POST',
            data: { searchProxyUrl: proxyUrl},
            success: function (data) {
                
            },
            error: function() {

            }
        })
    });
});