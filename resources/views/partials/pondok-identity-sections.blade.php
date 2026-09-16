@php
    $vision = $about['visionMission']['vision'] ?? ['title' => 'Visi', 'content' => "Menjadi Pondok Pesantren yang menyiapkan generasi Qur'ani yang berakhlak, mandiri untuk sukses dan berkembang demi kemuliaan Islam.", 'icon' => 'ri-eye-line'];
    $missions = $about['visionMission']['mission']['items'] ?? [
        ['text' => "Menyelenggarakan pendidikan Tahfidz Al-Qur'an yang membentuk akhlak mulia dan pengamalan nilai Al-Qur'an."],
        ['text' => 'Mengintegrasikan ilmu keislaman, ilmu pengetahuan, dan pengembangan potensi santri.'],
        ['text' => "Membina karakter Qur'ani yang disiplin, mandiri, percaya diri, dan bertanggung jawab."],
        ['text' => 'Mengembangkan tilawah, public speaking, kepemimpinan, olahraga sunnah, dan ekstrakurikuler.'],
        ['text' => 'Membangun tata kelola pondok yang profesional, amanah, dan berkelanjutan.'],
        ['text' => 'Menghadirkan pendidikan Islam yang berkualitas dan terjangkau bagi masyarakat.'],
    ];
    $cultureItems = !empty($superiorities) ? $superiorities : [
        ['title'=>'Akhlak','description'=>'Santun kepada Allah, Rasul, orang tua, guru, teman, dan lingkungan.','class_icon'=>'ri-heart-3-line'],
        ['title'=>'Tahfidz','description'=>"Menghafal dan menjaga hafalan Al-Qur'an secara istiqamah.",'class_icon'=>'ri-book-open-line'],
        ['title'=>'Tilawah','description'=>"Membaca Al-Qur'an dengan tartil sesuai kaidah tajwid.",'class_icon'=>'ri-mic-line'],
        ['title'=>'Tarjamah','description'=>"Memahami makna ayat Al-Qur'an sebagai dasar penghayatan.",'class_icon'=>'ri-translate-2'],
        ['title'=>'Tadabbur','description'=>"Merenungkan kandungan Al-Qur'an untuk membentuk karakter Islami.",'class_icon'=>'ri-lightbulb-line'],
        ['title'=>'Terapan','description'=>"Mengamalkan nilai Al-Qur'an dalam ibadah, belajar, dan bermasyarakat.",'class_icon'=>'ri-community-line'],
    ];
    $graduateItems = !empty($whyChooseUs) ? $whyChooseUs : [
        ['title'=>"Qur'ani",'description'=>"Dekat dengan Al-Qur'an melalui hafalan, bacaan, dan pengamalannya.",'class_icon'=>'ri-book-open-line'],
        ['title'=>'Berakhlak','description'=>'Menjadikan adab dan akhlak sebagai dasar perilaku.','class_icon'=>'ri-heart-3-line'],
        ['title'=>'Berilmu','description'=>'Memiliki dasar pendidikan akademik yang baik.','class_icon'=>'ri-graduation-cap-line'],
        ['title'=>'Berkarakter','description'=>'Memiliki pribadi kuat untuk menghadapi tantangan kehidupan.','class_icon'=>'ri-shield-star-line'],
        ['title'=>'Mandiri','description'=>'Bertanggung jawab dan mampu mengelola diri.','class_icon'=>'ri-seedling-line'],
        ['title'=>'Berkembang Sesuai Potensi','description'=>'Mengenali dan mengembangkan bakat serta minatnya.','class_icon'=>'ri-star-smile-line'],
    ];
    $findService = static function (array $items, string $title): ?array {
        foreach ($items as $item) {
            if (strcasecmp(trim((string) ($item['title'] ?? '')), $title) === 0) return $item;
        }
        return null;
    };
    $dormProgram = $findService($services ?? [], 'Kegiatan Asrama');
    $ppdbProgram = $findService($services ?? [], 'Penerimaan Santri Baru');
