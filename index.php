<?php
$classe_colore = "";
$errore = "";
$mostra_risultato = false;

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = htmlspecialchars($_POST['nome'] ?? '');
    $peso = $_POST['peso'] ?? '';
    $altezza_cm = $_POST['altezza'] ?? '';

    // Validazione dei dati inviati
    if (empty($nome) || $peso === '' || $altezza_cm === '') {
        $errore = "Tutti i campi sono obbligatori.";
    } elseif (!is_numeric($peso) || !is_numeric($altezza_cm) || $peso <= 0 || $altezza_cm <= 0) {
        $errore = "Inserisci valori numerici validi e maggiori di zero per peso e altezza.";
    } elseif ($peso > 700 || $altezza_cm > 300) {
        $errore = "I valori inseriti superano i limiti realistici umani (Max: 700 kg, 300 cm).";
    } else {
        // Dati corretti: procediamo con il calcolo
        $mostra_risultato = true;
        $altezza_m = $altezza_cm / 100;
        $bmi = $peso / ($altezza_m * $altezza_m);
        $bmi_formatted = number_format($bmi, 1);

        if ($bmi < 18.5) $categoria = "Sottopeso";
        elseif ($bmi < 24.9) $categoria = "Normopeso";
        elseif ($bmi < 29.9) $categoria = "Sovrappeso";
        else $categoria = "Obesità";

        $classe_colore = $categoria;
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcolatore BMI</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="main-container">
        <?php if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] == "GET" || !$mostra_risultato): ?>
            <!-- VISUALIZZAZIONE FORM (GET o presenza di errori in POST) -->
            <h1>Calcolatore BMI</h1>
            <div class="card">
                <?php if (!empty($errore)): ?>
                    <p style="color: #A00; margin-bottom: 16px; font-weight: bold; font-size: 0.9rem;"><?php echo $errore; ?></p>
                <?php endif; ?>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" value="<?php echo isset($nome) ? $nome : ''; ?>" placeholder="Inserisci il tuo nome" required>
                    </div>
                    <div class="form-group">
                        <label for="peso">Peso (kg)</label>
                        <input type="number" id="peso" name="peso" step="0.1" value="<?php echo isset($_POST['peso']) ? $_POST['peso'] : ''; ?>" placeholder="Es. 70.5" required>
                    </div>
                    <div class="form-group">
                        <label for="altezza">Altezza (cm)</label>
                        <input type="number" id="altezza" name="altezza" step="0.1" value="<?php echo isset($_POST['altezza']) ? $_POST['altezza'] : ''; ?>" placeholder="Es. 175" required>
                    </div>
                    <button type="submit" class="btn-submit">Calcola</button>
                </form>
            </div>
        <?php else: ?>
            <!-- VISUALIZZAZIONE RISULTATI (POST con dati corretti) -->
            <h1>Risultato BMI</h1>
            <div class="card <?php echo $classe_colore; ?>">
                <p style="margin-bottom: 12px;">Ciao <strong><?php echo $nome; ?></strong>,</p>
                <p style="margin-bottom: 12px;">Il tuo BMI è: <strong><?php echo $bmi_formatted; ?></strong></p>
                <p style="margin-bottom: 24px;">Categoria: <strong><?php echo $categoria; ?></strong></p>
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>"><button type="button" class="btn-submit">Torna indietro</button></a>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>