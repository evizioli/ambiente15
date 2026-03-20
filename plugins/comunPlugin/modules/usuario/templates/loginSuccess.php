

<div class="container-fluid text-center">
    <div class="row">
        <div class="col-lg-12">
			<h1 class="h1 mb-3 font-weight-normal"><?php echo ProjectConfiguration::NOMBRE_ENTIDAD ?></h1>
            <div class="account-wall">
                   <h3 class="h3 mb-3 font-weight-normal">Acceso al sistema</h3>
	    
				<?php if ($oForm->hasGlobalErrors()): ?>
				<?php echo $oForm->renderGlobalErrors() ?>
				<?php endif; ?>
				
                <form class="form-signin"  action="<?php echo url_for('usuario/doLogin');?>" method="post">
                	<?php echo $oForm->renderHiddenFields(false) ?>
	                <div class="form-group input-group<?php $oForm['username']->hasError() and print ' errors' ?>">
		                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
		                <input name="login[username]" type="text" class="form-control" placeholder="Usuario" required autofocus>
	                </div>
	                <div class="form-group input-group<?php $oForm['password']->hasError() and print ' errors' ?>">
		                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
		                <input name="login[password]" type="password" class="form-control" placeholder="Contrase&ntilde;a" required>
		    		</div>
	    
	                <button class="btn btn-primary btn-block" type="submit">Ingresar</button>
	                <a href="<?php echo url_for('usuario/reset')?>" class="pull-right need-help">&iquest;Olvid&oacute; la clave? </a><span class="clearfix"></span>
                </form>
            </div>
        </div>
    </div>
</div>

