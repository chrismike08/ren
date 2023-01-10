<?php
/**
* Function returns editor
* @return string
* @param  string  $sName
* @param  int     $iH
* @param  int     $iW
* @param  string  $sContent
*/
function htmlEditor( $sName = 'sDescriptionFull', $iH = '300', $iW = '100%', $sContent = '' ){
  $sEdit = '';
  if( !strstr( $iH, '%' ) )
    $iH .= 'px';
  if( !strstr( $iW, '%' ) )
    $iW .= 'px';

 if( WYSIWYG === true ){
        if( empty( $sEdit ) && defined( 'TinyMceFullActive' ) && TinyMceFullActive === true ){
          if( !defined( 'WYSIWYG_START' ) ){
            define( 'WYSIWYG_START', true );
            $sEdit .= '<script type="text/javascript" src="'.$GLOBALS['config']['dir_plugins'].'tinymce-full/tinymce.min.js"></script>';
          }
          $sEdit .= '<script type="text/javascript">
          AddOnload( function(){ tinymce.init({
              selector: "textarea#'.$sName.'",
              plugins: [
                  "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                  "searchreplace wordcount visualblocks visualchars code fullscreen tabindex",
                  "insertdatetime media nonbreaking save table contextmenu directionality",
                  "emoticons template paste textcolor"
              ],
              toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons",
              image_advtab: true,
              entity_encoding : "raw"
           }) } );
          </script>';
        }
        if( empty( $sEdit ) && defined( 'CKEditorActive' ) && CKEditorActive === true ){
          if( !defined( 'WYSIWYG_START' ) ){
            define( 'WYSIWYG_START', true );
            $sEdit .= '<script type="text/javascript" src="'.$GLOBALS['config']['dir_plugins'].'ckeditor/ckeditor.js"></script>';
          }
          $sEdit .= '<script type="text/javascript">AddOnload( function(){ CKEDITOR.replace( "'.$sName.'", { language: "'.$GLOBALS['config']['admin_lang'].'" } ); } )</script>';
        }
    if( empty( $sEdit ) ){
      if( !defined( 'WYSIWYG_START' ) ){
        define( 'WYSIWYG_START', true );
        $sEdit .= '<script type="text/javascript" src="'.$GLOBALS['config']['dir_plugins'].'tinymce/tinymce.min.js"></script>';
      }
      $sEdit .= '<script type="text/javascript">
      tinymce.init({
          selector: "textarea#'.$sName.'",
          toolbar : "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist | undo redo | link unlink cleanup removeformat | about fullscreen code",
          menubar : false,
          plugins: ["link, code, fullscreen"],
          entity_encoding : "raw",
          setup: function(editor) {
            editor.addButton("about", {
              title: "About",
              icon: "help",
              onclick: function() {
                editor.windowManager.open({url:editor.editorManager.baseURL+"/plugins/about.htm",width:480,height:300,inline:true})
              }

            });
          }
       });
      </script>';
    }
  }
  $sEdit .= '<textarea name="'.$sName.'" id="'.$sName.'" rows="20" cols="60" style="width:'.$iW.';height:'.$iH.';" tabindex="1">'.$sContent.'</textarea>';

  return $sEdit;
} // end function htmlEditor

/**
* Returns javascript languages
* @return string
*/
function javascriptLanguages( ){
  return base64_decode( ( $GLOBALS['config']['admin_lang']=='pl' ? 'dmFyIENsb3NlID0gJ1phbWtuaWonOyB2YXIgc0ZpcnN0Tm90aWNlID0gJ0tvcnp5c3RhasSFYyB6IFF1aWNrLkNtcyBha2NlcHR1amVzeiA8YSBocmVmPSJodHRwOi8vb3BlbnNvbHV0aW9uLm9yZy9saWNlbmNqYS5odG1sP25vdGljZT0iIHRhcmdldD0iX2JsYW5rIj5saWNlbmNqxJk8L2E+Lic7' : 'dmFyIENsb3NlID0gJ0Nsb3NlJzsgdmFyIHNGaXJzdE5vdGljZSA9ICdVc2Ugb2YgUXVpY2suQ21zIGNvbnN0aXR1dGVzIHlvdXIgYWNjZXB0YW5jZSB0byB0aGUgPGEgaHJlZj0iaHR0cDovL29wZW5zb2x1dGlvbi5vcmcvbGljZW5zZS5odG1sP25vdGljZT0iIHRhcmdldD0iX2JsYW5rIj5saWNlbnNlPC9hPi4nOw==' ) );
} // end function javascriptLanguages

?>