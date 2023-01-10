<?php
if( !defined( 'ADMIN_PAGE' ) )
  exit;
?>
        <div id="foot">
          <div class="back">
            &laquo; <a href="javascript:history.back();"><?php echo $GLOBALS['lang']['back']; ?></a>
          </div>
          <div class="links">
            <a href="./?sLang=<?php echo LANGUAGE; ?>" target="_blank"><?php echo $lang['homepage']; ?></a>|<a href="?p="><?php echo $lang['dashboard']; ?></a>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>