<div class="container">
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>productos/listado/<?php echo $pagina?>">Listado de productos</a></li>
      <li class="active">Agregar fotos producto</li>
    </ol>
    <div class="panel panel-primary">
        <div class="panel-heading">Agregar fotos producto (<?php echo $datos->nombre?>)</div>
        <div class="panel-body">
            <?php
            if($this->session->flashdata('mensaje')!='')
            {
               ?>
               <div class="alert alert-<?php echo $this->session->flashdata('css')?>"><?php echo $this->session->flashdata('mensaje')?></div>
               <?php 
            }
            ?>
            <div>
                
               
            
            
            <?php echo form_open_multipart(null,array("name"=>"form"));?>
            <?php
                //acá visualizamos los mensajes de error
                $errors=validation_errors('<li>','</li>');
                if($errors!="")
                {
                    ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php echo $errors;?>
                        </ul>
                    </div>
                    <?php
                }
                ?>
            <p>
                <label for="nombre">Foto:</label>
                <input type="file" name="file" />
                <!--<input type="file" name="file[]" multiple="true" />-->
            </p>
            
            
            
            <hr />
            <input type="hidden" name="id" value="<?php echo $id?>" />
            <input type="hidden" name="pagina" value="<?php echo $pagina?>" />
            <input type="submit" value="Enviar" class="btn btn-default" />
            <?php echo form_close();?> 
             <hr />
            </div>
            <div>
                
                <!--fotos-->
                <div class="row">
                    <?php
                    foreach($fotos as $foto)
                    {
                        ?>
                        <div class="col-xs-6 col-md-3">
                            
                              <img src="<?php echo base_url();?>public/uploads/productos/<?php echo $foto->foto?>" alt="..."  class="thumbnail" width="100" height="100" />
                            
                        </div>
                        <?php
                    }
                    ?>
                  
                 
                </div>
                <!--/fotos-->
                
            </div>
        </div>
    </div>
</div>

