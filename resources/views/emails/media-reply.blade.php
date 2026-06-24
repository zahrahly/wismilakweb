<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Reply from Media Relations</title>
</head>

<body style="margin:0;background:#111;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0"
style="padding:40px;background:#111;">

<tr>
<td align="center">

<table width="600" cellpadding="0" cellspacing="0"
style="background:#1a1208;border-radius:14px;border:1px solid #3a2e10;">


<tr>
<td style="padding:40px;text-align:center;
background:linear-gradient(135deg,#1a1208,#2a1f08);">

<p style="font-size:11px;color:#8a7030;letter-spacing:3px;">
WISMILAK PREMIUM CIGARS
</p>

<h1 style="margin:0;color:#D4AF37;">
Media Relations Response
</h1>

</td>
</tr>


<tr>
<td style="padding:40px;">


<p style="color:#eee;font-size:16px;">
Dear {{ $inquiry->name }},
</p>


<p style="color:#aaa;font-size:14px;line-height:1.8;">

Thank you for your inquiry. Please see our response below:

</p>


<table width="100%" cellpadding="20" cellspacing="0"
style="background:#221a10;border-left:4px solid #D4AF37;
border-radius:8px;margin:20px 0;">

<tr>
<td style="color:#eee;font-size:14px;line-height:1.7;">

{{ $replyMessage }}

</td>
</tr>

</table>


<p style="color:#777;font-size:13px;">

Original message preview:

</p>


<p style="color:#999;font-size:12px;font-style:italic;">

{{ Str::limit($inquiry->message,200) }}

</p>


<br>


<p style="color:#D4AF37;font-weight:bold;">

Wismilak Media Relations Team

</p>


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