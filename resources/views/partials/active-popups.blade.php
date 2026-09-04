@if(!empty($activePopups))
    @php
        $popupTypeConfig = [
            'announcement' => ['label' => 'Pengumuman', 'icon' => 'ri-megaphone-line'],
            'promotion' => ['label' => 'Promosi', 'icon' => 'ri-gift-line'],
            'warning' => ['label' => 'Perhatian', 'icon' => 'ri-error-warning-line'],
            'info' => ['label' => 'Informasi', 'icon' => 'ri-information-line'],
        ];
        $allowedPositions = ['center', 'top', 'bottom'];
    @endphp

    <div class="landing-popup-queue" data-landing-popup-queue>
        @foreach($activePopups as $popup)
            @php
                $popupType = array_key_exists($popup['popup_type'] ?? '', $popupTypeConfig)
                    ? $popup['popup_type']
                    : 'info';
                $popupPosition = in_array($popup['position'] ?? '', $allowedPositions, true)
                    ? $popup['position']
                    : 'center';
                $typeConfig = $popupTypeConfig[$popupType];
                $popupImage = landing_media_url($popup['image'] ?? null);
                $buttonText = trim((string) ($popup['button_text'] ?? '')) ?: 'Tutup';
                $buttonLink = trim((string) ($popup['button_link'] ?? ''));
                $isExternalLink = (bool) preg_match('/^https?:\/\//i', $buttonLink);
                $isSafeInternalLink = str_starts_with($buttonLink, '/') || str_starts_with($buttonLink, '#');
                $hasSafeLink = $buttonLink !== '' && ($isExternalLink || $isSafeInternalLink);
                $popupId = 'landing-popup-' . preg_replace('/[^a-zA-Z0-9_-]/', '', (string) ($popup['_id'] ?? $loop->index));
            @endphp

            <section
                class="landing-popup landing-popup--{{ $popupPosition }} landing-popup--{{ $popupType }}"
                data-landing-popup
                data-popup-id="{{ $popup['_id'] ?? $loop->index }}"
                role="dialog"
                aria-modal="true"
                aria-labelledby="{{ $popupId }}-title"
                aria-describedby="{{ $popupId }}-content"
                hidden
            >
                <article class="landing-popup__card" tabindex="-1">
                    <button class="landing-popup__close" type="button" data-popup-close aria-label="Tutup popup">
                        <i class="ri-close-line" aria-hidden="true"></i>
                    </button>

                    @if($popupImage)
                        <div class="landing-popup__media">
                            <img src="{{ $popupImage }}" alt="{{ $popup['title'] ?? 'Informasi' }}" loading="eager">
                        </div>
                    @endif

                    <div class="landing-popup__body">
                        <span class="landing-popup__eyebrow">
                            <i class="{{ $typeConfig['icon'] }}" aria-hidden="true"></i>
                            {{ $typeConfig['label'] }}
                        </span>
                        <h2 id="{{ $popupId }}-title">{{ $popup['title'] ?? 'Informasi' }}</h2>
                        <div class="landing-popup__content" id="{{ $popupId }}-content">{!! nl2br(e($popup['content'] ?? '')) !!}</div>

                        <div class="landing-popup__actions">
                            @if($hasSafeLink)
                                <a
                                    class="landing-popup__button"
                                    href="{{ $buttonLink }}"
                                    data-popup-action
                                    @if($isExternalLink) target="_blank" rel="noopener noreferrer" @endif
                                >
                                    {{ $buttonText }}
                                    <i class="ri-arrow-right-line" aria-hidden="true"></i>
                                </a>
                            @else
                                <button class="landing-popup__button" type="button" data-popup-close>{{ $buttonText }}</button>
                            @endif
                        </div>
                    </div>
                </article>
            </section>
        @endforeach
    </div>

    <style>
        .landing-popup[hidden] {
            display: none !important;
        }

        .landing-popup {
            position: fixed;
            inset: 0;
            z-index: 10000;
            display: flex;
            justify-content: center;
            padding: clamp(1rem, 4vw, 2.5rem);
            background:
                radial-gradient(circle at 20% 10%, rgba(127, 47, 83, 0.18), transparent 34%),
                rgba(23, 14, 20, 0.62);
            backdrop-filter: blur(12px) saturate(115%);
            -webkit-backdrop-filter: blur(12px) saturate(115%);
            opacity: 0;
            visibility: hidden;
            transition: opacity 220ms ease, visibility 220ms ease;
        }

        .landing-popup--center { align-items: center; }
        .landing-popup--top { align-items: flex-start; padding-top: clamp(5.5rem, 12vh, 8rem); }
        .landing-popup--bottom { align-items: flex-end; padding-bottom: clamp(1.5rem, 8vh, 5rem); }

        .landing-popup.is-visible {
            opacity: 1;
            visibility: visible;
        }

        .landing-popup__card {
            position: relative;
            width: min(100%, 540px);
            max-height: min(86vh, 760px);
            overflow: auto;
            color: #34232d;
            background:
                radial-gradient(circle at 100% 0, rgba(127, 47, 83, 0.07), transparent 30%),
                #ffffff;
            border: 0;
            outline: none;
            border-radius: 28px;
            box-shadow:
                0 40px 100px rgba(32, 16, 26, 0.28),
                0 12px 32px rgba(32, 16, 26, 0.16);
            transform: translateY(22px) scale(0.965);
            transition: transform 280ms cubic-bezier(0.22, 1, 0.36, 1);
            scrollbar-width: thin;
            isolation: isolate;
        }

        .landing-popup.is-visible .landing-popup__card {
            transform: translateY(0) scale(1);
        }

        .landing-popup--top .landing-popup__card,
        .landing-popup--bottom .landing-popup__card {
            width: min(100%, 620px);
        }

        .landing-popup__close {
            position: absolute;
            top: 16px;
            right: 16px;
            z-index: 4;
            display: grid;
            width: 42px;
            height: 42px;
            place-items: center;
            padding: 0;
            color: #3a2731;
            background: rgba(255, 255, 255, 0.9);
            border: 0;
            border-radius: 50%;
            box-shadow: 0 10px 28px rgba(44, 22, 34, 0.16);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            cursor: pointer;
            transition: color 180ms ease, background 180ms ease, transform 180ms ease, box-shadow 180ms ease;
        }

        .landing-popup__close:hover,
        .landing-popup__close:focus-visible {
            color: #fff;
            background: #7f2f53;
            outline: none;
            transform: rotate(4deg) scale(1.04);
            box-shadow: 0 12px 30px rgba(127, 47, 83, 0.28);
        }

        .landing-popup__media {
            overflow: hidden;
            aspect-ratio: 16 / 8.5;
            margin: 12px 12px 0;
            background: #f4eaf0;
            border-radius: 20px;
        }

        .landing-popup__media img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .landing-popup__body {
            padding: clamp(1.55rem, 4vw, 2.25rem);
        }

        .landing-popup__eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            margin-bottom: 0.9rem;
            padding: 0.42rem 0.78rem;
            color: #3653a6;
            background: #edf2ff;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .landing-popup--announcement .landing-popup__eyebrow { color: #64349d; background: #f2eafb; }
        .landing-popup--promotion .landing-popup__eyebrow { color: #176a48; background: #e6f7ee; }
        .landing-popup--warning .landing-popup__eyebrow { color: #8a5200; background: #fff2d9; }

        .landing-popup__body h2 {
            margin: 0;
            padding-right: 2.25rem;
            color: #2e2028;
            font-size: clamp(1.5rem, 4vw, 2.15rem);
            line-height: 1.15;
            letter-spacing: -0.035em;
        }

        .landing-popup__content {
            margin-top: 1rem;
            color: #705d67;
            font-size: 1rem;
            line-height: 1.75;
            overflow-wrap: anywhere;
        }

        .landing-popup__actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 1.75rem;
        }

        .landing-popup__button {
            display: inline-flex;
            min-height: 48px;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            padding: 0.8rem 1.3rem;
            color: #fff;
            background: #7f2f53;
            border: 0;
            border-radius: 14px;
            box-shadow: 0 12px 28px rgba(127, 47, 83, 0.24);
            font: inherit;
            font-weight: 750;
            text-decoration: none;
            cursor: pointer;
            transition: transform 180ms ease, background 180ms ease, box-shadow 180ms ease;
        }

        .landing-popup__button:hover,
        .landing-popup__button:focus-visible {
            color: #fff;
            background: #63223f;
            outline: 3px solid rgba(127, 47, 83, 0.2);
            outline-offset: 2px;
            transform: translateY(-2px);
            box-shadow: 0 16px 32px rgba(127, 47, 83, 0.3);
        }

        body.has-landing-popup {
            overflow: hidden;
        }

        @media (max-width: 540px) {
            .landing-popup { padding: 0.85rem; }
            .landing-popup--top { padding-top: 4.75rem; }
            .landing-popup--bottom { padding-bottom: 1rem; }
            .landing-popup__card { border-radius: 22px; }
            .landing-popup__close { top: 13px; right: 13px; }
            .landing-popup__media { margin: 9px 9px 0; border-radius: 16px; }
            .landing-popup__body { padding: 1.4rem 1.25rem 1.5rem; }
            .landing-popup__actions { display: block; }
            .landing-popup__button { width: 100%; }
        }

        @media (prefers-reduced-motion: reduce) {
            .landing-popup,
            .landing-popup__card { transition: none; }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const storagePrefix = 'landing-popup-shown:';
            const hasBeenShown = (popup) => {
                try {
                    return window.sessionStorage.getItem(storagePrefix + popup.dataset.popupId) === '1';
                } catch (error) {
                    return false;
                }
            };
            const rememberAsShown = (popup) => {
                try {
                    window.sessionStorage.setItem(storagePrefix + popup.dataset.popupId, '1');
                } catch (error) {
                    // Storage may be unavailable in strict privacy mode; the popup still works normally.
                }
            };
            const queue = Array.from(document.querySelectorAll('[data-landing-popup]'))
                .filter((popup) => !hasBeenShown(popup));
            let activePopup = null;
            let lastFocusedElement = null;

            const showNextPopup = () => {
                const nextPopup = queue.shift();
                if (!nextPopup) {
                    activePopup = null;
                    document.body.classList.remove('has-landing-popup');
                    if (lastFocusedElement instanceof HTMLElement) {
                        lastFocusedElement.focus();
                    }
                    lastFocusedElement = null;
                    return;
                }

                activePopup = nextPopup;
                rememberAsShown(nextPopup);
                if (!lastFocusedElement) {
                    lastFocusedElement = document.activeElement;
                }
                nextPopup.hidden = false;
                document.body.classList.add('has-landing-popup');

                window.requestAnimationFrame(() => {
                    nextPopup.classList.add('is-visible');
                    nextPopup.querySelector('.landing-popup__card')?.focus({ preventScroll: true });
                });
            };

            const closeActivePopup = () => {
                if (!activePopup) return;

                const popupToClose = activePopup;
                activePopup = null;
                popupToClose.classList.remove('is-visible');
                window.setTimeout(() => {
                    popupToClose.hidden = true;
                    showNextPopup();
                }, 230);
            };

            document.querySelectorAll('[data-popup-close]').forEach((button) => {
                button.addEventListener('click', closeActivePopup);
            });

            document.querySelectorAll('[data-popup-action]').forEach((link) => {
                link.addEventListener('click', closeActivePopup);
            });

            document.addEventListener('click', (event) => {
                if (activePopup && event.target === activePopup) {
                    closeActivePopup();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && activePopup) {
                    closeActivePopup();
                }
            });

            if (queue.length) {
                window.setTimeout(showNextPopup, 350);
            }
        });
    </script>
@endif
