<?php 


Class Pessoa {

	private $pdo;

	public function __construct($dbname, $host, $user, $senha)
	{
		try {

			$this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);


		} catch(PDOException $e){

			echo "Erro com o banco de dados" .$e->getMessage();

			exit();

		} catch(Exception $e){

			echo "Erro generico" .$e->getMessage();

			exit();
		}

	}

	public function buscarDados()
	{
		$res = array();
		$select = $this->pdo->query("SELECT * FROM PESSOA ORDER BY nome");
		$res = $select->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}

	public function cadastrarPessoas($nome, $telefone, $email)
	{
		//ANTES DE CADASTRAR VERIFICAR SE JA EXISTE NO BANCO
		$cmd = $this->pdo->prepare("SELECT id FROM PESSOA WHERE email = :email");
		$cmd->bindValue(":email", $email);
		$cmd->execute();
		if($cmd->rowCount() > 0 ) //EMAIL JA EXISTE
		{
			return false;
		}

		else //AINDA NAO FOI CADASTRADA
		{
			$cmd = $this->pdo->prepare("INSERT INTO PESSOA (nome, telefone, email) VALUES (:nome, :telefone, :email)");
			$cmd->bindValue(":nome", $nome);
			$cmd->bindValue(":telefone", $telefone);
			$cmd->bindValue(":email", $email);
			$cmd->execute();
			return true;
		}
	}

	public function excluirPessoa($id)
	{
		$cmd = $this->pdo->prepare("DELETE FROM PESSOA WHERE id = :id");
		$cmd->bindValue(":id", $id);
		$cmd->execute();
	}

	public function buscarDadosPessoa($id)
	{
		$res = array();
		$cmd = $this->pdo->prepare("SELECT * FROM PESSOA WHERE id = :id");
		$cmd->bindValue(":id", $id);
		$cmd->execute();
		$res = $cmd->fetch(PDO::FETCH_ASSOC);
		return $res;
	}

	public function atualizarDados($id, $nome, $telefone, $email)
	{
		$cmd = $this->pdo->prepare("UPDATE PESSOA SET nome = :nome, telefone = :telefone, email = :email WHERE id = :id");
		$cmd->bindValue(":nome", $nome);
		$cmd->bindValue(":telefone", $telefone);
		$cmd->bindValue(":email", $email);
		$cmd->bindValue(":id", $id);
		$cmd->execute();
	}
}