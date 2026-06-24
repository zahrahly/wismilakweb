<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>New Media Inquiry</title>
</head>

<body style="margin:0;padding:0;background:#0d0d0d;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 20px;background:#0d0d0d;">
<tr>
<td align="center">

<table width="600" cellpadding="0" cellspacing="0"
style="background:#1a1a1a;border:1px solid #333;border-radius:14px;overflow:hidden;">

<tr>
<td style="padding:30px;border-bottom:1px solid #333;">

<p style="margin:0;font-size:11px;color:#777;letter-spacing:2px;">
WISMILAK ADMIN PANEL
</p>

<h2 style="margin:5px 0 0;color:#D4AF37;">
New Media Inquiry Received
</h2>

</td>
</tr>


<tr>
<td style="padding:30px;">


<table width="100%" cellpadding="10" cellspacing="0"
style="background:#222;border-radius:10px;border:1px solid #333;">

<tr>
<td style="color:#999;font-size:12px;">Name</td>
<td style="color:#fff;">{{ $inquiry->name }}</td>
</tr>

<tr>
<td style="color:#999;font-size:12px;">Email</td>
<td style="color:#D4AF37;">{{ $inquiry->email }}</td>
</tr>

<tr>
<td style="color:#999;font-size:12px;">Phone</td>
<td style="color:#fff;">{{ $inquiry->phone ?? '-' }}</td>
</tr>

<tr>
<td style="color:#999;font-size:12px;">Organization</td>
<td style="color:#fff;">{{ $inquiry->organization ?? '-' }}</td>
</tr>

<tr>
<td style="color:#999;font-size:12px;">Inquiry Type</td>
<td style="color:#fff;">{{ $inquiry->inquiry_type ?? '-' }}</td>
</tr>

<tr>
<td style="color:#999;font-size:12px;">Subject</td>
<td style="color:#fff;">{{ $inquiry->subject ?? '-' }}</td>
</tr>

<tr>
<td style="color:#999;font-size:12px;">Submitted</td>
<td style="color:#fff;">
{{ $inquiry->created_at->format('d M Y H:i') }} WIB
</td>
</tr>

<tr>
<td colspan="2"
style="padding-top:20px;color:#ccc;font-size:14px;line-height:1.6;">
{{ $inquiry->message }}
</td>
</tr>

</table>


<br>


<a href="{{ url('/admin/media-inquiries/'.$inquiry->id) }}"
style="background:#D4AF37;color:black;padding:12px 20px;
text-decoration:none;border-radius:6px;font-size:12px;font-weight:bold;">

VIEW & REPLY IN DASHBOARD →

</a>


</td>
</tr>


<tr>
<td style="padding:20px;border-top:1px solid #333;
text-align:center;font-size:11px;color:#555;">

This is an automated system notification.

</td>
</tr>

</table>

</td>
</tr>
</table>

</body>
</html>