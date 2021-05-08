<?php
require_once("../clases/empleado.php");
require_once("../clases/fabrica.php");
require_once("eliminar.php");

$accion = isset($_POST['accion']) ? $_POST['accion'] : false;

switch ($accion) {
    case "alta":
        $retorno = "Empleado agregado con exito";
    case "modificar":
        $retorno = isset($retorno) ? "Empleado agregado con exito" : "Empleado modificado con exito";

        define("DNI", $_POST["txtDni"]);
        define("APELLIDO", $_POST["txtApellido"]);
        define("NOMBRE", $_POST["txtNombre"]);
        define("SEXO", $_POST["cboSexo"]);

        define("LEGAJO", $_POST["txtLegajo"]);
        define("SUELDO", $_POST["txtSueldo"]);
        define("TURNO", $_POST["rdoTurno"]);

        $tempPath = "./fotos/" . $_FILES["archivo"]["name"];
        $extension = pathinfo($tempPath, PATHINFO_EXTENSION);
        $_FILES["archivo"]["name"] = DNI . "-" . APELLIDO . "." . $extension;
        $fotoPath = "./fotos/" . $_FILES["archivo"]["name"];

        $empleado = new Empleado(NOMBRE, APELLIDO, DNI, SEXO, LEGAJO, SUELDO, TURNO, $fotoPath);
        $fabrica = new Fabrica("Mi Fabrica", 7);

        $fabrica->traerDeBD();

        if ($accion === 'alta') {
            if (!Agregar($fabrica, $empleado)) {
                $retorno = "Error al agregar al empleado";
            }
        }

        if ($accion === 'modificar') {
            if (!Modificar($fabrica, $empleado)) {
                $retorno = "Error al modificar al empleado";
            }
        }

        if(!$fabrica->actualizarBD())
            $retorno = "Error al actualizar la base de datos";

        break;
    default;
        $retorno = "Error de envio de formulario";
}

echo $retorno;

function validarFoto($fotoPath)
{
    $newPath = false;

    $extension = pathinfo($fotoPath, PATHINFO_EXTENSION);
    if ($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "gif" || $extension == "bmp") {

        $newPath = $fotoPath;

        if (!(!(file_exists($newPath)) && getimagesize($_FILES['archivo']['tmp_name']) != false && $_FILES['archivo']['size'] <= 1000000)) {
            $newPath = false;
        }
    }
    return $newPath;
}

function Agregar($fabrica, $empleado)
{
    $ret = false;
    $fotoPath = validarFoto($empleado->getPathFoto());

    if ($fotoPath != false) {
        if ($fabrica->agregarEmpleado($empleado)) {
            //si se agrego bien el empleado, muevo la foto a donde debo
            move_uploaded_file($_FILES['archivo']['tmp_name'], ".".$empleado->getPathFoto());
            $ret = true;
        }
    }
    return $ret;
}

function Modificar($fabrica, $empleado)
{
    $ret = false;
    //recorro la fabrica
    foreach ($fabrica->getEmpleados() as $value) {
        //si se encuentra el empleado a modificar
        if ($value->getDni() == DNI) {
            //Lo elimino (con su foto)
            if (Eliminar($fabrica, $value)) {
                $ret = Agregar($fabrica, $empleado);
                break;
            }
        }
    }
    return $ret;
}
