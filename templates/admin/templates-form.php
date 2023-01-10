<?php
if( !defined( 'ADMIN_PAGE' ) )
  exit( 'templatesEditor plugin by OpenSolution.org' );

if( isset( $sTemplate ) || isset( $_POST['sTemplate'] ) ){
  if( isset( $_POST['sTemplate'] ) )
    $sTemplate = $_POST['sTemplate'];

  $sTemplate = str_replace( '..', '', $sTemplate );

  if( !$oFFS->checkCorrectFile( $sTemplate, $config['template_editor_extensions'] ) )
    $a = null;
}

require_once DIR_CORE.'template-editor-admin.php';

if( isset( $_POST['sOption'] ) && !empty( $_POST['sTemplate'] ) ){
  saveTemplate( $config['dir_templates'], $_POST );
  header( 'Location: '.$_SERVER['PHP_SELF'].'?p=templates-form&sOption=save&sTemplate='.$_POST['sTemplate'] );
  exit;
}

$aData = null;
$aData['sMode'] = 'text/html';
if( isset( $sTemplate ) ){
  if( is_file( $config['dir_templates'].$sTemplate ) ){
    if( is_writeable( $config['dir_templates'].$sTemplate ) ){
      $aData['sContent'] = editTemplate( $config['dir_templates'].$sTemplate );
      $aData['sTemplate'] = $sTemplate;
      if( $oFFS->throwExtOfFile( $sTemplate ) == 'css' )
        $aData['sMode'] = 'text/css';
    }
    else{
      $bNotWritable = true;
    }
  }
  else{
    $sTemplate = null;      
  }
}

if( !isset( $sTemplate ) )
  $sTemplate = null;

if( isset( $bNotWritable ) )
  $sTemplate = $lang['Template_is_not_writable'].': '.$config['dir_templates'].$_GET['sTemplate'];
else{
  if( !isset( $sTemplate ) )
    $sTemplate = $lang['Template_not_set'];
}

$aSelectMenu['bTools'] = true;
require_once DIR_TEMPLATES.'admin/_header.php'; // include headers
require_once DIR_TEMPLATES.'admin/_menu.php'; // include menu

if( isset( $sOption ) ){
  echo '<div id="msg">'.$lang['Operation_completed'].'</div>';
}
?>
<h1><?php echo $lang['Templates']; ?></h1>

<link rel="stylesheet" href="<?php echo DIR_PLUGINS; ?>codemirror/lib/codemirror.css" />
<script src="<?php echo DIR_PLUGINS; ?>codemirror/lib/codemirror.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo DIR_PLUGINS; ?>codemirror/theme/default.css" />
<script src="<?php echo DIR_PLUGINS; ?>codemirror/mode/css/css.js" type="text/javascript"></script>
<script src="<?php echo DIR_PLUGINS; ?>codemirror/mode/xml/xml.js" type="text/javascript"></script>
<script src="<?php echo DIR_PLUGINS; ?>codemirror/mode/javascript/javascript.js" type="text/javascript"></script>
<script src="<?php echo DIR_PLUGINS; ?>codemirror/mode/htmlmixed/htmlmixed.js" type="text/javascript"></script>

<form action="?p=<?php echo $p; ?>" method="post" id="mainForm" name="form" onsubmit="return checkForm( this );">
  <fieldset id="type2">
    <input type="hidden" name="sTemplate" value="<?php if( isset( $aData['sTemplate'] ) ) echo $aData['sTemplate']; ?>" />
    <table cellspacing="1" class="mainTable" id="templates">
      <thead>
        <tr class="save">
          <th colspan="2">
            <input type="submit" value="<?php echo $lang['save']; ?> &raquo;" name="sOption" />
          </th>
        </tr>
      </thead>
      <tfoot>
        <tr class="save">
          <th colspan="2">
            <input type="submit" value="<?php echo $lang['save']; ?> &raquo;" name="sOption" />
          </th>
        </tr>
      </tfoot>
      <tbody>
        <tr class="l0">
          <td>
            <?php echo $lang['Content_of']; ?> <strong><?php echo $sTemplate; ?></strong>
          </td>
          <th rowspan="2" class="tabs">
            <div id="tabs">
              <ul id="tabsNames">
                <li class="tabTemplates"><a href="#more"><?php echo $lang['Templates']; ?></a></li>
              </ul>
              <div id="tabsForms">
                <div id="tabTemplates">
                  <?php echo listTemplates( DIR_TEMPLATES, $sTemplate ); ?>
                </div>
              </div>
            </div>
          </th>
        </tr>
        <tr class="l1 editor">
          <td>
            <div class="textarea">
              <textarea name="sContent" id="sContent" cols="105" rows="55"><?php if( isset( $aData['sContent'] ) ) echo $aData['sContent']; ?></textarea>
              <script type="text/javascript">
                var editor = CodeMirror.fromTextArea(document.getElementById("sContent"), {
                  mode: "<?php echo $aData['sMode']; ?>",
                  lineNumbers: true,
                  tabMode: "shift",
                  lineWrapping: true,
                  onCursorActivity: function() {
                    editor.setLineClass(hlLine, null);
                    hlLine = editor.setLineClass(editor.getCursor().line, "activeline");
                  }
                });
                var hlLine = editor.setLineClass(0, "activeline");
              </script>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </fieldset>
</form>
<?php
require_once DIR_TEMPLATES.'admin/_footer.php'; // include footer
?>