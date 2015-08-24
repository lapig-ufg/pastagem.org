<?php

defined( '_JEXEC' ) or die( 'Restricted access' );
include_once (dirname(__FILE__).DS.'/php/ja_vars.php');

if( !array_key_exists('pastagem_img', $_COOKIE) ) {
  $exp = time() + 60*60*24;
  $selImg = $tmpTools->getRandomImage(dirname(__FILE__).DS.'img/fundos/');
  setcookie ('pastagem_img', $selImg, $exp, '/');
  $_COOKIE['pastagem_img'] = $selImg;
}

$img = $_COOKIE['pastagem_img'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<script src="<?php echo $tmpTools->templateurl() ?>/<?php echo $tmpTools->templateurl() ?>/js/bootstrap.js"></script>
<title><?php echo $tmpTools->sitename() ?> - <?php echo $tmpTools->pagetitle() ?></title>
<link href="<?php echo $tmpTools->templateurl() ?>/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $tmpTools->templateurl() ?>/css/bootstrap-theme.min.css" rel="stylesheet">
<link href="<?php echo $tmpTools->templateurl() ?>/css/pastagem.css" rel="stylesheet">
<link href = "<?php echo $tmpTools->templateurl() ?>/css/font-awesome.min.css" rel = "stylesheet" >

<jdoc:include type="head" />
<style>
body {
  background: white;
}
</style>

</head>
<body>
  
  <div class="row" style="background-image: url(<?php echo $tmpTools->templateurl() ?>/img/fundos/<? echo $img ?>); background-position: left top;">
    <div style="padding-top: 10px;">
      <div class = "col-sm-12 col-md-12 col-lg-12 col-xs-12" style="background-color:rgba(255, 255, 255, 0.9);   border-top: 1px solid gray; border-bottom: 1px solid gray;">
        <div class="container"><!--Logomarcas-->
          
          <div class="row">

            <div class="col-sm-9 col-md-9 col-lg-9 col-xs-9" style="margin-top: 10px;"><a href="http://pastagem.org/">
              <img src="<?php echo $tmpTools->templateurl() ?>/img/logomarca.png" width="250" align="left" class="img-responsive" style="margin-bottom:12px">
            </a>
            </div>

            <div class="col-sm-3 col-md-3 col-lg-3 col-xs-3" style="margin-top: 10px;">
              <div class="row">
                <div class = "col-sm-6 col-md-6 col-lg-6 col-xs-6">
                  <a href="https://www.ufg.br/" target="new">
                    <img src="<?php echo $tmpTools->templateurl() ?>/img/logo-ufg.png" class="img-responsive" style="height:50px; margin-top:5px; margin-left:4px">
                  </a>
                </div>
                <div class = "col-sm-6 col-md-6 col-lg-6 col-xs-6">
                  <a href="http://www.lapig.iesa.ufg.br/lapig/" target="new">
                    <img src="<?php echo $tmpTools->templateurl() ?>/img/logo-lapig.png" class="img-responsive" style="margin-left:-15px; height: 50px;">
                  </a>
                </div>
              </div>

              <div class="row">
                <div class = "col-sm-12 col-md-12 col-lg-12 col-xs-12">
                  <a href="http://www.agroicone.com.br/" target="new">
                    <img src="<?php echo $tmpTools->templateurl() ?>/img/logo-agroicone.png" class="img-responsive" align="left">
                  </a>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    <div class = "col-sm-12 col-md-12 col-lg-12 col-xs-12">
      <div class="container">
        <div class = "row"> <!-- Menus -->
          <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
            <jdoc:include type="modules" name="menu" />
          </div>
        </div>
      </div>
    </div>

    <?php if($tmpTools->isFrontPage()) { ?>
    <div class="container">
      <div class = "row" style="margin-top:325px;" align="center"></div>
    </div>
  </div>

  <div class="container margin-top-15 margin-bottom-15" >

    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  border-center-1">
        <div class = "row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class = "row">
              <div class="col-sm-3 col-md-3 col-lg-3 col-xs-3">
                <a href="index.php/bases-documentais/viewdownload/23-apresentacoes/1024-radiografia-das-pastagens-do-brasil-resultados-desdobramentos-e-perspectivas">
                <img src="<?php echo $tmpTools->templateurl() ?>/img/icon-apresentacoes.png" class="img-responsive"style="height: 80px;">
                </a>
              </div>
              <div class="col-sm-9 col-md-9 col-lg-9 col-xs-9">
                <a href="index.php/bases-documentais/viewdownload/23-apresentacoes/1024-radiografia-das-pastagens-do-brasil-resultados-desdobramentos-e-perspectivas"><h4 class="text pull-left"> Radiografia das Pastagens do Brasil</h4></a>
                  <div class= "descricao"><span><br><br>Saiba mais sobre os resultados, desdobramentos e perspectivas do Projeto.</br></br></span>
                  </div>
              </div>
            </div>

            <div class = "row" style="margin-top: 30px">
              <div class="col-sm-3 col-md-3 col-lg-3 col-xs-3">
                <a href="index.php/mapa-interativo">
                <img src="<?php echo $tmpTools->templateurl() ?>/img/icon-mapas.png" class="img-responsive"style="height: 80px;">
                </a>
              </div>
              <div class="col-sm-9 col-md-9 col-lg-9 col-xs-9">
                <a href="index.php/mapa-interativo"><h4 class="text pull-left"> Dados Geográficos</h4></a>
                  <div class= "descricao"><span><br><br>Acesse o mapa interativo para consultar, visualizar e obter dados relacionados a atividade agropecuária brasileira.</br></br></span>
                  </div>
              </div>
            </div>

            <div class = "row" style="margin-top: 30px; text-align:left">
              <div class="col-sm-3 col-md-3 col-lg-3 col-xs-3">
                <a href="index.php/bases-documentais/viewdownload/29-periodicos/1063-fazendeiros-e-frigorificos-responderam-aos-acordos-de-desmatamento-zero-na-amazonia-brasileira">
                <img src="<?php echo $tmpTools->templateurl() ?>/img/icon-publicacoes.png" class="img-responsive"style="height: 80px;">
                </a>
              </div>
              <div class="col-sm-9 col-md-9 col-lg-9 col-xs-9">
                <a href="index.php/bases-documentais/viewdownload/29-periodicos/1063-fazendeiros-e-frigorificos-responderam-aos-acordos-de-desmatamento-zero-na-amazonia-brasileira">
                  <h4 class="text pull-left">Desmatamento Zero na Amazônia ?</h4>
                </a>
                  <div class= "descricao"><span><br><br>Veja as novas intervenções na cadeia de fornecimento no setor de carne bovina no Brasil para reduzir o desmatamento.</br></br></span>
                  </div>
              </div>
            </div>

            <div class = "row" style="margin-top: 30px">
              <div class="col-sm-3 col-md-3 col-lg-3 col-xs-3">
                <a href="index.php/bases-documentais/viewdownload/24-relatorios/1014-analise-dos-recursos-do-programa-abc">
                <img src="<?php echo $tmpTools->templateurl() ?>/img/icon-relatorios.png" class="img-responsive"style="height: 80px;">
                </a>
              </div>
              <div class="col-sm-9 col-md-9 col-lg-9 col-xs-9">
                <a href="index.php/bases-documentais/viewdownload/24-relatorios/1014-analise-dos-recursos-do-programa-abc"><h4 class="text pull-left"> Análise dos Recursos do Programa ABC</h4></a>
                  <div class= "descricao"><span><br><br>Conheça o plano ABC cujo o principal objetivo é minimizar as emissões de gases do efeito estufa.</br></br></span>
                  </div>
              </div>
            </div>

            <div class = "row" style="margin-top: 30px">
              <div class="col-sm-3 col-md-3 col-lg-3 col-xs-3">
                <a href="index.php/noticias-pastagem/703-conheco-um-projeto-colaborativo-de-analise-das-acoes-de-pecuaria-sustentavel-na-amazonia">
                <img src="<?php echo $tmpTools->templateurl() ?>/img/icon-mapas-brasil.png" class="img-responsive"style="height: 80px;">
                </a>
              </div>
              <div class="col-sm-9 col-md-9 col-lg-9 col-xs-9">
                <a href="index.php/noticias-pastagem/703-conheco-um-projeto-colaborativo-de-analise-das-acoes-de-pecuaria-sustentavel-na-amazonia"><h4 class="text pull-left"> Novo Portal: zerodeforestationcattle.org</h4></a>
                  <div class= "descricao"><span><br><br>Um portal de informações sobre criação de gado na Amazônia com enfoque em desmatamento zero.</br></br></span>
                  </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <jdoc:include type="modules" name="right" />
      </div>
    </div>
    <?php } else { ?>
      <div class="row" style="  padding-top: 220px; padding-bottom: 5px;">
        <div class = "col-sm-12 col-md-12 col-lg-12 col-xs-12" style="background-color:rgba(255, 255, 255, 0.9);   border-top: 1px solid gray; border-bottom: 1px solid gray; height:60px">
          <div class="container">
                <h3 style="color:#5b6421; text-align:center; text-align: center; text-overflow: ellipsis; white-space: nowrap;"><?php echo $tmpTools->pagetitle() ?></h3>
          </div>
        </div>
      </div>
  </div>

    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-bottom-15">
            <!-- Component ================================================== -->
                <br>
            <jdoc:include type="component" />
            <jdoc:include type="modules" name="center" />
          </div>
        </div>
      </div>
    <?php } ?>
    </div>
  </div>
  
  <div class="row">
    <div class = "col-sm-12 col-md-12 col-lg-12 col-xs-12" style="background-color:#5b6421; border-bottom: 1px solid #5b6421;"></div>
    <div class = "col-sm-12 col-md-12 col-lg-12 col-xs-12" style="background-color: rgba(59, 66, 17, 0.20);   border-top: 2px solid #E4E4E4; border-bottom: 1px solid gray; text-align:center">

      <div class="container"> <!-- Logomarcas de parceiros e endereço -->
        <div class = "row" style="margin-top: 10px; margin-bottom:10px">
          <div class = "col-sm-2 col-md-2 col-lg-2 col-xs-2" style="margin-top: 05px;">
            <a href="https://www.moore.org/" target="new"><img src="<?php echo $tmpTools->templateurl() ?>/img/logo-moore.png"></a>
          </div>
          <div class = "col-sm-10 col-md-10 col-lg-10 col-xs-10" style="margin-left:-30px;">
            <div class = "col-sm-12 col-md-12 col-lg-12 col-xs-12">
              <a href="http://www.sae.gov.br/" target="new"><img src="<?php echo $tmpTools->templateurl() ?>/img/logo-sae.png" style="margin-right: 25px;"></a>
              <a href="http://www.agrosatelite.com.br/" target="new"><img src="<?php echo $tmpTools->templateurl() ?>/img/logo-agrosatelite.png" style="margin-right: 25px;"></a>
              <a href="http://www.agroconsult.com.br/" target="new"><img src="<?php echo $tmpTools->templateurl() ?>/img/logo-agroconsult.png" style="margin-right: 25px;"></a>
              <a href="http://www.wwf.org.br/" target="new"><img src="<?php echo $tmpTools->templateurl() ?>/img/logo-wwf.png" style="margin-right: 25px;"></a>
            </div>

            <div class = "col-sm-12 col-md-12 col-lg-12 col-xs-12" style="margin-top:10px;">
              <a href="http://www.aliancadaterra.org/" target="new"><img src="<?php echo $tmpTools->templateurl() ?>/img/logo-alianca-da-terra.png" style="margin-right: 25px; margin-left:25px"></a>
              <a href="http://www.appliedgeosolutions.com/" target="new"><img src="<?php echo $tmpTools->templateurl() ?>/img/logo-geosolutions.png" style="margin-right: 25px;"></a>
              <a href="http://www.tnc.org.br/" target="new"><img src="<?php echo $tmpTools->templateurl() ?>/img/logo-nature-conservancy.png" style="margin-right: 25px;"></a>
              <a href="http://www.icv.org.br/site/" target="new"><img src="<?php echo $tmpTools->templateurl() ?>/img/logo-icv.png" style="margin-right: 25px;"></a>
            </div>
          </div>
        </div>
        </div>
     </div>
    </div>
  

  <div class="row">
    <div class = "col-sm-12 col-md-12 col-lg-12 col-xs-12" style="background-color:#5b6421; border-bottom: 1px solid #5b6421;"></div>
    <div class = "col-sm-12 col-md-12 col-lg-12 col-xs-12" style="background-color: #3b4211;   border-top: 2px solid #E4E4E4; border-bottom: 1px solid gray;">

      <div class="container"> <!-- Endereço e redes sociais -->
        <div class = "row">
          <div class = "col-sm-8 col-md-8 col-lg-8 col-xs-8" align="center" style="color:white; margin-top:15px;">
            <jdoc:include type="modules" name="syndicate" />
          </div>
          <div class = "col-sm-1 col-md-1 col-lg-1 col-xs-1" style="margin-top:20px;">
            <a href="https://www.facebook.com/pages/Pastagemorg/382861661860792" target="new"><img src="<?php echo $tmpTools->templateurl() ?>/img/logo-face.png" class="img-responsive" style="height:50px;"></a>
          </div>
          <div class = "col-sm-1 col-md-1 col-lg-1 col-xs-1" style="margin-top:20px;">
            <a href="https://twitter.com/pastagem_org" target="new"><img src="<?php echo $tmpTools->templateurl() ?>/img/logo-twitter.png" class="img-responsive" style="height:50px;"></a>
          </div>
          <div class = "col-sm-1 col-md-1 col-lg-1 col-xs-1" style="margin-top:20px;">
            <a href="https://plus.google.com/u/1/113285336366387073137/posts" target="new"><img src="<?php echo $tmpTools->templateurl() ?>/img/logo-google+.png" class="img-responsive" style="height:50px;"></a>
          </div>
          <div class = "col-sm-1 col-md-1 col-lg-1 col-xs-1" style="margin-top:20px;"> 
            <a href="https://br.linkedin.com/pub/pastagem-org/100/a38/3b6" target="new"><img src="<?php echo $tmpTools->templateurl() ?>/img/logo-linkedin.png" class="img-responsive" style="height:50px;"></a>
          </div>
        </div>
      </div>

    </div>
  </div>

</body>
</html>
