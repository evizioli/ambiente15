<?php

class gridFormatter extends sfWidgetFormSchemaFormatter
{
  protected
    $rowFormat			 = "<td>\n  %error%\n %field%\n  %help%\n%hidden_fields%\n</td>\n",
    $helpFormat      = '<div class="form_helper">%help%</div>',
    $errorRowFormat  = "<div>\n%errors%</div>\n",
    $errorListFormatInARow     = "  <ul class=\"error_list\">\n%errors%  </ul>\n",
    $errorRowFormatInARow      = "    <li>%error%</li>\n",
    $namedErrorRowFormatInARow = "    <li>%name%: %error%</li>\n",
    $decoratorFormat = "%content%";
}