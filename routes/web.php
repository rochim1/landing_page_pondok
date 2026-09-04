<?php

use Illuminate\Support\Facades\Route;
use App\Services\GraphQLClient;


Route::get('/subscription-expired', function () {
    return view('subscription-expired', [
        'paymentUrl' => config('landing.payment_url', 'https://app.pantoo.id/hrms/billing'),
        'brandName' => config('app.name', 'Pantoo'),
    ]);
})->name('landing.subscription.expired');

Route::get('/robots.txt', function () {
    $seo = landing_seo_settings();
    $baseUrl = rtrim(($seo['canonicalUrl'] ?? null) ?: url('/'), '/');
    $lines = ['User-agent: *'];
    $lines[] = ($seo['robotsIndex'] ?? true) ? 'Allow: /' : 'Disallow: /';
    $lines[] = 'Sitemap: ' . $baseUrl . '/sitemap.xml';

    return response(implode("\n", $lines) . "\n", 200)
        ->header('Content-Type', 'text/plain; charset=UTF-8');
})->name('landing.robots');

Route::get('/sitemap.xml', function () {
    $seo = landing_seo_settings();
    $baseUrl = rtrim(($seo['canonicalUrl'] ?? null) ?: url('/'), '/');
    $paths = ['/', '/berita', '/galeri', '/faq'];
    $lastModified = now()->toAtomString();
    $urls = array_map(fn ($path) => [
        'loc' => $path === '/' ? $baseUrl : $baseUrl . $path,
        'lastmod' => $lastModified,
        'changefreq' => $path === '/' ? 'weekly' : 'daily',
        'priority' => $path === '/' ? '1.0' : '0.8',
    ], $paths);

    $xml = view('partials.sitemap', ['urls' => $urls])->render();
    return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
})->name('landing.sitemap');

