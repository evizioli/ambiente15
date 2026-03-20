<?php

class comunUser extends sfBasicSecurityUser
{

	protected $ns = 'comunPlugin';
	public function iniciarSesion ( Usuario $usuario )
	{
		$this->setAttribute('usuario_id', $usuario->getId(), $this->ns);
		$this->setAttribute('nombre', $usuario->getNombre(), $this->ns);
		
		$locs = array();
		$tipos = array();
		
		if($usuario->getAdmin()==1) $this->addCredential('admin');
		
		$c=array();
		 
		$d= $usuario->getUsuarioGruposJoinGrupo();
		foreach( $d as $aux ) {
			 
		    foreach ($aux->getGrupo()->getGrupoLocalidads() as $gl) $locs[]=$gl->getLocalidadId();
		    foreach ($aux->getGrupo()->getGrupoTipos() as $gt) $tipos[]=$gt->getTipoId();
			 
			$aux2 = $aux->getGrupo()->getCredencialGruposJoinCredencial();
			 
			foreach($aux2 as $cg) $c[]= $cg->getCredencial()->getNombre();
		}
		$this->setAttribute('localidades', $locs, $this->ns);
		$this->setAttribute('tipos', $tipos, $this->ns);

		$d= $usuario->getCredencialUsuariosJoinCredencial();
		foreach( $d as $aux ) $c[]= $aux->getCredencial()->getNombre();

		foreach(array_unique($c) as $aux) $this->addCredential( $aux);
		 
		$this->setAuthenticated(true);
		/*
		$i = new Ingreso();
		$i->setUsuarioId($usuario->getId());
		$i->setFechaHora(time());
		$i->setIp($_SERVER['REMOTE_ADDR']);
		$i->save();
		*/
		return true;
	}

	public function getId()
	{
		return $this->getAttribute('usuario_id', null, $this->ns);
	}
	
	public function getNombre ()
	{
		return $this->getAttribute('nombre', null, $this->ns);
	}

	public function setClave($clave)
	{
		UsuarioQuery::create()->findPk($this->getId())->setClave(md5($clave))->save();
	}

	public function getLocalidades()
	{
	    return $this->getAttribute('localidades', array(), $this->ns);
	}
	
	public function esMunicipio()
	{
	    return count($this->getLocalidades())>0;
	}
	
	
	public function getTipos()
	{
	    return $this->getAttribute('tipos', array(), $this->ns);
	}
	
}
