var url = 'http://pixelgram.com';
window.addEventListener("load", function(){

   $('.btn-like').css('cursor', 'pointer');
   $('.btn-dislike').css('cursor', 'pointer');

   //Botón de like
    function like(){
        $('.btn-like').unbind('click').click(function(){
            console.log('like');
            $(this).addClass('btn-dislike').removeClass('btn-like');
            $(this).attr('src', url+'/img/corazon-rojo.png');
            $.ajax({
                url: url+'/like/'+$(this).data('id'),
                type:'GET',
                success: function(response){
                    if (response){
                        console.log('Has dado like a la publicacion');
                    }else{
                        console.log('Error al dar like');
                    }
                }
            });
            dislike();
        });
    }
    like();

    function dislike(){
        $('.btn-dislike').unbind('click').click(function(){
            console.log('dislike');
            $(this).addClass('btn-like').removeClass('btn-dislike');
            $(this).attr('src', url+'/img/corazon-negro.png');
            $.ajax({
                url: url+'/dislike/'+$(this).data('id'),
                type:'GET',
                success: function(response){
                    if (response){
                        console.log('Has dado dislike a la publicacion');
                    }else{
                        console.log('Error al dar dislike');
                    }
                }
            });
            like();
        });
    }
    dislike();

    //BUSCADOR
    $('#buscador').submit(function(){
        $(this).attr('action', url+'/gente/'+$('#buscador #search').val());
    });


});
