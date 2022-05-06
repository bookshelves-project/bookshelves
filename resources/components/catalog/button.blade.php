<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="center">
<table border="0" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
<a href="{{ $url }}"
{{ $attributes->merge(['class' => 'button button-primary']) }}>{{ $slot }}</a>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%"
border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;"
align="left">

<div align="center">
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;font-family:arial,helvetica,sans-serif;"><tr><td style="font-family:arial,helvetica,sans-serif;" align="center"><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="" style="height:45px; v-text-anchor:middle; width:120px;" arcsize="9%" stroke="f" fillcolor="#3AAEE0"><w:anchorlock/><center style="color:#FFFFFF;font-family:arial,helvetica,sans-serif;"><![endif]-->
@if ($url)
<a href="{{ $url }}"
style="box-sizing: border-box;display: inline-block;font-family:arial,helvetica,sans-serif;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #FFFFFF; background-color: #3AAEE0; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; width:auto; max-width:100%; overflow-wrap: break-word; word-break: break-word; word-wrap:break-word; mso-border-alt: none;">
<span style="display:block;padding:30px 50px;line-height:120%;"><span
style="font-size: 25px; line-height: 16.8px; color: white;">
{{ $slot }}
</span></span>
</a>
@else
<div
style="box-sizing: border-box;display: inline-block;font-family:arial,helvetica,sans-serif;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #FFFFFF; background-color: #3AAEE0; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; width:auto; max-width:100%; overflow-wrap: break-word; word-break: break-word; word-wrap:break-word; mso-border-alt: none;">
<span style="display:block;padding:30px 50px;line-height:120%;"><span
style="font-size: 25px; line-height: 16.8px; color: white;">
{{ $slot }}
</span></span>
</div>
@endif

<!--[if mso]></center></v:roundrect></td></tr></table><![endif]-->
</div>

</td>
</tr>
</tbody>
</table>
