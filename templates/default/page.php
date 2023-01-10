<?php 
// More about design modifications - www.opensolution.org/Quick.Cms/docs/?id=en-design
if( !defined( 'CUSTOMER_PAGE' ) )
  exit;

require_once DIR_SKIN.'_header.php'; // include design of header
?>
<div id="page">
<?php
if( isset( $aData['sName'] ) ){ // displaying pages and subpages content
  echo '<h1>'.$aData['sName'].'</h1>'; // displaying page name

  if( isset( $aData['sPagesTree'] ) )
    echo '<h4>'.$aData['sPagesTree'].'</h4>'; // displaying page tree (breadcrumb)
  
  echo $oFile->listImagesByTypes( $aData['iPage'], 1 ); // displaying images with type: left
  
  echo $oFile->listImagesByTypes( $aData['iPage'], 2 ); // displaying images with type: right
  
  if( isset( $aData['sDescriptionFull'] ) )
    echo '<div class="content" id="pageDescription">'.$aData['sDescriptionFull'].'</div>'; // full description

      if( !empty( $config['google_map_page'] ) && $config['google_map_page'] == $aData['iPage'] ){
        echo '<div class="googlemap"><iframe src="https://maps.google.pl/maps?q='.( !empty( $config['google_map_country'] ) ? ','.$config['google_map_country'] : null ).( !empty( $config['google_map_city'] ) ? ','.$config['google_map_city'] : null ).( !empty( $config['google_map_street'] ) ? ','.$config['google_map_street'] : null ).'a&hnear='.( !empty( $config['google_map_city'] ) ? $config['google_map_city'] : null ).'&z=13&output=embed"></iframe></div>';
      }

  if( isset( $aData['sPages'] ) )
    echo '<div class="pages">'.$lang['Pages'].': <ul>'.$aData['sPages'].'</ul></div>'; // full description pagination
  
  if( isset( $aData['iDownload'] ) )
    echo $oFile->listFilesDownload( $aData['iPage'] ); // display files included to the page in download layout
  else
    if( isset( $aData['iDownload'] ) )
    echo $oFile->listFilesDownload( $aData['iPage'] ); // display files included to the page in download layout
  else
    echo $oFile->listFiles( $aData['iPage'] ); // display files included to the page
  
  if( $aData['iSubpagesShow'] > 0 )
    echo $oPage->listSubpages( $aData['iPage'], $aData['iSubpagesShow'] ); // displaying subpages
}
else{
  echo '<div class="message" id="error"><h3>'.$lang['Data_not_found'].'</h3></div>'; // displaying 404 error
}
?>
</div>
<?php
require_once DIR_SKIN.'_footer.php'; // include design of footer
?>
