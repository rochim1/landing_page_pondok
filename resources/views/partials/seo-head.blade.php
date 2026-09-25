@php
    $seoData = is_array($seo ?? null) ? $seo : [];
    $currentBrand = trim((string) ($brandName ?? ($seoData['organizationName'] ?? 'Pondok Pesantren Al-Madinah Al-Kamilah')));
    $hasPageTitle = !empty($title ?? null);
    $isArticle = ($type ?? null) === 'berita';
    $isFilteredPage = request()->filled('search') || request()->filled('category') || request()->filled('tag');
    $adminMetaTitle = trim((string) ($seoData['metaTitle'] ?? ''));
    $pageTitle = $hasPageTitle
        ? (($isArticle && $adminMetaTitle !== '') ? $adminMetaTitle : trim($title . ' | ' . $currentBrand))
        : ($adminMetaTitle ?: $currentBrand);
    $defaultDescription = 'Pondok tahfidz Al-Qur’an yang membina generasi berilmu, beradab, mandiri, dan bermanfaat bagi umat.';
    $adminMetaDescription = trim(strip_tags((string) ($seoData['metaDescription'] ?? '')));
    $pageDescription = trim(strip_tags((string) (
        ($isArticle && $adminMetaDescription !== '')
            ? $adminMetaDescription
            : (($description ?? null) ?: ($adminMetaDescription ?: $defaultDescription))
    )));
    $pageDescription = \Illuminate\Support\Str::limit(preg_replace('/\s+/', ' ', $pageDescription), 160, '');
    $configuredCanonical = trim((string) ($seoData['canonicalUrl'] ?? ''));
    $configuredCanonicalPath = $configuredCanonical !== '' ? (string) parse_url($configuredCanonical, PHP_URL_PATH) : '';
    $hasPageCanonical = $configuredCanonicalPath !== '' && $configuredCanonicalPath !== '/';
    $canonicalBase = $hasPageCanonical ? rtrim(url('/'), '/') : rtrim($configuredCanonical, '/');
    $requestPath = request()->path() === '/' ? '' : '/' . ltrim(request()->path(), '/');
    $canonicalUrl = $hasPageCanonical
        ? $configuredCanonical
        : ($canonicalBase !== '' ? $canonicalBase . $requestPath : url()->current());
    $absoluteUrl = static function ($value) use ($canonicalBase) {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }
        if (preg_match('/^https?:\/\//i', $value)) {
            return $value;
        }

        $base = $canonicalBase !== '' ? $canonicalBase : rtrim(url('/'), '/');
        return $base . '/' . ltrim($value, '/');
    };
    $pageImage = $absoluteUrl(($image ?? null) ?: (($seoData['ogImage'] ?? null) ?: ($brandLogo ?? null)));
    $adminOgTitle = trim((string) ($seoData['ogTitle'] ?? ''));
    $adminOgDescription = trim(strip_tags((string) ($seoData['ogDescription'] ?? '')));
    $openGraphTitle = ($isArticle && $adminOgTitle !== '') ? $adminOgTitle : $pageTitle;
    $openGraphDescription = ($isArticle && $adminOgDescription !== '') ? $adminOgDescription : $pageDescription;
    $twitterTitle = $hasPageTitle
        ? $openGraphTitle
        : (($seoData['twitterTitle'] ?? null) ?: $openGraphTitle);
    $twitterDescription = $hasPageTitle
        ? $openGraphDescription
        : (($seoData['twitterDescription'] ?? null) ?: $openGraphDescription);
    $twitterImage = $absoluteUrl(($seoData['twitterImage'] ?? null) ?: $pageImage);
    $faviconUrl = $absoluteUrl(($siteIcon ?? null) ?: ($brandLogo ?? asset('logo/al-madinatul-kamilah.png')));
    $allowIndex = ($seoData['robotsIndex'] ?? true) && !$isFilteredPage;
    $robots = ($allowIndex ? 'index' : 'noindex') . ', ' . (($seoData['robotsFollow'] ?? true) ? 'follow' : 'nofollow') . ', max-image-preview:large, max-snippet:-1, max-video-preview:-1';
    $schemaType = $seoData['schemaType'] ?? 'EducationalOrganization';
    $organizationName = ($seoData['organizationName'] ?? null) ?: $currentBrand;
    $organizationUrl = rtrim(($seoData['organizationUrl'] ?? null) ?: ($configuredCanonical ?: url('/')), '/');
    $organizationLogo = $absoluteUrl($brandLogo ?? $faviconUrl);
    $organizationId = rtrim($organizationUrl, '/') . '#organization';
    $websiteId = rtrim($organizationUrl, '/') . '#website';
    $webPageType = in_array(($type ?? null), ['news', 'gallery', 'faq'], true) ? 'CollectionPage' : 'WebPage';
    $schemaGraph = [
        [
            '@type' => $schemaType,
            '@id' => $organizationId,
            'name' => $organizationName,
            'url' => $organizationUrl,
            'logo' => ['@type' => 'ImageObject', 'url' => $organizationLogo],
            'image' => $pageImage ?: $organizationLogo,
            'description' => $seoData['metaDescription'] ?? $pageDescription,
        ],
        [
            '@type' => 'WebSite',
            '@id' => $websiteId,
            'url' => $organizationUrl,
            'name' => $organizationName,
            'publisher' => ['@id' => $organizationId],
            'inLanguage' => 'id-ID',
        ],
        [
            '@type' => $webPageType,
            '@id' => $canonicalUrl . '#webpage',
            'url' => $canonicalUrl,
            'name' => $pageTitle,
            'description' => $pageDescription,
            'primaryImageOfPage' => $pageImage ? ['@type' => 'ImageObject', 'url' => $pageImage] : null,
            'isPartOf' => ['@id' => $websiteId],
            'about' => ['@id' => $organizationId],
            'inLanguage' => 'id-ID',
        ],
    ];

    $breadcrumbItems = [['name' => 'Beranda', 'url' => url('/')]];
    if (($type ?? null) === 'news') $breadcrumbItems[] = ['name' => 'Berita', 'url' => route('landing.news.index')];
    if (($type ?? null) === 'gallery') $breadcrumbItems[] = ['name' => 'Galeri', 'url' => route('landing.gallery.index')];
    if (($type ?? null) === 'faq') $breadcrumbItems[] = ['name' => 'FAQ', 'url' => route('landing.faq.index')];
    if ($isArticle) {
        $breadcrumbItems[] = ['name' => 'Berita', 'url' => route('landing.news.index')];
        $breadcrumbItems[] = ['name' => (string) $title, 'url' => $canonicalUrl];
    } elseif (($type ?? null) === 'galeri') {
        $breadcrumbItems[] = ['name' => 'Galeri', 'url' => route('landing.gallery.index')];
        $breadcrumbItems[] = ['name' => (string) $title, 'url' => $canonicalUrl];
    } elseif ($hasPageTitle && !in_array(($type ?? null), ['news', 'gallery', 'faq'], true)) {
        $breadcrumbItems[] = ['name' => (string) $title, 'url' => $canonicalUrl];
    }
    if (count($breadcrumbItems) > 1) {
        $schemaGraph[] = [
            '@type' => 'BreadcrumbList',
            '@id' => $canonicalUrl . '#breadcrumb',
            'itemListElement' => array_map(fn ($item, $index) => [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['url'],
            ], $breadcrumbItems, array_keys($breadcrumbItems)),
        ];
    }
    if ($isArticle) {
        $schemaGraph[] = array_filter([
            '@type' => 'NewsArticle',
            '@id' => $canonicalUrl . '#article',
            'headline' => (string) $title,
            'description' => $pageDescription,
            'image' => $pageImage ? [$pageImage] : null,
            'datePublished' => $publishedAtIso ?? null,
            'dateModified' => $publishedAtIso ?? null,
            'articleSection' => collect($chips ?? [])->first(),
            'keywords' => !empty($tags ?? []) ? implode(', ', $tags) : null,
            'author' => ['@type' => 'Person', 'name' => ($authorName ?? null) ?: $organizationName],
            'publisher' => ['@id' => $organizationId],
            'mainEntityOfPage' => ['@id' => $canonicalUrl . '#webpage'],
            'inLanguage' => 'id-ID',
        ], fn ($value) => $value !== null && $value !== '');
    }
    if (($type ?? null) === 'galeri' && $pageImage) {
        $schemaGraph[] = [
            '@type' => 'ImageObject',
            '@id' => $canonicalUrl . '#image',
            'contentUrl' => $pageImage,
            'url' => $pageImage,
            'name' => (string) $title,
            'caption' => $pageDescription,
            'creditText' => $organizationName,
            'copyrightNotice' => $organizationName,
        ];
    }
    if (($type ?? null) === 'team') {
        $schemaGraph[] = [
            '@type' => 'Person',
            '@id' => $canonicalUrl . '#person',
            'name' => (string) $title,
            'description' => $pageDescription,
            'image' => $pageImage,
            'jobTitle' => $description ?? null,
            'worksFor' => ['@id' => $organizationId],
        ];
    }
    if (($type ?? null) === 'event') {
        $schemaGraph[] = [
            '@type' => 'Event',
            '@id' => $canonicalUrl . '#event',
            'name' => (string) $title,
            'description' => $pageDescription,
            'image' => $pageImage ? [$pageImage] : null,
            'organizer' => ['@id' => $organizationId],
            'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
        ];
    }
    if (($type ?? null) === 'faq' && !empty($items ?? [])) {
        $schemaGraph[] = [
            '@type' => 'FAQPage',
            '@id' => $canonicalUrl . '#faq',
            'mainEntity' => array_values(array_map(fn ($item) => [
                '@type' => 'Question',
                'name' => strip_tags((string) ($item['question'] ?? '')),
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags((string) ($item['answer'] ?? ''))],
            ], array_filter($items, fn ($item) => !empty($item['question']) && !empty($item['answer'])))),
        ];
    }
    $schemaGraph = array_map(fn ($node) => array_filter($node, fn ($value) => $value !== null && $value !== ''), $schemaGraph);
    $schema = ['@context' => 'https://schema.org', '@graph' => $schemaGraph];
    $metaKeywords = $seoData['metaKeywords'] ?? null;
    if (is_array($metaKeywords)) $metaKeywords = implode(', ', array_filter($metaKeywords));
    $gaId = preg_match('/^G-[A-Z0-9]+$/i', (string) ($seoData['googleAnalyticsId'] ?? '')) ? $seoData['googleAnalyticsId'] : null;
    $pixelId = preg_match('/^\d+$/', (string) ($seoData['facebookPixelId'] ?? '')) ? $seoData['facebookPixelId'] : null;
