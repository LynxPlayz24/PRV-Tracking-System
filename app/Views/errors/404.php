<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | PRVTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #003399 0%, #002266 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }
        .error-card {
            text-align: center;
            animation: fadeInUp 0.5s ease;
        }
        .error-code {
            font-size: 8rem;
            font-weight: 700;
            line-height: 1;
            color: #FFCC00;
        }
        .error-message {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-code">404</div>
        <div class="error-message">Page Not Found</div>
        <p class="mb-4" style="opacity:0.7;">The page you're looking for doesn't exist or has been moved.</p>
        <a href="<?= rtrim($_ENV['APP_URL'] ?? '', '/') ?>/dashboard" class="btn btn-warning btn-lg px-4">
            <i class="bi bi-house me-2"></i>Go to Dashboard
        </a>
    </div>
</body>
</html>
