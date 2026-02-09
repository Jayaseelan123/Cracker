<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <style>
        /* Page-only styles for admin login (matches attached design) */
        :root{
            --orange:#f57c00;
            --card-bg:#ffffff;
            --input-bg:#eef6ff;
            --muted:#6b7280;
        }
        html,body{height:100%;}
        body{
            margin:0;
            font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            background: linear-gradient(180deg, #ffe9d6 0%, #ffd1d1 100%);
            display:flex;
            align-items:center;
            justify-content:center;
            -webkit-font-smoothing:antialiased;
            -moz-osx-font-smoothing:grayscale;
            position:relative;
            overflow:hidden;
        }

        /* subtle scattered dots background */
        .bg-dots{
            position:absolute; inset:0; z-index:0; pointer-events:none;
            background-image: radial-gradient(var(--orange) 1.8px, rgba(255,255,255,0) 2px);
            background-size: 80px 80px;
            opacity:0.65;
            mix-blend-mode: multiply;
        }

        .login-card{
            position:relative; z-index:2;
            width:420px; max-width:92%;
            background:var(--card-bg);
            padding:36px 40px;
            border-radius:12px;
            box-shadow: 0 30px 60px rgba(14,30,37,0.12);
            text-align:left;
        }

        .login-card h2{
            margin:0 0 18px 0; text-align:center;
            color:var(--orange); font-size:26px; font-weight:700;
        }

        .field{
            margin-bottom:18px;
        }
        .field label{ display:block; font-size:13px; color:var(--muted); margin-bottom:8px; }
        .field input{
            width:100%; box-sizing:border-box; padding:12px 14px; border-radius:8px;
            border:1px solid rgba(14,30,37,0.06); background:var(--input-bg);
            font-size:15px; outline:none;
            transition:box-shadow .15s, border-color .15s;
        }
        .field input:focus{ box-shadow:0 6px 18px rgba(21,101,192,0.06); border-color: rgba(21,101,192,0.22); }

        .btn-login{
            display:block; width:100%; padding:12px 14px; border-radius:8px; border:none;
            background:var(--orange); color:#fff; font-weight:700; font-size:15px; cursor:pointer;
            box-shadow: 0 8px 18px rgba(245,124,0,0.18);
        }

        .errors{ color:#b91c1c; font-size:14px; margin-bottom:12px; text-align:center; }

        @media (max-width:480px){
            .login-card{ padding:24px; }
            .login-card h2{ font-size:20px; }
        }
    </style>
</head>
<body>

<div class="bg-dots" aria-hidden="true"></div>

<div class="login-card">
    <h2>Admin Login</h2>

    @if($errors->any())
        <div class="errors">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf

        <div class="field">
            <label for="email">Username</label>
            <input id="email" type="email" name="email" placeholder="admin@example.com" required autofocus>
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn-login">Login</button>
    </form>
</div>

</body>
</html>
