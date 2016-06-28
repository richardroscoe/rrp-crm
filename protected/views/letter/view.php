<?php
$this->breadcrumbs=array(
	'Letters'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Letter', 'url'=>array('index')),
	array('label'=>'Create Letter', 'url'=>array('create')),
	array('label'=>'Update Letter', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Letter', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Letter', 'url'=>array('admin')),
);
?>

<h1>View Letter #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'type',
		'media',
		'cat',
		'subcat',
		'sex',
		'subject',
		'body:html',
	),
)); ?>
