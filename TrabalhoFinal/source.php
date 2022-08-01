<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <!-- <script src="scripts/utils.js"></script> -->
  <!-- <script src="scripts/script.js" defer></script> -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/tela.css">

  <!-- Bootstrap CSS -->
  <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l"
        crossorigin="anonymous"
  />

  <script
      src="https://code.jquery.com/jquery-3.5.1.min.js"
      integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
      crossorigin="anonymous"
  ></script>
  <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
      integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
      crossorigin="anonymous"
  ></script>
  <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"
      integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF"
      crossorigin="anonymous"
  ></script>

  <style>
    #Conteiner_Btn
    {
      text-align: center;
      margin: 10px;
      display: none;
    }
  </style>
</head>
<body>
  <h1>Urna Eletrônica</h1>

  <div class="urna-area">
    <div class="urna">
      <div class="tela">
        <div class="principal">
          <div class="esquerda">
            <div class="rotulo r1">
              <span>Seu voto para</span>
            </div>
            <div class="rotulo r2">
              <span>Cargo</span>
            </div>
            <div class="rotulo r3">
              <div class="numero pisca"></div>
              <div class="numero"></div>
            </div>
            <div class="rotulo r4">
              <div class="mensagem"></div>
              <p class="nome-candidato">Nome: <span>Fulano de Tal</span></p>
              <p class="partido-politico">Partido: <span>XXXX</span></p>
              <p class="nome-vice">Vice-Prefeito: <span>Ciclano de Tal</span></p>
            </div>
          </div>
          <div class="direita">
            <div class="candidato">
              <div class="imagem">
                <img src="" alt="Candidato">
              </div>
              <div class="cargo">
                <p>Prefeito</p>
              </div>
            </div>
            <div class="candidato menor">
              <div class="imagem">
                <img src="" alt="Vice">
              </div>
              <div class="cargo">
                <p>Vice-Prefeito</p>
              </div>
            </div>
          </div>
        </div>
        <div class="rodape">
          <p>
            Aperte a tecla<br>
            CONFIRMA para CONFIRMAR este voto<br>
            CORRIGE para REINICIAR este voto.
          </p>
        </div>
      </div>

      <div class="lateral">
        <div class="logoarea">
          <img src="img/brasao.png" alt="Brasão da República">
          <h2>Justiça Eleitoral</h2>
        </div>

        <div class="teclado">
          <div class="teclado--linha">
            <div class="teclado--botao">1</div>
            <div class="teclado--botao">2</div>
            <div class="teclado--botao">3</div>
          </div>
          <div class="teclado--linha">
            <div class="teclado--botao">4</div>
            <div class="teclado--botao">5</div>
            <div class="teclado--botao">6</div>
          </div>
          <div class="teclado--linha">
            <div class="teclado--botao">7</div>
            <div class="teclado--botao">8</div>
            <div class="teclado--botao">9</div>
          </div>
          <div class="teclado--linha">
            <div class="teclado--botao">0</div>
          </div>
          <div class="teclado--linha">
            <div class="teclado--botao especial branco">Branco</div>
            <div class="teclado--botao especial laranja">Corrige</div>
            <div class="teclado--botao especial verde">Confirma</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- <div id="Conteiner_Btn" style="text-align: center; margin: 10px; display: none;"> -->
  <div id="Conteiner_Btn">
    <button id="BtnContinua" class="btn btn-success"> Continuar Votação </button>
    <button id="BtnEncerra" class="btn btn-success"> Encerrar Votação </button>
  </div>

  <div id="QuadroResultado" class="margin: 10px;"></div>

  <?php require "footer.php" ?>
</body>
</html>