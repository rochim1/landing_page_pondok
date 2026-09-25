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
    .identity-vision-section{padding:70px 0}.identity-vision-section .head{margin-bottom:26px;align-items:center}.identity-vision-section .head h2{font-size:clamp(2.15rem,4vw,3.45rem)}.identity-layout{display:grid;grid-template-columns:5fr 7fr;gap:24px;align-items:stretch}.identity-education-image{position:relative;min-height:100%;margin:0;overflow:hidden;border-radius:20px;background:var(--navy);box-shadow:0 20px 45px rgba(7,86,106,.14)}.identity-education-image:after{content:'';position:absolute;inset:0;background:linear-gradient(180deg,transparent 55%,rgba(7,50,60,.72))}.identity-education-image img{display:block;width:100%;height:100%;min-height:520px;object-fit:cover;object-position:center 46%}.identity-education-image figcaption{position:absolute;z-index:1;right:20px;bottom:18px;left:20px;color:#fff;font-size:.72rem;font-weight:700;line-height:1.55}.identity-education-image figcaption i{margin-right:6px;color:var(--coral);font-size:1rem}.identity-direction-copy{display:grid;gap:20px;min-width:0}.identity-vision{display:flex;min-height:auto;flex-direction:column;justify-content:center;padding:30px;border-radius:20px;background:var(--navy);color:#fff}.identity-vision>i{font-size:1.45rem;color:var(--coral)}.identity-vision h3,.identity-mission h3{margin:8px 0 10px;font:1.7rem var(--serif)}.identity-vision p{max-width:540px;margin:0;color:#d9f3f7;line-height:1.75}.identity-mission{display:flex;min-width:0;flex-direction:column}.identity-mission h3{flex:0 0 auto}.identity-mission ol{display:grid;flex:1;grid-auto-rows:minmax(46px,1fr);gap:8px;margin:0;padding:0;list-style:none;counter-reset:misi}.identity-mission li{position:relative;display:flex;align-items:center;padding:10px 16px 10px 50px;border:1px solid var(--line);border-radius:12px;background:#fff;color:var(--muted);font-size:.82rem;line-height:1.5;counter-increment:misi}.identity-mission li:before{content:counter(misi);position:absolute;left:13px;top:50%;display:grid;place-items:center;width:25px;height:25px;border-radius:50%;background:#e5f8fc;color:var(--cyan);font-weight:800;transform:translateY(-50%)}.identity-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}.identity-card{padding:25px;border-radius:18px;background:#fff;border:1px solid var(--line)}.identity-card i{color:var(--coral);font-size:1.55rem}.identity-card h3{margin:12px 0 7px;color:var(--navy);font:1.35rem var(--serif)}.identity-card p{margin:0;color:var(--muted);font-size:.82rem}.identity-card ul{padding-left:18px;color:var(--muted);font-size:.8rem}.ppdb-layout{display:grid;grid-template-columns:1.05fr .95fr;gap:55px;align-items:center}.ppdb-panel{padding:34px;border-radius:24px;background:var(--navy);color:#fff}.ppdb-panel h3{margin:0 0 16px;font:2rem var(--serif)}.ppdb-panel ul{padding-left:20px;color:#d9f3f7}.ppdb-details{display:grid;grid-template-columns:1fr 1fr;gap:11px;margin:25px 0}.ppdb-details span{display:flex;gap:8px;align-items:center;font-size:.83rem;font-weight:700}.ppdb-details i{color:var(--coral)}
    @media(max-width:900px){.identity-vision-section{padding:58px 0}.identity-vision-section .head{margin-bottom:22px}.identity-layout,.ppdb-layout{grid-template-columns:1fr;gap:22px}.identity-education-image{min-height:340px}.identity-education-image img{min-height:340px;max-height:460px}.identity-vision{min-height:auto}.identity-mission ol{grid-template-rows:none}.identity-grid{grid-template-columns:repeat(2,1fr)}}@media(max-width:600px){.identity-vision-section{padding:48px 0}.identity-education-image,.identity-education-image img{min-height:250px}.identity-vision{padding:27px 24px}.identity-mission li{padding-top:10px;padding-bottom:10px}.identity-grid,.ppdb-details{grid-template-columns:1fr}}
    .identity-vision-section .head h2{font-size:clamp(1.8rem,2.8vw,2.65rem);line-height:1.12}
    .ppdb-section{position:relative;background:linear-gradient(118deg,#04313d 0%,#07566a 58%,#087f99 100%)!important;color:#fff}.ppdb-section:before{opacity:.13!important;background-image:linear-gradient(90deg,rgba(4,49,61,.2),rgba(4,49,61,.72)),url('{{ asset('assets/islamic-pattern-gold.jpg') }}')!important}.ppdb-section>.shell:before{border-color:rgba(255,255,255,.32);background:var(--coral);color:#fff;box-shadow:0 0 0 8px rgba(255,255,255,.09)}.ppdb-section>.shell:after{background:linear-gradient(90deg,transparent,#fff,transparent);opacity:.28}.ppdb-layout{gap:64px}.ppdb-priority{display:inline-flex;align-items:center;gap:9px;padding:8px 13px;border:1px solid rgba(255,255,255,.24);border-radius:999px;background:rgba(255,255,255,.1);color:#fff;font-size:.7rem;font-weight:800;letter-spacing:.1em;text-transform:uppercase;backdrop-filter:blur(8px)}.ppdb-priority i{color:#ff8067;font-size:1rem}.ppdb-section h2{max-width:670px;margin:18px 0 18px;color:#fff;font:600 clamp(2.25rem,4vw,3.65rem)/1.08 var(--serif);letter-spacing:-.022em}.ppdb-intro{max-width:650px;margin:0;color:#d9f3f7;line-height:1.75}.ppdb-section .ppdb-details{gap:10px;margin:28px 0}.ppdb-section .ppdb-details span{min-height:44px;padding:9px 12px;border:1px solid rgba(255,255,255,.14);border-radius:12px;background:rgba(255,255,255,.08);color:#f3fbfc}.ppdb-section .ppdb-details i{color:#ff8067}.ppdb-action{min-height:56px;padding:0 25px;background:var(--coral);color:#fff;box-shadow:0 16px 34px rgba(246,98,67,.3)}.ppdb-action:hover{background:#ff7457}.ppdb-panel{position:relative;padding:34px 32px;border:0;border-radius:24px;background:linear-gradient(155deg,#fff 0%,#f5fcfd 100%);color:var(--navy);transform:translateY(-6px);box-shadow:0 9px 0 rgba(3,45,56,.2),0 34px 72px rgba(0,24,31,.34),inset 0 1px 0 #fff}.ppdb-panel:before{content:'';position:absolute;inset:0 0 auto;height:5px;border-radius:24px 24px 0 0;background:linear-gradient(90deg,var(--coral),#ff9b83)}.ppdb-panel__icon{display:grid;width:52px;height:58px;place-items:center;margin-bottom:18px;border-radius:28px 28px 13px 13px;background:#e5f8fc;color:var(--cyan);font-size:1.5rem;box-shadow:0 10px 22px rgba(2,173,208,.14)}.ppdb-panel h3{margin:0 0 8px;color:var(--navy);font:600 1.75rem/1.25 var(--serif)}.ppdb-panel>p{margin:0 0 20px;color:var(--muted);font-size:.78rem}.ppdb-panel ul{display:grid;gap:10px;margin:0;padding:0;color:var(--navy);list-style:none}.ppdb-panel li{position:relative;padding:11px 12px 11px 38px;border-radius:12px;background:#edf9fb;font-size:.8rem;line-height:1.5}.ppdb-panel li:before{content:'\2713';position:absolute;left:13px;top:11px;color:var(--coral);font-weight:900}
    .ppdb-section .ppdb-panel{border:0;transform:translateY(-10px);box-shadow:0 18px 42px rgba(255,255,255,.3),0 38px 78px rgba(255,255,255,.13),inset 0 1px 0 #fff}.ppdb-section .ppdb-panel:before{display:none}
    .ppdb-section .ppdb-panel{transform:translateY(-6px);background:linear-gradient(145deg,#f8eabe 0%,#efd27f 52%,#dcb247 100%);box-shadow:-8px -8px 28px rgba(255,255,255,.11),0 14px 30px rgba(1,35,44,.2),0 34px 68px rgba(0,22,29,.22),inset 0 1px 0 rgba(255,249,224,.9)}.ppdb-section .ppdb-panel__icon{background:rgba(5,73,88,.1);color:var(--navy);box-shadow:0 8px 18px rgba(89,60,4,.12)}.ppdb-section .ppdb-panel>p{color:#435b5f}.ppdb-section .ppdb-panel li{background:rgba(255,249,226,.72);color:#06475b;box-shadow:inset 0 1px 0 rgba(255,255,255,.45)}.ppdb-section .ppdb-panel li:before{color:#c34f37}.ppdb-action{position:relative;isolation:isolate;overflow:hidden;background:linear-gradient(135deg,#ff765c,#ed563b);box-shadow:0 14px 30px rgba(182,54,35,.34),0 5px 12px rgba(0,24,31,.16);animation:ppdb-cta-pulse 2.8s ease-in-out infinite}.ppdb-action:before{content:'';position:absolute;z-index:-1;top:-60%;bottom:-60%;left:-45%;width:32%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.5),transparent);transform:skewX(-20deg);animation:ppdb-cta-shine 3.4s ease-in-out infinite}.ppdb-action i{font-size:1.15rem;animation:ppdb-cta-icon 1.9s ease-in-out infinite}.ppdb-action:hover{background:linear-gradient(135deg,#ff856e,#f35e43);box-shadow:0 17px 34px rgba(182,54,35,.4);transform:translateY(-3px);animation-play-state:paused}.ppdb-action:hover:before,.ppdb-action:hover i{animation-play-state:paused}@keyframes ppdb-cta-pulse{0%,100%{transform:translateY(0);box-shadow:0 14px 30px rgba(182,54,35,.32),0 5px 12px rgba(0,24,31,.14)}50%{transform:translateY(-2px);box-shadow:0 19px 38px rgba(246,98,67,.48),0 7px 14px rgba(0,24,31,.14)}}@keyframes ppdb-cta-shine{0%,34%{left:-45%}68%,100%{left:125%}}@keyframes ppdb-cta-icon{0%,100%{transform:rotate(0) scale(1)}50%{transform:rotate(7deg) scale(1.1)}}@media(prefers-reduced-motion:reduce){.ppdb-action,.ppdb-action:before,.ppdb-action i{animation:none}}
    @media(max-width:900px){.ppdb-layout{gap:34px}.ppdb-panel{max-width:none}}@media(max-width:600px){.ppdb-section h2{font-size:2rem}.ppdb-section .ppdb-details{grid-template-columns:1fr 1fr}.ppdb-action{width:100%}.ppdb-panel{padding:28px 22px}}
    @media(max-width:600px){.identity-vision-section .head h2{font-size:1.75rem}}
</style>

@if($vision || !empty($missions))
<section class="section soft identity-vision-section" id="vision"><div class="shell">
    <div class="head reveal"><div><span class="eyebrow">Arah Pendidikan</span><h2>{{ $about['visionMission']['title'] ?? 'Visi dan Misi Pondok' }}</h2></div><p>{{ $about['visionMission']['subtitle'] ?? 'Arah pendidikan Al-Madinah Al-Kamilah.' }}</p></div>
    <div class="identity-layout reveal">
        <figure class="identity-education-image">
            <img src="{{ asset('assets/arah-pendidikan-santri.jpg') }}" alt="Kebersamaan santri dan asatidz Pondok Pesantren Al-Madinah Al-Kamilah" loading="lazy" decoding="async">
            <figcaption><i class="ri-book-open-line" aria-hidden="true"></i>Pendidikan yang menyatukan Al-Qur'an, ilmu, dan adab.</figcaption>
        </figure>
        <div class="identity-direction-copy">
            <article class="identity-vision"><i class="{{ $vision['icon'] ?? 'ri-eye-line' }}"></i><h3>{{ $vision['title'] ?? 'Visi' }}</h3><p>{{ $vision['content'] ?? '' }}</p></article>
            <div class="identity-mission"><h3>{{ $about['visionMission']['mission']['title'] ?? 'Misi' }}</h3><ol>@foreach($missions as $mission)<li>{{ $mission['text'] ?? '' }}</li>@endforeach</ol></div>
        </div>
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

<section class="section ppdb-section" id="ppdb"><div class="shell ppdb-layout reveal">
    <div><span class="ppdb-priority"><i class="ri-megaphone-line"></i>Informasi Pendaftaran Santri</span><h2>{{ $ppdbProgram['title'] ?? 'PPDB Al-Madinah Al-Kamilah' }}</h2><p class="ppdb-intro">{{ $ppdbProgram['description'] ?? 'Pendaftaran tersedia melalui jalur Inden dan Reguler.' }}</p><div class="ppdb-details"><span><i class="ri-checkbox-circle-fill"></i>Persyaratan</span><span><i class="ri-group-line"></i>Kuota</span><span><i class="ri-calendar-line"></i>Jadwal</span><span><i class="ri-money-dollar-circle-line"></i>Biaya</span><span><i class="ri-building-line"></i>Fasilitas</span><span><i class="ri-route-line"></i>Alur Pendaftaran</span></div><a class="btn ppdb-action" href="{{ $waPpdb }}" target="_blank" rel="noopener">Isi Form Minat PPDB <i class="ri-whatsapp-line"></i></a></div>
    <aside class="ppdb-panel"><span class="ppdb-panel__icon"><i class="ri-school-line"></i></span><h3>Jalur dan Jenjang</h3><p>Pilih program pendidikan yang sesuai untuk perjalanan belajar calon santri.</p><ul>@foreach(($ppdbProgram['features'] ?? ['PPDB Inden dan PPDB Reguler','TPQ non-muqim','SMP dan SMA muqim']) as $feature)<li>{{ $feature }}</li>@endforeach</ul></aside>
</div></section>
