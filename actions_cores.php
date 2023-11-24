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

    /*Função para gerar formulário de adição para cor*/
    function adicionar(){
        echo "
            <form name='frm_user' action='actions_cores.php?opt=adicionar_salvar' method='POST'>
                <input type='text' name='name' maxlength='40' placeholder='Nome' required />
                <input type='submit' value='Salvar' />
            </form>

            <a href='index.php'> Voltar </a>
        ";
    }

    /*Função para salvar formulário de cor*/
    function adicionar_salvar(){
        $name = isset($_POST['name'])?$_POST['name']:null;

        if($name){
            require 'connection.php';
            $connection = new Connection();
            $qry = $connection->getConnection()->prepare('INSERT INTO colors (`name`) VALUES (?)');
            if($qry->execute(array($name))){
               return header("Location: ./index.php?resposta=sucesso");
            }
        }
        return header("Location: ./index.php?resposta=falha");
    }

    /*Função para gerar formulário de edição para cor*/
    function editar(){
        require 'connection.php';
        $id = $_GET['color_id'];
        $connection = new Connection();
        $colors = $connection->query("SELECT * FROM colors where id=?",[$id]);
        $color = $connection->getFirst($colors);

        echo "
            <form name='frm_user' action='actions_cores.php?opt=editar_salvar' method='POST'>
                <input type='hidden' name='id' value='{$color->id}' />
                <input type='text' name='name' value='{$color->name}' maxlength='40' placeholder='Nome' required />
                <input type='submit' value='Salvar' />
            </form>

            <a href='index.php'> Voltar </a>
        ";
    }

    /*Função para salvar formulário de cor*/
    function editar_salvar(){
        $id = isset($_POST['id'])?$_POST['id']:null;
        $name = isset($_POST['name'])?$_POST['name']:null;

        if($id && $name){
            require 'connection.php';
            $connection = new Connection();
            $qry = $connection->getConnection()->prepare('UPDATE colors SET `name`=? WHERE `id`=?');
            if($qry->execute([$name, $id])){
               return header("Location: ./index.php?resposta=sucesso");
            }
        }
        return header("Location: ./index.php?resposta=falha");
    }

    /*Função para deletar cor*/
    function excluir(){
        $id = isset($_GET['color_id'])?$_GET['color_id']:null;

        if($id){
            require 'connection.php';
            $connection = new Connection();
            $qry = $connection->getConnection()->prepare('DELETE FROM colors WHERE `id`=?');
            if($qry->execute([$id])){
               return header("Location: ./index.php?resposta=sucesso");
            }
        }
        return header("Location: ./index.php?resposta=falha");
    }

?>