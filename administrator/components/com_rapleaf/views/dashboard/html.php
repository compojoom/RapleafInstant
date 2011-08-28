<?php


defined('KOOWA') or die('');

class ComRapleafViewDashboardHtml extends ComDefaultViewHtml
{
	public function display()
	{
//$lastId = KFactory::tmp('admin::com.rapleaf.model.reports')->getTable()->getSchema()->autoinc - 1;

$report = KFactory::tmp('admin::com.rapleaf.model.reports')
		->set('sort', 'id')
		->set('direction','DESC')->limit(1)->getList()->top();
//var_dump($lastId);
//		$report = KFactory::tmp('admin::com.rapleaf.model.reports')
//				->set('sort','rapleaf_report_id')
//				->set('direction', 'DESC')
//				->last(true)
//				->getItem();
		
//		foreach ($report as $key => $value) {
//			echo $value->id;
//		}
		var_dump(($report->id));
//		var_dump($report);
//		$this->getToolbar()->reset()->setTitle('Overview');

//		KFactory::get('admin::com.rapleaf.toolbar.dashboard')
//			->reset()
//			->setTitle('COM_RAPLEAF_DASHBOARD_TITLE','dashboard');
			
//		$age = KFactory::tmp('admin::com.rapleaf.model.users')->userAge();
		var_dump(json_encode(KFactory::tmp('admin::com.rapleaf.model.users')->userLocation()));
//		$this->assign('age', KFactory::tmp('admin::com.rapleaf.model.users')->userAge());
//		$this->assign('gender', KFactory::tmp('admin::com.rapleaf.model.users')->userGender());
//		$this->assign('location', KFactory::tmp('admin::com.rapleaf.model.users')->userLocation());
//		KRequest::set('get.hidemainmenu', 0);

		return parent::display();
	}
}