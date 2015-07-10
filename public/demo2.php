<?
  $mrh_login = "planerka";
  $mrh_pass1 = "Qwerty111";
  $inv_id = 1;
  $inv_desc = "Тест, описание";
  $out_summ = "100";
  $crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1");
  print
  "<html><style>input{width:500px}</style>".
   "<form action='http://test.robokassa.ru/Index.aspx' method=POST>".
   "<input type=text name=MrchLogin value=$mrh_login><br><br>".
   "<input type=text name=OutSum value=$out_summ><br><br>".
   "<input type=text name=InvId value=$inv_id><br><br>".
   "<input type=text name=Desc value='$inv_desc'><br><br>".
   "<input type=text name=SignatureValue value=$crc><br><br>".
   "<input type=submit value='Оплатить'>".
   "</form></html>";
?>