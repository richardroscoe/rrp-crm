<?php
$this->breadcrumbs=array(
	'Yiilogs',
);

$this->menu=array(
	array('label'=>'Create Yiilog', 'url'=>array('create')),
	array('label'=>'Manage Yiilog', 'url'=>array('admin')),
);
?>

<h1>Yiilogs</h1>

<?php /* $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); */?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'yiilog-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
//		'level',
//		'category',
//		'logtime',
//		'message:ntext',
		array(
			'name'=>'Log Time',
			'value'=>'date("d M Y H:i:s", $data->logtime)',
		),
		array(
			'name'=>'Message',
			'value'=>'CrmHelper::firstline($data->message)',
		),
//		array(
//			'class'=>'CButtonColumn',
//		),
	),
)); ?>