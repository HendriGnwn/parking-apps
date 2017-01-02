<?php

use yii\helpers\Html;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<div class="thumbnail">
	<div class="caption">
	<h3><?= $title ?></h3>
	<table class="table table-striped">
		<tr>
			<th>Kendaraan</th>
			<th>Semua</th>
			<th>Masuk</th>
			<th>Keluar</th>
		</tr>
		<?php foreach($data as $id => $value): ?>
		<tr>
			<td><?= $id ?></td>
			<td><?= $value['all'] ?></td>
			<td><?= $value['in'] ?></td>
			<td><?= $value['out'] ?></td>
		</tr>
		<?php endforeach; ?>
	</table>

	<p><?= Html::a('<i class="fa fa-list"></i>&nbsp;&nbsp;Lihat Transaksi', ['transaction/index'], ['class'=>'btn btn-primary']) ?></p>
	</div>
</div>

