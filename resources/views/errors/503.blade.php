<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Unavailable - 503</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; color: #334155; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { text-align: center; background: white; padding: 3rem; border-radius: 8px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1); }
        h1 { font-size: 6rem; margin: 0; color: #8b5cf6; }
        h2 { font-size: 1.5rem; margin-top: 0; }
        p { color: #64748b; margin-bottom: 2rem; }
        a { background-color: #3b82f6; color: white; text-decoration: none; padding: 0.75rem 1.5rem; border-radius: 6px; font-weight: 600; transition: background-color 0.2s; }
        a:hover { background-color: #2563eb; }
    </style>
</head>
<body>
    <div class="container">
        <h1>503</h1>
        <h2>Service Unavailable</h2>
        <p>Our service is currently down for maintenance. Please check back soon.</p>
        <a href="{{ url('/') }}">Refresh Page</a>
    </div>
</body>
</html>
