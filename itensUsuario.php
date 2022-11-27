<?php
include("sessao.php");
require('conexao.php');
?>

<!DOCTYPE html>
<html>

<head>
    <title>Seus Itens</title>
    <link rel="stylesheet" href="principal.css">
    <ul>
        <li><a href="logout.php">Logout</a></li>
        <li><a href="principal.php">Inicio</a></li>
        <li><a href="cadastroItem.php">Cadastrar</a></li>
        <li><a href="devolverItem.php">Devolver</a></li>
        <li><a href="itensPendentes.php">Pendentes</a></li>
        <li><a href="itensUsuario.php">Seus Itens</a></li>
        <li><a href="infoUsuario.php">Usuario</a></li>
    </ul>
</head>

<body>
    <div class="cadastro">
        <h1>Seus Itens</h1>
        <p>Ola,
            <?php
            $result1 = mysqli_query($con, "SELECT usuario FROM new_table WHERE email= '" . $_SESSION['email'] . "'");
            while ($row = mysqli_fetch_array($result1)) {
                $usuario = $row['usuario'];
            }
            echo $usuario
                ?>! Estes sao seus itens:
        </p>
        <table>
            <tr>
                <th style='border:black; border-width:1px; border-style:solid;'>Item</th>
                <th style='border:black; border-width:1px; border-style:solid;'>Data de Emprestimo</th>
                <th style='border:black; border-width:1px; border-style:solid;'>Data de Devolucao</th>
                <th style='border:black; border-width:1px; border-style:solid;'>Contato</th>
                <th style='border:black; border-width:1px; border-style:solid;'>Status</th>
            </tr>
            <?php
            $query = "SELECT * FROM `new_table2`";
            if ($mysqli_query = mysqli_query($con, $query)) {
                while ($mysqli_row = mysqli_fetch_assoc($mysqli_query)) {
                    if ($mysqli_row['devolvido'] == 1) {
                        $colorClass = 'green';
                        $entregue = 'Entregue';
                    } else if ($mysqli_row['data2'] == null || date('Y-m-d') > $mysqli_row['data2']) {
                        $colorClass = 'red';
                        $entregue = 'Expirado';
                    } else {
                        $colorClass = 'black';
                        $entregue = 'Pendente';
                    }

                    if ($mysqli_row['data2'] == null) {
                        $mysqli_row['data2'] = '-';
                        $styleCenter = 'class=styleCenter';
                    } else {
                        $styleCenter = 'class=styleCenter';
                    }

                    if ($mysqli_row['usuario'] == $usuario) {
                        echo "
			
                            <tr class=" . $colorClass . ">
                                <td class=" . $colorClass . " style='border:gray; border-width:1px; border-style:solid;'>" . $mysqli_row['item'] . "</td>
                                <td style='border:gray; border-width:1px; border-style:solid;'>" . $mysqli_row['data3'] . "</td>
                                <td $styleCenter   style='border:gray; border-width:1px; border-style:solid;'>" . $mysqli_row['data2'] . "</td>
                                <td style='border:gray; border-width:1px; border-style:solid;'>" . $mysqli_row['email'] . "</td>
                                <td style='border:gray; border-width:1px; border-style:solid;'>" . $entregue . "</td>
                            </tr>
                        ";
                    }

                }
            } else {
                die(mysqli_error($con));
            }
            ?>
        </table>
        <p>
            <input class="button" type="submit" value="Devolver Item" onclick="window.location.href='devolverItem.php'">
            <input class="button" type="button" value="Voltar" onclick="window.location.href='principal.php'">
        </p>
    </div>
    <script src="principal.js"></script>
</body>

</html>