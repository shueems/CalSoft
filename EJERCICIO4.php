<?php

namespace Module\Loginadmin\Repository;

use Config\Conn;
use Module\Loginadmin\Entity\LoginEntity;
use PDO;

class LoginRepository extends Conn {

	/*
		Lista todos los clubs de la base de datos con la cantidad de socios que tiene cada club
	*/
	public function verifyLoginIn(LoginEntity $loginIn){
		$sha1_pass = sha1($loginIn->get_passsword());
		$sql = "SELECT u.CODUSUARIOADMIN,
				      u.NOMBRE,
				      u.CORREO,
				      u.PERMISO,
				      u.CLAVE,
				      u.FOTOURL,
				      u.FECHAINICIO,
				      u.FECHAFIN
				FROM usuarioadmin u
				WHERE CORREO = '{$loginIn->get_email()}' AND CLAVE = '{$sha1_pass}'
				AND IFNULL(u.FECHAFIN,CURDATE())>=CURDATE()"; //validar si no se le ha vencido el acceso

		$resource = $this->_conn->prepare($sql);
		$resource->execute();
		//$resource es de tipo PDO
		// $row es un array
		$row = $resource->fetchAll(PDO::FETCH_ASSOC);
		if(count($row) == 1){
			session_start();
			foreach ($row as $key => $fila)
			$_SESSION['nombre'] = $fila['NOMBRE'];
			$_SESSION['correo'] = $fila['CORREO'];
			$_SESSION['permiso'] = $fila['PERMISO'];
			$_SESSION['clave'] = $fila['CLAVE'];
			return true;
		}else{
			return false;
		}
//		$_SESSION['usu_nombre'] = $row['nombre'];

	}

	public function getAll(){
		$sql = "SELECT c.clubid, c.nit, c.name, c.address, c.phone, ";
		$sql .= "(SELECT COUNT(partnerid) FROM partner WHERE clubid = c.clubid) as cantidadhijos ";
		$sql .= "FROM club c ";
		$sql .= "ORDER BY c.clubid DESC";
//        echo $sql;
//        exit();
		// Todo lo que le solicitemos a PHP es un recurso (ya sea de tipo PDO, ORACLE;
		// $this-> me permite acceder a los metodos y/o propiedades.
		$resource = $this->_conn->prepare($sql);
		$resource->execute();
		//$resource es de tipo PDO
		// $rows es un array
		$rows = $resource->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	/*
		Inserta un nuevo club a la base de datos
	*/
	public function add(LoginEntity $club){
		$sql = "INSERT INTO club(nit, name, address, phone) ";
		$sql .= "VALUES (?,?,?,?)";

		// bindParam ->
		$nit = $club->get_nit();
		$name = $club->get_name();
		$address = $club->get_address();
		$phone = $club->get_phone();
		$resource = $this->_conn->prepare($sql);
		$resource->bindParam(1, $nit);
		$resource->bindParam(2, $name);
		$resource->bindParam(3, $address);
		$resource->bindParam(4, $phone);
		$resource->execute();
		//echo '<pre>';
		//$resource->debugDumpParams();
		//echo '</pre>';
		return $resource;
	}

	/*
		Obtiene el ID Y NOMBRE del club y lo retorna en forma de un array asociativo
	*/
	public function getAssoc(){
		$sql = "SELECT c.clubid, c.name ";
		$sql .= "FROM club c ";
		$sql .= "ORDER BY c.clubid ASC";
		$resource = $this->_conn->prepare($sql);
		$resource->execute();
		$rows = $resource->fetchAll(PDO::FETCH_ASSOC);
		$arreglo = [];
		foreach ($rows as $index => $column) {
			$arreglo[$column['clubid']] = $column["name"];
		}
		return $arreglo;
	}

	/*
		Elimina un club seleccionado
	*/
	public function delete(LoginEntity $deleteClub){
		$sql = "DELETE FROM club ";
		$sql .= "WHERE clubid = ?";
		$deleteCod = $deleteClub->get_id();
		$resource = $this->_conn->prepare($sql);

		$resource->bindParam(1, $deleteCod);
		$resource->execute();
		return $resource;
	}

	/*
		Cuenta cuantos socios tiene un club en especifico
	*/
	public function getChildren(LoginEntity $deleteClub){
		$sql = "SELECT (SELECT COUNT(partnerid) FROM partner WHERE clubid = c.clubid) as cantidadhijos ";
		$sql .= "FROM club c ";
		$sql .= "WHERE c.clubid = ?";

		$clubId = $deleteClub->get_id();
		$resource = $this->_conn->prepare($sql);
		$resource->bindParam(1, $clubId);

		$resource->execute();
		$row = $resource->fetchAll(PDO::FETCH_ASSOC);
		return $row[0];
	}

	/*
		Obtiene un club seleccionado
	*/
	public function getOne(LoginEntity $club){
		$sql = "SELECT c.clubid, c.nit, c.name, c.address, c.phone ";
		$sql .= "FROM club c ";
		$sql .= "WHERE c.clubid = ?";
		$clubId = $club->get_id();

		$resource = $this->_conn->prepare($sql);

		$resource->bindParam(1, $clubId);
		$resource->execute();
		$row = $resource->fetchAll(PDO::FETCH_ASSOC);
		if(empty($row)){
			return NULL;
		}
		return $row[0];
	}

}
