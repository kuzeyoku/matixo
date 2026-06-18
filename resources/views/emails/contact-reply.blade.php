<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>{{ $subjectLine }}</title></head>
<body style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;padding:20px;background:#f7f3eb">
  <div style="background:white;border-radius:8px;padding:24px;border-top:4px solid #41B7A8">
    <p>Merhaba {{ $original->name }},</p>
    <div style="margin:20px 0;white-space:pre-wrap">{{ $body }}</div>
    <hr style="border:0;border-top:1px solid #eee;margin:20px 0">
    <p style="font-size:13px;color:#777">
      <strong>Orijinal mesajınız:</strong><br>
      <em>"{{ \Illuminate\Support\Str::limit($original->message, 200) }}"</em>
    </p>
    <p style="margin-top:20px;font-size:13px">
      Saygılarımızla,<br>
      <strong>{{ setting('site_name', 'MATIXO') }} Ekibi</strong><br>
      {{ setting('contact_phone', '') }} • {{ setting('contact_email', '') }}
    </p>
  </div>
</body></html>
