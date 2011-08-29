<?php
defined('_JEXEC') or die('Restricted access');

$oldReportData = json_decode($this->oldReport->report);
$currentReportData = json_decode($this->currentReport->report);

$stats = array();
foreach ($currentReportData->gender as $value) {
	foreach ($oldReportData->gender as $oldValue) {
		$stats[$value->age]['new']['male'] = $value->male;
		$stats[$value->age]['new']['female'] = $value->female;

		if ($oldValue->age == $value->age) {
			$stats[$value->age]['old']['male'] = $oldValue->male;
			$stats[$value->age]['old']['female'] = $oldValue->female;
			$stats[$value->age]['new']['male'] = $value->male;
			$stats[$value->age]['new']['female'] = $value->female;

			if ($value->male > $oldValue->male) {
				$stats[$value->age]['male']['development'] = 'up';
			} elseif ($value->male == $oldValue->male) {
				$stats[$value->age]['male']['development'] = 'equal';
			} else {
				$stats[$value->age]['male']['development'] = 'down';
			}

			if ($value->female > $oldValue->female) {
				$stats[$value->age]['female']['development'] = 'up';
			} elseif ($value->female == $oldValue->female) {
				$stats[$value->age]['female']['development'] = 'equal';
			} else {
				$stats[$value->age]['female']['development'] = 'down';
			}
		}
	}
}
?>

<?php if (count($this->reports) >= 2) : ?>
	<div class="comparison-info" id="comparison-info">
		<h2>Compare reports</h2>
		<table class="adminlist" style="width:350px">
			<thead>
				<tr>
					<th width="45px;"></th>
					<th>
						<?php echo $this->currentReport->date; ?>
					</th>
					<th width="15px">
					</th>
					<th>
			<form action="index.php?option=com_rapleaf&view=report&task=compare" method="post" id="form-compare">
				<?php echo JHTML::_('select.genericlist', $this->reports, 'reports', null, 'rapleaf_report_id', 'date'); ?>
			</form>
			<img src="<?php echo Juri::root();?>/media/com_rapleaf/images/arrow.png" />
			</th>
			</tr>
			</thead>
		</table>
		<div id="comparison">
			<?php
				require_once(JPATH_COMPONENT_ADMINISTRATOR . '/views/report/tmpl/default.php');
			?>
		</div>
		<div class="clear-both"></div>
	</div>
<?php endif; ?>