Route::get('/', function () {
    $client = new GraphQLClient();

    $query = <<<'GRAPHQL'
        query GetLandingPageContent(
          $superiorityFilter: SuperiorityFilterInput
          $whyChooseUsFilter: WhyChooseUsFilterInput
          $heroFilter: HeroSectionFilter
          $aboutFilter: AboutUsFilterInput
          $contactFilter: ContactUsFilterInput
          $eventFilter: EventFilter
          $newsFilter: NewsFilter
          $galleryFilter: GalleryFilter
          $faqFilter: FilterFaq
          $teamFilter: OurTeamFilter
          $testimoniFilter: GlobalTestimoniFilter
          $instansiId: ID
        ) {
          GetAllHeroSection(filter: $heroFilter) {
            heroSections {
              _id
              slug
              order
              badge { emoji text bgColor textColor }
              heading { part1 part2 }
              description
              contact { name phone email whatsapp }
              buttons { text link type icon }
              background { image overlay position size }
              layout { type mascot { image width alignment } }
              stats { value label suffixLabel }
            }
            info_page { count }
          }
          services {
            id
            title
            description
            icon
            image
            features
            price
            isActive
            order
          }
          GetAllPortfolio(
            filter: { isActive: true }
            sorting: { field: "order", sort: "ASC" }
            pagination: { page: 1, limit: 9 }
          ) {
            data {
              _id
              title
              description
              category
              images
              url
              technologies
              isActive
              order
            }
            total
          }
          GetAllSuperiorities(filter: $superiorityFilter, pagination: { page: 0, limit: 3 }) {
            superiorities {
              title
              description
              class_icon
            }
            info_page { count }
          }
          GetAllWhyChooseUs(filter: $whyChooseUsFilter, pagination: { page: 0, limit: 6 }) {
            whyChooseUs {
              _id
              title
              description
              class_icon
            }
            info_page { count }
          }
          GetAllEvent(filter: $eventFilter, pagination: { page: 0, limit: 3 }) {
            events {
              _id
              title
              description
              badge { label textColor backgroundColor }
              cta { label url }
              media { thumbnail { type url } }
              highlights { label icon value }
              countdown { label ends_at enabled }
            }
            info_page { count }
          }
          GetAllNews(filter: $newsFilter, pagination: { page: 0, limit: 3 }) {
            news {
              _id
              title
              slug
              excerpt
              featured_image { url alt caption }
              published_at
              reading_time
              tags
            }
            info_page { count }
          }
          GetAllGallery(filter: $galleryFilter, pagination: { page: 1, limit: 8 }) {
            data {
              _id
              title
              description
              image
              isActive
            }
            total
          }
          GetFaqs(filter: $faqFilter, pagination: { page: 1, limit: 6 }) {
            faqs {
              _id
              question
              answer
              category
            }
            info_page { count }
          }
          getOurTeam(filter: $teamFilter, pagination: { page: 0, limit: 4 }) {
            ourTeams {
              _id
              profileImage { url alt }
              contact { email phone }
              currentContent {
                name
                position
                department
                bio
              }
            }
            info_page { count }
          }
          GetAllGlobalTestimonis(filter: $testimoniFilter, pagination: { page: 0, limit: 3 }) {
            testimonis {
              _id
              author_name
              author_position
              author_avatar
              content
              university
            }
            info_page { count }
          }
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
            footer {
              enabled
              showLogo
              showTagline
              showDescription
              description
              showNavigation
              navigationTitle
              showContact
              contactTitle
              showAddress
              showPhone
              showEmail
              showSocialMedia
              showMapLink
              links {
                key
                label
                url
                group
                enabled
                openInNewTab
                order
              }
              copyrightText
              additionalText
              backgroundColor
              textColor
              headingColor
              linkColor
            }
          }
          GetOneAboutUs(filter: $aboutFilter) {
            companyInfo {
              name
              fullName
              tagline
              description
            }
            story {
              badge
              title
              content { paragraph text }
              image { url alt caption description }
            }
            heroSection {
              titlePrefix
              highlightedTitle
              subtitle
              badge
              backgroundImage
              showBackgroundEffects
            }
            statistics {
              value
              label
              description
              color
              icon
            }
            callToAction {
              title
              description
              buttons { text type link icon }
            }
          }
          GetOneContactUs(filter: $contactFilter) {
            address { fullAddress googleMapsLink }
            phones { type number displayNumber isWhatsapp whatsappUrl }
            emails { type email }
            socialMedia { platform label url icon }
          }
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


    $newsGalleryQuery = <<<'GRAPHQL'
        query GetLandingPageNewsGallery(
          $newsFilter: NewsFilter
          $galleryFilter: GalleryFilter
        ) {
          GetAllNews(filter: $newsFilter, pagination: { page: 0, limit: 3 }) {
            news {
              _id
              title
              slug
              excerpt
              featured_image { url alt caption }
              published_at
              reading_time
              tags
            }
            info_page { count }
          }
          GetAllGallery(filter: $galleryFilter, pagination: { page: 1, limit: 6 }) {
            data {
              _id
              title
              description
              image
              isActive
            }
            total
          }
        }
    GRAPHQL;

    $instansiId = landing_instansi_id();
    $variables = [
        'aboutFilter' => [
            'lang' => 'id',
            'status' => 'active',
            'instansi_id' => $instansiId,
        ],
        'contactFilter' => [
            'lang' => 'id',
            'status' => 'active',
            'instansi_id' => $instansiId,
        ],
        'superiorityFilter' => [
            'lang' => 'id',
            'status' => 'active',
            'instansi_id' => $instansiId,
        ],
        'whyChooseUsFilter' => [
            'lang' => 'id',
            'status' => 'active',
            'instansi_id' => $instansiId,
        ],
        'heroFilter' => [
            'lang' => 'id',
            'status' => 'active',
            'instansi_id' => $instansiId,
        ],
        'eventFilter' => [
            'status' => 'published',
            'visibility' => 'public',
        ],
        'newsFilter' => [
            'status' => 'published',
            'visibility' => 'public',
            'instansi_id' => $instansiId,
        ],
        'galleryFilter' => [
            'isActive' => true,
        ],
        'faqFilter' => [
            'lang' => 'id',
            'status' => 'active',
            'isActive' => true,
            'instansi_id' => $instansiId,
        ],
        'teamFilter' => [
            'lang' => 'IND',
            'status' => 'active',
            'isActive' => true,
            'instansi_id' => $instansiId,
        ],
        'testimoniFilter' => [
            'status' => 'approved',
            'is_published' => true,
            'instansi_id' => $instansiId,
        ],
        'instansiId' => $instansiId,
    ];

    try {
        $data = $client->queryCached('home-main', $query, $variables);
        $superiorities = $data['GetAllSuperiorities']['superiorities'] ?? [];
        $whyChooseUs = $data['GetAllWhyChooseUs']['whyChooseUs'] ?? [];
        $events = $data['GetAllEvent']['events'] ?? [];
        $news = $data['GetAllNews']['news'] ?? [];
        $galleryItems = $data['GetAllGallery']['data'] ?? [];
        $faqs = $data['GetFaqs']['faqs'] ?? [];
        $teamMembers = $data['getOurTeam']['ourTeams'] ?? [];
        $testimonials = $data['GetAllGlobalTestimonis']['testimonis'] ?? [];
        $heroSections = $data['GetAllHeroSection']['heroSections'] ?? [];
        $websiteSetting = $data['GetWebsiteSetting'] ?? [];
        $aboutData = $data['GetOneAboutUs'] ?? null;
        $contactData = $data['GetOneContactUs'] ?? null;
        $activePopups = $data['GetActivePopups'] ?? [];
        $floatingButtons = $websiteSetting['floating_buttons'] ?? landing_default_floating_buttons();
        $seo = $websiteSetting['seo'] ?? [];
        $services = array_values(array_filter($data['services'] ?? [], fn ($service) => ($service['isActive'] ?? true) !== false));
        $portfolios = array_values(array_filter($data['GetAllPortfolio']['data'] ?? [], fn ($portfolio) => ($portfolio['isActive'] ?? true) !== false));
    } catch (\Exception $e) {
        $superiorities = [];
        $whyChooseUs = [];
        $events = [];
        $news = [];
        $galleryItems = [];
        $faqs = [];
        $teamMembers = [];
        $testimonials = [];
        $heroSections = [];
        $websiteSetting = [];
        $aboutData = null;
        $contactData = null;
        $activePopups = [];
        $floatingButtons = landing_default_floating_buttons();
        $seo = [];
        $services = [];
        $portfolios = [];
    }

    if (empty($news) || empty($galleryItems)) {
        try {
            $newsGalleryResponse = $client->queryCached(
                'home-news-gallery',
                $newsGalleryQuery,
                [
                    'newsFilter' => $variables['newsFilter'],
                    'galleryFilter' => $variables['galleryFilter'],
                ]
            );

            if (empty($news)) {
                $news = $newsGalleryResponse['GetAllNews']['news'] ?? [];
            }

            if (empty($galleryItems)) {
                $galleryItems = $newsGalleryResponse['GetAllGallery']['data'] ?? [];
            }
        } catch (\Exception $e) {
            $news = $news ?? [];
            $galleryItems = $galleryItems ?? [];
        }
    }

    $hero = null;
    if (!empty($heroSections)) {
        $hero = $heroSections[0];
    }

    if (!$hero && $aboutData && !empty($aboutData['heroSection'])) {
        $buttons = [];
        if (!empty($aboutData['callToAction']['buttons']) && is_array($aboutData['callToAction']['buttons'])) {
            foreach ($aboutData['callToAction']['buttons'] as $button) {
                $buttons[] = [
                    'text' => $button['text'] ?? 'Pelajari Lebih Lanjut',
                    'link' => $button['link'] ?? '#contact',
                    'type' => $button['type'] ?? 'primary',
                    'icon' => $button['icon'] ?? null,
                ];
            }
        }

        $hero = [
            'badge' => ['emoji' => '📖', 'text' => $aboutData['heroSection']['badge'] ?? 'Pondok Tahfidz Al-Qur’an', 'bgColor' => '#e8f9fc', 'textColor' => '#082f55'],
            'heading' => ['part1' => $aboutData['heroSection']['titlePrefix'] ?? 'Dekat dengan Al-Qur’an', 'part2' => $aboutData['heroSection']['highlightedTitle'] ?? 'Mulia dalam Kehidupan'],
            'description' => $aboutData['heroSection']['subtitle'] ?? $aboutData['companyInfo']['tagline'] ?? 'Pendidikan tahfidz yang memadukan hafalan Al-Qur’an, pemahaman agama, adab, dan kemandirian dalam lingkungan pondok yang hangat.',
            'buttons' => !empty($buttons) ? $buttons : [
                ['text' => 'Informasi Pendaftaran', 'link' => '#contact', 'type' => 'primary'],
                ['text' => 'Lihat Program', 'link' => '#program', 'type' => 'secondary'],
            ],
            'background' => ['image' => $aboutData['heroSection']['backgroundImage'] ?? '/images/hero-mom-baby-care.jpg', 'overlay' => 'rgba(255, 255, 255, 0.65)', 'position' => 'center', 'size' => 'cover'],
            'layout' => ['type' => 'center', 'mascot' => ['image' => '', 'width' => 120, 'alignment' => 'center']],
            'stats' => is_array($aboutData['statistics']) ? $aboutData['statistics'] : [],
            'contact' => [
                'name' => $contactData['phones'][0]['type'] ?? 'Admin Pondok',
                'phone' => $contactData['phones'][0]['number'] ?? '',
                'whatsapp' => $contactData['phones'][0]['whatsappUrl'] ?? '',
                'email' => $contactData['emails'][0]['email'] ?? '',
            ],
        ];
    }

    if (!$hero) {
        $hero = [
            'badge' => ['emoji' => '📖', 'text' => 'Pondok Tahfidz Al-Qur’an', 'bgColor' => '#e8f9fc', 'textColor' => '#082f55'],
            'heading' => ['part1' => 'Dekat dengan Al-Qur’an', 'part2' => 'Mulia dalam Kehidupan'],
            'description' => 'Pendidikan tahfidz yang memadukan hafalan Al-Qur’an, pemahaman agama, adab, dan kemandirian dalam lingkungan pondok yang hangat.',
            'buttons' => [
                ['text' => 'Informasi Pendaftaran', 'link' => '#contact', 'type' => 'primary'],
                ['text' => 'Lihat Program', 'link' => '#program', 'type' => 'secondary'],
            ],
            'background' => ['image' => '/images/hero-mom-baby-care.jpg', 'overlay' => 'rgba(255, 255, 255, 0.65)', 'position' => 'center', 'size' => 'cover'],
            'layout' => ['type' => 'center', 'mascot' => ['image' => '', 'width' => 120, 'alignment' => 'center']],
            'stats' => [
                ['value' => 30, 'label' => 'Target Hafalan', 'suffixLabel' => ' Juz'],
                ['value' => 24, 'label' => 'Lingkungan Qur’ani', 'suffixLabel' => ' Jam'],
            ],
            'contact' => [
                'name' => 'Admin Pondok',
                'phone' => '',
                'whatsapp' => '',
                'email' => '',
            ],
        ];
    }

    $backendBaseUrl = landing_backend_base_url();
    $resolveMediaUrl = function (?string $path) use ($backendBaseUrl): ?string {
        if (!$path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '//')) {
            return $path;
        }

        if (str_starts_with($path, '/static/')) {
            return rtrim($backendBaseUrl, '/') . $path;
        }

        return $path;
    };

    $defaultBrandLogo = landing_instansi_logo();
    $brandName = ($websiteSetting['siteName'] ?? null)
        ?: ($aboutData['companyInfo']['name'] ?? 'Pondok Pesantren Tahfidzul Qur’an Al-Madinatul Kamilah');
    $brandLogo = !empty($websiteSetting['logo'])
        ? landing_instansi_logo($websiteSetting['logo'])
        : $defaultBrandLogo;
    $siteIcon = !empty($websiteSetting['favicon'])
        ? landing_instansi_logo($websiteSetting['favicon'])
        : $defaultBrandLogo;

    return view('welcome', [
        'hero' => $hero,
        'about' => $aboutData,
        'contact' => $contactData,
        'services' => $services,
        'portfolios' => $portfolios,
        'superiorities' => $superiorities,
        'whyChooseUs' => $whyChooseUs,
        'events' => $events,
        'news' => $news,
        'galleryItems' => $galleryItems,
        'faqs' => $faqs,
        'teamMembers' => $teamMembers,
        'testimonials' => $testimonials,
        'brandName' => $brandName,
        'brandLogo' => $brandLogo,
        'brandTagline' => $websiteSetting['tagline'] ?? ($aboutData['companyInfo']['tagline'] ?? ''),
        'websiteDescription' => $websiteSetting['description'] ?? ($aboutData['companyInfo']['description'] ?? ''),
        'siteIcon' => $siteIcon,
        'mediaUrl' => $resolveMediaUrl,
        'floatingButtons' => $floatingButtons,
        'footer' => $websiteSetting['footer'] ?? [],
        'seo' => $seo,
        'activePopups' => is_array($activePopups) ? $activePopups : [],
    ]);
});

