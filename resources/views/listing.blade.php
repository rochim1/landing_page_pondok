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
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/remixicon/remixicon.css') }}">
    <style>
        :root {
            color-scheme: light;
            --font-body: "Plus Jakarta Sans", "Segoe UI", system-ui, sans-serif;
            --font-heading: "DM Serif Display", Georgia, serif;
            --text: #2b1825;
            --muted: #60485a;
            --brand: #762546;
            --line: rgba(244, 171, 202, 0.35);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: var(--font-body);
            color: var(--text);
            background: linear-gradient(180deg, #241120 0%, #fff7fa 360px, #fff7fa 100%);
            line-height: 1.65;
            letter-spacing: -0.006em;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
        }

        a { color: inherit; text-decoration: none; }

        .page {
            width: min(1160px, calc(100% - 32px));
            margin: 0 auto;
            padding: 16px 0 64px;
        }

        .navbar {
            position: sticky;
            top: 12px;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 12px 14px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            background: rgba(36, 19, 31, 0.96);
            color: #fff;
            backdrop-filter: blur(18px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.18), inset 0 1px 1px rgba(255,255,255,0.18);
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
            font-weight: 700;
        }

        .brand img {
            width: 42px;
            height: 42px;
            object-fit: contain;
            border-radius: 999px;
            background: rgba(255,255,255,0.82);
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
            background: rgba(255,255,255,0.16);
            font-weight: 700;
            font-size: 0.92rem;
        }

        .back-link:hover,
        .back-link:focus-visible {
            background: rgba(255,255,255,0.24);
        }

        .hero {
            padding: 76px 0 46px;
            color: #fff;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
            color: #eedde6;
            font-weight: 700;
        }

        h1 {
            max-width: 860px;
            margin: 0;
            font-family: var(--font-heading);
            font-style: normal;
            font-weight: 400;
            font-size: clamp(3rem, 8vw, 6rem);
            line-height: 0.92;
            letter-spacing: 0;
        }

        .lead {
            max-width: 720px;
            margin: 22px 0 0;
            color: #eedde6;
            font-size: 1.08rem;
            font-weight: 400;
        }

        .filter-panel {
            margin: -12px 0 28px;
            padding: 18px;
            border: 1px solid rgba(244, 171, 202, 0.35);
            border-radius: 24px;
            background: rgba(255,255,255,0.96);
            backdrop-filter: blur(18px);
            box-shadow: 0 24px 70px rgba(75, 28, 54, 0.10), inset 0 1px 1px rgba(255,255,255,0.16);
        }

        .filter-grid {
            display: grid;
            grid-template-columns: minmax(220px, 1.4fr) minmax(180px, 0.9fr) minmax(160px, 0.8fr) auto auto;
            gap: 12px;
            align-items: end;
        }

        .filter-field {
            display: grid;
            gap: 6px;
        }

        .filter-field label {
            color: #5b3650;
            font-size: 0.82rem;
            font-weight: 800;
        }

        .filter-control {
            width: 100%;
            height: 46px;
            border: 1px solid rgba(127, 47, 83, 0.18);
            border-radius: 14px;
            padding: 0 14px;
            background: rgba(255,255,255,0.86);
            color: var(--text);
            font: inherit;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .filter-control:focus {
            border-color: rgba(127, 47, 83, 0.52);
            box-shadow: 0 0 0 4px rgba(127, 47, 83, 0.10);
        }

        .filter-action {
            height: 46px;
            border: 0;
            border-radius: 14px;
            padding: 0 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #fff;
            background: var(--brand);
            font-weight: 800;
            cursor: pointer;
            white-space: nowrap;
        }

        .filter-action.secondary {
            border: 1px solid rgba(127, 47, 83, 0.18);
            color: var(--brand);
            background: rgba(255,255,255,0.74);
        }

        .filter-action:hover,
        .filter-action:focus-visible {
            background: #5f1d38;
        }

        .filter-action.secondary:hover,
        .filter-action.secondary:focus-visible {
            background: #fbe8f0;
            color: #5f1d38;
        }

        .filter-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 14px;
            color: var(--muted);
            font-weight: 700;
            font-size: 0.92rem;
        }

        .active-filter {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            background: #ffe5f1;
            color: var(--brand);
            font-size: 0.82rem;
            font-weight: 800;
        }

        .grid {
            display: grid;
            gap: 22px;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        }

        .gallery-feed {
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            grid-auto-flow: dense;
            grid-auto-rows: 78px;
            gap: 16px;
        }

        .gallery-feed-item {
            position: relative;
            grid-column: span 4;
            grid-row: span 4;
            min-height: 280px;
            margin: 0;
            overflow: hidden;
            border-radius: 26px;
            background: #2b1825;
            box-shadow: 0 22px 58px rgba(75, 28, 54, 0.16);
        }

        .gallery-feed-item:nth-child(8n + 1),
        .gallery-feed-item:nth-child(8n + 6) {
            grid-column: span 7;
            grid-row: span 5;
        }

        .gallery-feed-item:nth-child(8n + 2),
        .gallery-feed-item:nth-child(8n + 5) {
            grid-column: span 5;
            grid-row: span 3;
        }

        .gallery-feed-item:nth-child(8n + 3),
        .gallery-feed-item:nth-child(8n + 8) {
            grid-column: span 5;
            grid-row: span 4;
        }

        .gallery-feed-item:nth-child(8n + 4),
        .gallery-feed-item:nth-child(8n + 7) {
            grid-column: span 7;
            grid-row: span 3;
        }

        .gallery-feed-media,
        .gallery-feed-media img,
        .gallery-feed-media video {
            width: 100%;
            height: 100%;
        }

        .gallery-feed-media img,
        .gallery-feed-media video {
            display: block;
            object-fit: cover;
            transition: transform 0.45s ease;
        }

        .gallery-feed-item:hover .gallery-feed-media img {
            transform: scale(1.035);
        }

        .gallery-feed-caption {
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 2;
            padding: 58px 20px 18px;
            color: #ffffff;
            background: linear-gradient(180deg, transparent, rgba(20, 8, 16, 0.92));
            pointer-events: none;
        }

        .gallery-feed-item.is-video .gallery-feed-caption {
            bottom: 42px;
        }

        .gallery-feed-caption h2 {
            color: #ffffff;
            font-family: var(--font-body);
            font-size: clamp(1rem, 1.5vw, 1.3rem);
            font-weight: 700;
            line-height: 1.3;
            text-shadow: 0 2px 12px rgba(0,0,0,0.55);
        }

        .gallery-feed-caption p {
            display: -webkit-box;
            margin: 7px 0 0;
            overflow: hidden;
            color: #f4e8ee;
            font-size: 0.9rem;
            line-height: 1.5;
            text-shadow: 0 2px 10px rgba(0,0,0,0.55);
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }

        .gallery-media-kind {
            position: absolute;
            top: 14px;
            right: 14px;
            z-index: 3;
            display: inline-grid;
            width: 36px;
            height: 36px;
            place-items: center;
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 999px;
            background: rgba(36,19,31,0.72);
            color: #ffffff;
            backdrop-filter: blur(10px);
        }

        .card,
        .faq-item,
        .empty {
            position: relative;
            overflow: hidden;
            border-radius: 26px;
            background: rgba(255,255,255,0.96);
            backdrop-filter: blur(18px);
            box-shadow: 0 24px 70px rgba(75, 28, 54, 0.10), inset 0 1px 1px rgba(255,255,255,0.16);
        }

        .card img {
            width: 100%;
            aspect-ratio: 16 / 11;
            object-fit: cover;
            display: block;
            background: #f7dce7;
        }

        .card-body {
            padding: 22px;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            width: fit-content;
            margin-bottom: 12px;
            padding: 7px 10px;
            border-radius: 999px;
            background: #ffe5f1;
            color: var(--brand);
            font-size: 0.78rem;
            font-weight: 800;
        }

        h2 {
            margin: 0;
            color: #4e233b;
            font-family: var(--font-heading);
            font-style: normal;
            font-weight: 400;
            font-size: clamp(1.8rem, 3vw, 2.45rem);
            line-height: 1;
        }

        .card p {
            margin: 14px 0 0;
            color: #60465a;
        }

        .card-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 18px;
            color: #8b3f62;
            font-weight: 800;
        }

        .card-link:hover,
        .card-link:focus-visible {
            color: #5f1d38;
            text-decoration: underline;
            text-underline-offset: 0.2em;
        }

        a:focus-visible,
        button:focus-visible,
        input:focus-visible,
        select:focus-visible,
        summary:focus-visible {
            outline: 3px solid #ffb3d0;
            outline-offset: 3px;
        }

        .faq-list {
            display: grid;
            gap: 14px;
        }

        .faq-item {
            padding: 0;
        }

        .faq-item summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            cursor: pointer;
            padding: 22px 24px;
            color: #4e233b;
            font-weight: 800;
            list-style: none;
        }

        .faq-item summary::-webkit-details-marker {
            display: none;
        }

        .faq-item summary i {
            color: var(--brand);
            transition: transform 0.2s ease;
        }

        .faq-item[open] summary i {
            transform: rotate(45deg);
        }

        .faq-answer {
            padding: 0 24px 24px;
            color: #60465a;
        }

        .empty {
            padding: 30px;
            color: var(--muted);
        }

        .empty strong {
            display: block;
            margin-bottom: 6px;
            color: #4e233b;
            font-size: 1.2rem;
        }

        @media (max-width: 640px) {
            .navbar {
                align-items: flex-start;
                flex-direction: column;
                border-radius: 22px;
            }

            .brand span {
                white-space: normal;
            }

            .hero {
                padding-top: 54px;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .filter-action {
                width: 100%;
            }

            .filter-meta {
                align-items: flex-start;
                flex-direction: column;
            }

            .gallery-feed {
                grid-template-columns: 1fr;
                grid-auto-rows: auto;
            }

            .gallery-feed-item,
            .gallery-feed-item:nth-child(n) {
                grid-column: 1;
                grid-row: auto;
                min-height: 0;
                aspect-ratio: 4 / 5;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        @include('partials.landing-navbar')

        <header class="hero">
            <span class="eyebrow">
                <i class="ri-sparkling-2-line" aria-hidden="true"></i>
                {{ $eyebrow ?? 'Bubba Bloom' }}
            </span>
            <h1>{{ $title ?? 'Bubba Bloom' }}</h1>
            @if(!empty($description))
                <p class="lead">{{ $description }}</p>
            @endif
        </header>

        @php
            $filters = $filters ?? ['search' => '', 'category' => '', 'tag' => ''];
            $filterOptions = $filterOptions ?? [];
            $isFilterable = in_array(($type ?? ''), ['news', 'faq'], true);
            $hasActiveFilters = !empty($filters['search']) || !empty($filters['category']) || !empty($filters['tag']);
            $totalItems = $total ?? count($items ?? []);
        @endphp

        @if($isFilterable)
            <form class="filter-panel" method="GET" action="{{ url()->current() }}">
                <div class="filter-grid">
                    <div class="filter-field">
                        <label for="filter-search">Cari</label>
                        <input
                            id="filter-search"
                            class="filter-control"
                            type="search"
                            name="search"
                            value="{{ $filters['search'] ?? '' }}"
                            placeholder="{{ ($type ?? '') === 'faq' ? 'Cari pertanyaan atau jawaban' : 'Cari judul, isi, atau tag berita' }}"
                        >
                    </div>

                    <div class="filter-field">
                        <label for="filter-category">Kategori</label>
                        <select id="filter-category" class="filter-control" name="category">
                            <option value="">Semua kategori</option>
                            @foreach(($filterOptions['categories'] ?? []) as $categoryOption)
                                @php
                                    $optionValue = $categoryOption['_id'] ?? $categoryOption['value'] ?? '';
                                    $optionLabel = $categoryOption['name'] ?? $categoryOption['label'] ?? $optionValue;
                                @endphp
                                <option value="{{ $optionValue }}" @selected(($filters['category'] ?? '') === $optionValue)>
                                    {{ $optionLabel }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-field">
                        <label for="filter-tag">Tag</label>
                        @if(($type ?? '') === 'faq')
                            <select id="filter-tag" class="filter-control" name="tag">
                                <option value="">Semua tag</option>
                                @foreach(($filterOptions['tags'] ?? []) as $tagOption)
                                    <option value="{{ $tagOption }}" @selected(($filters['tag'] ?? '') === $tagOption)>
                                        {{ $tagOption }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <input
                                id="filter-tag"
                                class="filter-control"
                                type="text"
                                name="tag"
                                value="{{ $filters['tag'] ?? '' }}"
                                placeholder="Contoh: baby massage"
                            >
                        @endif
                    </div>

                    <button class="filter-action" type="submit">
                        <i class="ri-search-line" aria-hidden="true"></i>
                        Filter
                    </button>

                    @if($hasActiveFilters)
                        <a class="filter-action secondary" href="{{ url()->current() }}">
                            <i class="ri-close-line" aria-hidden="true"></i>
                            Reset
                        </a>
                    @else
                        <span></span>
                    @endif
                </div>

                <div class="filter-meta">
                    <span>{{ $totalItems }} hasil ditemukan</span>
                    @if($hasActiveFilters)
                        <span class="active-filter">
                            <i class="ri-filter-3-line" aria-hidden="true"></i>
                            Filter aktif
                        </span>
                    @endif
                </div>
            </form>
        @endif

        @if(($type ?? '') === 'faq')
            <main class="faq-list">
                @forelse($items as $faq)
                    <details class="faq-item">
                        <summary>
                            <span>{{ $faq['question'] ?? 'Pertanyaan' }}</span>
                            <i class="ri-add-line" aria-hidden="true"></i>
                        </summary>
                        <div class="faq-answer">
                            {{ $faq['answer'] ?? '' }}
                        </div>
                    </details>
                @empty
                    <div class="empty">
                        <strong>{{ $emptyTitle ?? 'Data belum tersedia.' }}</strong>
                        <span>{{ $emptyDescription ?? '' }}</span>
                    </div>
                @endforelse
            </main>
        @else
            <main class="{{ ($type ?? '') === 'gallery' ? 'gallery-feed' : 'grid' }}">
                @forelse($items as $item)
                    @if(($type ?? '') === 'news')
                        @php
                            $image = $mediaUrl($item['featured_image']['url'] ?? null);
                            $url = route('landing.news.detail', ['id' => $item['_id'], 'slug' => $item['slug'] ?? null]);
                        @endphp
                        <article class="card">
                            @if($image)
                                <img src="{{ $image }}" alt="{{ $item['featured_image']['alt'] ?? $item['title'] ?? 'Berita Bubba Bloom' }}" loading="lazy" decoding="async">
                            @endif
                            <div class="card-body">
                                <span class="chip">
                                    <i class="ri-newspaper-line" aria-hidden="true"></i>
                                    {{ !empty($item['reading_time']) ? $item['reading_time'] . ' menit baca' : ($item['category_id']['name'] ?? 'Berita') }}
                                </span>
                                <h2>{{ $item['title'] ?? 'Berita' }}</h2>
                                <p>{{ $item['excerpt'] ?? '' }}</p>
                                <a class="card-link" href="{{ $url }}">
                                    <i class="ri-arrow-right-line" aria-hidden="true"></i>
                                    Baca detail
                                </a>
                            </div>
                        </article>
                    @else
                        @php
                            $image = $mediaUrl($item['image'] ?? null);
                            $galleryPath = $image ? (parse_url($image, PHP_URL_PATH) ?? '') : '';
                            $galleryIsVideo = (bool) preg_match('/\.(mp4|webm|ogg|mov|m4v)$/i', $galleryPath);
                        @endphp
                        <figure class="gallery-feed-item{{ $galleryIsVideo ? ' is-video' : '' }}">
                            <div class="gallery-feed-media">
                                @if($galleryIsVideo)
                                    <video controls playsinline preload="metadata" aria-label="{{ $item['title'] ?? 'Video Galeri Bubba Bloom' }}">
                                        <source src="{{ $image }}">
                                        Browser Anda belum mendukung pemutar video.
                                    </video>
                                @else
                                    <img src="{{ $image ?? asset('images/spa-baby-hero.jpg') }}" alt="{{ $item['title'] ?? 'Galeri Bubba Bloom' }}" loading="lazy">
                                @endif
                            </div>
                            <span class="gallery-media-kind" aria-label="{{ $galleryIsVideo ? 'Video' : 'Foto' }}">
                                <i class="{{ $galleryIsVideo ? 'ri-play-fill' : 'ri-image-line' }}" aria-hidden="true"></i>
                            </span>
                            <figcaption class="gallery-feed-caption">
                                <h2>{{ $item['title'] ?? 'Galeri' }}</h2>
                                @if(!empty($item['description']))
                                    <p>{{ $item['description'] }}</p>
                                @endif
                            </figcaption>
                        </figure>
                    @endif
                @empty
                    <div class="empty">
                        <strong>{{ $emptyTitle ?? 'Data belum tersedia.' }}</strong>
                        <span>{{ $emptyDescription ?? '' }}</span>
                    </div>
                @endforelse
            </main>
        @endif
    </div>
    @include('partials.floating-buttons', ['floatingButtons' => $floatingButtons ?? []])
    @include('partials.active-popups', ['activePopups' => $activePopups ?? []])
</body>
</html>
