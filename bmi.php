<?php
// Inizializziamo le variabili per evitare warning
$nome = "";
$peso = "";
$altezza_cm = "";
$bmi_formatted = "";
$categoria = "";
$errore = "";

// Verifichiamo il metodo della richiesta tramite $_SERVER o $GLOBALS
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

    // Recupero dati con isset
    if (isset($_POST['nome'])) {
        $nome = htmlspecialchars($_POST['nome']);
    }
    
    if (isset($_POST['peso'])) {
        $peso = $_POST['peso'];
    }
    
    if (isset($_POST['altezza'])) {
        $altezza_cm = $_POST['altezza'];
    }

    // Controllo con is_numeric
    if (!empty($nome) && is_numeric($peso) && is_numeric($altezza_cm) && $altezza_cm > 0) {
        
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
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") ? "Risultato BMI" : "Calcolatore BMI"; ?></title>
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            color: #1F2328;
        }

        body {
            background-color: #F1F3F5;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 16px;
        }

        .main-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            min-width: 250px;
            max-width: 400px;
        }

        h1 {
            margin-bottom: 24px;
            font-size: 1.8rem;
            text-align: center;
        }

        .card {
            background-color: #FFFFFF;
            border-radius: 12px;
            padding: 24px;
            width: 100%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 16px;
        }

        .form-group label {
            width: 100%;
            margin-bottom: 6px;
            font-weight: 600;
        }

        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #D0D7DE;
            border-radius: 6px;
            font-size: 1rem;
        }

        .form-group input:focus {
            outline: none;
            border-color: #1F2328;
        }

        .error-message {
            color: #D92D20;
            font-size: 0.85rem;
            margin-top: 4px;
        }

        /* Distanza specifica di 24px tra l'ultimo campo (altezza) e il pulsante */
        .form-group:last-of-type {
            margin-bottom: 24px;
        }

        .btn-submit {
            width: 100%;
            background-color: #1F2328;
            color: #FFFFFF;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-submit:hover {
            background-color: #32383E;
        }
    </style>
</head>
<body>

    <main class="main-container">

        <?php if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST"): ?>
            
            <!-- PAGINA DEI RISULTATI (bmi.php) -->
            <h1>Risultato BMI</h1>
            
            <div class="card">
                <?php if (!empty($errore)): ?>
                    <p class="error-message"><?php echo $errore; ?></p>
                <?php else: ?>
                    <p style="margin-bottom: 12px;">Ciao <strong><?php echo $nome; ?></strong>,</p>
                    <p style="margin-bottom: 12px;">Il tuo BMI è: <strong><?php echo $bmi_formatted; ?></strong></p>
                    <p style="margin-bottom: 24px;">Categoria: <strong><?php echo $categoria; ?></strong></p>
                <?php endif; ?>

                <a href="<?php echo $_SERVER['PHP_SELF']; ?>" style="text-decoration: none;">
                    <button type="button" class="btn-submit">Torna indietro</button>
                </a>
            </div>

        <?php else: ?>

            <!-- PAGINA DEL FORM (form.html) -->
            <h1>Calcolatore BMI</h1>
            
            <div class="card">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="bmiForm">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" placeholder="Inserisci il tuo nome" required>
                        <span class="error-message" id="error-nome"></span>
                    </div>

                    <div class="form-group">
                        <label for="peso">Peso (kg)</label>
                        <input type="number" id="peso" name="peso" step="0.1" placeholder="Es. 70.5" required>
                        <span class="error-message" id="error-peso"></span>
                    </div>

                    <div class="form-group">
                        <label for="altezza">Altezza (cm)</label>
                        <input type="number" id="altezza" name="altezza" step="0.1" placeholder="Es. 175" required>
                        <span class="error-message" id="error-altezza"></span>
                    </div>

                    <button type="submit" class="btn-submit">Calcola</button>
                </form>
            </div>

        <?php endif; ?>

    </main>

</body>
</html>