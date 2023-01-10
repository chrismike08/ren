<?php
/*
* Quick.Cms by OpenSolution.org
* www.OpenSolution.org
*/
extract( $_GET );
define( 'ADMIN_PAGE', true );
$_SERVER['REQUEST_URI'] = htmlspecialchars( strip_tags( $_SERVER['REQUEST_URI'] ) );
$_SERVER['PHP_SELF'] = htmlspecialchars( strip_tags( $_SERVER['PHP_SELF'] ) );

require 'database/config/general.php';
require DB_CONFIG_LANG;

session_start( );

header( 'Content-Type: text/html; charset='.$config['charset'] );
require_once DIR_LIBRARIES.'file-jobs.php';
require_once DIR_LIBRARIES.'flat-files.php';
require_once DIR_LIBRARIES.'image-jobs.php';
require_once DIR_LIBRARIES.'trash.php';
require_once DIR_PLUGINS.'plugins-admin.php';

require_once DIR_DATABASE.'_fields.php';
require_once DIR_CORE.'common-admin.php';
require_once DIR_CORE.'pages.php';
require_once DIR_CORE.'pages-admin.php';
require_once DIR_CORE.'lang-admin.php';
require_once DIR_CORE.'files.php';
require_once DIR_CORE.'files-admin.php';

$p = !empty( $p ) ? strip_tags( $p ) : 'dashboard';

if( !isset( $iTypeSearch ) )
  $iTypeSearch = 1;

if( $p == 'search' ){
  $aSearchActions = Array( 1 => 'pages-list' );
  $p = ( isset( $aSearchActions[$iTypeSearch] ) ) ? $aSearchActions[$iTypeSearch] : null;
}
elseif( $p == 'dashboard' || $p == 'login' )
  $sNotifications = listNotifications( );

$sPhrase = isset( $sPhrase ) && !empty( $sPhrase ) ? trim( changeSpecialChars( htmlspecialchars( stripslashes( $sPhrase ) ) ) ) : null;
if( !isset( $sSort ) )
  $sSort = null;
$aActions = getAction( $p );

loginActions( $p, SESSION_KEY_NAME );

$oFFS = FlatFilesSerialize::getInstance( );
$oImage = ImageJobs::getInstance( );
$oPage = PagesAdmin::getInstance( );
$oFile = FilesAdmin::getInstance( );

if( ( strstr( $p, '-delete' ) || count( $_POST ) > 0 ) && !empty( $_SERVER['HTTP_REFERER'] ) && !strstr( $_SERVER['HTTP_REFERER'], $_SERVER['SCRIPT_NAME'] ) ){
  header( 'Location: '.$_SERVER['PHP_SELF'].'?p=error' );
  exit;
}

// back-end dashboard
if( $p == 'dashboard' || $p == 'login' ){
  require_once DIR_TEMPLATES.'admin/home.php';
}

// page actions
elseif( $p == 'pages-list' ){
  $iTypeSearch = 1;
  require_once DIR_TEMPLATES.'admin/pages.php';
}
elseif( $p == 'pages-form' ){
  $iTypeSearch = 1;
  require_once DIR_TEMPLATES.'admin/pages-form.php';
}
elseif( $p == 'pages-delete' && isset( $iPage ) && is_numeric( $iPage ) ){
  if( !isset( $bWithoutFiles ) )
    $bWithoutFiles = null;
  $oPage->deletePage( $iPage, $bWithoutFiles );
  header( 'Location: '.$_SERVER['PHP_SELF'].'?p=pages-list&sOption=del' );
  exit;
}

// translation actions
elseif( $p == 'lang-list' || $p == 'lang-translations' ){
  require_once DIR_TEMPLATES.'admin/languages.php';
}
elseif( $p == 'lang-form' ){
  require_once DIR_TEMPLATES.'admin/languages-form.php';
}
elseif( $p == 'lang-delete' && isset( $sLanguage ) && !empty( $sLanguage ) ){
  deleteLanguage( $sLanguage );
  header( 'Location: '.$_SERVER['PHP_SELF'].'?p=lang-list&sOption=del' );
  exit;
}

// settings
elseif( $p == 'tools-config' ){
  require_once DIR_TEMPLATES.'admin/settings.php';
}

// file actions
elseif( $p == 'files-in-dir' ){
  header( 'Cache-Control: no-cache' );
  header( 'Content-type: text/html' );
  echo $oFile->listFilesInDir( 'time' );
  exit;
}
elseif( $p == 'files-upload' && !empty( $sFileName ) ){
  echo $oFile->uploadFile( $sFileName );
  exit;
}
// plugins actions
    elseif( $p == 'files-server' ){
      require_once DIR_TEMPLATES.'admin/files.php';
    }
