<?php


defined('KOOWA') or die('');

class ComRapleafViewDashboardHtml extends ComDefaultViewHtml
{
	public function display()
	{

//		$this->getToolbar()->reset()->setTitle('Overview');

//		KFactory::get('admin::com.rapleaf.toolbar.dashboard')
//			->reset()
//			->setTitle('COM_RAPLEAF_DASHBOARD_TITLE','dashboard');
			
		KRequest::set('get.hidemainmenu', 0);

		return parent::display();
	}
}