Route::get('/berita', function () {
    $client = new GraphQLClient();
    $instansiId = landing_instansi_id();
    $search = trim((string) request('search', ''));
    $category = trim((string) request('category', ''));
    $tag = trim((string) request('tag', ''));
    if ($category !== '' && !preg_match('/^[a-f0-9]{24}$/i', $category)) {
        $category = '';
    }

    $query = <<<'GRAPHQL'
        query GetLandingNewsIndex($newsFilter: NewsFilter, $categoryFilter: NewsCategoryFilter) {
          GetAllNews(filter: $newsFilter, pagination: { page: 0, limit: 24 }) {
            news {
              _id
              title
              slug
              excerpt
              featured_image { url alt caption }
              category_id { name slug }
              published_at
              reading_time
              tags
            }
            info_page { count }
          }
          GetAllNewsCategory(filter: $categoryFilter, sorting: { order: asc }, pagination: { page: 0, limit: 50 }) {
            categories {
              _id
              name
              slug
            }
          }
        }
    GRAPHQL;

    $newsFilter = [
        'status' => 'published',
        'visibility' => 'public',
        'instansi_id' => $instansiId,
    ];

    if ($search !== '') {
        $newsFilter['search'] = $search;
    }

    if ($category !== '') {
        $newsFilter['category_id'] = $category;
    }

    if ($tag !== '') {
        $newsFilter['tags'] = [$tag];
    }

    try {
        $data = $client->queryCached(
            'news-list',
            $query,
            [
                'newsFilter' => $newsFilter,
                'categoryFilter' => [
                    'status' => 'active',
                    'instansi_id' => $instansiId,
                ],
            ],
            null,
            config('landing.cache.listing_ttl', 30)
        );
        $items = $data['GetAllNews']['news'] ?? [];
        $categories = $data['GetAllNewsCategory']['categories'] ?? [];
        $total = $data['GetAllNews']['info_page'][0]['count'] ?? count($items);
    } catch (\Exception $e) {
        $items = [];
        $categories = [];
        $total = 0;
    }

    return view('listing', landing_detail_context([
        'type' => 'news',
        'eyebrow' => 'Berita',
        'title' => 'Berita & Artikel',
        'description' => 'Kumpulan artikel, tips, dan kabar terbaru seputar perawatan ibu, bayi, dan anak.',
        'items' => $items,
        'total' => $total,
        'filters' => [
            'search' => $search,
            'category' => $category,
            'tag' => $tag,
        ],
        'filterOptions' => [
            'categories' => $categories,
        ],
        'emptyTitle' => ($search || $category || $tag) ? 'Tidak ada berita yang cocok.' : 'Belum ada berita.',
        'emptyDescription' => ($search || $category || $tag) ? 'Coba ubah kata kunci, kategori, atau tag filter.' : 'Artikel published-public dari admin akan tampil di halaman ini.',
        'backUrl' => url('/'),
        'backLabel' => 'Beranda',
    ]));
})->name('landing.news.index');

