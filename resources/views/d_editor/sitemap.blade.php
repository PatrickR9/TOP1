<div class = "d_sitemap">
    @if(isset($siteTree))
    <ul>
        @foreach($siteTree as $site)
            @include('d_editor.sitemaplevel', $site)
        @endforeach
    </ul>
    @else
    Kein Zugang
    @endif
</div>