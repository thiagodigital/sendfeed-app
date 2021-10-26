<h1>{{ env('APP_NAME') }}</h1>
<img src="{{ $feed->image }}" alt="" srcset="">
<h1>{{ $feed->title }}</h1>
<small>{{ $feed->pub_date->format('d M Y') }}</small>
<p>
    {{ $feed->description }}
</p>
<pre>{{ $feed->url }}</pre>

<a href="{{ $feed->url }}">Leia Mais...</a>
