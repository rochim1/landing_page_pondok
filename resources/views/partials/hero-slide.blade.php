@php
    $slideDescription = trim((string) data_get($slide, 'description', ''));
    $slidePart1 = trim((string) data_get($slide, 'heading.part1', ''));
    $slidePart2 = trim((string) data_get($slide, 'heading.part2', ''));
    $slideEyebrow = trim((string) data_get($slide, 'badge.text', ''));

    if ($slideDescription === '' || preg_match($legacyHeroPattern, $slideDescription)) {
        $slideDescription = 'Pendidikan tahfidz yang memadukan hafalan Al-Qur’an, pemahaman agama, adab, dan kemandirian dalam lingkungan pondok yang hangat.';
    }
    if ($slidePart1 === '' || preg_match($legacyHeroPattern, $slidePart1)) $slidePart1 = 'Dekat dengan Al-Qur’an';
    if ($slidePart2 === '' || preg_match($legacyHeroPattern, $slidePart2)) $slidePart2 = 'Mulia dalam Kehidupan.';
    if ($slideEyebrow === '' || preg_match($legacyHeroPattern, $slideEyebrow)) $slideEyebrow = 'Mencetak Generasi Qur’ani';

    $slideButtons = array_slice(is_array(data_get($slide, 'buttons')) ? data_get($slide, 'buttons') : [], 0, 2);
    $backgroundSource = trim((string) data_get($slide, 'background.image', ''));
    $legacyMascotSource = trim((string) data_get($slide, 'layout.mascot.image', ''));
    $imageSource = $backgroundSource !== '' ? $backgroundSource : $legacyMascotSource;
    $slideBackgroundImage = $imageSource !== '' ? $mediaUrl($imageSource) : null;
    if ($slideBackgroundImage && preg_match($legacyHeroPattern, $imageSource)) $slideBackgroundImage = null;
@endphp
<article class="hero__slide{{ $index === 0 ? ' is-active' : '' }}{{ $slideBackgroundImage ? ' hero__slide--with-background' : '' }}" data-hero-slide aria-hidden="{{ $index === 0 ? 'false' : 'true' }}" @if($slideBackgroundImage) style="background-image:linear-gradient(90deg,rgba(3,38,48,.92) 0%,rgba(4,63,77,.78) 48%,rgba(4,86,106,.48) 100%),url('{{ $slideBackgroundImage }}')" @endif>
    <div class="shell hero__grid hero__grid--background">
        <div class="hero__content">
            <span class="eyebrow">{{ $slideEyebrow }}</span>
            <h1>{{ $slidePart1 }}, <span>{{ $slidePart2 }}</span></h1>
            <p class="hero__copy">{{ $slideDescription }}</p>
            <div class="actions">
                @forelse($slideButtons as $buttonIndex => $button)
                    @php($slideHref = $safeHeroLink($button['link'] ?? null, $buttonIndex === 0 ? '#program' : $wa))
                    <a class="btn {{ $buttonIndex === 0 ? 'btn--primary' : 'btn--ghost' }}" href="{{ $slideHref }}" @if(str_starts_with($slideHref, 'https://wa.me/')) target="_blank" rel="noopener" @endif>
                        {{ $button['text'] ?? ($buttonIndex === 0 ? 'Jelajahi Program' : 'Informasi Pendaftaran') }}
                        <i class="{{ $button['icon'] ?? ($buttonIndex === 0 ? 'ri-arrow-down-line' : 'ri-customer-service-2-line') }}"></i>
                    </a>
                @empty
                    <a class="btn btn--primary" href="#program">Jelajahi Program <i class="ri-arrow-down-line"></i></a>
                    <a class="btn btn--ghost" href="{{ $wa }}" target="_blank" rel="noopener"><i class="ri-whatsapp-line"></i> Informasi Pendaftaran</a>
                @endforelse
            </div>
        </div>
    </div>
</article>
