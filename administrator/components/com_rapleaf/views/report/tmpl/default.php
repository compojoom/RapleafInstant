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

<table class="rapleaf-table" style="width:350px">
	<tbody>

		<?php foreach ($stats as $key => $value) : ?>
			<tr>
				<td width="45px;">
					<?php echo JText::_('COM_RAPLEAF_AGE'); ?>
				</td>
				<td colspan="3">
					<span class="bold"><?php echo $key; ?></span>

				</td>
			</tr>
			<tr>
				<td width="45px;">
					<?php echo JText::_('COM_RAPLEAF_MALE'); ?>
				</td>
				<td align="right"> <span class="bold"><?php echo $value['new']['male']; ?></span></td>
				<td width="15px">
					<span class="<?php echo $value['male']['development']; ?>"></span>
				</td>
				<td><span class="bold"><?php echo $value['old']['male']; ?></span></td>
			</tr>
			<tr class="bottom-line">
				<td  width="45px;"><?php echo JText::_('COM_RAPLEAF_FEMALE'); ?></td>
				<td align="right" width="90px;"><span class="bold"><?php echo $value['new']['female']; ?></span></td>
				<td  width="15px"><span class="<?php echo $value['female']['development']; ?>"></span></td>
				<td><span class="bold"><?php echo $value['old']['female']; ?></span></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
