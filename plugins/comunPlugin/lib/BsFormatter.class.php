<?php

class BsFormatter extends sfWidgetFormSchemaFormatter
{
  protected
    $rowFormat			 = "<div class='form-group'>\n  %error%\n %field%\n  %help%\n%hidden_fields%\n</div>\n",
//    $helpFormat      = '<span class="help-block">%help%</span>',
    $helpFormat      = '<p class="help-block">%help%</p>',
    $errorRowFormat  = "<div class='has-error'>\n%errors%</div>\n",
    $errorListFormatInARow     = "  <ul class=\"has-error error_list\">\n%errors%  </ul>\n",
    $errorRowFormatInARow      = "    <li>%error%</li>\n",
    $namedErrorRowFormatInARow = "    <li>%name%: %error%</li>\n",
  
    $decoratorFormat = '<div class="form-inline">%content%</div>';
    
}
  