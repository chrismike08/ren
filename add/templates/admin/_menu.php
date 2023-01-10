<?php
if( !defined( 'ADMIN_PAGE' ) )
  exit;
?>

<body>
  <div id="container">
    <div id="header">
      <div id="menuTop">

        <form action="" method="get" id="searchPanel">
          <fieldset>
            <input type="hidden" name="p" value="search" />
            <input type="text" name="sPhrase" value="<?php echo $sPhrase; ?>" class="input" size="25" />
            <select name="iTypeSearch"><?php echo throwSelectFromArray( Array( 1 => $lang['Pages'] ), $iTypeSearch ); ?></select>
            <input type="submit" value="<?php echo $lang['search']; ?> &raquo;" />
          </fieldset>
        </form>
        <div id="lang"><?php echo $lang['Language']; ?>: <select name="" onchange="redirectToUrl( '<?php echo $_SERVER['PHP_SELF']; ?>?sLang='+this.value )"><?php echo throwLangSelect( $config['language'] ); ?></select></div>
      </div>
      <div id="links"><em>Quick.Cms.Add v<?php echo $config['version']; ?></em>|<a href="?p="><?php echo $lang['dashboard']; ?></a>|<a href="?p=logout"><strong><?php echo $lang['log_out']; ?></strong></a><!-- menu top end --></div>
      <div id="logoOs">
        <a href="http://opensolution.org/" target="_blank"><img src="<?php echo $config['dir_templates']; ?>admin/img/logo_os.jpg" alt="OpenSolution.org" /></a>
      </div>
      <div class="clear"></div>

      <!-- menu under_logo start -->
      <ul id="menuBar">
        <li onmouseover="return buttonClick( event, 'pages' ); buttonMouseover( event, 'pages' );"<?php echo ( isset( $aSelectMenu['bPages'] ) ? ' class="selected"' : null ); ?>><a href="?p=pages-list"><span class="pages"><?php echo $lang['Pages']; ?></span></a></li>
        <!-- main menu -->
        <li onmouseover="return buttonClick( event, 'tools' ); buttonMouseover( event, 'tools' );"<?php echo ( isset( $aSelectMenu['bTools'] ) ? ' class="selected"' : null ); ?>><a href="#"><span class="tools"><?php echo $lang['Tools']; ?></span></a></li>
        <li class="sep" onmouseover="return buttonClick( event, 'support' ); buttonMouseover( event, 'support' );"><a href="http://opensolution.org/support-free" target="_blank"><span class="support"><?php echo $lang['Support']; ?></span></a></li>
        <li class="sep" onmouseover="return buttonClick( event, 'extend' ); buttonMouseover( event, 'extend' );"><a href="http://opensolution.org/?p=download&sDir=Quick.Cms" target="_blank"><span class="extend"><?php echo $lang['Extend']; ?></span></a></li>
      </ul>

      <!-- submenu under_logo start -->
      <div id="pages" class="menu" onmouseover="menuMouseover( event );">
        <a href="?p=pages-form"><?php echo $lang['New_page']; ?></a>
        <!-- menu pages -->
      </div>
      <div id="tools" class="menu" onmouseover="menuMouseover( event );">
        <a href="?p=tools-config"><?php echo $lang['Settings']; ?></a>
        <span class="sep">&nbsp;</span>
        <a href="?p=lang-list"><?php echo $lang['Languages']; ?></a>
        <a href="?p=lang-form"><?php echo $lang['New_language']; ?></a>
        <span class="sep">&nbsp;</span>
        <a href="?p=fixes"><?php echo $lang['Check_fixes']; ?></a>
        <span class="sep">&nbsp;</span>
        <a href="?p=files-server"><?php echo $lang['Files']; ?></a>
        <span class="sep">&nbsp;</span>
        <a href="?p=backup-download"><?php echo $lang['Download_backup']; ?></a>
        <?php if( $config['extended_options'] === true ){ ?>
          <a href="?p=tools-not_included&amp;sPlugin=simpleBackup" class="extended"><?php echo $lang['Backup_list']; ?></a>
        <?php } ?>
        <span class="sep">&nbsp;</span>
        <a href="?p=templates-form"><?php echo $lang['Templates']; ?></a>
        <?php if( $config['extended_options'] === true ){ ?>
          <a href="?p=tools-not_included&amp;sPlugin=templatesEditor" class="extended"><?php echo $lang['New_template']; ?></a>
        <?php } ?>
        <!-- menu tools -->
      </div>
      <div id="extend" class="menu" onmouseover="menuMouseover( event );">
        <a href="http://opensolution.org/?p=download&sDir=Quick.Cms/plugins" target="_blank"><?php echo $lang['Plugins']; ?></a>
        <a href="http://opensolution.org/?p=download&sDir=Quick.Cms/skins" target="_blank"><?php echo $lang['Skins']; ?></a>
        <a href="http://opensolution.org/?p=download&sDir=Quick.Cms/translations" target="_blank"><?php echo $lang['Languages']; ?></a>
        <span class="sep"></span>
        <a href="http://opensolution.org/?p=Quick.Cms_editions" target="_blank">Quick.Cms.Ext</a>
        <!-- menu extend -->
      </div>
      <div id="support" class="menu" onmouseover="menuMouseover( event );">
        <a href="http://opensolution.org/faq" target="_blank"><?php echo $lang['FAQ']; ?></a>
        <a href="http://opensolution.org/contact" target="_blank"><?php echo $lang['Contact']; ?></a>
        <a href="http://opensolution.org/Quick.Cms/forum/" target="_blank"><?php echo $lang['Forum']; ?></a>
        <a href="http://opensolution.org/Quick.Cms/docs/" target="_blank"><?php echo $lang['Manual']; ?></a>
        <a href="<?php echo DIR_PLUGINS; ?>read-me.txt" target="_blank"><?php echo $lang['License']; ?></a>
        <!-- menu support -->
      </div>
      <!-- menu under_logo end -->

    </div>
    <div class="clear"></div>
    <div id="body">