

<?php use_helper('I18N', 'Date') ?>
<?php include_partial('caudales/assets') ?>

<div class="container">
  <h1><?php echo __('Caudales Dique F. Ameghino', array(), 'messages') ?></h1>

  <?php include_partial('caudales/flashes') ?>

  <div class="page_header">
    <?php include_partial('caudales/list_header', array('pager' => $pager)) ?>
  </div>
  <div id="bs_admin_content">
	<div class="row">
	  	<div class="col-lg-4">
        	<div class="container-fluid">
			    <?php include_partial('caudales/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
		  	</div>
        	<div class="container-fluid">
                <div style="text-align:justify; padding: 10px; background-image: linear-gradient( 180deg,#BFD4FE, #E5EFFF); border: 3px solid #4A7EBB; border-radius: 25px;" >
                    <p class="lead align-middle" style="font-size: 1em; font-weight: bold;">
					Desde esta pantalla, podes acceder al listado de datos cargados, filtrando por fecha.<br>
					Al poner el rango de fecha y filtrar, aparecerá un gráfico con la información del nivel del embalse (m) y el caudal emitido por la represa (m3/seg).<br>
					Además se puede agregar un registro individual, haciendo clic en “+agregar registro”<br>
					O podes importar un grupo de registro desde una planilla excell, haciendo clic en “importar”<br>
                    </p>
                </div>
        	    <ul class="bs_admin_actions list-inline">
        	      <?php include_partial('caudales/list_batch_actions', array('helper' => $helper)) ?>
        	      <?php include_partial('caudales/list_actions', array('helper' => $helper)) ?>
        	    </ul>
	    	
		  	</div>
  		</div>
  		<div class="col-lg-8">
			<div class="container-fluid">
			  <div class="bs_admin_list"  style="height: 25em; overflow-y: auto">
              <?php if (!$pager->getNbResults()): ?>
                        <div style="text-align:justify; padding: 10px; background-image: linear-gradient( 180deg,#BFD4FE, #E5EFFF); border: 3px solid #4A7EBB; border-radius: 25px;" >
                            <p class="lead align-middle" style="font-size: 1em;">
                            La siguiente información es aportada por Hidroeléctrica Ameghino S. A. (HASA).<br>
                            El <b>caudal de aporte</b>, es el que alimenta el embalse. La medici&oacute;n se realiza en Los Altares.<br>
                            El <b>caudal vertido</b>, es el caudal que la presa emite sin generar energía eléctrica.<br>
                            El <b>caudal turbinado</b>, es el caudal emitido que pasa por las turbinas para generar energía.
                            La suma de los caudales vertido y turbinado se conoce como <b>caudal emitido</b> por la represa y es el que alimenta el Río Chubut.
                            </p>
							<?php echo image_tag('embalse2',array('style'=>'width:100%'))?>			  
                        </div>
                
              <?php else: ?>
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <?php include_partial('caudales/list_th_tabular', array('sort' => $sort)) ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($pager->getResults() as $Caudal): ?>
                      <tr class="bs_admin_row">
                        <?php include_partial('caudales/list_td_tabular', array('Caudal' => $Caudal)) ?>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              <?php endif; ?>
            </div>
            
            <div>
                  <?php if ($pager->haveToPaginate()): ?>
                          <?php include_partial('caudales/pagination', array('pager' => $pager)) ?>
                        <?php endif; ?>
            
                        <?php echo format_number_choice('[0] |[1] 1 result|(1,+Inf] %1% results', array('%1%' => $pager->getNbResults()), $pager->getNbResults(), 'bs_admin') ?>
                        <?php if ($pager->haveToPaginate()): ?>
                          <?php echo __('(page %%page%%/%%nb_pages%%)', array('%%page%%' => $pager->getPage(), '%%nb_pages%%' => $pager->getLastPage()), 'sf_admin') ?>
                        <?php endif; ?>
            
            </div>
            <script type="text/javascript">
            /* <![CDATA[ */
            function checkAll()
            {
              var boxes = document.getElementsByTagName('input'); for(var index = 0; index < boxes.length; index++) { box = boxes[index]; if (box.type == 'checkbox' && box.className == 'bs_admin_batch_checkbox') box.checked = document.getElementById('bs_admin_list_batch_checkbox').checked } return true;
            }
            /* ]]> */
            </script>
    	  </div>
	  </div>
	</div>
	<?php if ($pager->getNbResults()): ?>
    	<div class="row">
    	
    	  		<div class="col-lg-12">
    				  <div id="chart" style="display:inline-block; height: 300px; width: 100%;"></div>
              </div>
          </div>
      </div>
  <?php endif  ?>
  
  <div class="page_footer">
    <?php include_partial('caudales/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
		<?php include_partial('caudales/chartCaudales',array('nivel_embalse'=>$nivel_embalse, 'caudal_aporte'=>$caudal_aporte, 'caudal'=>$caudal))?>
