<?php 
require_once 'classe-pessoa.php';
$p = new Pessoa("CRUDPDO", "localhost", "allan", "allanpsg10");

?>

<!DOCTYPE html>
<html>
<head>
	<title>Cadastro Pessoa</title>
	<link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>

	<?php 
	if(isset($_POST['nome']))//clicou NO BOTAO CADASTRAR OU EDITAR
	{
		if(isset($_GET['id_up']) && !empty($_GET['id_up']))
		{

		}
		else
		{
			$nome = addslashes($_POST['nome']);
			$telefone = addslashes($_POST['telefone']);
			$email = addslashes($_POST['email']);
			if(!empty($nome) && !empty($telefone) && !empty($email)) {
				$p->cadastrarPessoas($nome, $telefone, $email);
			}
			else {
				echo "Preencha todos os campos";
			}
		}	

	}		
	?>

	<?php 

	if(isset($_GET['id_up']))
	{
			$id_update = addslashes($_GET['id_up']); //VERIFICA SE A PESSOA CLICOU EM EDITAR
			$res = $p->buscarDadosPessoa($id_update);
		}
		?>

		<section id="esquerda">
			<form method="POST">
				<h2>CADASTRAR PESSOA</h2>
				<label for="nome">Nome</label>
				<input type="text" name="nome" id="nome" 
				value="<?php if(isset($res)){echo $res['nome'];} ?>">

				<label for="telefone">Telefone</label>
				<input type="text" name="telefone" id="telefone" 
				value="<?php if(isset($res)){echo $res['telefone'];} ?>">

				<label for="email">E-mail</label>
				<input type="text" name="email" id="email" 
				value="<?php if(isset($res)){echo $res['email'];}?>">


				<input type="submit"
				value=" <?php if(isset($res)){echo "Atualizar";} else {echo "Cadastrar";}?>" >
			</form>
		</section>

		<section id="direita">
			<table>
				<tr id="titulo">
					<td>NOME</td>
					<td>TELEFONE</td>
					<td colspan="2">E-MAIL</td>
				</tr>

				<?php 

				$dados = $p->buscarDados();
				if(count($dados) > 0 ) {
					for ($i=0; $i < count($dados); $i++) { 
						echo "<tr>";
						foreach ($dados[$i] as $k => $v) {
							if($k != "id"){
								echo "<td>".$v."</td>";
							}
						}
						?> 
						<td> 

							<a href="index.php?id_up=<?php echo $dados[$i]['id'];?>">Editar</a> 
							<a href="index.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a> 
						</td>

						<?php
						echo "</tr>";
					}

			} else { //O BANCO ESTA VAZIO
				echo "Ainda nao há pessoas cadastradas";
			}
			?>
			
			
		</table>
	</section>
</body>
</html>

<?php 

if(isset($_GET['id']))
{
	$id_pessoa = addslashes($_GET['id']);
	$p->excluirPessoa($id_pessoa);
	header("location: index.php");
}
?>