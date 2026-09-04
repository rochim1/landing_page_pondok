@php
    $seoData = is_array($seo ?? null) ? $seo : [];
    $currentBrand = $brandName ?? ($seoData['organizationName'] ?? 'Pondok Pesantren Tahfidzul Qur’an Al-Madinatul Kamilah');
    $hasPageTitle = !empty($title ?? null);
    $pageTitle = $hasPageTitle
        ? trim($title . ' - ' . $currentBrand)
        : (($seoData['metaTitle'] ?? null) ?: $currentBrand);
    $defaultDescription = 'Pondok tahfidz Al-Qur’an yang membina generasi berilmu, beradab, mandiri, dan bermanfaat bagi umat.';
    $pageDescription = trim(strip_tags((string) (($description ?? null) ?: (($seoData['metaDescription'] ?? null) ?: $defaultDescription))));
    $configuredCanonical = trim((string) ($seoData['canonicalUrl'] ?? ''));
    $canonicalBase = rtrim($configuredCanonical, '/');
    $requestPath = request()->path() === '/' ? '' : '/' . ltrim(request()->path(), '/');
    $canonicalUrl = $canonicalBase !== '' ? $canonicalBase . $requestPath : url()->current();
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
    $openGraphTitle = $hasPageTitle
        ? $pageTitle
        : (($seoData['ogTitle'] ?? null) ?: $pageTitle);
    $openGraphDescription = $hasPageTitle
        ? $pageDescription
        : (($seoData['ogDescription'] ?? null) ?: $pageDescription);
    $twitterTitle = $hasPageTitle
        ? $openGraphTitle
        : (($seoData['twitterTitle'] ?? null) ?: $openGraphTitle);
    $twitterDescription = $hasPageTitle
        ? $openGraphDescription
        : (($seoData['twitterDescription'] ?? null) ?: $openGraphDescription);
    $twitterImage = $absoluteUrl(($seoData['twitterImage'] ?? null) ?: $pageImage);
    $faviconUrl = $absoluteUrl(($siteIcon ?? null) ?: ($brandLogo ?? asset('logo/al-madinatul-kamilah.png')));
    $robots = (($seoData['robotsIndex'] ?? true) ? 'index' : 'noindex') . ', ' . (($seoData['robotsFollow'] ?? true) ? 'follow' : 'nofollow');
    $schemaType = $seoData['schemaType'] ?? 'Organization';
    $organizationName = ($seoData['organizationName'] ?? null) ?: $currentBrand;
    $organizationUrl = rtrim(($seoData['organizationUrl'] ?? null) ?: ($configuredCanonical ?: url('/')), '/');
    $organizationLogo = $absoluteUrl($brandLogo ?? $faviconUrl);
    $schemaGraph = [
        [
            '@type' => $schemaType,
            '@id' => rtrim($organizationUrl, '/') . '#organization',
            'name' => $organizationName,
            'url' => $organizationUrl,
            'logo' => $organizationLogo,
            'description' => $seoData['metaDescription'] ?? $pageDescription,
        ],
        [
            '@type' => ($type ?? null) === 'berita' ? 'Article' : 'WebPage',
            '@id' => $canonicalUrl . '#webpage',
            'url' => $canonicalUrl,
            'name' => $pageTitle,
            'description' => $pageDescription,
            'image' => $pageImage,
            'isPartOf' => ['@id' => rtrim($organizationUrl, '/') . '#organization'],
        ],
    ];
    $schema = ['@context' => 'https://schema.org', '@graph' => $schemaGraph];
    $gaId = preg_match('/^G-[A-Z0-9]+$/i', (string) ($seoData['googleAnalyticsId'] ?? '')) ? $seoData['googleAnalyticsId'] : null;
    $pixelId = preg_match('/^\d+$/', (string) ($seoData['facebookPixelId'] ?? '')) ? $seoData['facebookPixelId'] : null;
@endphp

<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $pageDescription }}">
@if(!empty($seoData['metaKeywords']))
    <meta name="keywords" content="{{ $seoData['metaKeywords'] }}">
@endif
<meta name="robots" content="{{ $robots }}">
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
    <meta property="og:image:alt" content="{{ $openGraphTitle }}">
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
