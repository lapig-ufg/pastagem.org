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
<script src="<?php echo $tmpTools->templateurl() ?>/<?php echo $tmpTools->templateurl() ?>/js/bootstrap.js"></script>
<title><?php echo $tmpTools->sitename() ?> - <?php echo $tmpTools->pagetitle() ?></title>
<link href="<?php echo $tmpTools->templateurl() ?>/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $tmpTools->templateurl() ?>/css/bootstrap-theme.min.css" rel="stylesheet">
<link href="<?php echo $tmpTools->templateurl() ?>/css/pastagem.css" rel="stylesheet">

<jdoc:include type="head" />
<style>
body {
  background: white;
}
</style>

</head>
<body>
  <div class="container full-width border-header-1" style="border-top: none;">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="background: url('<?php echo $tmpTools->templateurl() ?>/img/fundos/<? echo $img ?>'); height: 10px;">
      </div>
    </div>
  </div>
  <div class="container" >
    <div class="row margin-top-15">
      <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> 
        <h2 class="title-header">
          Pastagem<a href="/">.org</a>
        </h2>
      </div>
      <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9"> 
        <!-- Menu ================================================== -->
        <!--jdoc:include type="modules" name="menu"/-->
        <p class="pull-right">
          <!--<a href="http://www.ufg.br">
            <img class="pull-right img-responsive img-foot" src="<?php echo $tmpTools->templateurl() ?>/img/logo-ufg.png" />
          </a>-->
          <a href="http://www.agroicone.com.br/">
            <img class="pull-right img-responsive img-foot" src="<?php echo $tmpTools->templateurl() ?>/img/logo-agroicone.jpg" />
          </a>
          <a href="http://www.sae.gov.br">
            <img class="pull-right img-responsive img-foot" src="<?php echo $tmpTools->templateurl() ?>/img/logo-sae.png" />
          </a>
          <a href="http://www.lapig.iesa.ufg.br">
            <img class="pull-right img-responsive img-foot" src="<?php echo $tmpTools->templateurl() ?>/img/logo-lapig.png" />
          </a>
        </p>
      </div>
    </div>
  </div>
  <div class="container full-width border-header-1" style="border-bottom: 0px;">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid gray; background: url('<?php echo $tmpTools->templateurl() ?>/img/fundos/<? echo $img ?>'); height: 240px; background-position: 0px -149px;">
        <?php if(!$tmpTools->isFrontPage()) { ?>
          <div class="container">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 float-menu">
                <jdoc:include type="modules" name="menu" />
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>


  </div>
  <div class="container margin-top-15 margin-bottom-15" >

    <?php if($tmpTools->isFrontPage()) { ?>
      <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
          <div class="row margin-bottom-15">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a href="index.php/apresentacao">
                  <img class="img-responsive pull-right" src="<?php echo $tmpTools->templateurl() ?>/img/ico-apresentacao.png" />
                </a>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a href="index.php/apresentacao">
                  <h4 class="text pull-right"> 
                    Apresentação
                    <small><br>Ententa a importância das pastagens para o país</small>
                  </h4>
                </a>
              </div>
            </div>
          </div>
          <div class="row margin-bottom-15">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a href="index.php/equipe">
                  <img class="img-responsive pull-right" src="<?php echo $tmpTools->templateurl() ?>/img/ico-equipe.png" />
                </a>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a href="index.php/equipe">
                  <h4 class="text pull-right"> 
                    Equipe
                    <small><br>Conheça os pesquisadores envolvidos nessa iniciativa</small>
                  </h4>
                <a/>
              </div>
            </div>
          </div>
          <div class="row margin-bottom-15">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a href="index.php/mapa-interativo">
                  <img class="img-responsive pull-right" src="<?php echo $tmpTools->templateurl() ?>/img/ico-mapa-interativo.png" />
                </a>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a href="index.php/mapa-interativo">
                  <h4 class="text pull-right"> 
                    Mapa Interativo
                    <small><br>Acesse os dados espaciais gerados até o momento</small>
                  </h4>
                </a>
              </div>
            </div>
          </div>
          <div class="row margin-bottom-15">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a href="index.php/bases-documentais">
                  <img class="img-responsive pull-right" src="<?php echo $tmpTools->templateurl() ?>/img/ico-documentos.png" />
                </a>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a href="index.php/bases-documentais">
                  <h4 class="text pull-right"> 
                    Bases Documentais
                    <small><br>Acesse as publicações, relatórios e documentos gerados até o momento</small>
                  </h4>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 border-center-1">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="row">
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                  <a target="_blank" href="http://pastagem.org/index.php/bases-documentais/finish/24-relatorios/1023-manual-de-utilizacao-do-portal-pastagem-org/0">
                    <img class="img-responsive pull-left" src="<?php echo $tmpTools->templateurl() ?>/img/manual.png" />
                  </a>
                </div>
                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                  <a target="_blank" href="http://pastagem.org/index.php/bases-documentais/finish/24-relatorios/1023-manual-de-utilizacao-do-portal-pastagem-org/0">
                    <h4 class="text pull-right"> 
                     Manual de Utilização
                      <small><br>Explore todo o conteúdo do portal e do mapa interativo</small>
                    </h4>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <hr/>
              <jdoc:include type="modules" name="right" />
            </div>
          </div>
        </div>
      </div>
    <?php } else { ?>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top-15 margin-bottom-15">
            <!-- Component ================================================== -->
            <jdoc:include type="component" />
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
  <div class="container full-width border-header-1" >
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="background: url('<?php echo $tmpTools->templateurl() ?>/img/fundos/<? echo $img ?>'); height: 40px; background-position: 0px -397px;">
      </div>
    </div>
  </div>
  <div class="container" >
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 footer"> 
        <p class="center" style="text-align: center;">
          <!-- Syndicate ================================================== -->
          <jdoc:include type="modules" name="syndicate" />
        </p>
      </div>
    </div>
  </div>
  <div class="container full-width border-header-1" >
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="background: url('<?php echo $tmpTools->templateurl() ?>/img/fundos/<? echo $img ?>'); height: 40px; background-position: 0px -494px;">
      </div>
    </div>
  </div>
</body>
</html>
