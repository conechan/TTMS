		<table class="form">
			<tr>
				<td class="label">Host name</td>
				<td><?= $server->name ?></td>
			</tr>
			<tr>
				<td class="label">IP</td>
				<td><?= $server->ip ?></td>
			</tr>
            <tr>
				<td class="label">Type</td>
				<td><?= $server->type->name ?></td>
			</tr>
            <tr>
				<td class="label">System</td>
				<td><?= $server->system->name ?></td>
			</tr>
            <tr>
				<td class="label">Login name</td>
				<td><?= $server->login_name ?></td>
			</tr>
                        <tr>
				<td class="label">Login password</td>
				<td><?= $server->login_pwd ?></td>
			</tr>
            <tr>
				<td class="label">root password</td>
				<td><?= $server->root_pwd ?></td>
			</tr>
            <tr>
				<td class="label">description</td>
				<td><?= $server->description ?></td>
			</tr>
			<tr>
				<td class="label">Actions</td>
                <td>
			<? foreach($server->actions as $s): ?>
			<li><?=anchor_popup('servers/execute/'.$server->ip.'/'.$s->command, $s->name)?></li>
			<? endforeach; ?>
            </td>
			<tr>
				<td class="label">Manage</td>
                <td>
                <?php
                echo
                anchor('servers/edit/'.$server->id,'edit', 'class="edit"').' '.
                anchor('servers/delete/'.$server->id,'delete', 'class="delete"');
                ?>
                </td>
			</tr>
		</table>
        <p>
        <?=anchor('servers/','back to the list', 'class="back"')?>
        </p>