Route::get('/galeri', function () {
    $client = new GraphQLClient();
    $query = <<<'GRAPHQL'
        query GetLandingGalleryIndex($galleryFilter: GalleryFilter) {
          GetAllGallery(filter: $galleryFilter, sorting: { field: "createdAt", sort: "DESC" }, pagination: { page: 1, limit: 24 }) {
            data {
              _id
              title
              description
              image
              category_id { name description }
              isActive
            }
            total
          }
        }
    GRAPHQL;

    try {
        $data = $client->queryCached(
            'gallery-list',
            $query,
            ['galleryFilter' => ['isActive' => true]],
            null,
            config('landing.cache.listing_ttl', 30)
        );
        $items = $data['GetAllGallery']['data'] ?? [];
    } catch (\Exception $e) {
        $items = [];
    }

    return view('listing', landing_detail_context([
        'type' => 'gallery',
        'eyebrow' => 'Galeri',
        'title' => 'Koleksi Foto & Video',
        'description' => 'Dokumentasi kegiatan belajar, ibadah, dan kebersamaan santri Al-Madinatul Kamilah.',
        'items' => $items,
        'emptyTitle' => 'Belum ada media galeri.',
        'emptyDescription' => 'Foto dan video aktif dari modul Galeri akan tampil di halaman ini.',
        'backUrl' => url('/'),
        'backLabel' => 'Beranda',
    ]));
})->name('landing.gallery.index');

