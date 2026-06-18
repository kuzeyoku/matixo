<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Yeni İletişim Mesajı</title>
  <style>
    body {
      font-family: 'Outfit', 'Helvetica Neue', Helvetica, Arial, sans-serif;
      background-color: #f8fafc;
      margin: 0;
      padding: 0;
      -webkit-font-smoothing: antialiased;
    }
    .wrapper {
      width: 100%;
      background-color: #f8fafc;
      padding: 40px 0;
    }
    .container {
      max-width: 600px;
      margin: 0 auto;
      background-color: #ffffff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
      border: 1px solid #e2e8f0;
    }
    .header {
      background-color: #0f172a;
      padding: 32px;
      text-align: center;
      border-bottom: 4px solid #41B7A8;
    }
    .header .logo {
      font-size: 24px;
      font-weight: 800;
      color: #ffffff;
      letter-spacing: 0.05em;
    }
    .header .logo span {
      color: #41B7A8;
    }
    .content {
      padding: 32px;
    }
    .title {
      font-size: 20px;
      font-weight: 700;
      color: #0f172a;
      margin-top: 0;
      margin-bottom: 24px;
    }
    .info-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 24px;
    }
    .info-table td {
      padding: 12px 0;
      border-bottom: 1px solid #edf2f7;
      font-size: 14px;
      vertical-align: top;
    }
    .info-table td.label {
      font-weight: 600;
      color: #64748b;
      width: 30%;
    }
    .info-table td.value {
      color: #0f172a;
    }
    .message-box {
      background-color: #f1f5f9;
      border-left: 4px solid #41B7A8;
      border-radius: 4px;
      padding: 20px;
      margin-top: 12px;
      color: #334155;
      font-size: 14px;
      line-height: 1.6;
      white-space: pre-wrap;
    }
    .btn-container {
      text-align: center;
      margin-top: 32px;
    }
    .btn-action {
      display: inline-block;
      background-color: #41B7A8;
      color: #ffffff !important;
      text-decoration: none;
      padding: 12px 24px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 14px;
      transition: background-color 0.3s ease;
    }
    .footer {
      background-color: #f8fafc;
      padding: 24px;
      text-align: center;
      border-top: 1px solid #e2e8f0;
      font-size: 12px;
      color: #94a3b8;
    }
    .footer a {
      color: #41B7A8;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="container">
      <div class="header">
        <div class="logo">MATI<span style="color:#41B7A8">X</span>O</div>
      </div>
      <div class="content">
        <div class="title">Yeni İletişim Mesajı Alındı</div>
        <p style="font-size: 14px; color: #64748b; margin-top: 0; margin-bottom: 24px; line-height: 1.5;">
          Sitenizdeki iletişim formu üzerinden yeni bir müşteri mesajı gönderildi. Detaylar aşağıdadır:
        </p>
        <table class="info-table">
          <tr>
            <td class="label">Ad Soyad</td>
            <td class="value"><strong>{{ $msg->name }}</strong></td>
          </tr>
          <tr>
            <td class="label">E-posta</td>
            <td class="value"><a href="mailto:{{ $msg->email }}" style="color: #41B7A8; text-decoration: none; font-weight: 500;">{{ $msg->email }}</a></td>
          </tr>
          @if($msg->phone)
          <tr>
            <td class="label">Telefon</td>
            <td class="value"><a href="tel:{{ $msg->phone }}" style="color: #0f172a; text-decoration: none;">{{ $msg->phone }}</a></td>
          </tr>
          @endif
          <tr>
            <td class="label">Konu</td>
            <td class="value"><span style="background-color: #e2e8f0; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; color: #475569;">{{ $msg->subject }}</span></td>
          </tr>
          <tr>
            <td class="label">Tarih</td>
            <td class="value">{{ $msg->created_at->format('d.m.Y H:i') }}</td>
          </tr>
        </table>
        
        <div style="font-weight: 600; font-size: 14px; color: #0f172a; margin-top: 24px;">Mesaj İçeriği:</div>
        <div class="message-box">{{ $msg->message }}</div>

        <div class="btn-container">
          <a href="{{ url('/admin/messages/' . $msg->id) }}" class="btn-action">Mesajı Yönetim Panelinde Gör</a>
        </div>
      </div>
      <div class="footer">
        Bu e-posta <strong>{{ setting('site_name', 'MATIXO') }}</strong> yönetim sistemi tarafından otomatik olarak gönderilmiştir.<br>
        <a href="{{ url('/admin') }}">Yönetim Paneline Git</a>
      </div>
    </div>
  </div>
</body>
</html>
