<?php
if( !defined( 'ADMIN_PAGE' ) )
  exit( 'filesManager plugin by OpenSolution.org' );

if( isset( $_GET['sDelete'] ) ){
  $oFile->deleteFileFromServer( $_GET['sDelete'] );
  $sOption = true;
}

$aSelectMenu['bTools'] = true;
require_once DIR_TEMPLATES.'admin/_header.php'; // include headers
require_once DIR_TEMPLATES.'admin/_menu.php'; // include menu

if( isset( $sOption ) ){
  echo '<div id="msg">'.$lang['Operation_completed'].'</div>';
}
?>
<h1><?php echo $lang['Files']; ?></h1>
<form action="" method="get" id="search">
  <fieldset>
    <input type="hidden" name="p" value="files-server" />
    <input type="hidden" name="sSort" value="<?php if( isset( $sSort ) ) echo $sSort; ?>" />
    <input type="text" name="sPhrase" value="<?php if( isset( $sPhrase ) ) echo $sPhrase; ?>" class="input" size="50" />
    <input type="submit" value="<?php echo $lang['search']; ?> &raquo;" />
  </fieldset>
</form>
<script type="text/javascript">
  AddOnload( function(){ gEBI( 'search' ).sPhrase.focus( ); } );
</script>
<?php
// get list of files
$sFilesList = $oFile->listFilesOnServer( );

// display files in the table list
if( isset( $sFilesList ) ){
  ?>
  <table id="list" class="files on-server" cellspacing="1">
    <thead>
      <tr class="save">
        <td colspan="6" class="pages">
          <?php echo $lang['Pages']; ?>: <ul><?php echo $sPages; ?></ul>
        </td>
      </tr>
      <tr>
        <td class="image"><?php echo ucfirst( $lang['preview'] ); ?></td>
        <td class="name"><a href="?p=files-server<?php if( isset( $sPhrase ) ) echo '&amp;sPhrase='.$sPhrase; ?>"><?php echo $lang['File']; ?></a></td>
        <td><a href="?p=files-server<?php if( isset( $sPhrase ) ) echo '&amp;sPhrase='.$sPhrase; ?>&amp;sSort=link1"><?php echo $lang['Pages']; ?></a></td>
        <td><a href="?p=files-server<?php if( isset( $sPhrase ) ) echo '&amp;sPhrase='.$sPhrase; ?>&amp;sSort=modified"><?php echo $lang['Modified']; ?></a></td>
        <td><a href="?p=files-server<?php if( isset( $sPhrase ) ) echo '&amp;sPhrase='.$sPhrase; ?>&amp;sSort=size"><?php echo $lang['Size']; ?></a></td>
        <td class="delete"><?php echo $lang['Delete']; ?></td>
      </tr>
    </thead>
    <tfoot>
      <tr class="save">
        <td colspan="6" class="pages">
          <?php echo $lang['Pages']; ?>: <ul><?php echo $sPages; ?></ul>
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $sFilesList; ?>
    </tbody>
  </table>
  <?php
}
else{
  echo '<div id="msg" class="error">'.$lang['Data_not_found'].'</div>';
}

require_once DIR_TEMPLATES.'admin/_footer.php'; // include footer
?>