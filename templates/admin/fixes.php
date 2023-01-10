<?php
if( !defined( 'ADMIN_PAGE' ) )
  exit( 'bugFixesChecker plugin by OpenSolution.org' );

require_once DIR_CORE.'fixes-admin.php';

$aSelectMenu['bTools'] = true;
require_once DIR_TEMPLATES.'admin/_header.php'; // include headers
require_once DIR_TEMPLATES.'admin/_menu.php'; // include menu

if( isset( $sOption ) ){
  echo '<div id="msg">'.$lang['Operation_completed'].'</div>';
}
?>
<h1><?php echo $lang['Check_fixes']; ?></h1>
<?php
// get list of fixes
echo getBugFixes( $config['upgrade_file'] );

require_once DIR_TEMPLATES.'admin/_footer.php'; // include footer
?>