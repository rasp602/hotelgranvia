<?php
class Alumno
{
    private $pdo;

    public $idUsuario;
    public $Rut;
    public $Nombre;
    public $Apellido;
    public $Fechacrea;
    public $Genero;

    public $id_user;
    public $Email;
    public $Password;
    public $Nivel;
    public $Usuario;

    public function __CONSTRUCT()
    {
        try {
            $this->pdo = Database::Conectar();
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Listar()
    {
        try {
            $sql = "SELECT 
                        u.id_user,
                        u.email,
                        u.password,
                        u.nivel,
                        u.idUsuario,
                        u.usuario,
                        t.rut,
                        t.nombre,
                        t.apellido,
                        t.fechacrea,
                        t.genero
                    FROM usuario u
                    INNER JOIN tblusuario t ON t.idUsuario = u.idUsuario
                    ORDER BY t.idUsuario DESC";

            $stm = $this->pdo->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Obtener($idUsuario)
    {
        try {
            $sql = "SELECT 
                        u.id_user,
                        u.email,
                        u.password,
                        u.nivel,
                        u.idUsuario,
                        u.usuario,
                        t.rut,
                        t.nombre,
                        t.apellido,
                        t.fechacrea,
                        t.genero
                    FROM usuario u
                    INNER JOIN tblusuario t ON t.idUsuario = u.idUsuario
                    WHERE t.idUsuario = ?";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([$idUsuario]);

            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Registrar(Alumno $data)
    {
        try {
            $this->pdo->beginTransaction();

            $sqlTbl = "INSERT INTO tblusuario (rut, nombre, apellido, fechacrea, genero)
                       VALUES (?, ?, ?, ?, ?)";

            $stmTbl = $this->pdo->prepare($sqlTbl);
            $stmTbl->execute([
                $data->Rut,
                $data->Nombre,
                $data->Apellido,
                $data->Fechacrea,
                $data->Genero
            ]);

            $idUsuario = $this->pdo->lastInsertId();

            $passwordHash = md5($data->Password);

            $sqlUsu = "INSERT INTO usuario (email, password, nivel, idUsuario, usuario)
                       VALUES (?, ?, ?, ?, ?)";

            $stmUsu = $this->pdo->prepare($sqlUsu);
            $stmUsu->execute([
                $data->Email,
                $passwordHash,
                $data->Nivel,
                $idUsuario,
                $data->Usuario
            ]);

            $this->pdo->commit();
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            die($e->getMessage());
        }
    }

    public function Actualizar($data)
    {
        try {
            $this->pdo->beginTransaction();

            $sqlTbl = "UPDATE tblusuario
                       SET rut = ?, nombre = ?, apellido = ?, fechacrea = ?, genero = ?
                       WHERE idUsuario = ?";

            $stmTbl = $this->pdo->prepare($sqlTbl);
            $stmTbl->execute([
                $data->Rut,
                $data->Nombre,
                $data->Apellido,
                $data->Fechacrea,
                $data->Genero,
                $data->idUsuario
            ]);

            if (!empty($data->Password)) {
                $sqlUsu = "UPDATE usuario
                           SET email = ?, password = ?, nivel = ?, usuario = ?
                           WHERE idUsuario = ?";

                $stmUsu = $this->pdo->prepare($sqlUsu);
                $stmUsu->execute([
                    $data->Email,
                    md5($data->Password),
                    $data->Nivel,
                    $data->Usuario,
                    $data->idUsuario
                ]);
            } else {
                $sqlUsu = "UPDATE usuario
                           SET email = ?, nivel = ?, usuario = ?
                           WHERE idUsuario = ?";

                $stmUsu = $this->pdo->prepare($sqlUsu);
                $stmUsu->execute([
                    $data->Email,
                    $data->Nivel,
                    $data->Usuario,
                    $data->idUsuario
                ]);
            }

            $this->pdo->commit();
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            die($e->getMessage());
        }
    }

    public function Eliminar($idUsuario)
    {
        try {
            $this->pdo->beginTransaction();

            $stm1 = $this->pdo->prepare("DELETE FROM usuario WHERE idUsuario = ?");
            $stm1->execute([$idUsuario]);

            $stm2 = $this->pdo->prepare("DELETE FROM tblusuario WHERE idUsuario = ?");
            $stm2->execute([$idUsuario]);

            $this->pdo->commit();
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            die($e->getMessage());
        }
    }

    public function validarUsuario($Email, $Password)
    {
        try {
            $sql = "SELECT * 
                    FROM usuario 
                    WHERE email = ? AND password = ? 
                    LIMIT 1";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([$Email, md5($Password)]);

            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function validarNivel($Email)
    {
        try {
            $sql = "SELECT nivel 
                    FROM usuario 
                    WHERE email = ? 
                    LIMIT 1";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([$Email]);

            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}