<?php
// More about design modifications - www.opensolution.org/Quick.Cms/docs/?id=en-design
if( !defined( 'CUSTOMER_PAGE' ) )
  exit;

echo '<?xml'; ?> version="1.0" encoding="<?php echo $config['charset']; ?>"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $config['language']; ?>">
<head>
  <title><?php echo $sTitle.$config['title']; ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $config['charset']; ?>" />
  <meta name="Language" content="<?php echo $config['language']; ?>" />
  <meta name="Description" content="<?php echo $sDescription; ?>" />
  <meta name="Keywords" content="<?php echo $sKeywords; ?>" />
  <meta name="Generator" content="Quick.Cms v<?php echo $config['version']; ?>" />

  <script type="text/javascript" src="<?php echo $config['dir_core']; ?>common.js"></script>
  <script type="text/javascript" src="<?php echo $config['dir_plugins']; ?>mlbox/mlbox.js"></script>
    <?php if( !defined( 'JQUERY-LOADED' ) ){ echo '<script type="text/javascript" src="'.$config['dir_plugins'].'jquery-1.8.2.min.js"></script>'; define( 'JQUERY-LOADED', true ); } ?>
      <script type="text/javascript" src="<?php echo $config['dir_plugins']; ?>nivo-slider/jquery.nivo.slider.pack.js"></script>
      <link rel="stylesheet" href="<?php echo $config['dir_plugins']; ?>nivo-slider/themes/default/default.css" type="text/css" media="screen" />
      <link rel="stylesheet" href="<?php echo $config['dir_plugins']; ?>nivo-slider/nivo-slider.css" type="text/css" media="screen" />
  <script type="text/javascript"><!-- var cfBorderColor = "#aeb7bb"; //--></script>
  <?php displayAlternateTranslations( ); ?>
  <style type="text/css">@import "<?php echo $config['dir_skin'].$config['style']; ?>";</style>
  <?php if( isset( $aData['sName'] ) && isset( $aData['iPage'] ) && $aData['iPage'] == $config['start_page'] ){ ?>
    <style type="text/css">
      .subpagesList{display:none;}
      .listHome .subpagesList{display:block;}
    </style>
  <?php } ?>
<link rel="stylesheet" href="<?php echo $config['dir_skin']; ?>menu.css" />
<?php if( isset( $aData['iScroll'] ) ){ if( !defined( 'JQUERY-LOADED' ) ){ ?><script type="text/javascript" src="<?php echo $config['dir_plugins']; ?>jquery-1.10.2.min.js"></script><?php define( 'JQUERY-LOADED', true ); } ?><script type="text/javascript">$(imagesSliderInit);</script><?php } ?>
    <?php if( !defined( 'JQUERY-LOADED' ) ){ echo '<script type="text/javascript" src="'.$config['dir_plugins'].'jquery-1.9.1.min.js"></script>'; define( 'JQUERY-LOADED', true ); } ?>
      <script type="text/javascript">$(function(){ backToTop(); });</script>
    </head>
<body<?php if( isset( $aData['iPage'] ) && is_numeric( $aData['iPage'] ) ) echo ' id="page'.$aData['iPage'].'"'; ?>>
<div class="skiplink"><a href="#content" accesskey="1"><?php echo $lang['Skip_navigation']; ?></a></div>

<div id="container">
      <?php   
        if( !empty( $GLOBALS['config']['question_page'] ) && isset( $oPage->aPages[$GLOBALS['config']['question_page']] ) )
          echo '<div id="sideTab"><a href="'.$oPage->aPages[$config['question_page']]['sLinkName'].'" >'.$lang['Have_question'].'</a></div>'; ?>
  <div id="header">
    <div id="head1"><?php // banner, logo and slogan starts here ?>
      <div class="container">
        <div id="logo"><?php // logo and slogan ?>
          <div id="title"><a href="./" tabindex="1"><?php echo $config['logo']; ?></a></div>
          <div id="slogan"><?php echo $config['slogan']; ?></div>
        </div>
      </div>
    </div>
    <div id="head2"><?php // top menu starts here ?>
      <div class="container">
        <?php echo $oPage->throwMenu( 1, $iContent, 1 ); // content of top menu ?>
      </div>
    </div>
  </div>
  <div id="body">
    <div class="container">
      <div id="head-img">
        <img src="<?php echo $config['dir_skin']; ?>img/img_46.jpg"> 
        <div class="theme-default">
          <!-- SLIDER STARTS HERE -->
          <div id="slider" class="nivoSlider">
            <img src="<?php echo $config['dir_files']; ?>_slider-1.jpg" alt="" title="Bidang Transmisi & Distribusi | UIW KALTIMRA" />
            <img src="<?php echo $config['dir_files']; ?>_slider-2.jpg" alt="" title="PENGENDALIAN DAN OPERASI | DALOPS"/>
            <img src="<?php echo $config['dir_files']; ?>_slider-3.jpg" alt="" title="Aplikasi AGO Web & Mobile - UIW Kaltimra "/>
            <img src="<?php echo $config['dir_files']; ?>_slider-4.jpg" alt="" title="Aplikasi Inspeksi Jaringan - JARVIST" />
            <img src="<?php echo $config['dir_files']; ?>_slider-5.jpg" alt="" title="PLN BERAKHLAK - HANDAL - TERBAIK" />
          </div>
          <script type="text/javascript">
              $(window).load(function() {
                  $('#slider').nivoSlider();
              });
          </script>
        </div>
      </div>
  <?php if( isset( $aData['sName'] ) && isset( $aData['iPage'] ) && $aData['iPage'] == $config['start_page'] ){ ?>
    <div class="listHome">
      <?php echo $oPage->listSubpages( $aData['iPage'], 3 ); // displaying subpages ?>
    </div>
    <?php } ?>
    <div id="column"><?php // left column with left menu ?>
      <?php echo $oPage->throwMenu( 2, $iContent, 1 ); // content of left menu 
            echo $oPage->throwRandomPage( 4 ); // random page box 
            echo $oPage->listSimpleNews( $config['news_type'] ); // simple news box ?>
    </div>
    <div id="content">
            <div class="theme-default"><!-- SLIDER STARTS HERE -->
              <div id="slider" class="nivoSlider">
                <img src="<?php echo $config['dir_files']; ?>_slider-1.jpg" alt="" /><!-- PUT YOUR IMAGES HERE -->
                <img src="<?php echo $config['dir_files']; ?>_slider-2.jpg" alt="" /> 
		            <img src="<?php echo $config['dir_files']; ?>_Slider-3.jpg" alt="" />
                <img src="<?php echo $config['dir_files']; ?>_slider-4.jpg" alt="" />
                <img src="<?php echo $config['dir_files']; ?>_slider-5.jpg" alt="" />
              </div>

              <script type="text/javascript">
              $(window).load(function() {
                  $('#slider').nivoSlider();
              });
              </script>
            </div>
