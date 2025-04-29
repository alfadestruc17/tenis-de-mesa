<?php
require_once 'models/partido.php';

class PartidoController {
    private $db;
    private $partidoModel;

    public function __construct($db) {
        $this->db = $db;
        $this->partidoModel = new Partido($db);
    }

    public function index() {
        $partidos = $this->partidoModel->obtenerPartidos();
        $leaderboard = $this->calcularLeaderboard();
        include 'views/index.php';
    }
    

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jugador1 = $_POST['jugador1'];
            $jugador2 = $_POST['jugador2'];
            $fecha = $_POST['fecha'];
            $resultado = $_POST['resultado'];

            if ($resultado == '2-0' || $resultado == '2-1') {
                $ganador = $jugador1;
            } else {
                $ganador = $jugador2;
            }

            $this->partidoModel->jugador1 = $jugador1;
            $this->partidoModel->jugador2 = $jugador2;
            $this->partidoModel->fecha = $fecha;
            $this->partidoModel->resultado = $resultado;
            $this->partidoModel->ganador = $ganador;

            $this->partidoModel->crear();
        }

        header("Location: index.php");
    }
    private function calcularLeaderboard() {
        $partidos = $this->partidoModel->obtenerPartidos();
        $puntajes = [];
    
        while ($p = $partidos->fetch(PDO::FETCH_ASSOC)) {
            $jugador1 = $p['jugador1'];
            $jugador2 = $p['jugador2'];
            $resultado = $p['resultado'];
            $ganador = $p['ganador'];
    
            // Inicializar si no existe
            if (!isset($puntajes[$jugador1])) {
                $puntajes[$jugador1] = ['puntos' => 0, 'jugados' => 0];
            }
            if (!isset($puntajes[$jugador2])) {
                $puntajes[$jugador2] = ['puntos' => 0, 'jugados' => 0];
            }
    
            // Aumentar partidos jugados
            $puntajes[$jugador1]['jugados']++;
            $puntajes[$jugador2]['jugados']++;
    
            // Asignar puntos solo al ganador
            if ($ganador == $jugador1) {
                if ($resultado == '2-0') {
                    $puntajes[$jugador1]['puntos'] += 2;
                } elseif ($resultado == '2-1') {
                    $puntajes[$jugador1]['puntos'] += 1;
                }
            } elseif ($ganador == $jugador2) {
                if ($resultado == '0-2') {
                    $puntajes[$jugador2]['puntos'] += 2;
                } elseif ($resultado == '1-2') {
                    $puntajes[$jugador2]['puntos'] += 1;
                }
            }
        }
    
        // Ordenar primero por puntos descendentes
        uasort($puntajes, function ($a, $b) {
            return $b['puntos'] <=> $a['puntos'];
        });
    
        return $puntajes;
    }
    
}
