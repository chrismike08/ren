<?php
/*
* Quick.Cms by OpenSolution.org
* www.OpenSolution.org
*/
extract( $_GET );
define( 'CUSTOMER_PAGE', true );

require 'database/config/general.php';
require DB_CONFIG_LANG;

if( HIDDEN_SHOWS === true )
 session_start( );

header( 'Content-Type: text/html; charset='.$config['charset'] );
require_once DIR_LIBRARIES.'file-jobs.php';
require_once DIR_LIBRARIES.'flat-files.php';
require_once DIR_LIBRARIES.'trash.php';
require_once DIR_PLUGINS.'plugins.php';

require_once DIR_DATABASE.'_fields.php';
require_once DIR_CORE.'pages.php';
require_once DIR_CORE.'files.php';

$aActions = getUrlFromGet( );
if( isset( $aActions['f'] ) && $aActions['f'] == 'pages' )
  $iContent = ( isset( $aActions['a'] ) && is_numeric( $aActions['a'] ) ) ? $aActions['a'] : $config['start_page'];
else
  $iContent = null;

$oFFS = FlatFilesSerialize::getInstance( );
$oPage = Pages::getInstance( );
$oFile = Files::getInstance( $iContent );
$sTitle = null;
$sTheme = null;

$sKeywords = $config['keywords'];
$sDescription = $config['description'];
$aVistisCounter = simpleCounter( );

if( isset( $iContent ) && is_numeric( $iContent ) ){
  $aData = $oPage->throwPage( $iContent );
  if( isset( $aData ) ){
    
    if( !empty( $aData['sUrl'] ) ){
      header( 'Location: '.$aData['sUrl'] );
      exit;
    }

    if( !empty( $aData['sMetaKeywords'] ) )
      $sKeywords = $aData['sMetaKeywords'];
    if( !empty( $aData['sMetaDescription'] ) )
      $sDescription = $aData['sMetaDescription'];
    if( !empty( $aData['sTheme'] ) )
      $sTheme = $aData['sTheme'];
    else{
      if( $config['inherit_from_parents'] === true && !empty( $aData['iPageParent'] ) && !empty( $oPage->aPages[$aData['iPageParent']]['sTheme'] ) ){
        $sTheme = $oPage->aPages[$aData['iPageParent']]['sTheme'];
      } 
    }
    if( empty( $aData['sDescriptionFull'] ) && !empty( $aData['sDescriptionShort'] ) )
      $aData['sDescriptionFull'] = $aData['sDescriptionShort'];

    $aData['sPagesTree'] = $oPage->throwPagesTree( $iContent );
    $sTitle = trim( !empty( $aData['sNameTitle'] ) ? $aData['sNameTitle'] : strip_tags( $aData['sName'] ) );
    if( !empty( $sTitle ) )
      $sTitle .= ' - ';

    if( isset( $aData['sDescriptionFull'] ) )
      $aData['sDescriptionFull'] = changeTxt( $aData['sDescriptionFull'], 'nlNds' );
  }
}
elseif( isset( $aActions['f'] ) && isset( $aActions['a'] ) ){
  $sLink = $aActions['f'].'-'.$aActions['a'];
  // plugins actions
}

if( !isset( $aData['sName'] ) ){
  header( "HTTP/1.0 404 Not Found\r\n" );
  $sTitle = $lang['404_error'].' - ';
}

if( isset( $sTheme ) && is_file( DIR_SKIN.$sTheme ) ){
  require_once DIR_SKIN.$sTheme;
}
else{
  require_once DIR_SKIN.$config['default_pages_template'];
}
?>