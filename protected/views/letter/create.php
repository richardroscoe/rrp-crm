<?php
$this->breadcrumbs=array(
	'Letters'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Letter', 'url'=>array('index')),
	array('label'=>'Manage Letter', 'url'=>array('admin')),
);
?>

<h1>Create Letter</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>