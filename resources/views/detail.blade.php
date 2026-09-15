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
            --text: #183a31;
            --muted: #64786f;
            --brand: #123d32;
            --brand-soft: #edf7f0;
            --line: rgba(22, 133, 91, 0.2);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: var(--font-sans);
            background: #fbf8ef;
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
            color: #123d32;
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

        h1 {
            max-width: 900px;
            margin: 0;
            color: #123d32;
            font-family: var(--font-heading);
            font-weight: 400;
            font-size: clamp(2.2rem, 6vw, 4.2rem);
            line-height: 1.08;
            letter-spacing: 0;
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
            background: #e5f0e8;
        }

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
            color: #405f55;
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
            color: #5d2e48;
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
            box-shadow: 0 16px 38px rgba(246, 126, 155, 0.24);
        }

        .cta:hover,
        .cta:focus-visible {
            background: #5f1d38;
        }

        .article h2,
        .article h3 {
            color: #482438;
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
            outline: 3px solid #e88bae;
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
            background: #f7dce7;
        }

        @media (min-width: 920px) {
            .content-layout {
                grid-template-columns: minmax(0, 1fr) 320px;
            }
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
            <section class="detail-hero">
                <div>
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
                    <img class="hero-image" src="{{ $image }}" alt="{{ $imageAlt ?? $title ?? 'Detail Bubba Bloom' }}">
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
                </article>

                <aside class="side-panel">
                    @if(!empty($highlights))
                        @foreach($highlights as $highlight)
                            <div class="panel-item">
                                <span class="panel-icon"><i class="{{ $highlight['icon'] ?? 'ri-check-line' }}" aria-hidden="true"></i></span>
                                <div>
                                    <strong>{{ $highlight['label'] ?? 'Highlight' }}</strong>
                                    <span>{{ $highlight['value'] ?? '' }}</span>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if(!empty($tags))
                        <div class="panel-item">
                            <span class="panel-icon"><i class="ri-hashtag" aria-hidden="true"></i></span>
                            <div>
                                <strong>Topik</strong>
                                <span>{{ implode(', ', $tags) }}</span>
                            </div>
                        </div>
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
                                <strong>{{ $brandName ?? 'Bubba Bloom' }}</strong>
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
</body>
</html>
