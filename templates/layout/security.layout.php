<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAXIT SA - Mon Espace Client</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Ajoutez Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Ajoutez le script avec un timestamp pour éviter le cache -->
    <script src="/js/register.js?v=<?= time() ?>" defer></script>
    <!-- Ajout du script login.js -->
    <script src="/js/login.js?v=<?= time() ?>" defer></script>
    <style>
        body {
            background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%);
            min-height: 100vh;
        }
        .container-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .phone-icon {
            width: 20px;
            height: 20px;
            fill: #9ca3af;
        }
        .green-gradient {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        }
        .input-focus:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }
         
        .upload-area {
            border: 2px dashed #34d399;
            border-radius: 8px;
            background-color: #f0fdf4;
            transition: all 0.3s ease;
            cursor: pointer;
            min-height: 120px;
        }
        .upload-area:hover {
            border-color: #10b981;
            background-color: #dcfce7;
        }
        .black-button {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
        }
        .black-button:hover {
            background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-4xl">
        <?php echo $content; ?>
    </div>

</body>
</html>
