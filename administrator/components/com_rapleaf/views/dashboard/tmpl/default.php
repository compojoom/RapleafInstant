<?php
defined('_JEXEC') or die('Restricted access');
JHTML::stylesheet(JURI::root() . 'media/com_rapleaf/css/rapleaf.css');
JToolBarHelper::title(JText::_('COM_RAPLEAF_DASHBOARD'), 'rapleaf.png');
JToolBarHelper::custom('generateReport','rerportGenerator.png','','Generate Report', false);
JHTML::_('behavior.mootools');
JHTML::script(JURI::root() . 'media/com_rapleaf/js/spin.js');
JHTML::script(JURI::root() . 'media/com_rapleaf/js/rapleaf.js');

$document = JFactory::getDocument();
$domready = "window.addEvent('domready', function() {
	rapleaf = new Rapleaf;
	
});";
$document->addScriptDeclaration($domready);

?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'generateReport') {
			rapleaf = new Rapleaf;
			rapleaf.initializeReport();
			return;
		}
		Joomla.submitform(task,document.getElementById('admin-form'));
	}
	
</script>
<form name="adminForm" action="" id="admin-form">
	<input type="hidden" name="option" value="com_rapleaf" />
	<input type="hidden" name="view" value="report" />
	<input type="hidden" name="task" value="" />
</form>
<?php if (count($this->reports)) : ?>
	<?php echo $this->loadTemplate('charts'); ?>    
	
	<?php echo $this->loadTemplate('analysis'); ?>
	<?php echo $this->loadTemplate('report'); ?>
<?php else: ?>
	It seems that you have no reports.
	<span id="rapleaf-generate-report">
		generate one now
		
	</span>
<?php endif; ?>
