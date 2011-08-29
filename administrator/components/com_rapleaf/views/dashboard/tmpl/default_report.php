<?php
defined('_JEXEC') or die('Restricted access');
?>

<?php if (count($this->reports) >= 2) : ?>
	<div>
		compare with
		<form action="index.php?option=com_rapleaf&view=report&task=compare" method="post" id="form-compare">
			<?php echo JHTML::_('select.genericlist', $this->reports, 'reports', null, 'rapleaf_report_id', 'date'); ?>
			<input type="submit" value="submit" />
		</form>
	</div>
	<div id="comparison">
		<?php
		echo require_once(JPATH_COMPONENT_ADMINISTRATOR . '/views/report/tmpl/default.php');
		?>
	</div>
<?php endif; ?>