<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php $report = json_decode($this->lastReport->report); ?>
<?php
JHTML::script('jsapi', 'https://www.google.com/');

$document = JFactory::getDocument();

$age = json_encode($report->age);
$gender = json_encode($report->gender);
$location = json_encode($report->location);
$domready = <<<ABC

	google.load("visualization", "1", {packages:["corechart", 'geochart', 'imagechart']});
	google.setOnLoadCallback(draw);
	
	function draw() {
		
		var age = $age;
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Age');
		data.addColumn('number', 'Number of people');
		data.addRows(age.length);
		var i = 0;
		age.each(function(user) {
			data.setValue(i, 0, user.age.toString());
			data.setValue(i, 1, user.count.toInt());
			i++;
		});

		var chart = new google.visualization.PieChart(document.getElementById('age'));
		chart.draw(data, {width: 420, height: 300});
		google.visualization.events.addListener(chart, 'select', function() {
			var selection = chart.getSelection();
			var age = data.getValue(selection[0].row,0);
			window.location = 'index.php?option=com_rapleaf&view=users&search=age:' + age;
		});
		


		var gender = $gender;
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Age');
		data.addColumn('number', 'Male');
		data.addColumn('number', 'Female');
		data.addRows(gender.length);
		var i = 0;
		gender.each(function(user) {
			data.setValue(i, 0, user.age.toString());
			data.setValue(i, 1, user.male.toInt());
			data.setValue(i, 2, user.female.toInt());
			i++;
		});

		var genderChart = new google.visualization.ColumnChart(document.getElementById('gender'));
		genderChart.draw(data, {width: 420, height: 300,
					hAxis: {title: 'Age', titleTextStyle: {color: 'red'}}});
		google.visualization.events.addListener(genderChart, 'select', function() {
			var selection = genderChart.getSelection();
			var gender;
			if(selection[0].column == 1) {
				gender = 'male';
			} else {
				gender = 'female';
			}
			window.location = 'index.php?option=com_rapleaf&view=users&search=gender:' + gender;
		});
		
		var location = $location;
		var mapData = new google.visualization.DataTable();
		mapData.addColumn('string', 'Country');
		mapData.addColumn('number', 'Users');
		mapData.addRows(location.length);
		var i = 0;
		location.each(function(country) {
			mapData.setValue(i, 0, country.location);
			mapData.setValue(i, 1, country.count.toInt());
			i++;
		});
		
		var options = {width: 900, height: 450};

		var container = document.getElementById('map');
		var geochart = new google.visualization.GeoChart(container);
		geochart.draw(mapData, options);
		
		google.visualization.events.addListener(geochart, 'select', function() {
			var selection = geochart.getSelection();
			var location = mapData.getValue(selection[0].row,0);

			window.location = 'index.php?option=com_rapleaf&view=users&search=location:' + location;
		});
	}
ABC;

$document->addScriptDeclaration($domready);
?>
<div class="age-chart">
	<h2><?php echo JText::_('COM_RAPLEAF_AGE_GROUPS');?></h2>
	<div id="age"></div>
</div>
<div class="gender-chart">
	<h2><?php echo JText::_('COM_RAPLEAF_GENDER_AND_AGE_GROUPS');?></h2>
	<div id="gender"></div>
</div>
<div class="clear-both"></div>
<div class="map-chart">
	<h2><?php echo JText::_('COM_RAPLEAF_MEMBERS_COUNTRIES'); ?></h2>
	<div id="map"></div>
</div>