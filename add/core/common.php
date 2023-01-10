<?php
/**
* Returns status limit
* @return int
*/
function throwStatus( ){
  if( defined( 'SESSION_KEY_NAME' ) && isset( $_SESSION[SESSION_KEY_NAME] ) && $_SESSION[SESSION_KEY_NAME] === true ){
    if( defined( 'CUSTOMER_PAGE' ) ){
      if( HIDDEN_SHOWS === true )
        return 0;
      else
        return 1;
    }
    else
      return 0;
  }
  else
    return 1;
} // end function throwStatus

/**
* Returns value of the $_GET array to the $p array
* @return array
*/
function getUrlFromGet( ){
  global $a;
  if( isset( $_GET ) && is_array( $_GET ) ){
    foreach( $_GET as $mKey => $mValue ){
      if( strstr( $mKey, ',' ) ){
        $mKey = htmlspecialchars( $mKey );
        $aExp = explode( ',', $mKey );

        if( empty( $aExp[2] ) )
          $aExp[2] = 'pages';

        for( $i = 2; $i < count( $aExp ); $i++ ){
          $aActions['o'.( $i )] = $aExp[$i];
          if( $aActions['o'.( $i )] == 'pages' )
            $aActions['o'.( $i )] = null;
        } // end for

        if( is_numeric( $aExp[2] ) )
          $aExp[2] = 'pages';

        $aActions['o1'] = $aExp[0];
        $aActions['f'] = $aExp[2];
        $aActions['a'] = $aExp[1];
        $aActions['sLink']= $mKey;
        $a = $aActions['a'];
        return $aActions;
      }
    }
    $a = null;
    return Array( 'f' => 'pages', 'a' => null, 'sLink' => 'pages' );
  }
} // end function getUrlFromGet

/**
* Returns extensions icons
* @return array
*/
function throwIconsFromExt( ){
  return Array( 'rar'=>'zip', 'zip'=>'zip', 'bz2'=>'zip', 'gz'=>'zip', 'fla'=>'fla', 'mp3'=>'media', 'mpeg'=>'media', 'mpe'=>'media', 'mov'=>'media', 'mid'=>'media', 'midi'=>'media', 'asf'=>'media', 'avi'=>'media', 'wav'=>'media', 'wma'=>'media', 'msg'=>'msg', 'eml'=>'msg', 'pdf'=>'pdf', 'jpg'=>'pic', 'jpeg'=>'pic', 'jpe'=>'pic', 'gif'=>'pic', 'bmp'=>'pic', 'tif'=>'pic', 'tiff'=>'pic', 'wmf'=>'pic', 'png'=>'png', 'chm'=>'chm', 'hlp'=>'chm', 'psd'=>'psd', 'swf'=>'swf', 'pps'=>'pps', 'ppt'=>'pps', 'sys'=>'sys', 'dll'=>'sys', 'txt'=>'txt', 'doc'=>'txt', 'rtf'=>'txt', 'vcf'=>'vcf', 'xls'=>'xls', 'xml'=>'xml', 'tpl'=>'web', 'html'=>'web', 'htm'=>'web', 'com'=>'exe', 'bat'=>'exe', 'exe'=>'exe' );
} // end function throwIconsFromExt

/**
* Returns language id based on the URL parameter
* @return string
*/
function getLanguageFromUrl( ){
  $aUrl = getUrlFromGet( );
  if( isset( $aUrl['o1'] ) ){
    $iLangPos = strpos( $aUrl['o1'], LANGUAGE_SEPARATOR );
    if( $iLangPos === false )
      return null;
    else
      return substr( $aUrl['o1'], 0, $iLangPos );
  }
  else
    return null;
} // end function getLanguageFromUrl

/**
* Displays date changed by $config['time_diff']
* @return string
* @param int    $iTime
* @param string $sFormat
*/
function displayDate( $iTime = null, $sFormat = 'Y-m-d H:i' ){
  return isset( $iTime ) ? date( $sFormat, $iTime + ( TIME_DIFF * 60 ) ) : date( $sFormat );
} // end function displayDate

