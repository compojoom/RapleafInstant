<?php

//var_dump($this);
//var_dump(KFactory::get('admin::com.rapleaf.model.users')->getItems());
//var_dump($users);
//$users = KFactory::get('admin::com.rapleaf.model.users')->getList();
//
//foreach($users as $user) {
//	var_dump($user->email);
//	
////	$person = $argv[1];
//   $rapleafArray[] = array(
//	   'email' => $user->email
//   );
//}
//
//
//$api = new RapleafApiBulk();
//   try {
//     $response = $api->getJsonResponse($rapleafArray);
//var_dump($response);
//     foreach ($response as $key => $value) {
//      echo $key . " = " . $value . "\n";
//     }
//   } catch (Exception $e) {
//     echo 'Caught exception: ' . $e->getMessage() . "\n";
//   }

//var_dump($jusers);
?>

<div style="float:left;">
	<div class="icon">
		<a href="<?= @route('view=users') ?>">
			<img alt="<?= @text('COM_RAPLEAF_DASHBOARD_USERS');?>"
				src="media://com_rapleaf/images/dashboard/users.png" />
			<span><?= @text('COM_RAPLEAF_DASHBOARD_USERS');?></span>
		</a>
	</div>
</div>

<div style="float:left;">
	<div class="icon">
		<a href="<?= @route('view=statistics') ?>">
			<img alt="<?= @text('COM_RAPLEAF_DASHBOARD_STATISTICS');?>"
				src="media://com_rapleaf/images/dashboard/statistics.png" />
			<span><?= @text('COM_RAPLEAF_DASHBOARD_STATISTICS');?></span>
		</a>
	</div>
</div>