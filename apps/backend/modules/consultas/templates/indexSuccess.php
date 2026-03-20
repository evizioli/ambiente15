<div class="container">
	<div class="row">
    	<div class="col-lg-8 col-lg-offset-2">
        	<div style="text-align:justify; margin-top: 40px; padding: 40px; background-image: linear-gradient( 180deg,#E3FBC2, #F4FFE6);  border-radius: 50px; border: 2px solid #98B855">
        		
        		<p class="lead align-middle" style="padding-bottom: 10px">
        			Este Sistema
        			Provincial de Informaci&oacute;n Ambiental (SPIA) se arma con el objetivo de
        			tener toda la informaci&oacute;n ambiental que genera el Ministerio de
        			Ambiente y Control de Desarrollo Sustentable en un solo lugar para
        			poder ser aprovechada y utilizada para la toma de decisiones
        			pol&iacute;ticas de gesti&oacute;n y control en la provincia.
        		</p>
        		<div style="font-size: large;">
            		<?php if( $sf_user->hasCredential('muestras')):?>
                		<span style="font-weight: bold; font-size: large;">Para acceder a la informaci&oacute;n puede hacerlo desde las opciones:</span>
                		<ul>
                			<li><?php echo link_to('MUESTRAS','@muestra')?>: acceso a la tabla con datos cargados. </li>
                			<li>REPORTES: acceso a la información bacteriológica graficada en función de la localidad o de la fecha</li>
                		</ul>
                	<?php else:?>
                		<b>Para acceder a la informaci&oacute;n puede hacerlo desde la opci&oacute;n de REPORTES</b>
                	<?php endif?>


            		<span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>
            		Si tiene dudas, le dejamos el <?php echo link_to('Manual del usuario','consultas/tutorial', array('title'=>'Ver tutorial','target'=>'_blank'))?> a disposici&oacute;n


        		</div>
            	
        	</div>
    	</div>
    </div>
</div>