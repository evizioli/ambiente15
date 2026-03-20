<?php
class usuario_habilitadoFilter extends sfFilter {
	public function execute($filterChain) {
		$user = $this->getContext()->getUser ();
		if ($user->isAuthenticated ()) {
			$u = UsuarioQuery::create ()->findPk ( $user->getId () );
			if (! $u) {
				$this->getContext()->getInstance()->getLogger()->info('no está el usuario');
				$user->setAuthenticated ( false );
				$this->getContext()->getController ()->redirect ( '@homepage' );
			}
			
			if ($u->getDeshabilitado ()==1) {
				$this->getContext()->getInstance()->getLogger()->info('el usuario está deshabilitado');
				$user->setAuthenticated ( false );
				return $this->getContext()->getController ()->redirect ( '@homepage' );
			}
			/*
			if( !$user->hasCredential('admin')){
				$pasar=false;
				foreach ( explode(',',sfConfig::get('app_ips') ) as $pattern){
					if($pasar= preg_match('/'.$pattern.'/', $_SERVER['REMOTE_ADDR'])) break;
				}
				if (!$pasar ) {
					$this->getContext()->getInstance()->getLogger()->info('ip no permitida:');
					$user->setAuthenticated ( false );
					return $this->getContext()->getController ()->redirect ( '@homepage' );
				}
				
			}
			*/
		}
		
		// Execute next filter
		$filterChain->execute ();
	}
}

