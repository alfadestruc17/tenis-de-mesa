<?php
class Partido {
    private $conn;
    private $table = 'partidos';

    public $id;
    public $jugador1;
    public $jugador2;
    public $fecha;
    public $resultado;
    public $ganador;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crear() {
        $query = "INSERT INTO " . $this->table . "
                  SET jugador1=:jugador1, jugador2=:jugador2, fecha=:fecha, resultado=:resultado, ganador=:ganador";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":jugador1", $this->jugador1);
        $stmt->bindParam(":jugador2", $this->jugador2);
        $stmt->bindParam(":fecha", $this->fecha);
        $stmt->bindParam(":resultado", $this->resultado);
        $stmt->bindParam(":ganador", $this->ganador);

        return $stmt->execute();
    }

    public function obtenerPartidos() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY fecha DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
