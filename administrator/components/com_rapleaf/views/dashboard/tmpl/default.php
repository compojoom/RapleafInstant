<?php
defined('_JEXEC') or die('Restricted access');
require_once(JPATH_COMPONENT_ADMINISTRATOR . '/helpers/language.php');
JHTML::stylesheet('rapleaf.css', 'media/com_rapleaf/css/');
JToolBarHelper::title(JText::_('COM_RAPLEAF_DASHBOARD'), 'rapleaf.png');
if (count($this->reports)) {
	JToolBarHelper::custom('generateReport', 'rerportGenerator.png', '', 'COM_RAPLEAF_GENERATE_REPORT', false);
}
JHTML::_('behavior.mootools');

JHTML::script('spin.js', 'media/com_rapleaf/js/');
JHTML::script('rapleaf.js', 'media/com_rapleaf/js/');

$document = JFactory::getDocument();
$domready = "window.addEvent('domready', function() {
	rapleafLanguage = " . RapleafHelperLanguage::outputJsonLanguage() . "
	var rapleafOptions = {'url' : '" . Juri::base() . "'};
	rapleaf = new Rapleaf(rapleafOptions);
	
});";
$document->addScriptDeclaration($domready);

if (count($this->reports)) {
	$reportData = json_decode($this->currentReport->report);
}
$config = JFactory::getConfig();
if (RAPLEAF_JVERSION == 15) {
	$siteName = $config->getValue('config.sitename');
} else {
	$siteName = $config->get('sitename');
}
?>
<?php if (RAPLEAF_JVERSION == 15) : ?>
	<script type="text/javascript">
		function submitbutton(task) {
			
			if (task == 'generateReport') {
				rapleaf.initializeReport();
				return;
			}
			submitform(task);
		}
	</script>
<?php else : ?>
	<script type="text/javascript">
		Joomla.submitbutton = function(task)
		{
			if (task == 'generateReport') {
				rapleaf.initializeReport();
				return;
			}
			Joomla.submitform(task,document.getElementById('admin-form'));
		}
			
	</script>
<?php endif; ?>

<div class="rapleaf">
	<div id="rapleaf-logo"><a href="http://rapleaf.com" target="_blank" title="<?php echo JText::_('COM_RAPLEAF_POWERED_BY');?>"><span></span></a></div>

	<form name="adminForm" action="" id="admin-form">
		<input type="hidden" name="option" value="com_rapleaf" />
		<input type="hidden" name="view" value="report" />
		<input type="hidden" name="task" value="" />
	</form>
	<?php if (count($this->reports)) : ?>
		<?php if ($reportData->rapleafUsers > 20) : ?>
			<div class="report-info">
				<h1>
					<?php echo JText::sprintf('COM_RAPLEAF_SITE_DEMOGRAPHIC_REPORT', $siteName); ?>
				</h1>
				<?php echo $this->loadTemplate('analysis'); ?>
				<?php echo $this->loadTemplate('report'); ?>
				<div class="clear-both"></div>
				<?php echo $this->loadTemplate('charts'); ?>    
			</div>

		<?php else : ?>
			<?php if ($reportData->joomlaUsers <= 20) : ?>
				<?php echo JText::sprintf('COM_RAPLEAF_WEBSITE_HAS_LESS_THAN_20_MEMBERS', 'index.php?option=com_rapleaf&view=users'); ?>

			<?php elseif ($reportData->rapleafUsers <= 20) : ?>
				<?php echo JText::sprintf('COM_RAPLEAF_RAPLEAF_DATA_FOR_LESS_THAN_20_MEMBERS', 'index.php?option=com_rapleaf&view=users'); ?>
			<?php endif; ?>

		<?php endif; ?>
	<?php else: ?>
	<div class="first-time-run">
		<?php echo JText::_('COM_RAPLEAF_INFO_0_REPORTS'); ?>
		<br /><br />
		<?php echo JText::_('COM_RAPLEAF_INFO_TERMS'); ?>
		<a href="https://www.rapleaf.com/opt_out">https://www.rapleaf.com/opt_out</a>
		<br /><br />
		<input type="checkbox" name="accept" id="rapleaf-accept-terms" />
		<label id="label-accept" for="rapleaf-accept-terms">
			<?php echo JText::_('COM_RAPLEAF_ACCEPT_TERMS'); ?>
			<span style="display:none; color:red;">(<?php echo JText::_('COM_RAPLEAF_NEED_TO_ACCEPT_TERMS'); ?>)</span>
		</label>
		<br /><br />
	</div>
		<span id="rapleaf-generate-report">
			<?php echo JText::_('COM_RAPLEAF_ANALYZE_SITE_MEMBERS'); ?>
		</span>
	<?php endif; ?>
</div>