Route::get('/faq', function () {
    $client = new GraphQLClient();
    $instansiId = landing_instansi_id();
    $search = trim((string) request('search', ''));
    $category = trim((string) request('category', ''));
    $tag = trim((string) request('tag', ''));
    $faqCategories = [];

    $query = <<<'GRAPHQL'
        query GetLandingFaqIndex($faqFilter: FilterFaq, $instansiId: ID) {
          GetFaqs(filter: $faqFilter, sorting: { sortOrder: asc }, pagination: { page: 1, limit: 50 }) {
            faqs {
              _id
              question
              answer
              category
              tags
            }
            info_page { count }
          }
          GetAvailableTagsFaq(instansi_id: $instansiId)
          GetFaqCategories(filter: { lang: "id", isActive: true }, pagination: { page: 1, limit: 100 }) {
            categories {
              name
              slug
            }
          }
        }
    GRAPHQL;

    $faqFilter = [
        'lang' => 'id',
        'status' => 'active',
        'isActive' => true,
        'instansi_id' => $instansiId,
    ];

    if ($search !== '') {
        $faqFilter['searchTerm'] = $search;
    }

    if ($category !== '') {
        $faqFilter['category'] = $category;
    }

    if ($tag !== '') {
        $faqFilter['tags'] = $tag;
    }

    try {
        $data = $client->queryCached(
            'faq-list',
            $query,
            [
                'faqFilter' => $faqFilter,
                'instansiId' => $instansiId,
            ],
            null,
            config('landing.cache.listing_ttl', 30)
        );
        $items = $data['GetFaqs']['faqs'] ?? [];
        $tags = $data['GetAvailableTagsFaq'] ?? [];
        $faqCategories = array_map(
            static fn (array $item): array => [
                'value' => $item['slug'] ?? '',
                'label' => $item['name'] ?? ($item['slug'] ?? ''),
            ],
            $data['GetFaqCategories']['categories'] ?? []
        );
        $total = $data['GetFaqs']['info_page'][0]['count'] ?? count($items);
    } catch (\Exception $e) {
        $items = [];
        $tags = [];
        $total = 0;
    }

    return view('listing', landing_detail_context([
        'type' => 'faq',
        'eyebrow' => 'FAQ',
        'title' => 'Pertanyaan yang Sering Diajukan',
        'description' => 'Jawaban ringkas untuk pertanyaan umum tentang program dan pendaftaran pondok.',
        'items' => $items,
        'total' => $total,
        'filters' => [
            'search' => $search,
            'category' => $category,
            'tag' => $tag,
        ],
        'filterOptions' => [
            'categories' => $faqCategories,
            'tags' => $tags,
        ],
        'emptyTitle' => ($search || $category || $tag) ? 'Tidak ada FAQ yang cocok.' : 'Belum ada FAQ.',
        'emptyDescription' => ($search || $category || $tag) ? 'Coba ubah kata kunci, kategori, atau tag filter.' : 'FAQ aktif dari admin akan tampil di halaman ini.',
        'backUrl' => url('/'),
        'backLabel' => 'Beranda',
    ]));
})->name('landing.faq.index');

