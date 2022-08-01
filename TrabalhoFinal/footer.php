<?php 

/**
 * Similar to javascript's console.log
 *
 * @param $data object to be printed on the console.
 * @return void
 */
function console_log($data)
{
    echo "<script>";
    echo "console.log(" . json_encode($data) . ")";
    echo "</script>";
}

/**
 *  A better output for print_r.
 *
 * @param $val
 * @return void 
 */
function print_r2($val)
{
    echo "<pre>";
    print_r($val);
    echo "</pre>";
}


/**
 * Função para criar um array associativo no padrão do json exigido no
 * frontend
 * 
 * @return string
 */
function createDataJson()
{
  $dataJson = [
    "0" => [
      "titulo" => "vereador",
      "numeros" => 5,
      "candidatos" => createDataVereador()
    ],



    "1" => [
      "titulo" => "prefeito",
      "numeros" => 2,
      "candidatos" => createDataPrefeito()
    ]
  ];

  return json_encode($dataJson);
}


/**
 * Função para criar um array associativo no padrão do json exigido no frontend
 * para o vereador
 * 
 * @return array
 */
function createDataVereador()
{
  //Realizando conexão com o banco de dados
  include "connection.php";

  //Realizando consulta no banco de dados
  $queryVereador = "SELECT * FROM `vereador`";
  $vereadores = mysqli_query($link, $queryVereador);
  $dataVereador = [];

  if($vereadores)
  {
    //Trabalhando o array para inserir as informaçãoes
    while($currentVereador = mysqli_fetch_array($vereadores))
    {
      $dataVereador[$currentVereador['numero']] = [
               "nome" => $currentVereador['nome'],
               "partido" => $currentVereador['partido'],
               "foto" => $currentVereador['foto']
      ];
    }
  }

  //Retornando estrutura com os dados inseridos
  return $dataVereador;
}


/**
 * Função para criar um array associativo no padrão do json exigido no frontend
 * para o prefeito
 * 
 * @return array
 */
function createDataPrefeito()
{
  //Realizando conexão com o banco de dados
  include "connection.php";

  //Realizando consulta no banco de dados
  $queryPrefeito = "SELECT * FROM `prefeito`";
  $prefeitos = mysqli_query($link, $queryPrefeito);
  $dataPrefeitos = [];

  if($prefeitos)
  {
    //Trabalhando o array para inserir as informaçãoes
    while($currentPrefeito = mysqli_fetch_array($prefeitos))
    {
      $dataPrefeitos[$currentPrefeito['numero']] = [
               "nome" => $currentPrefeito['nome'],
               "partido" => $currentPrefeito['partido'],
               "foto" => $currentPrefeito['foto'],
               "vice" => [
                  "nome" => $currentPrefeito['vice'],
                  "partido" => $currentPrefeito['partidoVice'],
                  "foto" => $currentPrefeito['fotoVice']
               ]
      ];
    }
  }

  //Retornando estrutura com os dados inseridos
  return $dataPrefeitos;
}


/**
 * Função que computa o voto efetuado
 * 
 * @param $post Cargo pleteado
 * @param $numberCandidate Número do candidato
 * @return void 
 */
function computeVote($post, $numberCandidate)
{
  // console_log("passei aqui");
  //Realizando conexão com o banco de dados
  include "connection.php";

  //Construindo a query apropriada e inserindo no campo votos do bd
  $query = "";
  if($post == "vereador")
  {
    $query = "UPDATE `vereador` SET voto = voto + 1 WHERE numero = ".$numberCandidate;
  }
  else
  {
    $query = "UPDATE `prefeito` SET voto = voto + 1 WHERE numero = ".$numberCandidate;
  }

  //Executando a query
  mysqli_query($link, $query);
  
}

/**
 * Função para reiniciar os votos dos candidados para uma nova eleição
 * 
 * @return void
 */
function restartVotes()
{
  //Realizando conexão com o banco de dados
  include "connection.php";

  //Construindo a query apropriada e inserindo no campo votos do bd
  $queryVereador = "UPDATE `vereador` SET voto = 0";
  $queryPrefeito = "UPDATE `prefeito` SET voto = 0";

  //Executando a query
  mysqli_query($link, $queryVereador);
  mysqli_query($link, $queryPrefeito);
}

/**
 * Função que executa o computo de votos
 * 
 * @return void
 */
function executionComputeVote()
{
  if(isset($_POST["post"]) && isset($_POST["numberCandidate"]))
  {
    $post = $_POST["post"];
    $numberCandidate = $_POST["numberCandidate"];
    computeVote($post, $numberCandidate); 
  }
}

