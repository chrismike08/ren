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
  <meta name="Generator" content="Quick.Cms.Add v<?php echo $config['version']; ?>" />

  <script type="text/javascript" src="<?php echo $config['dir_core']; ?>common.js"></script>
  <script type="text/javascript" src="<?php echo $config['dir_plugins']; ?>mlbox/mlbox.js"></script><?php
  if( !empty( $config['google_analytics_id'] ) && $config['google_analytics_id'] != 'UA-xxxxxx-x' ){?>
    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', '<?php echo $config['google_analytics_id']; ?>']);
      _gaq.push(['_trackPageview']);
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script><?php
  }?>
  <script type="text/javascript"><!-- var cfBorderColor = "#aeb7bb"; //--></script>
  <?php displayAlternateTranslations( ); ?>
  <style type="text/css">@import "<?php echo $config['dir_skin'].$config['style']; ?>";</style>
  <style type="text/css">@import "<?php echo $config['dir_skin']; ?>menu.css";</style> <?php // drop down menu styles ?>
</head>
<body<?php if( isset( $aData['iPage'] ) && is_numeric( $aData['iPage'] ) ) echo ' id="page'.$aData['iPage'].'"'; ?>>
<div class="skiplink"><a href="#content" accesskey="1"><?php echo $lang['Skip_navigation']; ?></a></div>

<div id="container">
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
        <?php echo $oPage->throwMenu( 1, $iContent, ( $config['display_dropdown_menu'] == 1 ) ? 1 : 0 ); // content of top menu ?>
      </div>
    </div>
  </div>
  <div id="body">
    <div class="container">
      <div id="column"><?php // left column with left menu ?>
        <?php echo $oPage->throwMenu( 2, $iContent, 1 ); // content of left menu 
        echo $oPage->listSimpleNews( $config['news_type'] ); // simple news box ?>
        <div class="box"><?php // simple counter box ?>
          <div class="type"><?php echo $lang['Visits']; ?>:</div>
          <div class="content visits">
            <span><?php echo $lang['Visits_today']; ?>: <strong><?php echo $aVistisCounter[1]; ?></strong></span><em><?php echo $lang['Visits_all_time']; ?>: <strong><?php echo $aVistisCounter[0]; ?></strong></em>
          </div>
        </div>
      </div>
      <div id="content">