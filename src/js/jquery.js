
// Salva a avaliação da notícia no banco de dados (ainda não terminado)
$('#enviarAvaliacao').on('click', function() {

      if($('#nota_avaliacao').val() == '' || $('#nota_avaliacao').val().length > 1)
      {
        alert('Nota inválida!');
      }else{
        //pegando id da noticia na URL
        let urlParams = new URLSearchParams(window.location.search);
        const idNoticia = urlParams.get('id');

        //Mandando a requisição AJAX
          $.ajax({
      url: "https://localhost/dentroDaInformacao/avaliar-noticia",
      method: "POST",
      data: {
        "nota_avaliacao": $('#nota_avaliacao').val(),
        "comentario_avaliacao": $('#comentario_avaliacao').val(),
        "id_noticia": idNoticia
      },
      success: function( result ) {
        $('.container-avaliar-noticia').html('<p id="msg-comentario-enviado">Comentário enviado com sucesso!</p>');
        $('.container-avaliar-noticia').addClass('section-comentario-enviado');
      },
      error: function(error) {
        $('.container-avaliar-noticia').html('<p id="msg-comentario-enviado">Não foi possível enviar seu comentário!!</p>');
        $('.container-avaliar-noticia').addClass('section-comentario-falhou');
      }
    });

  }

});
