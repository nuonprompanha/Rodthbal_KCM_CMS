@props(['url'])
<tr>
<td class="header">
<a href="{{ $url ?? config('app.url') }}" style="display: inline-block; text-decoration: none; color: #0d47a1; font-size: 24px; font-weight: bold;">
{{ config('app.name') }}
</a>
</td>
</tr>
