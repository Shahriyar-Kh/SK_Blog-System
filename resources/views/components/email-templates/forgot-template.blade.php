<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>SK Blog – Reset Password</title>

<style>
  body {
    margin: 0;
    padding: 0;
    background: #f3f5f7;
    font-family: Arial, sans-serif;
  }

  .wrapper {
    width: 100%;
    padding: 20px;
  }

  .email-card {
    max-width: 520px;
    margin: auto;
    background: #ffffff;
    border-radius: 10px;
    padding: 25px;
    border-top: 5px solid #0d6efd;
    box-shadow: 0 3px 12px rgba(0,0,0,0.08);
  }

  .logo {
    text-align: center;
    margin-bottom: 20px;
  }

  .logo img {
    width: 120px;
    height: auto;
  }

  h2 {
    text-align: center;
    color: #202124;
    margin: 0 0 15px 0;
  }

  .text {
    font-size: 15px;
    color: #444;
    line-height: 1.6;
  }

  .btn-container {
    text-align: center;
    margin: 30px 0;
  }

  .btn-container a {
    background: #0d6efd;
    color: #ffffff !important;
    padding: 12px 22px;
    font-size: 16px;
    text-decoration: none;
    border-radius: 6px;
    display: inline-block;
    font-weight: bold;
  }

  .footer {
    text-align: center;
    margin-top: 25px;
    font-size: 13px;
    color: #777;
  }

  @media(max-width: 480px) {
    .email-card {
      padding: 20px;
    }
    .btn-container a {
      width: 100%;
      display: block;
    }
  }
</style>

</head>
<body>

<div class="wrapper">
  <div class="email-card">

    <!-- Logo Section -->
    <div class="logo">
      <img src="https://via.placeholder.com/120x50?text=SK+Blog" alt="SK Blog Logo" />
    </div>

    <h2>Reset Your Password</h2>
    <h3>Hello, {{ $name }}</h3>
    <p class="text">
      You requested to reset your password for your <strong>SK Blog System</strong> account.
      Click the button below to continue.
    </p>

    <div class="btn-container">
      <a href="{{$actionLink}}" target="_blank">Reset Password</a>
    </div>

    <p class="text">
      If this wasn’t you, simply ignore this message.  
      Your password will stay the same.
    </p>

    <div class="footer">
      © 2025 SK Blog System — Crafted with passion.
    </div>

  </div>
</div>

</body>
</html>