@endphp

<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $pageDescription }}">
@if(!empty($metaKeywords))
    <meta name="keywords" content="{{ $metaKeywords }}">
@endif
<meta name="robots" content="{{ $robots }}">
<meta name="author" content="{{ ($authorName ?? null) ?: $organizationName }}">
<meta name="theme-color" content="#07566a">
<meta name="referrer" content="strict-origin-when-cross-origin">
<meta name="format-detection" content="telephone=no">
<link rel="canonical" href="{{ $canonicalUrl }}">
<link rel="icon" href="{{ $faviconUrl }}">
<link rel="apple-touch-icon" href="{{ $faviconUrl }}">

<meta property="og:type" content="{{ ($type ?? null) === 'berita' ? 'article' : 'website' }}">
<meta property="og:locale" content="id_ID">
<meta property="og:site_name" content="{{ $currentBrand }}">
<meta property="og:title" content="{{ $openGraphTitle }}">
<meta property="og:description" content="{{ $openGraphDescription }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
@if($pageImage)
    <meta property="og:image" content="{{ $pageImage }}">
    <meta property="og:image:secure_url" content="{{ $pageImage }}">
    <meta property="og:image:alt" content="{{ $openGraphTitle }}">
@endif
@if($isArticle)
    @if(!empty($publishedAtIso))<meta property="article:published_time" content="{{ $publishedAtIso }}">@endif
    @if(!empty($authorName))<meta property="article:author" content="{{ $authorName }}">@endif
    @foreach(($tags ?? []) as $articleTag)<meta property="article:tag" content="{{ $articleTag }}">@endforeach
@endif

<meta name="twitter:card" content="{{ $seoData['twitterCard'] ?? 'summary_large_image' }}">
<meta name="twitter:title" content="{{ $twitterTitle }}">
<meta name="twitter:description" content="{{ $twitterDescription }}">
@if($twitterImage)
    <meta name="twitter:image" content="{{ $twitterImage }}">
    <meta name="twitter:image:alt" content="{{ $twitterTitle }}">
@endif
@if(!empty($seoData['twitterSite']))
    <meta name="twitter:site" content="{{ $seoData['twitterSite'] }}">
@endif
@if(!empty($seoData['googleSearchConsoleId']))
    <meta name="google-site-verification" content="{{ $seoData['googleSearchConsoleId'] }}">
@endif

@if(($seoData['structuredDataEnabled'] ?? true) === true)
    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
@endif

@if($gaId)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', @json($gaId));
    </script>
@endif

@if($pixelId)
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
        n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}
        (window, document,'script','https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', @json($pixelId));
        fbq('track', 'PageView');
    </script>
@endif
