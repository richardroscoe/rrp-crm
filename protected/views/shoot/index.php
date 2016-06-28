<?php
$this->breadcrumbs=array(
	'Shoot',
);?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?php
$this->renderPartial('_list', array('shoots' => $shoots));
?>