$(function(){
    $('#btn-datafari-search').on('click', function(e){
        e.preventDefault();
        let term = $('#imput-datafari-search').val()
        let filters = '';
        //languages
        let languages = '';
        $('[data-search="languages"]').find('.uk-checkbox').each(function( index, element ) {
            if($(element).is(':checked')){
                let search = $(this).data('language')
                if(languages === ''){
                    languages += search;
                }else{
                    languages += ',' + search;
                }
            }
        })
        if(languages !== ''){
            filters += '&languages=' + languages;
        }

        //types
        let types = '';
        $('[data-search="types"]').find('.uk-checkbox').each(function( index, element ) {
            if($(element).is(':checked')){
                let search = $(this).data('type')
                if(types === ''){
                    types += search;
                }else{
                    types += ',' + search;
                }
            }
        })
        if(types !== ''){
            filters += '&types=' + types;
        }

        //sources
        let sources = ''
        $('[data-search="sources"]').find('.uk-checkbox').each(function( index, element ) {
            if($(element).is(':checked')){
                let search = $(this).data('source')
                if(sources === ''){
                    sources += search;
                }else{
                    sources += ',' + search;
                }
            }
        })
        if(sources !== ''){
            filters += '&sources=' + sources;
        }
        let baseURL = OC.generateUrl('/apps/datafari/');
        let finalURL  = filters === '' ? baseURL + "?search=" + term : baseURL + "?search=" + term + filters;
        window.location.href = finalURL;
    });

})