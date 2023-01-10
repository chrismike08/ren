<?php
if( !defined( 'CUSTOMER_PAGE' ) )
  exit;
?>

          <div id="options">
			 	<div class="print"><a href="javascript:window.print();"><?php echo $lang['print']; ?></a></div>
				<div class="back"><a href="javascript:history.back();">&laquo; <?php echo $lang['back']; ?></a></div>   
          </div>
        </div>
      </div>
    </div>
  <div class="clearing">&nbsp;</div>
  </div>
  <div id="foot"><?php // footer starts here ?>
    <div class="container">
      <div id="copy"><?php echo $config['foot_info']; ?></div><!-- copyrights here -->
      <?php
      /*
      * Dont delete or hide link "CMS by Quick.Cms" to www.OpenSolution.org
      * Read license requirements: www.opensolution.org/license.html
      */
      ?>
      <div class="foot" id="powered"><a href="http://opensolution.org/"><?php echo $sLangFooter; ?></a> | <a href="http://www.alphastudio.pl">Designed by Alpha Studio</a> | <a href="http://freetemplatescms.com">Adapted by freetemplatescms.com</a></div><!-- dont delete or hide this line, read license: www.opensolution.org/license.html -->
    </div>
  </div>
</div>
</body>
</html>