<?php
// Controlli e calcoli (circa 10 righe)
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = htmlspecialchars($_POST['nome'] ?? '');
    $peso = $_POST['peso'] ?? 0;
    $altezza_cm = $_POST['altezza'] ?? 0;

    $altezza_m = $altezza_cm / 100;
    $bmi = $peso / ($altezza_m * $altezza_m);
    $bmi_formatted = number_format($bmi, 1);

    if ($bmi < 18.5) $categoria = "Sottopeso";
    elseif ($bmi < 24.9) $categoria = "Normopeso";
    elseif ($bmi < 29.9) $categoria = "Sovrappeso";
    else $categoria = "Obesità";
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcolatore BMI</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: sans-serif; color: #1F2328; }
        body { background: #F1F3F5; min-height: 100vh; display: flex; justify-content: center; align-items: center; padding: 16px; }
        .main-container { width: 100%; max-width: 400px; display: flex; flex-direction: column; align-items: center; }
        h1 { margin-bottom: 24px; font-size: 1.8rem; text-align: center; }
        .card { background: #FFF; border-radius: 12px; padding: 24px; width: 100%; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .form-group { display: flex; flex-direction: column; margin-bottom: 16px; }
        .form-group:last-of-type { margin-bottom: 24px; }
        .form-group label { margin-bottom: 6px; font-weight: 600; }
        .form-group input { padding: 10px 12px; border: 1px solid #D0D7DE; border-radius: 6px; font-size: 1rem; }
        .btn-submit { width: 100%; background: #1F2328; color: #FFF; border: none; border-radius: 8px; padding: 12px; font-weight: bold; cursor: pointer; }
        .btn-submit:hover { background: #32383E; }
    </style>
</head>
<body>
    <main class="main-container">
        <?php if ($_SERVER["REQUEST_METHOD"] == "GET"): ?>
            <!-- VISUALIZZAZIONE FORM (GET) -->
            <h1>Calcolatore BMI</h1>
            <div class="card">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" placeholder="Inserisci il tuo nome" required>
                    </div>
                    <div class="form-group">
                        <label for="peso">Peso (kg)</label>
                        <input type="number" id="peso" name="peso" step="0.1" placeholder="Es. 70.5" required>
                    </div>
                    <div class="form-group">
                        <label for="altezza">Altezza (cm)</label>
                        <input type="number" id="altezza" name="altezza" step="0.1" placeholder="Es. 175" required>
                    </div>
                    <button type="submit" class="btn-submit">Calcola</button>
                </form>
            </div>
        <?php else: ?>
            <!-- VISUALIZZAZIONE RISULTATI (POST) -->
            <h1>Risultato BMI</h1>
            <div class="card">
                <p style="margin-bottom: 12px;">Ciao <strong><?php echo $nome; ?></strong>,</p>
                <p style="margin-bottom: 12px;">Il tuo BMI è: <strong><?php echo $bmi_formatted; ?></strong></p>
                <p style="margin-bottom: 24px;">Categoria: <strong><?php echo $categoria; ?></strong></p>
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>"><button type="button" class="btn-submit">Torna indietro</button></a>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>