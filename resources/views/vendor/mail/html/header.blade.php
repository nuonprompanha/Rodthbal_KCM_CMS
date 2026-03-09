@props(['url'])
@php
    $logoPath = public_path('vendor/img/OCT-LogoG2.png');
    if (file_exists($logoPath)) {
        $mime = mime_content_type($logoPath) ?: 'image/png';
        $logoSrc = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($logoPath));
    } else {
        $logoSrc = rtrim(config('app.url'), '/') . '/vendor/img/OCT-LogoG2.png';
    }
@endphp
<tr>
<td class="header">
<a href="{{ $url ?? config('app.url') }}" style="display: inline-block;">
<img src="{{ $logoSrc }}" class="logo" alt="{{ config('app.name') }}" style="max-height: 75px; height: 75px; display: block;">
</a>
</td>
</tr>
