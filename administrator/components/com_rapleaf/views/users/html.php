<?php


defined('KOOWA') or die('');

class ComRapleafViewUsersHtml extends ComDefaultViewHtml
{
	public function display()
	{
		//Reset the toolbar
//		KFactory::get('admin::com.rapleaf.toolbar.dashboard')
//			->reset()
//			->setTitle('COM_RAPLEAF_DASHBOARD_TITLE','dashboard');
			
		KRequest::set('get.hidemainmenu', 0);

		return parent::display();
	}
}