Route::get('/event/{id}/{slug?}', function (string $id) {
    $client = new GraphQLClient();
    $query = <<<'GRAPHQL'
        query GetLandingEventDetail($id: ID!) {
          GetOneEvent(id: $id) {
            _id
            type
            title
            description
            badge { label textColor backgroundColor }
            cta { label url }
            countdown { label ends_at enabled }
            media { thumbnail { type url } }
            highlights { label icon value }
            published_at
          }
        }
    GRAPHQL;

    try {
        $event = $client->queryCached(
            'event-detail',
            $query,
            ['id' => $id],
            null,
            config('landing.cache.detail_ttl', 60)
        )['GetOneEvent'] ?? null;
    } catch (\Exception $e) {
        $event = null;
    }

    abort_if(!$event, 404, 'Event tidak ditemukan');

    $image = landing_media_url($event['media']['thumbnail']['url'] ?? null);
    $chips = array_filter([
        $event['badge']['label'] ?? null,
        $event['type'] ?? null,
        !empty($event['published_at']) ? 'Dipublikasikan' : null,
    ]);

    return view('detail', landing_detail_context([
        'type' => 'event',
        'eyebrow' => 'Event & Promo',
        'title' => $event['title'] ?? 'Event Bubba Bloom',
        'description' => $event['description'] ?? '',
        'content' => $event['description'] ?? '',
        'image' => $image,
        'chips' => $chips,
        'highlights' => $event['highlights'] ?? [],
        'cta' => $event['cta'] ?? null,
        'backUrl' => url('/#events'),
        'backLabel' => 'Kembali ke Event',
    ]));
})->name('landing.event.detail');

