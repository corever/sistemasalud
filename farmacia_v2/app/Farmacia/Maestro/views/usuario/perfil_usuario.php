<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <!--<h1></h1>-->
             <!-- float-sm-right-->
             <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="javascript:void(0)">PAHO::HOPE</a></li>
               <li class="breadcrumb-item active">Perfil Usuario</li>
            </ol>
         </div>
         <!--<div class="col-sm-6">
            <button type="button" class="btn bg-teal btn-xs mt-2" style="float:right;"
            onclick="xModal.open('<?php // echo \Pan\Uri\Uri::getBaseUri(); ?>Farmacia/Mantenedor/Usuario/agregarUsuario/','Agregar Usuario','lg');">
            <i class="fa fa-plus"></i>&nbsp;&nbsp;</button>
         </div>-->
      </div>
   </div>
   <!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-4">
                <div class="card card-primary">
                    <div class="card-header">
                    <h3 class="card-title">Datos Básicos</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAMFBMVEX////b3d/u7/Dc3uD8/Pz39/jp6uvg4ePz9PTj5Ob5+fnn6Orv8PHl5ujY2t3r7e1cV8MnAAADyElEQVR4nO3di5riIAwF4KH3aovv/7Zr1Y6zaxUSCumZPf8TkI82IRTx64uIiIiIiIiIiIiIiIiIiIiIiIiIiIhIrmmnbh77vu77ce6qobEe0L5O1ei8dz9413et9bB2M41uk+8vv2Imh95vB3hzsR5esmb8FN9isB5imiEQ3vKsnq0HmaIKTeAtxNF6mHqXmACveuuBak2RAToHOottdICg72JTRwd4DXGyHq7CWRDgFV7tb2UButl6wGJvVmpvebRV6hCfZh7Q8ql0Cq+wJrERT6FzWBXjIg8QLJ1KauEKqiZKS8UdUq6pVBF662ELKDLpEiFOMyxakv7QWQ882kkXIFCfGN8Y/sN64NE6ZYDuZD3yWLpEg1QRe+0couyealMpztK00QYIs6o5aVMpTLmQd7+r2nrokRIiBGmgJm2AMAVR11n8JxGC7NWotjCgIlQvS2E2TRkhIzw+faZBifD3Vwv9qg2l4ut7C5R1qb4/ROme9LsYKB2weicKZ0tYXS5g9trUyRQklSZstlkPPJ7yRQQ6caJc1cC8htqPTx6k3t+oKiJMvV+o6kVlPWoJzXkaD1MrbhTZFGbJdif/DIzz8fBBXPRROqdv4lyD8nX0m7hJRJtC8Y4bTOP0JJtEqPXMSnSUHXAKZVUfLpHeRf3q6f6MotXCVfT6G2w58xS9mwGy1b0hcnWKclBoQ2QnbD3MFDFlHzbN3EVECJtm7sLJBrQUPs2hCHGOr7/RBIoiXNP06vMkopzV+yTQ7KO/heHfO8O/hsHdDPz3MLQjBbXRvSVcD7H2gV+FGyjI7v4ppn/CzqYxPTD0JEbtKPoK9VVs3t0P9Rpj37V4z2p7riUfZ3w9Q11wdrooTmP4epxAgpzUp76u7fDxV3Ft5/SHL5eZdPORg2yqj5ezxQZZdwfNrqdOlFw+6g/4Sg4Jb9+m7lAxNtV+0/fNj4fZC28Ss8vRY2z0v6+IiHE2TzpZ47sx3gVI+DVlLN8bppx2j/IXZrctnv0BXVnNYvDy1R1DtAmwWHzO5gNV0QAtvhOfyz2iN770+dr4kyS7KdtUCW5f3U3RmqG/nyVFyWwT/LCbhS+3fkv4kWiaUqtwm2d0UarwF1usvSj0nOp/5ruDIs9p4cXM30rkU4tS+FTi9kjTKSxxPEV3+ep+8q9P7RLpQ+5JtKuFq9yHNc2WM0+Zy77w/wByyJxOzR9Sl7ndN13PrLLmGvX9uXvKehNRwlVsO8pZEkvvP23K+q80Q3UER/7QT0RERERERERERERERERERERERERER/cH+9EuuaMrq64AAAAASUVORK5CYII=" alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center"><?php echo $usuario->gl_nombres.' '.$usuario->gl_apellidos ?></h3>
                        <p class="text-muted text-center"><?php echo $usuario->gl_email ?></p>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Actividad</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive col-lg-12" data-row="10">
                            <div id="dvGrillaActividad">
                                <?php echo $grilla?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </div>
</section>