@endphp

<style>
    .identity-vision-section{padding:70px 0}.identity-vision-section .head{margin-bottom:26px;align-items:center}.identity-vision-section .head h2{font-size:clamp(2.15rem,4vw,3.45rem)}.identity-layout{display:grid;grid-template-columns:.78fr 1.22fr;gap:32px;align-items:stretch}.identity-vision{display:flex;min-height:100%;flex-direction:column;justify-content:center;padding:36px 34px;border-radius:20px;background:var(--navy);color:#fff}.identity-vision>i{font-size:1.45rem;color:var(--coral)}.identity-vision h3,.identity-mission h3{margin:8px 0 10px;font:1.7rem var(--serif)}.identity-vision p{max-width:390px;margin:0;color:#d9f3f7;line-height:1.75}.identity-mission{display:flex;flex-direction:column}.identity-mission h3{flex:0 0 auto}.identity-mission ol{display:grid;flex:1;grid-auto-rows:minmax(46px,1fr);gap:8px;margin:0;padding:0;list-style:none;counter-reset:misi}.identity-mission li{position:relative;display:flex;align-items:center;padding:10px 16px 10px 50px;border:1px solid var(--line);border-radius:12px;background:#fff;color:var(--muted);font-size:.82rem;line-height:1.5;counter-increment:misi}.identity-mission li:before{content:counter(misi);position:absolute;left:13px;top:50%;display:grid;place-items:center;width:25px;height:25px;border-radius:50%;background:#e5f8fc;color:var(--cyan);font-weight:800;transform:translateY(-50%)}.identity-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}.identity-card{padding:25px;border-radius:18px;background:#fff;border:1px solid var(--line)}.identity-card i{color:var(--coral);font-size:1.55rem}.identity-card h3{margin:12px 0 7px;color:var(--navy);font:1.35rem var(--serif)}.identity-card p{margin:0;color:var(--muted);font-size:.82rem}.identity-card ul{padding-left:18px;color:var(--muted);font-size:.8rem}.ppdb-layout{display:grid;grid-template-columns:1.05fr .95fr;gap:55px;align-items:center}.ppdb-panel{padding:34px;border-radius:24px;background:var(--navy);color:#fff}.ppdb-panel h3{margin:0 0 16px;font:2rem var(--serif)}.ppdb-panel ul{padding-left:20px;color:#d9f3f7}.ppdb-details{display:grid;grid-template-columns:1fr 1fr;gap:11px;margin:25px 0}.ppdb-details span{display:flex;gap:8px;align-items:center;font-size:.83rem;font-weight:700}.ppdb-details i{color:var(--coral)}
    @media(max-width:900px){.identity-vision-section{padding:58px 0}.identity-vision-section .head{margin-bottom:22px}.identity-layout,.ppdb-layout{grid-template-columns:1fr;gap:22px}.identity-vision{min-height:auto}.identity-mission ol{grid-template-rows:none}.identity-grid{grid-template-columns:repeat(2,1fr)}}@media(max-width:600px){.identity-vision-section{padding:48px 0}.identity-vision{padding:27px 24px}.identity-mission li{padding-top:10px;padding-bottom:10px}.identity-grid,.ppdb-details{grid-template-columns:1fr}}
    .identity-vision-section .head h2{font-size:clamp(1.8rem,2.8vw,2.65rem);line-height:1.12}
    @media(max-width:600px){.identity-vision-section .head h2{font-size:1.75rem}}
</style>

@if($vision || !empty($missions))
<section class="section soft identity-vision-section" id="vision"><div class="shell">
    <div class="head reveal"><div><span class="eyebrow">Arah Pendidikan</span><h2>{{ $about['visionMission']['title'] ?? 'Visi dan Misi Pondok' }}</h2></div><p>{{ $about['visionMission']['subtitle'] ?? 'Arah pendidikan Al-Madinah Al-Kamilah.' }}</p></div>
    <div class="identity-layout reveal">
        <article class="identity-vision"><i class="{{ $vision['icon'] ?? 'ri-eye-line' }}"></i><h3>{{ $vision['title'] ?? 'Visi' }}</h3><p>{{ $vision['content'] ?? '' }}</p></article>
        <div class="identity-mission"><h3>{{ $about['visionMission']['mission']['title'] ?? 'Misi' }}</h3><ol>@foreach($missions as $mission)<li>{{ $mission['text'] ?? '' }}</li>@endforeach</ol></div>
    </div>
</div></section>
@endif

<section class="section white" id="culture"><div class="shell">
    <div class="head reveal"><div><span class="eyebrow">Culture Agreement</span><h2>Budaya Pondok.</h2></div><p>Kebiasaan utama yang ditanamkan kepada seluruh santri sebagai penerapan nilai Al-Qur'an dalam kehidupan sehari-hari.</p></div>
    <div class="identity-grid">@foreach($cultureItems as $item)<article class="identity-card reveal"><i class="{{ $item['class_icon'] ?? 'ri-checkbox-circle-line' }}"></i><h3>{{ $item['title'] ?? '' }}</h3><p>{{ $item['description'] ?? '' }}</p></article>@endforeach</div>
</div></section>

@if($dormProgram)
<section class="section soft" id="asrama"><div class="shell">
    <div class="head reveal"><div><span class="eyebrow">Kehidupan Santri</span><h2>{{ $dormProgram['title'] }}</h2></div><p>{{ $dormProgram['description'] }}</p></div>
    <div class="identity-grid">@foreach(($dormProgram['features'] ?? []) as $feature)<article class="identity-card reveal"><i class="ri-time-line"></i><h3>Kegiatan Santri</h3><p>{{ $feature }}</p></article>@endforeach</div>
</div></section>
@endif

<section class="section white" id="graduates"><div class="shell">
    <div class="head reveal"><div><span class="eyebrow">Arah Pendidikan</span><h2>Profil Lulusan.</h2></div><p>Karakter dan kemampuan yang dibangun selama santri menjalani pendidikan di pondok.</p></div>
    <div class="identity-grid">@foreach($graduateItems as $item)<article class="identity-card reveal"><i class="{{ $item['class_icon'] ?? 'ri-user-star-line' }}"></i><h3>{{ $item['title'] ?? '' }}</h3><p>{{ $item['description'] ?? '' }}</p></article>@endforeach</div>
</div></section>

<section class="section soft" id="ppdb"><div class="shell ppdb-layout reveal">
    <div><span class="eyebrow">Penerimaan Santri Baru</span><h2 style="margin:13px 0 18px;font:clamp(2.4rem,4.7vw,4.15rem)/1.05 var(--serif);color:var(--navy)">{{ $ppdbProgram['title'] ?? 'PPDB Al-Madinah Al-Kamilah' }}</h2><p style="color:var(--muted)">{{ $ppdbProgram['description'] ?? 'Pendaftaran tersedia melalui jalur Inden dan Reguler.' }}</p><div class="ppdb-details"><span><i class="ri-checkbox-circle-fill"></i>Persyaratan</span><span><i class="ri-group-line"></i>Kuota</span><span><i class="ri-calendar-line"></i>Jadwal</span><span><i class="ri-money-dollar-circle-line"></i>Biaya</span><span><i class="ri-building-line"></i>Fasilitas</span><span><i class="ri-route-line"></i>Alur Pendaftaran</span></div><a class="btn btn--primary" href="{{ $waPpdb }}" target="_blank" rel="noopener">Isi Form Minat PPDB <i class="ri-whatsapp-line"></i></a></div>
    <aside class="ppdb-panel"><h3>Jalur dan Jenjang</h3><ul>@foreach(($ppdbProgram['features'] ?? ['PPDB Inden dan PPDB Reguler','TPQ non-muqim','SMP dan SMA muqim']) as $feature)<li>{{ $feature }}</li>@endforeach</ul></aside>
</div></section>