Route::get('/berita/{id}/{slug?}', function (string $id) {
    $client = new GraphQLClient();
    $query = <<<'GRAPHQL'
        query GetLandingNewsDetail($id: ID!) {
          GetOneNews(_id: $id) {
            _id
            title
            slug
            excerpt
            content
            featured_image { url alt caption }
            media_gallery { url alt caption }
            category_id { name slug }
            tags
            reading_time
            published_at
          }
        }
    GRAPHQL;

    try {
        $article = $client->queryCached(
            'news-detail',
            $query,
            ['id' => $id],
            null,
            config('landing.cache.detail_ttl', 60)
        )['GetOneNews'] ?? null;
    } catch (\Exception $e) {
        $article = null;
    }

    abort_if(!$article, 404, 'Berita tidak ditemukan');

    $image = landing_media_url($article['featured_image']['url'] ?? null);
    $chips = array_filter([
        $article['category_id']['name'] ?? null,
        !empty($article['reading_time']) ? $article['reading_time'] . ' menit baca' : null,
    ]);

    return view('detail', landing_detail_context([
        'type' => 'berita',
        'eyebrow' => 'Berita',
        'title' => $article['title'] ?? 'Berita Bubba Bloom',
        'description' => $article['excerpt'] ?? '',
        'contentHtml' => $article['content'] ?? null,
        'content' => $article['content'] ?? $article['excerpt'] ?? '',
        'image' => $image,
        'imageAlt' => $article['featured_image']['alt'] ?? $article['title'] ?? 'Berita Bubba Bloom',
        'chips' => $chips,
        'tags' => $article['tags'] ?? [],
        'gallery' => $article['media_gallery'] ?? [],
        'backUrl' => route('landing.news.index'),
        'backLabel' => 'Kembali ke Berita',
    ]));
})->name('landing.news.detail');

