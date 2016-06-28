<?php
$this->breadcrumbs=array(
	'Yiilogs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Yiilog', 'url'=>array('index')),
	array('label'=>'Manage Yiilog', 'url'=>array('admin')),
);
?>

<h1>Create Yiilog</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>