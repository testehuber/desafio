<?php

require 'connection.php';

$connection = new Connection();


/* Incio tratamento de retorno */ 
if(isset($_GET['resposta'])){
    if($_GET['resposta']==='sucesso'){
        echo "<span style='background-color:green'> Ação realizada! </span>";
    }else{
        echo "<span style='background-color:red'> Ops.: Tivemos um problema! </span>";
    }
}
/* fim tratamento de retorno */ 

/* Inicio da sessão usuário */

echo "<fieldset>
    <legend>Usuários</legend>";

echo "<a href='actions_user.php?opt=adicionar'>Adicionar</a>";

echo "<table border='1'>

    <tr>
        <th>ID</th>    
        <th>Nome</th>    
        <th>Email</th>
        <th>Ação</th>    
    </tr>
";

$users = $connection->query("SELECT * FROM users");

foreach($users as $user) {

    echo sprintf("<tr>
                      <td>%s</td>
                      <td>%s</td>
                      <td>%s</td>
                      <td>
                           <a href='actions_user.php?opt=editar&user_id=%s'>Editar</a>
                           <a href='actions_user.php?opt=excluir&user_id=%s'>Excluir</a>
                      </td>
                   </tr>",
        $user->id, $user->name, $user->email, $user->id, $user->id);

}

echo "</table>";

echo "</fieldset>";

/* Fim da sessão usuário */


/* Inicio da sessão cores */

echo "<fieldset>
    <legend>Cores</legend>";

echo "<a href='actions_cores.php?opt=adicionar'>Adicionar</a>";

echo "<table border='1'>

    <tr>
        <th>ID</th>    
        <th>Nome</th>    
        <th>Ação</th>    
    </tr>
";

$colors = $connection->query("SELECT * FROM colors");

foreach($colors as $color) {

    echo sprintf("<tr>
                      <td>%s</td>
                      <td>%s</td>
                      <td>
                        <a href='actions_cores.php?opt=editar&color_id=%s'>Editar</a>
                        <a href='actions_cores.php?opt=excluir&color_id=%s'>Excluir</a>
                      </td>
                   </tr>",
        $color->id, $color->name, $color->id, $color->id,);

}

echo "</table>";

echo "</fieldset>";

/* Fim da sessão cores */


/* Inicio da sessão vículos */

echo "<fieldset>
    <legend>Vínculos</legend>";

echo "<a href='actions_join.php?opt=adicionar'>Adicionar</a>";

echo "<table border='1'>

    <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Cor</th>        
        <th>Ação</th>    
    </tr>
";

$user_colors = $connection->query("SELECT  u.id as user_id,  
                                    u.name as user_name,
                                    c.id as color_id,
                                    c.name as color_name
                                FROM user_colors as uc
                                INNER JOIN users as u ON u.id = uc.user_id
                                INNER JOIN colors as c ON c.id = uc.color_id
                            ");

foreach($user_colors as $user_color) {

    $ids = implode('-',[$user_color->user_id,$user_color->color_id]);
    echo sprintf("<tr>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>
                        <a href='actions_join.php?opt=editar&join_id=%s'>Editar</a>
                        <a href='actions_join.php?opt=excluir&join_id=%s'>Excluir</a>
                    </td>
                   </tr>",
                $ids,$user_color->user_name, $user_color->color_name,$ids,$ids);

}

echo "</table>";

echo "</fieldset>";

/* Fim da sessão cores */