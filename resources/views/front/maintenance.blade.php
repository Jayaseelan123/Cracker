<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Maintenance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { height: 100vh; display: flex; align-items: center; justify-content: center; background: #f8f9fa; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container text-center">
        <div class="card p-5 mx-auto" style="max-width: 600px;">
            <i class="fas fa-tools text-warning mb-4" style="font-size: 60px;"></i>
            <h2 class="fw-bold mb-3">We'll be right back!</h2>
            <p class="text-muted fs-5">{!! nl2br(e($msg)) !!}</p>
        </div>
    </div>
</body>
</html>
