<?php
/**
* Get file with fixes and upgrade script
* @return string
* @param string $sFileBugFixes
*/
function getBugFixes(  $sFileBugFixes ){
  global $lang;
  $sAdd = strstr( $sFileBugFixes, '?' ) ? '&' : '?';
  $sFile = file_get_contents( $sFileBugFixes.$sAdd.'sUrl='.$_SERVER['HTTP_HOST'].'&sVersion='.$GLOBALS['config']['version'] );
  if( !empty( $sFile ) ){
    if( $sFile != 'null' ){
      $aBugFixes = unserialize( $sFile );
      $sVersionActual = $aBugFixes['sVersionActual'];
      $content = null;

      $i = 0;
      foreach( $aBugFixes as $sKey => $aValues ){
        if( is_numeric( $sKey ) ){
          if( $sKey >= $GLOBALS['config']['version'] ){
            foreach( $aValues as $iBug => $aData ){
              if( isset( $aData['aSteps'] ) && is_array( $aData['aSteps'] ) ){
                $iCount = count( $aData['aSteps'] );
                $iOk = 0;
                foreach( $aData['aSteps'] as $aSteps ){
                  $mReturn = checkFileToUpgrade( $aSteps[0], $aSteps[1], $aSteps[2] );
                  if( isset( $mReturn ) ){
                    if( $mReturn === -1 ){
                      break;
                    }
                    else{
                      $iOk++;
                    }
                  }
                } // end foreach

                if( $iOk == $iCount ){
                  $aData['sStatus'] = $lang['Fixed'];
                }
                else{
                  if( $iOk > 0 ){
                    $aData['sStatus'] = $lang['Uncompleted'];
                  }
                  else{
                    $aData['sStatus'] = '<b>'.$lang['Fix_it'].'</b>';
                  }
                }
              }
              else{
                $aData['sStatus'] = $lang['Cant_check'];
              }

              $content .= '<tr class="l'.( ( $i % 2 ) ? 0: 1 ).'"><td class="from-version">v'.$sKey.'</td><td class="bug">'.$aData['sBugDescription'].'</td><td class="status">'.( isset( $aData['sStatus'] ) ? $aData['sStatus'] : null ).'</td><td class="link"><a href="'.$GLOBALS['config']['upgrade_link'].'#v'.$sKey.'-'.$iBug.'" target="_blank">'.$lang['Read_more'].'</a></td></tr>';
              $i++;
            } // end foreach
          }
          else{
            $bNewVersion = true;
          }
        }
      } // end foreach

      if( isset( $content ) )
        return '<table id="list" class="bug-fixes" cellspacing="1"><thead><tr><td class="from-version">'.$lang['Bug_from_version'].'</td><td class="bug">'.$lang['Bug'].'</td><td class="status">'.$lang['Status'].'</td><td class="link"></td></tr></thead><tbody>'.$content.'</tbody></table>';
      else{
        if( isset( $bNewVersion ) )
          return '<div id="msg">'.$lang['Operation_completed'].'</div>';
      }
    }
    else{
      return '<div id="msg">'.$lang['Operation_completed'].'</div>';
    }
  }
  else{
    return '<div id="msg" class="error">'.$lang['Error_download_bugfixes_file'].'</div>';
  }
} // end function getBugFixes

/**
* Upgrades data in file
* @return mixed
* @param string $sFile
* @param string $sFind
* @param string $sReplace
*/
function checkFileToUpgrade( $sFile, $sFind, $sReplace ){
  if( $sFile == 'admin.php' )
    $sFile = $GLOBALS['config']['admin_file'];

  if( is_file( $sFile ) ){
    $sContent = file_get_contents( $sFile );
    if( !empty( $sReplace ) ){
      if( ( strstr( $sContent, $sReplace ) || strstr( $sContent, str_replace( "\r", "", $sReplace ) ) ) ){
        return true;
      }
      else{
        return -1;
      }    
    }
    else{
      if( !strstr( $sContent, $sFind ) && !strstr( $sContent, str_replace( "\r", "", $sFind ) ) ){
        return true;
      }
      else{
        return -1;
      }
    }
  }

  return null;
} // end function checkFileToUpgrade
?>