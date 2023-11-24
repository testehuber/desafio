<?php
    require 'connection.php';

    //Escolhendo opções do CRUD
    switch($_GET['opt']){
        case 'adicionar':
            adicionar();
            break;
        case 'adicionar_salvar':
            adicionar_salvar();
            break;
        case 'editar':
            editar();
            break;
        case 'editar_salvar':
            editar_salvar();
            break;
        case 'excluir':
            excluir();
            break;
    }

    /*Função para gerar formulário de adição para usuário*/
    function adicionar(){

        $connection = new Connection();
        $users = $connection->query("SELECT * FROM users");
        $colors = $connection->query("SELECT * FROM colors");

        echo "<form name='frm_user' action='actions_join.php?opt=adicionar_salvar' method='POST'>";
              
        //Monto combox para users
        echo"<select name='user_id'>";
        $selected='selected';
        foreach($users as $user){
            echo "<option value='{$user->id}' {$selected}>$user->name</option>";
            $selected='';
        }
        echo"</select>";

        //Monto combox para cores
        echo"<select name='color_id'>";
        $selected='selected';
        foreach($colors as $color){
            echo "<option value='{$color->id}' {$selected}>$color->name</option>";
            $selected='';
        }
        echo"</select>";

        echo"<input type='submit' value='Salvar' />
            </form>

            <a href='index.php'> Voltar </a>
        ";
    }

    /*Função para salvar formulário de usuário*/
    function adicionar_salvar(){
        $user_id = isset($_POST['user_id'])?$_POST['user_id']:null;
        $color_id = isset($_POST['color_id'])?$_POST['color_id']:null;

        if($user_id && $color_id){
            $connection = new Connection();
            $qry = $connection->getConnection()->prepare('INSERT INTO user_colors (`user_id`, `color_id`) VALUES (?, ?)');
            if($qry->execute(array($user_id, $color_id))){
               return header("Location: ./index.php?resposta=sucesso");
            }
        }
        return header("Location: ./index.php?resposta=falha");
    }

    /*Função para gerar formulário de edição para usuário*/
    function editar(){
        $idsConcat=$_GET['join_id'];
        $id = explode('-',$idsConcat);
        

        $connection = new Connection();
        $users = $connection->query("SELECT * FROM user_colors where user_id=? and color_id=?",$id);
        $user = $connection->getFirst($users);

        $users = $connection->query("SELECT * FROM users");
        $colors = $connection->query("SELECT * FROM colors");

        echo "<form name='frm_user' action='actions_join.php?opt=editar_salvar' method='POST'>";
              
        echo "<input type='hidden' name='ids' value='{$idsConcat}' />";

        //Monto combox para users
        echo"<select name='user_id'>";
        foreach($users as $user){
            $selected='';
            if($user->id == $id[0]){
                $selected='selected';
            }
            echo "<option value='{$user->id}' {$selected}>$user->name</option>";
        }
        echo"</select>";

        //Monto combox para cores
        echo"<select name='color_id'>";
        $selected='selected';
        foreach($colors as $color){
            $selected='';
            if($color->id == $id[1]){
                $selected='selected';
            }
            echo "<option value='{$color->id}' {$selected}>$color->name</option>";
            $selected='';
        }
        echo"</select>";

        echo"<input type='submit' value='Salvar' />
            </form>

            <a href='index.php'> Voltar </a>
        ";
    }

    /*Função para salvar formulário de usuário*/
    function editar_salvar(){
        $ids = isset($_POST['ids'])?explode('-',$_POST['ids']):null;
        $user_id = isset($_POST['user_id'])?$_POST['user_id']:null;
        $color_id = isset($_POST['color_id'])?$_POST['color_id']:null;

        if($user_id && $color_id){
            $connection = new Connection();
            $qry = $connection->getConnection()->prepare('UPDATE user_colors SET `user_id`=?,`color_id`=? WHERE `user_id`=? and `color_id`=? ');

            if($qry->execute(array_merge([$user_id, $color_id],$ids))){
               return header("Location: ./index.php?resposta=sucesso");
            }
        }
        return header("Location: ./index.php?resposta=falha");
    }

    /*Função para deletar usuário*/
    function excluir(){
        $ids = isset($_GET['join_id'])?explode('-',$_GET['join_id']):null;

        if($ids){
            $connection = new Connection();
            $qry = $connection->getConnection()->prepare('DELETE FROM user_colors WHERE `user_id`=? and `color_id`=? ');
            if($qry->execute($ids)){
               return header("Location: ./index.php?resposta=sucesso");
            }
        }
        return header("Location: ./index.php?resposta=falha");
    }

?>