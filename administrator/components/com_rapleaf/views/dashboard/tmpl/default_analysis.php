<?php
defined('_JEXEC') or die('Restricted access');

$report = json_decode($this->currentReport->report);

$totalUsersInAgeGroups = 0;
foreach ($report->age as $value) {
	$totalUsersInAgeGroups += $value->count;
}
$age = array();
foreach ($report->age as $value) {
	$age[$value->age]['percentage'] = ($value->count * 100) / $totalUsersInAgeGroups;
}

if(count($age)) {
	$maxKey = max_key($age);

	if($age[$maxKey]['percentage'] > 25) {
		$ageGroup = str_replace('+','',str_replace('-','_',$maxKey));

		$ageAnalysis = JText::sprintf('COM_RAPLEAF_CRITERIA_AGE_'.$ageGroup, number_format($age[$maxKey]['percentage'],1).'%');
	} else {
		$ageAnalysis = JText::_('COM_RAPLEAF_NONE_AGE_CRITERIA_MET');
	}
} else {
	$ageAnalysis = '';
}
function max_key($array)
{
	foreach ($array as $key => $val) {
		if ($val == max($array))
			return $key;
	}
}

$percentageFemale = ($report->totalFemale*100)/($report->totalFemale + $report->totalMale);

if($percentageFemale < 30){
	$genderText = JText::_('COM_RAPLEAF_GENDER_ANALYSIS_LESS_THAN_30');
}  elseif($percentageFemale > 30 && $percentageFemale < 50) {
	$genderText = JText::sprintf('COM_RAPLEAF_GENDER_ANALYSIS_31_49',number_format($percentageFemale,1).'%');
} elseif($percentageFemale > 50 && $percentageFemale < 70) {
	$genderText = JText::sprintf('COM_RAPLEAF_GENDER_ANALYSIS_51_69',number_format($percentageFemale,1).'%');
} elseif ($percentageFemale > 70) {
	$genderText = JText::_('COM_RAPLEAF_GENDER_ANALYSIS_MORE_THAN_70');
}

$user = JFactory::getUser();
?>
<div class="analysis" id="analysis">
	<h2><?php echo JText::_('COM_RAPLEAF_QUICK_OVERVIEW');?></h2>
	<p>
		<?php echo JText::sprintf('COM_RAPLEAF_DEAR',$user->name); ?>
	</p>
	<p>
		<?php echo JText::sprintf('COM_RAPLEAF_QUICK_USER_REPORT', $report->joomlaUsers, $report->rapleafUsers); ?>
		
	</p>
	<p>
		<?php echo $ageAnalysis; ?>
	</p>
	<p>
		<?php echo $genderText; ?>
	</p>
</div>

