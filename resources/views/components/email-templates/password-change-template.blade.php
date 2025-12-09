<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Password Changed</title>

  <style>
    body {
      margin: 0;
      padding: 0;
      background: #f5f7fa;
      font-family: Arial, sans-serif;
    }
    .container {
      max-width: 600px;
      margin: auto;
      background: #ffffff;
      border-radius: 8px;
      padding: 20px;
    }
    .header {
      text-align: center;
      padding: 20px 0;
      background: #1a73e8;
      color: #ffffff;
      border-radius: 8px 8px 0 0;
      font-size: 20px;
      font-weight: bold;
    }
    .content {
      padding: 20px;
      color: #444444;
      line-height: 1.6;
    }
    .info-box {
      background: #f1f5ff;
      padding: 15px;
      border-radius: 6px;
      margin-top: 15px;
      font-size: 15px;
    }
    .footer {
      text-align: center;
      font-size: 13px;
      color: #777;
      margin-top: 20px;
      padding-bottom: 10px;
    }
    @media only screen and (max-width: 600px) {
      .container {
        width: 95% !important;
        padding: 10px !important;
      }
      .header {
        font-size: 18px !important;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">Password Updated Successfully</div>

    <div class="content">
    <p>Hello <strong>{{$name}}</strong>,</p>
      <p>Your password has been successfully changed.</p>

      <div class="info-box">
        <p><strong>Username/Email:</strong> {{$email}}</p>
        <p><strong>New Password:</strong> {{$new_password}}</p>
      </div>

      <p>If you did not make this change, please contact support immediately.</p>
    </div>

    <div class="footer">
      © {{date('Y')}} Sk Blog System — All rights reserved.
    </div>
  </div>
</body>
</html>
