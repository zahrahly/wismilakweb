<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Media Inquiry Received</title>
</head>

<body style="margin:0;background:#111;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0"
style="padding:40px;background:#111;">

<tr>
<td align="center">

<table width="600" cellpadding="0" cellspacing="0"
style="background:#1a1208;border:1px solid #3a2e10;border-radius:14px;overflow:hidden;">


<tr>
<td style="padding:40px;text-align:center;
background:linear-gradient(135deg,#1a1208,#2a1f08);">

<p style="font-size:11px;color:#8a7030;letter-spacing:3px;">
WISMILAK PREMIUM CIGARS
</p>

<h1 style="color:#D4AF37;margin:0;">
Media Relations
</h1>

</td>
</tr>


<tr>
<td style="padding:40px;">


<p style="color:#eee;font-size:16px;">
Dear <strong>{{ $inquiry->name }}</strong>,
</p>


<p style="color:#aaa;font-size:14px;line-height:1.8;">

Thank you for contacting Wismilak Premium Cigars.

Your inquiry has been received successfully and our Media Relations team
will respond within 1–2 business days.

</p>


<!-- SUMMARY BOX -->

<table width="100%" cellpadding="15" cellspacing="0"
style="background:#221a10;border-radius:10px;margin-top:20px;">

<tr>
<td style="color:#D4AF37;font-size:12px;">
Your Inquiry Summary
</td>
</tr>

<tr>
<td style="color:#ccc;font-size:13px;line-height:1.8;">


<strong>Email:</strong><br>
{{ $inquiry->email }}

<br><br>

<strong>Phone:</strong><br>
{{ $inquiry->phone ?? '-' }}

<br><br>

<strong>Organization:</strong><br>
{{ $inquiry->organization ?? '-' }}

<br><br>

<strong>Inquiry Type:</strong><br>
{{ $inquiry->inquiry_type ?? '-' }}

<br><br>

<strong>Subject:</strong><br>
{{ $inquiry->subject ?? '-' }}

<br><br>

<strong>Message:</strong><br>
{{ $inquiry->message }}


</td>
</tr>

</table>


</td>
</tr>


<tr>
<td style="padding:20px;text-align:center;
border-top:1px solid #3a2e10;color:#555;font-size:11px;">

© {{ date('Y') }} Wismilak Premium Cigars

</td>
</tr>


</table>

</td>
</tr>

</table>

</body>
</html>