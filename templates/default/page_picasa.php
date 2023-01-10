<?php 
// More about design modifications - www.opensolution.org/Quick.Cms/docs/?id=en-design
if( !defined( 'CUSTOMER_PAGE' ) )
  exit;

require_once DIR_TEMPLATES.$config['skin'].'/_header.php'; // include design of header
?>
<div id="page">
<?php
if( isset( $aData['sName'] ) ){ // displaying pages and subpages content
  echo '<h1>'.$aData['sName'].'</h1>'; // displaying page name

  if( isset( $aData['sPagesTree'] ) )
    echo '<h4>'.$aData['sPagesTree'].'</h4>'; // displaying page tree (main pages)
  
  echo $oFile->listImagesByTypes( $aData['iPage'], 1 ); // displaying images with type: left
  
  echo $oFile->listImagesByTypes( $aData['iPage'], 2 ); // displaying images with type: right
  
  if( isset( $aData['sDescriptionFull'] ) )
   echo '<div class="content" id="pageDescription">'.$aData['sDescriptionFull'].'</div>'; // full description

  if( isset( $aData['sPages'] ) )
    echo '<div class="pages">'.$lang['Pages'].': <ul>'.$aData['sPages'].'</ul></div>';
  
  echo $oFile->listFiles( $aData['iPage'] ); // display files included to the page
  
  echo $oPage->listSubpages( $aData['iPage'], $aData['iSubpagesShow'] ); // displaying subpages
  echo picasaAlbum( 'christofel_michael', 'beranda4th' );
}
else{
  echo '<div class="message" id="error"><h3>'.$lang['Data_not_found'].'</h3></div>'; // displaying 404 error
}
?>
</div>
<?php
require_once DIR_TEMPLATES.$config['skin'].'/_footer.php'; // include design of footer
?>
