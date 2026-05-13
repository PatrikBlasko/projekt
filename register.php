<?php
/**
 * Register Page
 * Registrácia nového používateľa
 */

require_once '../includes/header.php';
require_once '../config/database.php';
require_once '../includes/functions.php';

// Ak je už prihlásený, presmerovať na domov
if (is_logged_in()) {
    header("Location: index.php");
    exit;
}

$errors = [];
$username = '';
$email = '';

// Spracovanie formuláru
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $password_confirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';
    
    // Validácia
    $errors = validate_user_input($username, $email, $password);
    
    if ($password !== $password_confirm) {
        $errors[] = "Heslá sa nezhodujú.";
    }
    
    // Ak nema chyby, skúšame registrovať
    if (empty($errors)) {
        // Kontola či užívateľ neexistuje
        $check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $check->bind_param("ss", $username, $email);
        $check->execute();
        $result = $check->get_result();
        
        if ($result->num_rows > 0) {
            $errors[] = "Užívateľské meno alebo email už existuje.";
        } else {
            // Hashovanie hesla
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Vloženie nového používateľa - prepared statement
            $insert = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $insert->bind_param("sss", $username, $email, $hashed_password);
            
            if ($insert->execute()) {
                // Úspešná registrácia
                $insert->close();
                $check->close();
                $conn->close();
                
                // Presmerovanie na prihlásenie
                redirect_with_message('login.php', 'Registrácia úspešná! Prosím prihlaste sa.', 'success');
            } else {
                $errors[] = "Chyba pri registrácii: " . $conn->error;
            }
            
            $insert->close();
        }
        
        $check->close();
    }
}

$conn->close();
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg">
            <div class="card-body">
                <h1 class="card-title text-center mb-4">📝 Registrácia</h1>
                
                <?php display_message(); ?>
                
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger" role="alert">
                        <strong>Chyby pri registrácii:</strong>
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo safe_output($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="username" class="form-label">Užívateľské meno:</label>
                        <input type="text" class="form-control" id="username" name="username" 
                               value="<?php echo safe_output($username); ?>" required minlength="3">
                        <small class="text-muted">Minimálne 3 znaky</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?php echo safe_output($email); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Heslo:</label>
                        <input type="password" class="form-control" id="password" name="password" 
                               required minlength="6">
                        <small class="text-muted">Minimálne 6 znakov</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">Potvrďte heslo:</label>
                        <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                    </div>
                    
                    <button type="submit" class="btn btn-success w-100">Zaregistrovať sa</button>
                </form>
                
                <hr>
                
                <p class="text-center">
                    Už máte účet? <a href="login.php">Prihláste sa tu</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
