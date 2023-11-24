<?php
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
        echo "
            <form name='frm_user' action='actions_user.php?opt=adicionar_salvar' method='POST'>
                <input type='text' name='name' maxlength='40' placeholder='Nome' required />
                <input type='text' name='email' maxlength='100' placeholder='E-mail' required />
                <input type='submit' value='Salvar' />
            </form>

            <a href='index.php'> Voltar </a>
        ";
    }

    /*Função para salvar formulário de usuário*/
    function adicionar_salvar(){
        $name = isset($_POST['name'])?$_POST['name']:null;
        $email = isset($_POST['email'])?$_POST['email']:null;

        if($name && $email){
            require 'connection.php';
            $connection = new Connection();
            $qry = $connection->getConnection()->prepare('INSERT INTO users (`name`, `email`) VALUES (?, ?)');
            if($qry->execute(array($name, $email))){
               return header("Location: ./index.php?resposta=sucesso");
            }
        }
        return header("Location: ./index.php?resposta=falha");
    }

    /*Função para gerar formulário de edição para usuário*/
    function editar(){
        require 'connection.php';
        $id = $_GET['user_id'];
        $connection = new Connection();
        $users = $connection->query("SELECT * FROM users where id=?",[$id]);
        $user = $connection->getFirst($users);

        echo "
            <form name='frm_user' action='actions_user.php?opt=editar_salvar' method='POST'>
                <input type='hidden' name='id' value='{$user->id}' />
                <input type='text' name='name' value='{$user->name}' maxlength='40' placeholder='Nome' required />
                <input type='text' name='email' value='{$user->email}' maxlength='100' placeholder='E-mail' required />
                <input type='submit' value='Salvar' />
            </form>

            <a href='index.php'> Voltar </a>
        ";
    }

    /*Função para salvar formulário de usuário*/
    function editar_salvar(){
        $id = isset($_POST['id'])?$_POST['id']:null;
        $name = isset($_POST['name'])?$_POST['name']:null;
        $email = isset($_POST['email'])?$_POST['email']:null;

        if($id && $name && $email){
            require 'connection.php';
            $connection = new Connection();
            $qry = $connection->getConnection()->prepare('UPDATE users SET `name`=?,`email`=? WHERE `id`=?');
            if($qry->execute([$name, $email, $id])){
               return header("Location: ./index.php?resposta=sucesso");
            }
        }
        return header("Location: ./index.php?resposta=falha");
    }

    /*Função para deletar usuário*/
    function excluir(){
        $id = isset($_GET['user_id'])?$_GET['user_id']:null;

        if($id){
            require 'connection.php';
            $connection = new Connection();
            $qry = $connection->getConnection()->prepare('DELETE FROM users WHERE `id`=?');
            if($qry->execute([$id])){
               return header("Location: ./index.php?resposta=sucesso");
            }
        }
        return header("Location: ./index.php?resposta=falha");
    }

?>