<?php
if( !defined( 'ADMIN_PAGE' ) )
  exit( 'Script by OpenSolution.org' );

if( isset( $_POST['sOption'] ) ){
  if( isset( $_POST['skin'] ) && $config['skin'] != $_POST['skin'] && $_POST['skin'] != 'default' ){
    copyDirToDir( DIR_TEMPLATES.'default/', DIR_TEMPLATES.$_POST['skin'].'/' );
  }
  if( !isset( $_POST['display_dropdown_menu'] ) )
    $_POST['display_dropdown_menu'] = null;
  saveVariables( $_POST, DB_CONFIG );
  saveVariables( $_POST, DB_CONFIG_LANG );
  header( 'Location: '.$_SERVER['PHP_SELF'].'?p='.$p.'&sOption=save' );
  exit;
}

$aSelectMenu['bTools'] = true;
require_once DIR_TEMPLATES.'admin/_header.php'; // include headers
require_once DIR_TEMPLATES.'admin/_menu.php'; // include menu

if( isset( $sOption ) ){
  echo '<div id="msg">'.$lang['Operation_completed'].'</div><script type="text/javascript">var bDone = true;</script>';
}
?>
<h1><?php echo $lang['Settings']; ?><a href="<?php echo $config['manual_link']; ?>instruction#1.2" title="<?php echo $lang['Manual']; ?>" target="_blank"></a></h1>
<form action="?p=<?php echo $p; ?>" method="post" id="mainForm" name="form" onsubmit="return checkForm( this );">
  <fieldset id="type2">
    <table cellspacing="1" class="mainTable" id="config">
      <thead>
        <tr class="save">
          <th colspan="3">
            <input type="submit" value="<?php echo $lang['save']; ?> &raquo;" name="sOption" />
          </th>
        </tr>
      </thead>
      <tfoot>
        <tr class="save">
          <th colspan="3">
            <input type="submit" value="<?php echo $lang['save']; ?> &raquo;" name="sOption" />
          </th>
        </tr>
      </tfoot>
      <tbody>
        <!-- title start -->
        <tr class="l0">
          <th>
            <?php echo $lang['Page_title']; ?>
          </th>
          <td>
            <input type="text" name="title" value="<?php echo $config['title']; ?>" size="70" maxlength="200" class="input" />
          </td>
          <td rowspan="9" class="tabs">
            <div id="tabs">
              <ul id="tabsNames">
                <!-- tabs start -->
                <li class="tabOptions"><a href="#more" onclick="displayTab( 'tabOptions' )"><?php echo $lang['Options']; ?></a></li>
                <?php if( $config['display_advanced_options'] === true ){ ?><li class="tabPages"><a href="#more" onclick="displayTab( 'tabPages' )"><?php echo $lang['Pages']; ?></a></li><?php } ?>
                <li class="tabAdvanced"><a href="#more" onclick="displayTab( 'tabAdvanced' )"><?php echo $lang['Advanced']; ?></a></li>
                <!-- tabs end -->
              </ul>
              <div id="tabsForms">
                <!-- tabs list start -->
                <table class="tab" id="tabOptions">
                  <tr>
                    <td><?php echo $lang['Default_language']; ?></td>
                    <td>
                      <select name="default_lang">
                        <?php echo throwLangSelect( $config['default_lang'] ); ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td><?php echo $lang['Admin_language']; ?></td>
                    <td>
                      <select name="admin_lang">
                        <?php echo throwLangSelect( $config['admin_lang'] ); ?>
                      </select>
                    </td>
                  </tr>
                  <?php if( $config['display_advanced_options'] === true ){ ?>
                    <tr>
                      <td><?php echo $lang['Skin']; ?>&nbsp;-&nbsp;<a href="http://opensolution.org/?p=download&sDir=Quick.Cms/skins" target="_blank" style="text-transform:lowercase;"><?php echo $lang['Need_more']; ?></a></td>
                      <td>
                        <select name="skin">
                          <?php echo throwSkinsSelect( $config['skin'] ); ?>
                        </select>
                      </td>
                    </tr>
                  <?php } ?>
                  <tr>
                    <td><?php echo $lang['Admin_see_hidden_pages']; ?></td>
                    <td>
                      <select name="hidden_shows">
                        <?php echo throwTrueFalseOrNullSelect( $config['hidden_shows'] ); ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td><?php echo $lang['Display_expanded_menu']; ?></td>
                    <td>
                      <select name="display_expanded_menu">
                        <?php echo throwTrueFalseOrNullSelect( $config['display_expanded_menu'] ); ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td><?php echo $lang['Drop_down_menu']; ?> <?php if( $config['extended_options'] === true ){ ?><a href="?p=tools-not_included&amp;sPlugin=dropDownMenu"><?php echo $lang['Need_more']; ?></a><?php } ?></td>
                    <td>
                      <select name="display_dropdown_menu" id="displayDropdownMenu" multiple="multiple" size="2">
                        <?php 
                          echo throwSelectFromArray( Array( 1 => $lang['Menu_1'], 2 => $lang['Menu_2'] ), $config['display_dropdown_menu'] );
                        ?>
                      </select>
                      <script type="text/javascript">
                      <!--
                      function disableDropDown( ){
                        gEBI( 'displayDropdownMenu' ).options[1].disabled = true;
                      } // end function disableDropDown
                      AddOnload( disableDropDown );
                      //-->
                      </script>
                    </td>
                  </tr>
                  <?php if( $config['display_advanced_options'] === true ){ ?>
                    <tr>
                      <td><?php echo $lang['Language_in_url']; ?></td>
                      <td>
                        <select name="language_in_url">
                          <?php echo throwTrueFalseOrNullSelect( $config['language_in_url'] ); ?>
                        </select>
                      </td>
                    </tr>
                  <?php } ?>
                  <tr>
                    <td><?php echo $lang['Google_analytics_property_id']; ?></td>
                    <td>
                      <input type="text" name="google_analytics_id" value="<?php echo $config['google_analytics_id']; ?>" size="18" class="input" /><?php if( $config['extended_options'] === true ){ ?>&nbsp;&nbsp;&nbsp;<a href="?p=tools-not_included&amp;sPlugin=stats"><?php echo $lang['Need_more']; ?></a><?php } ?>
                    </td>
                  </tr>
                  <tr>
                        <td><?php echo $lang['Country']; ?></td>
                        <td>
                          <input type="text" name="google_map_country" value="<?php echo $config['google_map_country']; ?>" size="30" maxlength="40" class="input" />
                        </td>
                      </tr>
                      <tr>
                        <td><?php echo $lang['City']; ?></td>
                        <td>
                          <input type="text" name="google_map_city" value="<?php echo $config['google_map_city']; ?>" size="30" maxlength="40" class="input" />
                        </td>
                      </tr>
                      <tr>
                        <td><?php echo $lang['Street']; ?></td>
                        <td>
                          <input type="text" name="google_map_street" value="<?php echo $config['google_map_street']; ?>" size="30" maxlength="40" class="input" />
                        </td>
                      </tr>
                      <!-- tab options -->
                </table>

                <table class="tab" id="tabPages">
                  <tr>
                    <td><?php echo $lang['Start_page']; ?></td>
                    <td>
                      <select name="start_page">
                        <?php echo $oPage->throwPagesSelectAdmin( $config['start_page'] ); ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                        <td><?php echo $lang['Google_map_page']; ?></td>
                        <td>
                          <select name="google_map_page">
                            <option value=""><?php echo $lang['none'] ?></option>
                            <?php echo $oPage->throwPagesSelectAdmin( $config['google_map_page'] ); ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td><?php echo $lang['Question_page']; ?></td>
                        <td>
                          <select name="question_page">
                            <option value=""><?php echo $lang['none']; ?></option>
                            <?php echo $oPage->throwPagesSelectAdmin( $config['question_page'] ); ?>
                          </select>
                        </td>
                      </tr>
                      <!-- tab pages -->

                </table>

                <table class="tab" id="tabAdvanced">
                  <tr>
                    <td><?php echo $lang['Extended_options']; ?></td>
                    <td>
                      <select name="extended_options">
                        <?php echo throwTrueFalseOrNullSelect( $config['extended_options'] ); ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td><?php echo $lang['Change_files_names']; ?></td>
                    <td>
                      <select name="change_files_names">
                        <?php echo throwTrueFalseOrNullSelect( $config['change_files_names'] ); ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td><?php echo $lang['Delete_unused_files']; ?></td>
                    <td>
                      <select name="delete_unused_files">
                        <?php echo throwTrueFalseOrNullSelect( $config['delete_unused_files'] ); ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td><?php echo $lang['WYSIWIG_editor']; ?></td>
                    <td>
                      <select name="wysiwyg">
                        <?php echo throwTrueFalseOrNullSelect( $config['wysiwyg'] ); ?>
                      </select>
                    </td>
                  </tr>
                  <!-- tab advanced -->
                </table>
                
                <!-- tabs list end -->
              </div>
            </div>

            <script type="text/javascript">
            <!--
            AddOnload( getTabsArray );
            AddOnload( checkSelectedTab );
            //-->
            </script>          
          </td>
        </tr>
        <!-- title end -->
        <!-- description start -->
        <tr class="l1">
          <th>
            <?php echo $lang['Description']; ?>
          </th>
          <td>
            <input type="text" name="description" value="<?php echo $config['description']; ?>" size="70" maxlength="200" class="input" />
          </td>
        </tr>
        <!-- description end -->
        <!-- keywords start -->
        <tr class="l0">
          <th>
            <?php echo $lang['Key_words']; ?>
          </th>
          <td>
            <input type="text" name="keywords" value="<?php echo $config['keywords']; ?>" size="70" maxlength="255" class="input"/>
          </td>
        </tr>
        <!-- keywords end -->
        <!-- slogan start -->
        <tr class="l1">
          <th>
            <?php echo $lang['Logo']; ?>
          </th>
          <td>
            <input type="text" name="logo" value="<?php echo $config['logo']; ?>" size="70" maxlength="200" class="input" />
          </td>
        </tr>
        <!-- slogan end -->
        <!-- slogan start -->
        <tr class="l0">
          <th>
            <?php echo $lang['Slogan']; ?>
          </th>
          <td>
            <input type="text" name="slogan" value="<?php echo $config['slogan']; ?>" size="70" maxlength="200" class="input" />
          </td>
        </tr>
        <!-- slogan end -->
        <!-- foot info start -->
        <tr class="l1">
          <th>
            <?php echo $lang['Foot_info']; ?>
          </th>
          <td>
            <input type="text" name="foot_info" value="<?php echo $config['foot_info']; ?>" size="70" maxlength="200" class="input" />
          </td>
        </tr>
        <!-- foot info end -->
        <!-- login start -->
        <tr class="l0" id="login">
          <th>
            <?php echo $lang['Login']; ?>
          </th>
          <td>
            <input type="text" name="login" value="<?php echo $config['login']; ?>" size="40" class="input" alt="simple" />
          </td>
        </tr>
        <!-- login end -->
        <!-- pass start -->
        <tr class="l1" id="pass">
          <th>
            <?php echo $lang['Password']; ?>
          </th>
          <td>
            <input type="text" name="pass" value="<?php echo $config['pass']; ?>" size="40" class="input" alt="simple" id="oPass" style="display:none" /> <a href="#" onclick="gEBI('oPass').style.display='inline';this.style.display='none';return false;"><?php echo $lang['edit']; ?></a>
          </td>
        </tr>
        <!-- pass end -->
        <tr class="end">
          <td colspan="2">&nbsp;</td>
        </tr>
      </tbody>
    </table>
  </fieldset>
</form>
<?php
require_once DIR_TEMPLATES.'admin/_footer.php'; // include footer
?>