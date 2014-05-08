<table>
    <tr>
        <td>Action name</td>
        <td><?= $action->name ?></td>
    </tr>
    <tr>
        <td>Command or Script</td>
        <td><?= $action->command ?></td>
    </tr>
        <tr>
        <td>Description</td>
        <td><?= $action->description ?></td>
    </tr>
    <tr>
        <td>Manage</td>
        <td>
        <?= anchor('actions/edit/'.$action->id,'edit', 'class="edit"').' '.
            anchor('actions/delete/'.$action->id,'delete', 'class="delete"')?>
        </td>
    </tr>
</table>
<p>
<?=anchor('actions/','back to the list', 'class="back"')?>
</p>
