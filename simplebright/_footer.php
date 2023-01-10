<?php
if( !defined( 'CUSTOMER_PAGE' ) )
  exit;
?>
        <div id="options"><div class="print"><a href="javascript:window.print();"><?php echo $lang['print']; ?></a></div><div class="back"><a href="javascript:history.back();">&laquo; <?php echo $lang['back']; ?></a></div></div>
      </div>
    </div>
  </div>
  <div id="foot"><?php // footer starts here ?>
    <div class="container">
      <?php echo $config['foot_info']; ?> <a href="http://opensolution.org/"><?php echo $sLangFooter; ?></a> Template by <a href="http://proszablon.pl">ProSzablon.pl</a>
    </div>
  </div>
</div>
</body>
</html>