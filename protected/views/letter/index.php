<?php
$this->breadcrumbs=array(
	'Letters',
);

$this->menu=array(
	array('label'=>'Create Letter', 'url'=>array('create')),
	array('label'=>'Manage Letter', 'url'=>array('admin')),
);
?>

<h1>Letters</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'id',
		'type',
		'media',
		'cat',
		'subcat',
		'sex',
		/*
		'subject',
		'body',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>