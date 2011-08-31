<?php
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.mootools');
JHTML::stylesheet('rapleaf.css', 'media/com_rapleaf/css/');

JToolBarHelper::title(JText::_('COM_RAPLEAF_USERS'), 'users.png');
JToolBarHelper::custom('csvExport', 'csv.png', '', 'CSV', false);

$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
?> 
<?php if (RAPLEAF_JVERSION == 15) : ?>
	<script type="text/javascript">
		function submitbutton(task) {
				
			if (task == 'csvExport') {
				submitform(task);
				document.id('task').set('value','');
				return;
			}
			submitform(task);
		}
	</script>
<?php else : ?>
	<script type="text/javascript">
		Joomla.submitbutton = function(task)
		{
			if (task == 'csvExport') {
				Joomla.submitform(task,document.getElementById('admin-form'));
				document.id('task').set('value','');
				return;
			}
			Joomla.submitform(task,document.getElementById('admin-form'));
		}
				
	</script>
<?php endif; ?>
<div class="rapleaf">
	<div id="rapleaf-logo"><a href="http://rapleaf.com" target="_blank" title="<?php echo JText::_('COM_RAPLEAF_POWERED_BY'); ?>"><span></span></a></div>
	<form action="" name="adminForm" method="post" id="admin-form">
		<fieldset id="filter-bar">
			<div class="filter-search fltlft">
				<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search']; ?>" title="<?php echo JText::_('COM_RAPLEAF_FILTER_SEARCH_DESC'); ?>" />

				<button type="submit" class="btn"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
				<button type="button" onclick="document.id('search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
			</div>
		</fieldset>
		<table class="adminlist">
			<thead>
				<tr>
					<th>
						<?php echo JText::_('COM_RAPLEAF_GRAVATAR'); ?>
					</th>
					<th >
						<?php echo JHtml::_('grid.sort', 'COM_RAPLEAF_NAME', 'name', $listDirn, $listOrder); ?>
					</th>
					<th >
						<?php echo JHtml::_('grid.sort', 'COM_RAPLEAF_USERNAME', 'username', $listDirn, $listOrder); ?>
					</th>
					<th >
						<?php echo JHtml::_('grid.sort', 'COM_RAPLEAF_EMAIL', 'email', $listDirn, $listOrder); ?>
					</th>
					<th >
						<?php echo JHtml::_('grid.sort', 'COM_RAPLEAF_AGE', 'age', $listDirn, $listOrder); ?>
					</th>
					<th >
						<?php echo JHtml::_('grid.sort', 'COM_RAPLEAF_GENDER', 'gender', $listDirn, $listOrder); ?>
					</th>
					<th >
						<?php echo JHtml::_('grid.sort', 'COM_RAPLEAF_LOCATION', 'location', $listDirn, $listOrder); ?>
					</th>
					<th class="not-available" title="<?php echo JText::_('COM_RAPLEAF_COMMING_SOON'); ?>">
						<?php echo JText::_('COM_RAPLEAF_INCOME'); ?>
					</th>
					<th class="not-available" title="<?php echo JText::_('COM_RAPLEAF_COMMING_SOON'); ?>">
						<?php echo JText::_('COM_RAPLEAF_CHILDREN'); ?>
					</th>
					<th class="not-available" title="<?php echo JText::_('COM_RAPLEAF_COMMING_SOON'); ?>">
						<?php echo JText::_('COM_RAPLEAF_MARITIAL_STATUS'); ?>
					</th>
					<th class="not-available" title="<?php echo JText::_('COM_RAPLEAF_COMMING_SOON'); ?>">
						<?php echo JText::_('COM_RAPLEAF_EDUCATION'); ?>
					</th>
					<th class="not-available" title="<?php echo JText::_('COM_RAPLEAF_COMMING_SOON'); ?>">
						<?php echo JText::_('COM_RAPLEAF_OCCUPATION'); ?>
					</th>
				</tr>
			</thead>



			<tbody>
				<?php $i = 0; ?>
				<?php foreach ($this->users as $user) : ?>
					<?php
					$gravatarEmail = md5(strtolower(trim($user->email)));
					?>
					<tr>
						<td align="center">
							<a href="http://www.gravatar.com/<?php echo $gravatarEmail; ?>" target="_blank">
								<img src="http://www.gravatar.com/avatar/<?php echo $gravatarEmail; ?>?s=32" alt="gravatar" />
							</a>
						</td>
						<td align="left">    					
							<?php echo $user->name ?>
						</td>
						<td align="username">  
							<?php if(RAPLEAF_JVERSION == 15) : ?>
								<?php $link ='index.php?option=com_users&view=user&task=edit&cid[]='.$user->user_id; ?>
							<?php else: ?>
								<?php $link = 'index.php?option=com_users&task=user.edit&id='.$user->user_id; ?>
							<?php endif; ?>
							<a href="<?php echo JRoute::_($link); ?>">
								<?php echo $user->username ?>
							</a>
						</td>
						<td align="username">
							<a href="mailto:<?php echo $user->email; ?>">
								<?php echo $user->email ?>
							</a>
						</td>
						<td align="username">    					
							<?php echo $user->age ?>
						</td>
						<td align="center">
							<?php if ($user->gender == 1) : ?>
								<img src="<?php echo JURI::root() ?>/media/com_rapleaf/images/man.png" alt="male" />
							<?php elseif ($user->gender == 2) : ?>
								<img src="<?php echo JURI::root() ?>/media/com_rapleaf/images/woman.png" alt="female" />
							<?php endif; ?>
						</td>
						<td align="left">    					
							<?php echo $user->location ?>
						</td>
						<td align="left" class="not-available" title="<?php echo JText::_('COM_RAPLEAF_COMMING_SOON'); ?>">    					
							<?php //echo $user->household_income ?>
						</td>
						<td align="left" class="not-available" title="<?php echo JText::_('COM_RAPLEAF_COMMING_SOON'); ?>">    					
							<?php //echo $user->children  ?>
						</td>
						<td align="left" class="not-available" title="<?php echo JText::_('COM_RAPLEAF_COMMING_SOON'); ?>">    					
							<?php //echo $user->marital_status ?>
						</td>
						<td align="left" class="not-available" title="<?php echo JText::_('COM_RAPLEAF_COMMING_SOON'); ?>">    					
							<?php //echo $user->education ?>
						</td>
						<td align="left" class="not-available" title="<?php echo JText::_('COM_RAPLEAF_COMMING_SOON'); ?>">    					
							<?php //echo $user->occupation ?>
						</td>
					</tr>
				<?php endforeach; ?>

				<?php if (!count($this->users)) : ?>
					<tr>
						<td colspan="20" align="center">
							<?php echo JText::_('No Items Found'); ?>
						</td>
					</tr>
				<?php endif; ?>	
			</tbody>	

			<tfoot>
				<tr>
					<td colspan="13">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
		</table>
		<input type="hidden" id="task" name="task" value="" />
		<input type="hidden" name="view" value="users" />
	</form>
</div>