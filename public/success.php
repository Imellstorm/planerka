<?

// регистрационная информация (пароль #1)
// registration info (password #1)
$mrh_pass1 = "Qwerty111";

// чтение параметров
// read parameters
$out_summ = $_REQUEST["OutSum"];
$inv_id = $_REQUEST["InvId"];
$crc = $_REQUEST["SignatureValue"];


$crc = strtoupper($crc);

$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass1"));
echo 'Полученный ключ';
var_dump($crc); 
echo '<br>Составленный ключ';
var_dump($my_crc);

// проверка корректности подписи
// check signature
if ($my_crc != $crc)
{
  echo "bad sign\n";
  exit();
}
echo "Операция прошла успешно\n";

?>


