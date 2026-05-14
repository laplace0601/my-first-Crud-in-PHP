 <?= $cabecera?>
 <a class="btn btn-success" href="<?= base_url('crear') ?>">crea un libro</a>
 <br/>
 
 <table class="table table-dark table-striped mt-4">
        <thead class="thead-white">
            <tr>
                <th>#</th>
                <th>imagen</th>
                <th>nombre</th>
                <th><A></A>acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($libros as $libro): ?>
            <tr>
                <td><?= $libro['id']; ?></td>
                <td>
            
                <img class="img-thumbnail" 
                src="<?=base_url()?>/uploads/<?= $libro['imagen']; ?>"
                 width ="100" alt="">
              
            
            </td>
            <td><?= $libro['nombre'];?></td>
            <td>




                <a href="<?=base_url('editar/' . $libro['id']); ?>" class="btn btn-info" type="button">Editar</a>
                <a href="<?=base_url('borrar/' . $libro['id']); ?>" class="btn btn-danger" type="button">Borrar</a>


                </td>

            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
 <?= $pie?>