<?php
$this->breadcrumbs=array(
	'Yiilogs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Yiilog', 'url'=>array('index')),
	array('label'=>'Create Yiilog', 'url'=>array('create')),
	array('label'=>'View Yiilog', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Yiilog', 'url'=>array('admin')),
);
?>

<h1>Update Yiilog <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>