<?php
/**
* List of files in default "templates/" directory
* @return string
* @param string $sDirectory
* @param string $sTemplate
*/
function listTemplates( $sDirectory, $sTemplate = null ){
  global $lang;
  $content = null;

  $oFFS = FlatFilesSerialize::getInstance( );
  $aDirs = throwAllDataFromDir( $sDirectory );

  if( isset( $aDirs ) ){
    sort( $aDirs );
    $content = null;

    foreach( $aDirs as $aFiles ){
      if( isset( $aFiles ) && is_array( $aFiles ) ){
        $i = 0;
        foreach( $aFiles as $aData ){
          if( $i == 0 ){
            $content .= '<tr class="dir"><td colspan="3">'.$aData['sDir'].'</td></tr>';
          }

          $aData['sDirShort'] = basename( $aData['sDir'] ).'/';
          $aData['sDate'] = displayDate( $aData['iTime'], $GLOBALS['config']['date_format_admin_default'] );
          
          $content .= '<tr class="l'.( ( $i % 2 ) ? 0: 1 ).'"><td class="name"><a href="?p=templates-form&amp;sTemplate='.$aData['sDirShort'].$aData['sFileName'].'" '.( ( $sTemplate == $aData['sDirShort'].$aData['sFileName'] ) ? 'class="selected"' : null ).'>'.$aData['sFileName'].'</a></td><td class="date">'.$aData['sDate'].'</td><td class="option"><a href="?p=templates-form&amp;sTemplate='.$aData['sDirShort'].$aData['sFileName'].'"><img src="'.DIR_TEMPLATES.'admin/img/ico_edit.gif" alt="'.$lang['edit'].'" title="'.$lang['edit'].'" /></a>'.(( $GLOBALS['config']['extended_options'] === true ) ? ' <a href="?p=tools-not_included&amp;sPlugin=templatesEditor"><img src="'.DIR_TEMPLATES.'admin/img/ico_del.gif" alt="'.$lang['delete'].'" title="'.$lang['delete'].'" /></a>' : null).'</td></tr>';
          $i++;
        } // end foreach
      }
    } // end foreach

    if( isset( $content ) )
      return '<table cellspacing="0" id="templatesList"><thead><tr><td class="name">'.$lang['Name'].'</td><td class="date">'.$lang['Last_modified'].'</td><td class="option"></td></tr></thead><tbody>'.$content.'</tbody></table>';
  }
} // end function listTemplates

/**
* Return content of template
* @return string
* @param string $sFileName
*/
function editTemplate( $sFileName ){
  return htmlspecialchars( file_get_contents( $sFileName ) );
} // end function editTemplate

/**
* Save content of template
* @return void
* @param string $sDir
* @param array  $aForm
*/
function saveTemplate( $sDir, $aForm ){
  $aForm['sTemplate'] = $sDir.$aForm['sTemplate'];
  if( is_file( $aForm['sTemplate'] ) && is_writeable( $aForm['sTemplate'] ) ){
    $rFile = fopen( $aForm['sTemplate'], 'w' );
    fwrite( $rFile, stripslashes( $aForm['sContent'] ) );
    fclose( $rFile );
  }
} // end function saveTemplate

/**
* Return all files and directories from dir
* @return array
* @param string $sDir
* @param int $iDepth
* @param bool $bOnlyDirs
*/
function throwAllDataFromDir( $sDir, $iDepth = 0, $bOnlyDirs = null ){
  $oFFS = FlatFilesSerialize::getInstance( );

  foreach( new DirectoryIterator( $sDir ) as $oFileDir ){
    if( $oFileDir->isDir( ) && !strstr( $oFileDir->getFilename( ), '.' ) && $oFileDir->getFilename( ) != 'admin' && $iDepth < 1 ){
      if( isset( $bOnlyDirs ) )
        $aDirs[$sDir.$oFileDir->getFilename( ).'/'] = $sDir.$oFileDir->getFilename( ).'/';
      else
        $aFiles[$sDir.$oFileDir->getFilename( )] = throwAllDataFromDir( $sDir.$oFileDir->getFilename( ).'/', $iDepth + 1 );
    }

    if( !isset( $bOnlyDirs ) ){
      if( $oFileDir->isFile( ) && $oFFS->checkCorrectFile( $oFileDir->getFilename( ), $GLOBALS['config']['template_editor_extensions'] ) ){
        $aFiles[$oFileDir->getFilename( )]['sExt'] = $oFFS->throwExtOfFile( $oFileDir->getFilename( ) );
        $aFiles[$oFileDir->getFilename( )]['sFileName'] = $oFileDir->getFilename( );
        $aFiles[$oFileDir->getFilename( )]['iTime'] = $oFileDir->getMTime( );
        $aFiles[$oFileDir->getFilename( )]['sDir'] = $sDir;
      }
    }
  } // end foreach
  if( isset( $aDirs ) )
    return $aDirs;
  if( isset( $aFiles ) )
    return $aFiles;
} // end function throwAllDataFromDir
?>