Route::get('/galeri/{id}', function (string $id) {
    $client = new GraphQLClient();
    $query = <<<'GRAPHQL'
        query GetLandingGalleryDetail($id: ID!) {
          GetOneGallery(_id: $id) {
            _id
            title
            description
            image
            category_id { name description }
            createdAt
          }
        }
    GRAPHQL;

    try {
        $gallery = $client->queryCached(
            'gallery-detail',
            $query,
            ['id' => $id],
            null,
            config('landing.cache.detail_ttl', 60)
        )['GetOneGallery'] ?? null;
    } catch (\Exception $e) {
        $gallery = null;
    }

    abort_if(!$gallery, 404, 'Galeri tidak ditemukan');

    return view('detail', landing_detail_context([
        'type' => 'galeri',
        'eyebrow' => 'Galeri',
        'title' => $gallery['title'] ?? 'Galeri Bubba Bloom',
        'description' => $gallery['description'] ?? '',
        'content' => $gallery['description'] ?? '',
        'image' => landing_media_url($gallery['image'] ?? null),
        'chips' => array_filter([$gallery['category_id']['name'] ?? null]),
        'backUrl' => route('landing.gallery.index'),
        'backLabel' => 'Kembali ke Galeri',
    ]));
})->name('landing.gallery.detail');

Route::get('/team/{id}', function (string $id) {
    $client = new GraphQLClient();
    $query = <<<'GRAPHQL'
        query GetLandingTeamDetail($id: ID!) {
          getOurTeamById(id: $id, lang: "IND") {
            _id
            profileImage { url alt }
            contact { email phone }
            socialMedia { platform url icon }
            currentContent {
              name
              position
              department
              bio
              skills
            }
          }
        }
    GRAPHQL;

    try {
        $member = $client->queryCached(
            'team-detail',
            $query,
            ['id' => $id],
            null,
            config('landing.cache.detail_ttl', 60)
        )['getOurTeamById'] ?? null;
    } catch (\Exception $e) {
        $member = null;
    }

    abort_if(!$member, 404, 'Team tidak ditemukan');

    $content = $member['currentContent'] ?? [];
    $contact = $member['contact'] ?? [];
    $socialMedia = $member['socialMedia'] ?? [];

    return view('detail', landing_detail_context([
        'type' => 'team',
        'eyebrow' => 'Team',
        'title' => $content['name'] ?? 'Team Bubba Bloom',
        'description' => $content['position'] ?? $content['department'] ?? '',
        'content' => $content['bio'] ?? '',
        'image' => landing_media_url($member['profileImage']['url'] ?? null),
        'imageAlt' => $member['profileImage']['alt'] ?? $content['name'] ?? 'Team Bubba Bloom',
        'chips' => array_filter([$content['position'] ?? null, $content['department'] ?? null]),
        'tags' => $content['skills'] ?? [],
        'contactLinks' => array_values(array_filter([
            !empty($contact['email']) ? ['label' => $contact['email'], 'url' => 'mailto:' . $contact['email'], 'icon' => 'ri-mail-line'] : null,
            !empty($contact['phone']) ? ['label' => $contact['phone'], 'url' => 'tel:' . $contact['phone'], 'icon' => 'ri-phone-line'] : null,
        ])),
        'socialLinks' => $socialMedia,
        'backUrl' => url('/#team'),
        'backLabel' => 'Kembali ke Team',
    ]));
})->name('landing.team.detail');
