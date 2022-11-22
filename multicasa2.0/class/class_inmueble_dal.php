<?php
include('class_inmueble.php');
include("class_Db.php");

class inmueble_dal extends class_Db
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct(); // TODO: Change the autogenerated stub
    }


    function insertar($obj){
		$sql = "insert into inmueble (encabezado,descripcion,direccion,costo_inmueble,recamaras,banos,estacionamientos,estatus,ciudad,estado,codigo_postal,area_terreno,email,latitud,longitud,exterior,interior_1,interior_2) ";
		$sql .= "values(";
        $sql .= "'".$obj->getEncabezado()."',";
    	$sql .= "'".$obj->getDescripcion()."',";
        $sql .= "'".$obj->getDireccion()."',";
        $sql .= "'".$obj->getCosto_inmueble()."',";
        $sql .= "'".$obj->getRecamaras()."',";
        $sql .= "'".$obj->getBaños()."', ";
        $sql .= "'".$obj->getEstacionamientos()."', ";
        $sql .= "'".$obj->getEstatus()."', ";
        $sql .= "'".$obj->getCiudad()."', ";
        $sql .= "'".$obj->getEstado()."', ";
        $sql .= "'".$obj->getCodigo_postal()."', ";
        $sql .= "'".$obj->getArea_terreno()."', ";
        $sql .= "'".$obj->getEmail()."', ";
        $sql .= "'".$obj->getLatitud()."', ";
        $sql .= "'".$obj->getLongitud()."', ";
        $sql .= "'".$obj->getExterior()."', ";
        $sql .= "'".$obj->getInterior_1()."', ";
        $sql .= "'".$obj->getInterior_2()."'";
        $sql .= ")";
		//print $sql;exit;
	   	$this->set_sql($sql);
        $this->db_conn->set_charset("utf8");
    	mysqli_query($this->db_conn,$this->db_query) or die(mysqli_error($this->db_conn));
        if(mysqli_affected_rows($this->db_conn)==1) {
			$insertado=1;
			//print "insertado"."\n";
		}else{
			$insertado=0;
		}
		unset($obj);
 		return $insertado;
  	}

    function eliminar($id_inmueble){
        $sql = "DELETE FROM inmueble WHERE id_inmueble = '$id_inmueble'";
        $this->set_sql($sql);
        $this->db_conn->set_charset("utf8");
        $resultado = mysqli_query($this->db_conn,$this->db_query) or die(mysqli_error($this->db_conn));
        return $resultado;
    }

    function actualizar($id_inmueble, $encabezado, $descripcion, $costo_inmueble, $email, $estatus){
        $sql = "UPDATE inmueble SET encabezado='$encabezado', descripcion='$descripcion', costo_inmueble='$costo_inmueble', email='$email', estatus='$estatus' WHERE id_inmueble = '$id_inmueble'";
        $this->set_sql($sql);
        $this->db_conn->set_charset("utf8");
        $resultado = mysqli_query($this->db_conn,$this->db_query) or die(mysqli_error($this->db_conn));
        //echo $resultado;
        return $resultado;
    }



    //Trae los datos del inmueble, de la tabla 'especiales'
    function get_datos_inmueble($datos,$precio_minimo,$precio_maximo,$recamaras,$baños){
            $sql = ("SELECT * FROM inmueble WHERE estatus='En Venta' AND codigo_postal = '$datos' OR ciudad LIKE '%$datos%' OR estado LIKE '%$datos%' AND costo_inmueble >= '$precio_minimo' AND costo_inmueble <= '$precio_maximo' AND recamaras = '$recamaras' and banos = '$baños'");
            $this->set_sql($sql);
            $rs = mysqli_query($this->db_conn, $this->db_query) or die(mysqli_error($this->db_conn));
            if($rs){
            while($row = mysqli_fetch_assoc($rs)){


            $obj = new inmueble();

            $obj->setEncabezado(utf8_encode($row['encabezado']));
            $obj->setExterior(utf8_encode($row['exterior']));
            $obj->setDescripcion(utf8_encode($row['descripcion']));
            $obj->setEstado(utf8_encode($row['estado']));
            $obj->setCiudad(utf8_encode($row['ciudad']));
            $obj->setCodigo_postal($row['codigo_postal']);
            $obj->setCosto_inmueble($row['costo_inmueble']);
            $obj->setRecamaras($row['recamaras']);
            $obj->setBaños($row['banos']);
            //$arreglo = array();
            $arreglo[] = $obj;
            unset($obj);
            }

            mysqli_free_result($rs);
            return $arreglo;
        }
        else {
            return null;
        } 
    }
}
