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

<table class="adminlist" style="width:320px">
	<thead>
	<th></th>
	<th>
		<?php echo $this->currentReport->date; ?>
	</th>
	<th width="15px">
	</th>
	<th>
		<?php echo $this->oldReport->date; ?>
	</th>
	</thead>
	<tbody>

		<?php foreach ($stats as $key => $value) : ?>
			<tr>
				<td>
					age
				</td>
				<td colspan="3">
					<span class="bold"><?php echo $key; ?></span>

				</td>
			</tr>
			<tr>
				<td>
					Male
				</td>
				<td align="right"> <span class="bold"><?php echo $value['new']['male']; ?></span></td>
				<td>
					<span class="<?php echo $value['male']['development']; ?>"></span>
				</td>
				<td><span class="bold"><?php echo $value['old']['male']; ?></span></td>
			</tr>
			<tr>
				<td>Female</td>
				<td align="right"><span class="bold"><?php echo $value['new']['female']; ?></span></td>
				<td><span class="<?php echo $value['female']['development']; ?>"></span></td>
				<td><span class="bold"><?php echo $value['old']['female']; ?></span></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