elseif( $p == 'fixes' ){
  require_once DIR_TEMPLATES.'admin/fixes.php';
}
elseif( $p == 'files-server' ){
  require_once DIR_TEMPLATES.'admin/files.php';
}
elseif( $p == 'backup-download' ){
  if( function_exists( 'gzopen' ) ){
    $sTemporaryDir = ini_get( 'upload_tmp_dir' );

    if( is_dir( $sTemporaryDir ) ){
      $sTemporaryDir = ini_get( 'upload_tmp_dir' );
      if( substr( $sTemporaryDir, strlen( $sTemporaryDir ) - 1 ) != '/' )
        $sTemporaryDir .= '/';

      define( 'PCLZIP_TEMPORARY_DIR', $sTemporaryDir );

      require DIR_PLUGINS.'class-pclzip.php';

      $sFile = 'backup_'.date('Y-m-d_H-i').'.zip';
      $oBackup = new PclZip( $sTemporaryDir.$sFile );
      $oBackup->create( DIR_DATABASE );

      header( 'Content-Type: application/zip' );
      header( 'Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT' );
      header( 'Content-Disposition: attachment; filename="'.$sFile.'"' );
      header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
      header( 'Pragma: public' );
      echo file_get_contents( $sTemporaryDir.$sFile );
      exit;
    }
  }
  else{
    header( 'Location: '.$_SERVER['PHP_SELF'].'?p=no-action' );
    exit;
  }
}
elseif( $p == 'templates-form' ){
  require_once DIR_TEMPLATES.'admin/templates-form.php';
}
// START OF PLUGIN LICENSE RESTRICTIONS - GET MORE INFO HERE: read-me.txt
elseif( $p == 'tools-not_included' ){
  
  $aPluginsDemo = Array( 'simpleBackup' => 'admin.php?p=backup-list&amp;sPlugin=simple-backup', 'simpleNews' => 'admin.php?p=pages-form&iPage=11&amp;sPlugin=simple-news' );
  $aPluginsInfo = Array( 'download' => '&amp;sPlugin=downloadExt-add#downloadExt', 'dropDownMenu' => '&amp;sPlugin=dropDownMenuExt-add#dropDownMenuExt', 'templatesEditor' => '&amp;sPlugin=templateEditorExt-add#templateEditorExt', 'stats' => '&amp;sPlugin=stats-add#stats', 'filesManager' => '&amp;sPlugin=filesManagerExt-add#filesManagerExt' );

  require_once DIR_TEMPLATES.'admin/_header.php'; // include headers
  require_once DIR_TEMPLATES.'admin/_menu.php'; // include menu
  echo '<div id="msg" class="plugin-info">'.
    $lang['Only_in_Ext_notice'];
  if( isset( $sPlugin ) && isset( $aPluginsDemo[$sPlugin] ) )
    echo (( $config['admin_lang'] == 'pl' ) ? '<br /><br />Zobacz wersję <a href="http://opensolution.org/Quick.Cms/demo_ext/'.$aPluginsDemo[$sPlugin].'" target="_blank">demo &raquo;</a> tej funkcjonalności.' : '<br /><br />See <a href="http://opensolution.org/Quick.Cms/demo_ext/'.$aPluginsDemo[$sPlugin].'" target="_blank">demo &raquo;</a> of this functionality.' );
  else{
    if( !isset( $sPlugin ) || !isset( $aPluginsInfo[$sPlugin] ) )
      $aPluginsInfo[$sPlugin] = null;
    echo (( $config['admin_lang'] == 'pl' ) ? '<br /><br /><a href="http://opensolution.org/Quick.Cms/demo_ext/admin.php?p=plugins'.$aPluginsInfo[$sPlugin].'" target="_blank">Zobacz ten i więcej dodatków &raquo;</a>.' : '<br /><br /><a href="http://opensolution.org/Quick.Cms/demo_ext/admin.php?p=plugins'.$aPluginsInfo[$sPlugin].'" target="_blank">See this and more plugins &raquo;</a>.' );
  }
  echo '</div>';
  require_once DIR_TEMPLATES.'admin/_footer.php'; // include menu
}
// END OF PLUGIN LICENSE RESTRICTIONS

// error page
else{
  require_once DIR_TEMPLATES.'admin/_header.php'; // include headers
  require_once DIR_TEMPLATES.'admin/_menu.php'; // include menu
  echo '<div id="msg" class="error">'.$lang['Operation_unknown'].'</div>';
  require_once DIR_TEMPLATES.'admin/_footer.php'; // include menu
}
?>