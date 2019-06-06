<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "challenge_bpo";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "select   u.id as id_usuario, u.nombre, h.id id_horario, h.hora
from usuario u, horario h where  h.id not in (11,12,1,2,22,23,24,25)
order by id_usuario asc";
$horario_usado = "select u.id id_usuario, uh.id_hora_inicio id_horario from usuario_horario uh, usuario u where uh.usuario_id = u.id";
$result = $conn->query($sql);
$result_horario_usado = $conn->query($horario_usado);

$array = array();
$array_horarios = array();
$final_array = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) { //102
        $array_horarios[] = $row;
    }
    while ($row2 = $result_horario_usado->fetch_assoc()) {//23
        $array[] = $row2;
    }
} else {
    echo "no data";
}


$bandera = 0;
$total = 1;
foreach ($array_horarios as $k => $v) {
    foreach ($array as $e => $f) {
        if ($array_horarios[$k]['id_usuario'] == $array[$e]['id_usuario']) {
            if ($array_horarios[$k]['id_horario'] == $array[$e]['id_horario']) {
                $bandera = 1;
                $array[$e]['id_horario'] = 0;
            }
        }
    }
    if ($bandera == 0) {//salio
        $final_array[] = $array_horarios[$k];
    } else {
    }
    $bandera = 0;
}
$horario = "select * from horario";
$res_horario = $conn->query($horario);
$array_cast = array();
$cont_final = 1;
while ($row = $res_horario->fetch_assoc()) {
    $arr_temp = array();
    $cont_horario_mayor = 0;
    foreach ($final_array as $k => $val) {
        if ($row['id'] == $final_array[$k]['id_horario']) {
            $arr_temp[] = $final_array[$k];
            $cont_horario_mayor++;
        }
    }
    $array_cast[$cont_final] = array('total_datos' => $cont_horario_mayor, 'horario' => $row['hora'], 'datos' => $arr_temp);
    $cont_final++;
}
$conn->close();
header('Content-type: application/json');
echo json_encode($array_cast);
?>