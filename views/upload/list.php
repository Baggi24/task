<table class="table table-hover">
	<thead>
	<tr>
		<th scope="col">Import Number</th>
		<th scope="col">File Name</th>
		<th scope="col">Store</th>
		<th scope="col">Success</th>
		<th scope="col">Fail</th>
	</tr>
	</thead>
	<tbody>
	<?php

	foreach ($list as $value){
		?>
		<tr>
			<td><?= $value['id'] ?></td>
			<td><?= $value['file_name'] ?></td>
			<td><?= $value['store'] ?></td>
			<td><?= $value['success'] ?></td>
			<td><?= $value['fail'] ?></td>
		</tr>
	<?php
	}

	?>

	</tbody>
</table>
