<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = htmlspecialchars($_POST['nome'] ?? '');
    $peso = filter_var($_POST['peso'], FILTER_VALIDATE_FLOAT);
    $altezza_cm = filter_var($_POST['altezza'], FILTER_VALIDATE_FLOAT);

    if ($nome && $peso && $altezza_cm && $altezza_cm > 0) {
        // Conversione altezza da cm a metri
        $altezza_m = $altezza_cm / 100;
        
        // Calcolo del BMI: peso / (altezza * altezza)
        $bmi = $peso / ($altezza_m * $altezza_m);
        $bmi_formatted = number_format($bmi, 1);

        // Valutazione della fascia di peso
        if ($bmi < 18.5) {
            $categoria = "Sottopeso";
        } elseif ($bmi >= 18.5 && $bmi < 24.9) {
            $categoria = "Normopeso";
        } elseif ($bmi >= 25 && $bmi < 29.9) {
            $categoria = "Sovrappeso";
        } else {
            $categoria = "Obesità";
        }
    } else {
        $errore = "Dati inseriti non validi.";
    }
} else {
    header("Location: form.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risultato BMI</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <main class="main-container">
        <h1>Risultato BMI</h1>
        
        <div class="card">
            <?php if (isset($errore)): ?>
                <p class="error-message"><?php echo $errore; ?></p>
            <?php else: ?>
                <p style="margin-bottom: 12px;">Ciao <strong><?php echo $nome; ?></strong>,</p>
                <p style="margin-bottom: 12px;">Il tuo BMI è: <strong><?php echo $bmi_formatted; ?></strong></p>
                <p style="margin-bottom: 24px;">Categoria: <strong><?php echo $categoria; ?></strong></p>
            <?php endif; ?>

            <a href="form.html" style="text-decoration: none;">
                <button type="button" class="btn-submit">Torna indietro</button>
            </a>
        </div>
    </main>

</body>
</html>