<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
@if(!empty($datas))
    @foreach($datas as $data)
        @foreach($data as $item)
            <url>
                <loc>{{ $item->getUrl() }}</loc>
                <lastmod>{{ date(DATE_ATOM) }}</lastmod>
                <changefreq>daily</changefreq>
                <priority>0.8</priority>
            </url>
        @endforeach
    @endforeach
@endif

</urlset>