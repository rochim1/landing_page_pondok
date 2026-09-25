<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('partials.seo-head')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@500;600;700&family=Noto+Naskh+Arabic:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/remixicon/remixicon.css') }}">
    <style>
        :root {
            color-scheme: light;
            --font-sans: "Plus Jakarta Sans", "Segoe UI", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            --font-heading: "Lora", Georgia, serif;
            --text: #163a46;
            --muted: #62777f;
            --brand: #07566a;
            --brand-soft: #edf9fb;
            --line: rgba(2, 173, 208, 0.22);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: var(--font-sans);
            background: #f8fcfd;
            color: var(--text);
            line-height: 1.65;
            letter-spacing: -0.006em;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .page {
            width: min(1120px, calc(100% - 32px));
            margin: 0 auto;
            padding: 16px 0 56px;
        }

        .site-nav {
            position: sticky;
            top: 12px;
            z-index: 20;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            min-height: 72px;
            padding: 10px 16px;
            border: 1px solid var(--line);
            border-radius: 18px;
            background: rgba(255,255,255,.96);
            backdrop-filter: blur(16px);
            box-shadow: 0 16px 44px rgba(18,61,50,.09);
        }

        .site-nav__brand { display:flex;align-items:center;gap:11px;min-width:0; }
        .site-nav__brand img { width:50px;height:50px;flex:0 0 50px;object-fit:contain; }
        .site-nav__brand span { display:grid;line-height:1.08; }
        .site-nav__brand strong { color:var(--brand);font:700 1rem var(--font-heading);letter-spacing:.04em; }
        .site-nav__brand small { color:#a77d28;font-size:.67rem;font-weight:800; }
        .site-nav__links { display:flex;align-items:center;gap:18px;color:var(--brand);font-size:.72rem;font-weight:800;text-transform:uppercase; }
        .site-nav__cta { padding:10px 14px;border-radius:999px;background:#16855b;color:#fff; }
        .site-nav__toggle { display:none;width:42px;height:42px;border:0;border-radius:12px;background:var(--brand);color:#fff;font-size:1.25rem; }
        .sr-only { position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0,0,0,0); }

        .navbar {
            position: sticky;
            top: 12px;
            z-index: 20;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 14px 18px;
            border: 1px solid var(--line);
            border-radius: 18px;
            background: rgba(255, 248, 250, 0.96);
            backdrop-filter: blur(16px);
            box-shadow: 0 16px 44px rgba(157, 80, 122, 0.08);
        }

        .brand {
            display: inline-flex;
            align-items: center;
            min-width: 0;
            gap: 12px;
            font-weight: 800;
            color: var(--brand);
        }

        .brand img {
            width: 44px;
            height: 44px;
            object-fit: contain;
            border-radius: 12px;
            background: #fff;
            flex: 0 0 44px;
        }

        .brand span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 999px;
            color: var(--brand);
            background: var(--brand-soft);
            font-weight: 800;
            font-size: 0.9rem;
        }

        .back-link:hover,
        .back-link:focus-visible {
            background: #dfeee5;
            color: #0b3026;
        }

        .detail-hero {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 32px;
            padding: 64px 0 36px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
            color: var(--brand);
            font-size: 0.9rem;
            font-weight: 800;
        }

        .detail-back{display:inline-flex;align-items:center;gap:8px;margin-bottom:22px;color:var(--brand);font-size:.84rem;font-weight:800}.detail-back:hover{color:#f66243}

        h1 {
            width: 100%;
            max-width: none;
            margin: 0;
            color: var(--brand);
            font-family: var(--font-heading);
            font-weight: 400;
            font-size: clamp(1.9rem, 4vw, 3.25rem);
            line-height: 1.14;
            letter-spacing: 0;
        }

        .detail-hero--berita > div,
        .detail-hero--berita h1 {
            grid-column: 1 / -1;
            width: 100%;
        }

        .lead {
            max-width: 760px;
            margin: 22px 0 0;
            color: var(--muted);
            font-size: 1.08rem;
            line-height: 1.8;
        }

        .chips {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 24px;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 12px;
            border-radius: 999px;
            background: #fff;
            border: 1px solid var(--line);
            color: var(--brand);
            font-size: 0.82rem;
            font-weight: 800;
        }

        .hero-image {
            width: 100%;
            max-height: 560px;
            object-fit: cover;
            border-radius: 30px;
            border: 1px solid var(--line);
            box-shadow: 0 28px 80px rgba(18, 61, 50, 0.13);
            background: #e5f8fc;
        }

        .hero-figure { margin:0; }
        .hero-caption { margin:10px 12px 0;color:var(--muted);font-size:.82rem;font-style:italic; }

        .content-layout {
            display: grid;
            gap: 30px;
            align-items: start;
        }

        .article {
            padding: 34px;
            border-radius: 28px;
            background: #fff;
            border: 1px solid var(--line);
            box-shadow: 0 24px 60px rgba(18, 61, 50, 0.08);
        }

        .article p,
        .article li {
            color: #405f68;
            font-size: 1rem;
            line-height: 1.85;
        }

        .article p:first-child {
            margin-top: 0;
        }

        .side-panel {
            display: grid;
            gap: 14px;
        }

        .sidebar-box{padding:22px;border:1px solid var(--line);border-radius:22px;background:#fff;box-shadow:0 16px 42px rgba(4,49,61,.06)}.sidebar-box>h2{margin:0 0 16px;color:var(--brand);font:600 1.05rem/1.3 var(--font-heading)}.sidebar-list{display:grid;gap:14px}.sidebar-meta{display:grid;grid-template-columns:34px 1fr;gap:11px;align-items:start}.sidebar-meta i{display:grid;width:34px;height:34px;place-items:center;border-radius:11px;background:var(--brand-soft);color:var(--brand)}.sidebar-meta strong,.sidebar-meta span{display:block}.sidebar-meta strong{color:var(--brand);font-size:.76rem}.sidebar-meta span{margin-top:2px;color:var(--muted);font-size:.83rem;line-height:1.45}.tag-list{display:flex;flex-wrap:wrap;gap:7px}.tag-link{padding:7px 10px;border-radius:999px;background:var(--brand-soft);color:var(--brand);font-size:.72rem;font-weight:800}.share-actions{display:grid;grid-template-columns:repeat(3,1fr);gap:8px}.share-action{display:grid;height:42px;place-items:center;border:1px solid var(--line);border-radius:12px;background:#fff;color:var(--brand);font-size:1.12rem;cursor:pointer}.share-action:hover{border-color:var(--brand);background:var(--brand);color:#fff}.related-list{display:grid;gap:14px}.related-item{display:grid;grid-template-columns:72px 1fr;gap:12px;align-items:center}.related-item img,.related-placeholder{width:72px;height:62px;border-radius:12px;object-fit:cover;background:linear-gradient(135deg,var(--brand),#02add0)}.related-placeholder{display:grid;place-items:center;color:#fff}.related-item strong{display:-webkit-box;overflow:hidden;color:var(--brand);font-size:.79rem;line-height:1.4;-webkit-box-orient:vertical;-webkit-line-clamp:2}.related-item small{display:block;margin-top:4px;color:var(--muted);font-size:.66rem}.article-footer{display:flex;align-items:center;justify-content:space-between;gap:18px;margin-top:32px;padding-top:22px;border-top:1px solid var(--line)}.article-footer a{font-size:.82rem;font-weight:800}

        .panel-item {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            padding: 18px;
            border-radius: 22px;
            background: #fff;
            border: 1px solid var(--line);
        }

        .panel-icon {
            display: inline-grid;
            width: 38px;
            height: 38px;
            place-items: center;
            border-radius: 14px;
            background: var(--brand-soft);
            color: var(--brand);
            flex: 0 0 38px;
            font-size: 1.2rem;
        }

        .panel-item strong {
            display: block;
            color: var(--brand);
            line-height: 1.35;
        }

        .panel-item span,
        .panel-item a {
            display: block;
            margin-top: 4px;
            color: var(--muted);
            font-size: 0.94rem;
        }

        .cta {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
            padding: 13px 18px;
            border-radius: 999px;
            background: var(--brand);
            color: #fff;
            font-weight: 800;
            box-shadow: 0 16px 38px rgba(2, 173, 208, 0.24);
        }

        .cta:hover,
        .cta:focus-visible {
            background: #f66243;
        }

        .article h2,
        .article h3 {
            color: var(--brand);
            font-family: var(--font-heading);
            font-weight: 400;
            line-height: 1.2;
        }

        .article a:not(.cta),
        .panel-item a {
            color: var(--brand);
            text-decoration: underline;
            text-underline-offset: 0.2em;
        }

        a:focus-visible,
        button:focus-visible {
            outline: 3px solid #f66243;
            outline-offset: 3px;
        }

        .gallery-strip {
            display: grid;
            gap: 16px;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            margin-top: 26px;
        }

        .gallery-strip img {
            width: 100%;
            aspect-ratio: 4 / 3;
            object-fit: cover;
            border-radius: 20px;
            border: 1px solid var(--line);
            background: #e5f8fc;
        }

        .article img,.article video,.article iframe{max-width:100%;height:auto;border-radius:16px}.article blockquote{margin:24px 0;padding:18px 22px;border-left:4px solid #f66243;background:var(--brand-soft);color:var(--brand)}.article table{display:block;max-width:100%;overflow-x:auto;border-collapse:collapse}.article th,.article td{padding:10px 12px;border:1px solid var(--line)}

        @media (min-width: 920px) {
            .content-layout {
                grid-template-columns: minmax(0, 1fr) 320px;
            }
            .side-panel{position:sticky;top:96px}
        }

        @media (max-width: 900px) {
            .site-nav__toggle { display:block; }
            .site-nav__links { position:absolute;top:78px;left:0;right:0;display:none;padding:14px;border:1px solid var(--line);border-radius:16px;background:#fff;box-shadow:0 18px 45px rgba(18,61,50,.13); }
            .site-nav.is-open .site-nav__links { display:grid; }
            .site-nav__links a { padding:9px; }
        }

        @media (max-width: 640px) {
            .page {
                width: min(100% - 24px, 1120px);
                padding-top: 10px;
            }

            .navbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .brand span {
                white-space: normal;
            }

            .detail-hero {
                padding-top: 44px;
            }

            .article {
                padding: 24px;
            }

            .article-footer{align-items:flex-start;flex-direction:column}.share-actions{grid-template-columns:repeat(3,44px)}

            .site-nav__toggle { display:block; }
            .site-nav__links { position:absolute;top:78px;left:0;right:0;display:none;padding:14px;border:1px solid var(--line);border-radius:16px;background:#fff;box-shadow:0 18px 45px rgba(18,61,50,.13); }
            .site-nav.is-open .site-nav__links { display:grid; }
            .site-nav__links a { padding:9px; }
        }
    </style>
</head>
<body>
    <div class="page">
        @include('partials.landing-navbar', ['whatsappUrl' => 'https://wa.me/6287831633012?text=' . rawurlencode("Assalamu'alaikum, saya ingin bertanya mengenai Pondok Pesantren Al-Madinah Al-Kamilah.")])

        <main>
            <section class="detail-hero{{ ($type ?? null) === 'berita' ? ' detail-hero--berita' : '' }}">
                <div>
                    @if(!empty($backUrl))
                        <a class="detail-back" href="{{ $backUrl }}"><i class="ri-arrow-left-line"></i>{{ $backLabel ?? 'Kembali' }}</a>
                    @endif
                    <span class="eyebrow">
                        <i class="ri-sparkling-2-line" aria-hidden="true"></i>
                        {{ $eyebrow ?? 'Detail' }}
                    </span>
                    <h1>{{ $title ?? 'Detail' }}</h1>
                    @if(!empty($description))
                        <p class="lead">{{ $description }}</p>
                    @endif
                    @if(!empty($chips))
                        <div class="chips">
                            @foreach($chips as $chip)
                                <span class="chip">
                                    <i class="ri-price-tag-3-line" aria-hidden="true"></i>
                                    {{ $chip }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>

                @if(!empty($image))
                    <figure class="hero-figure">
                        <img class="hero-image" src="{{ $image }}" alt="{{ $imageAlt ?? $title ?? 'Kabar Pondok' }}">
                        @if(!empty($imageCaption))<figcaption class="hero-caption">{{ $imageCaption }}</figcaption>@endif
                    </figure>
                @endif
            </section>

            <section class="content-layout">
                <article class="article">
                    @if(!empty($contentHtml))
                        {!! $contentHtml !!}
                    @elseif(!empty($content))
                        <p>{!! nl2br(e($content)) !!}</p>
                    @else
                        <p>Informasi detail akan segera diperbarui.</p>
                    @endif

                    @if(!empty($cta['url']))
                        <a class="cta" href="{{ $cta['url'] }}">
                            <i class="ri-whatsapp-line" aria-hidden="true"></i>
                            <span>{{ $cta['label'] ?? 'Hubungi Kami' }}</span>
                        </a>
                    @endif

                    @if(!empty($gallery))
                        <div class="gallery-strip">
                            @foreach($gallery as $imageItem)
                                @php
                                    $galleryImage = $mediaUrl($imageItem['url'] ?? null);
                                @endphp
                                @if($galleryImage)
                                    <img src="{{ $galleryImage }}" alt="{{ $imageItem['alt'] ?? $title ?? 'Galeri' }}" loading="lazy" decoding="async">
                                @endif
                            @endforeach
                        </div>
                    @endif

                    @if(($type ?? '') === 'berita')
                        <div class="article-footer">
                            <a href="{{ $backUrl ?? route('landing.news.index') }}"><i class="ri-arrow-left-line"></i> Kembali ke semua berita</a>
                            <span>Bagikan kabar baik ini kepada keluarga dan sahabat.</span>
                        </div>
                    @endif
                </article>

                <aside class="side-panel">
                    @if(($type ?? '') === 'berita')
                        @if(!empty($highlights))
                            <section class="sidebar-box">
                                <h2>Informasi Artikel</h2>
                                <div class="sidebar-list">
                                    @foreach($highlights as $highlight)
                                        <div class="sidebar-meta"><i class="{{ $highlight['icon'] ?? 'ri-check-line' }}"></i><div><strong>{{ $highlight['label'] ?? 'Informasi' }}</strong><span>{{ $highlight['value'] ?? '' }}</span></div></div>
                                    @endforeach
                                </div>
                            </section>
                        @endif

                        @if(!empty($tags))
                            <section class="sidebar-box"><h2>Topik Berita</h2><div class="tag-list">@foreach($tags as $tag)<a class="tag-link" href="{{ route('landing.news.index',['tag'=>$tag]) }}">#{{ $tag }}</a>@endforeach</div></section>
                        @endif

                        <section class="sidebar-box">
                            <h2>Bagikan Berita</h2>
                            <div class="share-actions">
                                <a class="share-action" href="https://wa.me/?text={{ rawurlencode(($title??'').' '.url()->current()) }}" target="_blank" rel="noopener" aria-label="Bagikan ke WhatsApp"><i class="ri-whatsapp-line"></i></a>
                                <a class="share-action" href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode(url()->current()) }}" target="_blank" rel="noopener" aria-label="Bagikan ke Facebook"><i class="ri-facebook-fill"></i></a>
                                <button class="share-action" type="button" data-copy-url="{{ url()->current() }}" aria-label="Salin tautan"><i class="ri-link"></i></button>
                            </div>
                        </section>

                        @if(!empty($relatedNews))
                            <section class="sidebar-box">
                                <h2>Berita Terbaru</h2>
                                <div class="related-list">
                                    @foreach($relatedNews as $related)
                                        <a class="related-item" href="{{ $related['url'] }}">
                                            @if(!empty($related['image']))<img src="{{ $related['image'] }}" alt="{{ data_get($related,'featured_image.alt',$related['title']??'Berita') }}" loading="lazy">@else<span class="related-placeholder"><i class="ri-newspaper-line"></i></span>@endif
                                            <span><strong>{{ $related['title']??'Kabar Pondok' }}</strong><small>{{ data_get($related,'category_id.name','Kabar Pondok') }}</small></span>
                                        </a>
                                    @endforeach
                                </div>
                            </section>
                        @endif
                    @else
                        @if(!empty($highlights))
                            @foreach($highlights as $highlight)
                                <div class="panel-item"><span class="panel-icon"><i class="{{ $highlight['icon'] ?? 'ri-check-line' }}" aria-hidden="true"></i></span><div><strong>{{ $highlight['label'] ?? 'Highlight' }}</strong><span>{{ $highlight['value'] ?? '' }}</span></div></div>
                            @endforeach
                        @endif

                        @if(!empty($tags))
                            <div class="panel-item"><span class="panel-icon"><i class="ri-hashtag" aria-hidden="true"></i></span><div><strong>Topik</strong><span>{{ implode(', ', $tags) }}</span></div></div>
                        @endif
                    @endif

                    @if(!empty($contactLinks))
                        @foreach($contactLinks as $link)
                            <div class="panel-item">
                                <span class="panel-icon"><i class="{{ $link['icon'] ?? 'ri-links-line' }}" aria-hidden="true"></i></span>
                                <div>
                                    <strong>Kontak</strong>
                                    <a href="{{ $link['url'] }}">{{ $link['label'] }}</a>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if(!empty($socialLinks))
                        @foreach($socialLinks as $social)
                            <div class="panel-item">
                                <span class="panel-icon"><i class="{{ $social['icon'] ?? 'ri-links-line' }}" aria-hidden="true"></i></span>
                                <div>
                                    <strong>{{ $social['platform'] ?? 'Social Media' }}</strong>
                                    <a href="{{ $social['url'] ?? '#' }}">{{ $social['url'] ?? '' }}</a>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if(empty($highlights) && empty($tags) && empty($contactLinks) && empty($socialLinks))
                        <div class="panel-item">
                            <span class="panel-icon"><i class="ri-information-line" aria-hidden="true"></i></span>
                            <div>
                                <strong>{{ $brandName ?? 'Pondok Pesantren Al-Madinah Al-Kamilah' }}</strong>
                                <span>Informasi ini dikelola langsung dari database admin.</span>
                            </div>
                        </div>
                    @endif
                </aside>
            </section>
        </main>
    </div>
    @include('partials.floating-buttons', ['floatingButtons' => $floatingButtons ?? []])
    @include('partials.active-popups', ['activePopups' => $activePopups ?? []])
    <script>document.querySelectorAll('[data-copy-url]').forEach(button=>button.addEventListener('click',async()=>{try{await navigator.clipboard.writeText(button.dataset.copyUrl);const icon=button.querySelector('i');icon.className='ri-check-line';setTimeout(()=>icon.className='ri-link',1600)}catch(_){window.prompt('Salin tautan berita:',button.dataset.copyUrl)}}));</script>
</body>
</html>