/**
* Compares submitted form array to the array in "database/_fields.php" before it's saved to the database
* @return array
* @param array  $aKeys
* @param array  $aData
*/
function compareArrays( $aKeys, $aData ){
  foreach( $aKeys as $sKey ){
    if( isset( $aData[$sKey] ) && ( is_numeric( $aData[$sKey] ) || !empty( $aData[$sKey] ) ) ){
      if( $sKey[0] == 'i' )
        $aData[$sKey] = (int) $aData[$sKey];
      $aReturn[$sKey] = $aData[$sKey];
    }
  } // end foreach

  if( isset( $aReturn ) )
    return $aReturn;
} // end function compareArrays

/**
* Returns full description from a file
* @return int
* @param string $sDir
* @param int $iId
*/
function getFullDescription( $sDir, $iId ){
  $sFileName = LANGUAGE.'_'.sprintf( '%04.0f', $iId ).'.txt';
  if( is_file( $sDir.$sFileName ) )
    return file_get_contents( $sDir.$sFileName );
} // end function getFullDescription

/**
* Count page number and positions in database file
* @return array
* @param int $iCount
* @param int $iPage
* @param int $iList
*/
function countPageNumber( $iCount, $iPage, $iList = null ){
  if( !isset( $iList ) )
    $iList = $GLOBALS['config']['admin_list'];
  $iPages = ceil( $iCount / $iList );
  $iPageNumber = isset( $iPage ) ? $iPage : 1;
  if( !isset( $iPageNumber ) || !is_numeric( $iPageNumber ) || $iPageNumber < 1 )
    $iPageNumber = 1;
  if( $iPageNumber > $iPages )
    $iPageNumber = $iPages;

  $iEnd = $iPageNumber * $iList;
  $iStart = $iEnd - $iList;

  if( $iEnd > $iCount )
    $iEnd = $iCount;

  return Array( 'iStart' => $iStart, 'iEnd' => $iEnd, 'iPageNumber' => $iPageNumber ); 
} // end function countPageNumber

/**
* Displays links to alternate language versions of the website
* @return void
*/
function displayAlternateTranslations( ){
  if( isset( $GLOBALS['iContent'] ) && is_numeric( $GLOBALS['iContent'] ) && $GLOBALS['iContent'] == $GLOBALS['config']['start_page'] ){
    $oFFS = FlatFilesSerialize::getInstance( );
    foreach( new DirectoryIterator( DIR_LANG ) as $oFileDir ){
      if( $oFileDir->isFile( ) && preg_match( '/[a-z]+\.php/i', $oFileDir->getFilename( ) ) ){
        $sLang = $oFFS->throwNameOfFile( $oFileDir->getFilename( ) );
        if( $sLang != LANGUAGE ){
          echo '<link rel="alternate" hreflang="'.$sLang.'" href="?sLang='.$sLang.'" />';
        }
      }
    } // end foreach
  }
} // end function displayAlternateTranslations

/**
* Count visits and display
* @return array
*/
function simpleCounter( ){
  if( !is_file( DB_COUNTER ) ){
    touch( DB_COUNTER );
    chmod( DB_COUNTER, FILES_CHMOD );
  }

  $aFile = file( DB_COUNTER );
  if( isset( $aFile[1] ) && !empty( $aFile[1] ) ){
    $aExp = explode( '$', $aFile[1] );
    $sDate = date( 'Y-m-d' );
    $aVisits[0] = $aExp[0];
    $aVisits[1] = ( !empty( $aExp[2] ) && $aExp[2] == $sDate ) ? $aExp[1] : 0;
  }

  if( !isset( $_COOKIE['simpleCounter'] ) && !preg_match( '/'.$GLOBALS['config']['disable_agents'].'|^$/i', $_SERVER['HTTP_USER_AGENT'] ) ){
    $sSave = '<?php exit; ?>'."\n";
    $rFile = fopen( DB_COUNTER, 'r+' );
    if( isset( $aVisits ) ){
      $aVisits[0]++;
      $aVisits[1]++;
    }
    else{
      $aVisits = Array( 1, 1 );
    }

    fwrite( $rFile, $sSave.$aVisits[0].'$'.$aVisits[1].'$'.date( 'Y-m-d' ).'$'."\n" );
    fclose( $rFile );
    setcookie( 'simpleCounter', true, time( ) + 7200 );
  }

  if( isset( $aVisits ) )
    return $aVisits;
  else
    return Array( 1, 1 );
} // end function simpleCounter
?>