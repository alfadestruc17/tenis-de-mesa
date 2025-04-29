<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Fogueo Tenis de Mesa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <h1 class="mb-4 text-center"> Registro de Fogueo Tenis de Mesa (SENA)</h1>

        <div class="card mb-5">
            <div class="card-header bg-primary text-white">
                Nuevo Partido
            </div>
            <div class="card-body">
                <form method="post" action="index.php?action=store" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Jugador 1</label>
                        <input type="text" name="jugador1" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jugador 2</label>
                        <input type="text" name="jugador2" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Resultado (Sets)</label>
                        <select name="resultado" class="form-select" required>
                            <option value="">Seleccione...</option>
                            <option value="2-0">2-0</option>
                            <option value="2-1">2-1</option>
                            <option value="1-2">1-2</option>
                            <option value="0-2">0-2</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-success" type="submit">Registrar Partido</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-secondary text-white">
                Partidos Registrados
            </div>
            <div class="card-body">
                <?php if ($partidos->rowCount() == 0): ?>
                    <p>No hay partidos registrados aún.</p>
                <?php else: ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Jugador 1</th>
                                <th>Jugador 2</th>
                                <th>Resultado</th>
                                <th>Ganador</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($p = $partidos->fetch(PDO::FETCH_ASSOC)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($p['fecha']) ?></td>
                                    <td><?= htmlspecialchars($p['jugador1']) ?></td>
                                    <td><?= htmlspecialchars($p['jugador2']) ?></td>
                                    <td><?= htmlspecialchars($p['resultado']) ?></td>
                                    <td><strong><?= htmlspecialchars($p['ganador']) ?></strong></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
            <div class="card mt-5">
                <div class="card-header bg-success text-white">
                    Tabla de Puntajes
                </div>
                <div class="card-body">
                    <?php if (empty($leaderboard)): ?>
                        <p>No hay datos suficientes para mostrar el leaderboard.</p>
                    <?php else: ?>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Jugador</th>
                                    <th>Puntos</th>
                                    <th>Partidos Jugados</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($leaderboard as $jugador => $data): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($jugador) ?></td>
                                        <td><?= $data['puntos'] ?></td>
                                        <td><?= $data['jugados'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>