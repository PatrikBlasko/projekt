<?php
/**
 * Login Page
 * Prihlasovanie používateľa
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
$success = false;

// Spracovanie formuláru
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    // Validácia
    if (is_empty($username)) {
        $errors[] = "Užívateľské meno je povinné.";
    }
    if (is_empty($password)) {
        $errors[] = "Heslo je povinné.";
    }
    
    // Ak nema chyby, skúšame prihlásiť
    if (empty($errors)) {
        // Prepared statement - ochrana pred SQL injection
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Overenie hesla
            if (password_verify($password, $user['password'])) {
                // Úspešné prihlásenie - nastavenie session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                
                // Presmerovanie na domov
                redirect_with_message('index.php', 'Úspešne ste sa prihlásili! 🎉', 'success');
            } else {
                $errors[] = "Nesprávne heslo.";
            }
        } else {
            $errors[] = "Užívateľ nenajdený.";
        }
        
        $stmt->close();
    }
}

$conn->close();
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg">
            <div class="card-body">
                <h1 class="card-title text-center mb-4">🔓 Prihlásenie</h1>
                
                <?php display_message(); ?>
                
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger" role="alert">
                        <strong>Chyby pri prihlasovaní:</strong>
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
                               value="<?php echo safe_output($_POST['username'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Heslo:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Prihlásiť sa</button>
                </form>
                
                <hr>
                
                <p class="text-center">
                    Nemáte účet? <a href="register.php">Zaregistrujte sa tu</a>
                </p>
                
                <div class="alert alert-info mt-3">
                    <strong>Test kredenciály:</strong><br>
                    Username: <code>test</code><br>
                    Password: <code>password123</code>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
