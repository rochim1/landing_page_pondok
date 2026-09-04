<?php

use App\Services\GraphQLClient;

function landing_instansi_id(): string
{
    return (string) config('landing.instansi_id', '6a98fe7b1ee5fceb0ae0e7fc');
}

function landing_backend_base_url(): string
{
    return preg_replace('/\/graphql\/?$/', '', config('landing.graphql.endpoint', 'http://localhost:8080/graphql'));
}

function landing_media_url(?string $path): ?string
{
    if (!$path) {
        return null;
    }

    if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '//')) {
        return $path;
    }

    if (str_starts_with($path, '/static/')) {
        return rtrim(landing_backend_base_url(), '/') . $path;
    }

    return $path;
}

function landing_instansi_logo(?string $logo = null): string
{
    $backendBaseUrl = landing_backend_base_url();
    $instansiId = landing_instansi_id();

    if ($logo && (str_starts_with($logo, 'http://') || str_starts_with($logo, 'https://') || str_starts_with($logo, '//'))) {
        return $logo;
    }

    if ($logo) {
        return rtrim($backendBaseUrl, '/') . '/' . ltrim($logo, '/');
    }

    $staticRoot = config('landing.backend_static_path', '../presensi_zera_BE/static');
    $isAbsolutePath = str_starts_with($staticRoot, '/')
        || str_starts_with($staticRoot, '\\')
        || preg_match('/^[A-Za-z]:[\\\\\/]/', $staticRoot);
    if (!$isAbsolutePath) {
        $staticRoot = base_path($staticRoot);
    }

    $logoDir = rtrim($staticRoot, '/\\')
        . DIRECTORY_SEPARATOR . $instansiId
        . DIRECTORY_SEPARATOR . 'logo';

    if (is_dir($logoDir)) {
        $files = array_values(array_filter(glob($logoDir . DIRECTORY_SEPARATOR . '*') ?: [], 'is_file'));
        usort($files, fn ($a, $b) => filemtime($b) <=> filemtime($a));

        if (!empty($files)) {
            $fileName = basename($files[0]);
            return rtrim($backendBaseUrl, '/')
                . '/static/' . rawurlencode($instansiId)
                . '/logo/' . rawurlencode($fileName);
        }
    }

    return asset('logo/al-madinatul-kamilah.png');
}

function landing_default_floating_buttons(): array
{
    return [
        [
            'key' => 'whatsapp',
            'type' => 'whatsapp',
            'label' => 'WhatsApp',
            'icon' => 'ri-whatsapp-line',
            'url' => '',
            'phone' => '',
            'message' => 'Assalamu’alaikum, saya ingin memperoleh informasi tentang program dan pendaftaran santri.',
            'enabled' => true,
            'position' => 'bottom_right',
            'order' => 1,
            'bgColor' => '#25D366',
            'textColor' => '#ffffff',
            'openInNewTab' => true,
        ],
        [
            'key' => 'scroll_top',
            'type' => 'scroll_top',
            'label' => 'Ke atas',
            'icon' => 'ri-arrow-up-line',
            'url' => '',
            'phone' => '',
            'message' => '',
            'enabled' => true,
            'position' => 'bottom_right',
            'order' => 2,
            'bgColor' => '#082f55',
            'textColor' => '#ffffff',
            'openInNewTab' => false,
        ],
    ];
}

function landing_website_settings(): array
{
    static $settings = null;
    if (is_array($settings)) {
        return $settings;
    }

    $query = <<<'GRAPHQL'
        query GetLandingWebsiteSetting($instansiId: ID) {
          GetWebsiteSetting(instansi_id: $instansiId) {
            siteName
            tagline
            description
            logo
            favicon
            seo {
              metaTitle
              metaDescription
              metaKeywords
              canonicalUrl
              robotsIndex
              robotsFollow
              ogTitle
              ogDescription
              ogImage
              twitterCard
              twitterTitle
              twitterDescription
              twitterImage
              twitterSite
              favicon
              googleSearchConsoleId
              googleAnalyticsId
              facebookPixelId
              structuredDataEnabled
              schemaType
              organizationName
              organizationUrl
            }
            floating_buttons {
              key
              type
              label
              icon
              url
              phone
              message
              enabled
              position
              order
              bgColor
              textColor
              openInNewTab
            }
          }
        }
    GRAPHQL;

    try {
        $client = new GraphQLClient();
        $data = $client->queryCached(
            'website-settings',
            $query,
            ['instansiId' => landing_instansi_id()]
        );
        $settings = $data['GetWebsiteSetting'] ?? [];
    } catch (\Throwable) {
        $settings = [];
    }

    return $settings;
}

function landing_floating_buttons(): array
{
    $buttons = landing_website_settings()['floating_buttons'] ?? [];
    return !empty($buttons) ? $buttons : landing_default_floating_buttons();
}

function landing_seo_settings(): array
{
    static $seo = null;
    if (is_array($seo)) {
        return $seo;
    }

    $seo = landing_website_settings()['seo'] ?? [];

    return $seo;
}

function landing_active_popups(): array
{
    static $popups = null;
    if (is_array($popups)) {
        return $popups;
    }

    $query = <<<'GRAPHQL'
        query GetLandingActivePopups {
          GetActivePopups {
            _id
            title
            content
            image
            is_use_image_upload
            popup_type
            position
            is_active
            show_on_load
            start_date
            end_date
            button_text
            button_link
            sortOrder
          }
        }
    GRAPHQL;

    try {
        $client = new GraphQLClient();
        $data = $client->queryCached('active-popups', $query);
        $popups = $data['GetActivePopups'] ?? [];
    } catch (\Throwable) {
        $popups = [];
    }

    return is_array($popups) ? $popups : [];
}

function landing_detail_context(array $overrides = []): array
{
    $mediaUrl = fn (?string $path): ?string => landing_media_url($path);
    $settings = landing_website_settings();
    $defaultLogo = landing_instansi_logo();

    return array_merge([
        'brandName' => ($settings['siteName'] ?? null) ?: 'Bubba Bloom - Mom & Baby Care',
        'brandLogo' => !empty($settings['logo']) ? landing_instansi_logo($settings['logo']) : $defaultLogo,
        'siteIcon' => !empty($settings['favicon']) ? landing_instansi_logo($settings['favicon']) : $defaultLogo,
        'mediaUrl' => $mediaUrl,
        'floatingButtons' => landing_floating_buttons(),
        'seo' => landing_seo_settings(),
        'activePopups' => landing_active_popups(),
    ], $overrides);
}
