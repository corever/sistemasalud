<table class="table table-condensed small table-bordered">
    <thead>
        <tr>
            <th>Nº</th>
            <th>Nombre</th>
            <!--<th>Opciones</th>-->
        </tr>
    </thead>
    <tbody>
        <?php if ($arrEspecifico) :?>
            <?php $i = 0;?>
            <?php foreach ($arrEspecifico['opciones_select'] as $op_crit) :?>
                <tr>
                    <td class="text-center"><?php echo ++$i?></td>
                    <td class="text-center"><?php echo $op_crit?></td>
                    <!--<td class="text-center">
                        <button type="button" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></button>
                    </td>-->
                </tr>
            <?php endforeach;?>
        <?php endif;?>
    </tbody>
</table>