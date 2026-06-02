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
            position: relative;
        }
        .field label{ display:block; font-size:13px; color:var(--muted); margin-bottom:8px; }
        .field input{
            width:100%; box-sizing:border-box; padding:12px 14px; border-radius:8px;
            border:1px solid rgba(14,30,37,0.06); background:var(--input-bg);
            font-size:15px; outline:none;
            transition:box-shadow .15s, border-color .15s;
        }
        .field input:focus{ box-shadow:0 6px 18px rgba(21,101,192,0.06); border-color: rgba(21,101,192,0.22); }
        .field input[type="password"], .field input[type="text"] {
            padding-right: 40px;
        }
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 36px;
            cursor: pointer;
            color: var(--muted);
            background: none;
            border: none;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 20px;
            width: 20px;
        }

        .btn-login{
            display:block; width:100%; padding:12px 14px; border-radius:8px; border:none;
            background:var(--orange); color:#fff; font-weight:700; font-size:15px; cursor:pointer;
            box-shadow: 0 8px 18px rgba(245,124,0,0.18);
        }

        .errors{ color:#b91c1c; font-size:14px; margin-bottom:12px; text-align:center; }

        .forgot-link {
            display: block;
            text-align: center;
            font-size: 14px;
            color: var(--orange);
            text-decoration: none;
            font-weight: 500;
            margin-top: 16px;
        }
        .forgot-link:hover {
            text-decoration: underline;
        }

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

    @if(session('status'))
        <div class="success" style="color:#166534; background: #dcfce7; padding: 10px; border-radius: 6px; font-size:14px; margin-bottom:16px; text-align:center; border: 1px solid #bbf7d0;">
            {{ session('status') }}
        </div>
    @endif

    @if($errors->any())
        <div class="errors">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf

        <div class="field">
            <label for="email">Phone Number</label>
            <input id="email" type="text" name="email" placeholder="Enter phone number" required autofocus>
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" placeholder="••••••••" required>
            <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password', 'eye-icon')">
                <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
            </button>
        </div>

        <button type="submit" class="btn-login">Login</button>
        <a href="{{ route('admin.password.request') }}" class="forgot-link">Forgot Password?</a>
    </form>
</div>

<script>
    function togglePasswordVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = '<path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path><line x1="2" y1="2" x2="22" y2="22"></line>';
        } else {
            input.type = 'password';
            icon.innerHTML = '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>';
        }
    }
</script>
</body>
</html>
