<!DOCTYPE html>
<html>

<head>
    <meta charset="utf 8" />
    <script src="./javascript/funciones.js" ></script>
    <title>HTML5 -  Formulario Login</title>
</head>

<body>
    <h2>Login</h2>
    <form id="form"  action="./backend/verificarUsuario.php" method="POST">
        <table align="center">

            <!--LOGIN-->
            <div>
                <tr>
                    <td colspan="2">
                        <h4>Datos personales</h4>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td>DNI:</td>
                    <td>
                        <input type="number" name="txtDni" id="txtDni" min="1000000" max="55000000" />
                    </td>
                    <td>
                        <span id="spanDni" style="display:none">*</span>
                    </td>
                </tr>
                <tr>
                    <td>Apellido:</td>
                    <td>
                        <input type="text" name="txtApellido" id="txtApellido" />
                    </td>
                    <td>
                        <span id="spanApellido" style="display:none">*</span>
                    </td>
                </tr>
            </div>
            <!--TERMINA DATOS PERSONALES-->

            <!--SUBMIT-LIMPIAR-->
            <div>
                <tr>
                    <td colspan="2"><hr/></td>
                </tr>
                <tr>
                    <td colspan="2" align="right">
                        <input type="reset" value="Limpiar" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="right">
                        <input type="button" id="btnEnviar" value="Enviar" onclick="AdministrarValidacionesLogin()"/>
                    </td>
                </tr>
            </div>
            <!--TERMINA SUBMIT-LIMPIAR-->
        </table>
    </form>
</body>

</html>