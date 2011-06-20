<?php

require_once(JPATH_COMPONENT . DS . 'libraries' . DS . 'rapleafApiBulk.php');

echo KFactory::get('admin::com.rapleaf.dispatcher')->dispatch();

?>
