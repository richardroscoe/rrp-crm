<?php
$this->breadcrumbs=array(
	'Letters'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Letter', 'url'=>array('index')),
	array('label'=>'Create Letter', 'url'=>array('create')),
	array('label'=>'View Letter', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Letter', 'url'=>array('admin')),
);
?>

<h1>Update Letter <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>