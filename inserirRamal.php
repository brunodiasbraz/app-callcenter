<?php
//


include 'connect.php';

 $rama_sip = $_POST['rama_sip'];
 $senha_ramal_sip = $_POST['senha_ramal_sip'];
 $contexto_ramal_sip = $_POST['contexto_ramal_sip'];
 $dinamic_static_ramal_sip = $_POST['dinamic_static_ramal_sip'];




  $sql = "INSERT INTO sippeers  (name,secret,context,host)
  VALUES ('$rama_sip','$senha_ramal_sip','$contexto_ramal_sip','$dinamic_static_ramal_sip')";
  var_dump( $result = mysqli_query($conexao,$sql));; 


  if ($result==true) {
    //echo "New record created successfully";
    header('Location:../comum.php?cadastro=ok&ramal='.$rama_sip);

  } else {
    //echo "Error: " . $sql . "<br>" . $conn->error;
    header('Location:../comum.php?cadastro=fail&ramal='.$rama_sip);
  }




?>

