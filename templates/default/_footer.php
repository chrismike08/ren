<?php
if( !defined( 'CUSTOMER_PAGE' ) )
  exit;
?>
        <div id="options"><div class="print"><a href="javascript:window.print();"><?php echo $lang['print']; ?></a></div><div class="back"><a href="javascript:history.back();">&laquo; <?php echo $lang['back']; ?></a></div></div>
      </div>
    <div id="backToTop">
            <a href="#container"><span></span><?php echo $lang['Back_to_top']; ?></a>
          </div>
        </div>
      </div>
      <div id="foot"><?php // footer starts here ?>
    <div class="container">
      <?php echo $config['foot_info']; ?> <a href="http://www.sipenting.com/admin"><?php echo $sLangFooter; ?></a> - <a href="http://www.sipenting.com/admin"><strong>PLN UIW KALTIMRA</strong></a>
    </div>
  </div>
</div>
</body>
</html>