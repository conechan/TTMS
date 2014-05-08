		<table>
			<tr>
				<td>Name</td>
				<td><?= $system->name ?></td>
			</tr>
			<tr>
				<td>Owner</td>
				<td><?= $system->owner->name ?></td>
			</tr>
			<tr>
				<td>Manage</td>
                <td>
                <?php
                echo
                anchor('systems/edit/'.$system->id,'edit', 'class="edit"').' '.
                anchor('systems/delete/'.$system->id,'delete', 'class="delete"');
                ?>
                </td>
			</tr>
		</table>
        <p>
        <?=anchor('systems/','back to the list', 'class="back"')?>
        </p>