?>

<script type="text/javascript">
    var rVotoPara = document.querySelector('.esquerda .rotulo.r1 span')
    var rCargo = document.querySelector('.esquerda .rotulo.r2 span')
    var numeros = document.querySelector('.esquerda .rotulo.r3')
    var rDescricao = document.querySelector('.esquerda .rotulo.r4')
    var rMensagem = document.querySelector('.esquerda .rotulo.r4 .mensagem')
    var rNomeCandidato = document.querySelector('.esquerda .rotulo.r4 .nome-candidato')
    var rPartidoPolitico = document.querySelector('.esquerda .rotulo.r4 .partido-politico')
    var rNomeVice = document.querySelector('.esquerda .rotulo.r4 .nome-vice')
    var rRodape = document.querySelector('.tela .rodape')
    
    var rCandidato = document.querySelector('.direita .candidato')
    var rVice = document.querySelector('.direita .candidato.menor')

    const telaInicial = $(".tela").html();
    
    var votos = []
    
    var etapaAtual = 0
    var etapas = null
    var numeroDigitado = ''
    var votoEmBranco = false

    <?php $resu = createDataJson();?>
    var data = <?php echo "$resu";?>;
    console.log(data);

    etapas = data;
    
    comecarEtapa();
    
    window.onload = () => {
      let btns = document.querySelectorAll('.teclado--botao')
      for (let btn of btns) {
        btn.onclick = () => {
          clicar(btn.innerHTML)
        }
      }
  
      document.querySelector('.teclado--botao.branco').onclick = () => branco()
      document.querySelector('.teclado--botao.laranja').onclick = () => corrigir()
      document.querySelector('.teclado--botao.verde').onclick = () => confirmar()

      $("#BtnContinua").click(function() 
      {
        inicializa();
        comecarEtapa();
        $("#Conteiner_Btn").toggle(); 
      });
      $("#BtnEncerra").click(function()
      {
        $("#QuadroResultado").html(JSON.stringify(votos));
      });

      <?php restartVotes(); ?>
    }

    /**
     * Função para realizar inicialização
     */
    function inicializa()
    {
      $(".tela").html(telaInicial);

      rVotoPara = document.querySelector('.esquerda .rotulo.r1 span')
      rCargo = document.querySelector('.esquerda .rotulo.r2 span')
      numeros = document.querySelector('.esquerda .rotulo.r3')
      rDescricao = document.querySelector('.esquerda .rotulo.r4')
      rMensagem = document.querySelector('.esquerda .rotulo.r4 .mensagem')
      rNomeCandidato = document.querySelector('.esquerda .rotulo.r4 .nome-candidato')
      rPartidoPolitico = document.querySelector('.esquerda .rotulo.r4 .partido-politico')
      rNomeVice = document.querySelector('.esquerda .rotulo.r4 .nome-vice')
      rRodape = document.querySelector('.tela .rodape')
    
      rCandidato = document.querySelector('.direita .candidato')
      rVice = document.querySelector('.direita .candidato.menor')
    
      // votos = []

      etapaAtual = 0;
      numeroDigitado = '';
      votoEmBranco = false;
    }
    
    /**
     * Inicia a etapa atual.
     */
    function comecarEtapa() {
      let etapa = etapas[etapaAtual]
      console.log('Etapa atual: ' + etapa['titulo'])
    
      numeroDigitado = ''
      votoEmBranco = false
    
      numeros.style.display = 'flex'
      numeros.innerHTML = ''
      rVotoPara.style.display = 'none'
      rCandidato.style.display = 'none'
      rVice.style.display = 'none'
      rDescricao.style.display = 'none'
      rMensagem.style.display = 'none'
      rNomeCandidato.style.display = 'none'
      rPartidoPolitico.style.display = 'none'
      rNomeVice.style.display = 'none'
      rRodape.style.display = 'none'
    
      for (let i = 0; i < etapa['numeros']; i++) {
        let pisca = i == 0 ? ' pisca' : ''
        numeros.innerHTML += `
          <div class="numero${pisca}"></div>
        `
      }
  
      rCargo.innerHTML = etapa['titulo']
    }
    
    /**
     * Procura o candidato pelo nÃºmero digitado,
     * se encontrar, mostra os dados dele na tela.
     */
    function atualizarInterface() {
      console.log('NÃºmero Digitado:', numeroDigitado)
    
      let etapa = etapas[etapaAtual]
      let candidato = null
    
      for (let num in etapa['candidatos']) {
        if (num == numeroDigitado) {
          candidato = etapa['candidatos'][num]
          break
        }
      }
  
      console.log('Candidato: ' + candidato)
  
      rVotoPara.style.display = 'inline'
      rDescricao.style.display = 'block'
      rNomeCandidato.style.display = 'block'
      rPartidoPolitico.style.display = 'block'
  
      if (candidato) {
        let vice = candidato['vice']
    
        rRodape.style.display = 'block'
        rNomeCandidato.querySelector('span').innerHTML = candidato['nome']
        rPartidoPolitico.querySelector('span').innerHTML = candidato['partido']
    
        rCandidato.style.display = 'block'
        rCandidato.querySelector('.imagem img').src = `img/${candidato['foto']}`
        rCandidato.querySelector('.cargo p').innerHTML = etapa['titulo']
        
        if (vice) {
          rNomeVice.style.display = 'block'
          rNomeVice.querySelector('span').innerHTML = vice['nome']
          rVice.style.display = 'block'
          rVice.querySelector('.imagem img').src = `img/${vice['foto']}`
        } else {
          rNomeVice.style.display = 'none'
        }
    
        return
      }
  
      if (votoEmBranco) return
  
      // Anular o voto
      rNomeCandidato.style.display = 'none'
      rPartidoPolitico.style.display = 'none'
      rNomeVice.style.display = 'none'
  
      rMensagem.style.display = 'block'
      rMensagem.classList.add('pisca')
      rMensagem.innerHTML = 'VOTO NULO'
    }
    
    /**
     * Verifica se pode usar o teclado e atualiza o nÃºmero.
     */
    function clicar(value) {
      console.log(value)
    
      let elNum = document.querySelector('.esquerda .rotulo.r3 .numero.pisca')
      if (elNum && ! votoEmBranco) {
        numeroDigitado += (value)
        elNum.innerHTML = value
        elNum.classList.remove('pisca')
    
        let proximoNumero = elNum.nextElementSibling
        if (proximoNumero) {
          proximoNumero.classList.add('pisca')
        } else {
          atualizarInterface()
        }
    
        (new Audio('audio/se1.mp3')).play()
      }
    }
    
    /**
     * Verifica se hÃ¡ nÃºmero digitado, se nÃ£o,
     * vota em branco.
     */
    function branco() {
      console.log('branco')
    
      // Verifica se hÃ¡ algum nÃºmero digitado,
      // se sim, nÃ£o vota
      if (! numeroDigitado) {
        votoEmBranco = true
    
        numeros.style.display = 'none'
        rVotoPara.style.display = 'inline'
        rDescricao.style.display = 'block'
        rMensagem.style.display = 'block'
        rMensagem.innerHTML = 'VOTO EM BRANCO';
    
        (new Audio('audio/se1.mp3')).play()
      }
  
    }
    
    /**
     * Reinicia a etapa atual.
     */
    function corrigir() {
      console.log('corrigir');
      (new Audio('audio/se2.mp3')).play()
      comecarEtapa()
    }
    
    /**
     * Confirma o numero selecionado.
     */
    function confirmar() {
      console.log('confirmar')
    
      let etapa = etapas[etapaAtual]
    
      if (numeroDigitado.length == etapa['numeros']) {
        if (etapa['candidatos'][numeroDigitado]) {
          // Votou em candidato
          votos.push({
            'etapa': etapa['titulo'],
            'numero': numeroDigitado
          })
          console.log(`Votou em ${numeroDigitado}`)

          $.ajax({
              type: "POST",
              url: "footer.php",
              data: {
                post: etapa['titulo'],
                numberCandidate: numeroDigitado
              },
              success: function(response){<?php executionComputeVote() ?>}
            });

          // $.post("footer.php",{post: etapa['titulo'],numberCandidate: numeroDigitado},function(){});

        } else {
          // Votou nulo
          votos.push({
            'etapa': etapa['titulo'],
            'numero': null
          })
          console.log('Votou Nulo')
        }
      } else if (votoEmBranco) {
        // Votou em branco
          votos.push({
            'etapa': etapa['titulo'],
            'numero': ''
          })
          console.log('Votou em Branco')
      } else {
        // Voto nÃ£o pode ser confirmado
        console.log('Voto nÃ£o pode ser confirmado')
        return
      }
  
      if (etapas[etapaAtual + 1]) {
        etapaAtual++
      } else {
        document.querySelector('.tela').innerHTML = `
          <div class="fim">FIM</div>
        `;
        $("#Conteiner_Btn").toggle();
      }
  
      (new Audio('audio/se3.mp3')).play()
      comecarEtapa()
    }
</script>