<?php
$this->breadcrumbs=array(
	'Yiilogs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Yiilog', 'url'=>array('index')),
	array('label'=>'Create Yiilog', 'url'=>array('create')),
	array('label'=>'Update Yiilog', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Yiilog', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Yiilog', 'url'=>array('admin')),
);
?>

<h1>View Yiilog #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'level',
		'category',
		'logtime',
		'message',
	),
)); ?>
