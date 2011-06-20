<?php
class ComRapleafControllerDashboard extends ComDefaultControllerResource
{
    protected function _initialize(KConfig $config) 
    {   
        $config->append(array(
            'request' => array('layout' => 'default'),
        ));

        parent::_initialize($config);
    }
	
//	protected function _actionBrowse(KCommandContext $context) {
//		die('action browse dashboard');
//	}
//	
//	public function _beforeBrowse(KCommandContext $context)
//	{
//		die('before browse dashboard');
//	}
//	
//	public function _beforeRead(KCommandContext $context)
//	{
//		die('beforeread Dashboard');
//	}

}