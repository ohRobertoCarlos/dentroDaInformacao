
// Salva a avaliação da notícia no banco de dados (ainda não terminado)
$('#enviarAvaliacao').on('click', function() {

      if($('#nota_avaliacao').val() == '' || $('#nota_avaliacao').val().length > 1)
      {
        alert('Nota inválida!');
      }else{
          $.ajax({
      url: "https://localhost/dentroDaInformacao/avaliar-noticia",
      method: "POST",
      data: {
        "nota_avaliacao": $('#nota_avaliacao').val(),
        "comentario_avaliacao": $('#comentario_avaliacao').val()
      },
      success: function( result ) {
        console.log(result);
      }
    });

  }

});
