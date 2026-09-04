@php
    $buttons = collect($floatingButtons ?? [])
        ->filter(fn ($button) => ($button['enabled'] ?? true) !== false)
        ->sortBy(fn ($button) => (int) ($button['order'] ?? 0))
        ->values();

    $buildFloatingHref = function (array $button): string {
        $type = $button['type'] ?? 'link';
        $url = trim((string) ($button['url'] ?? ''));
        $phone = trim((string) ($button['phone'] ?? ''));
        $message = trim((string) ($button['message'] ?? ''));

        if ($type === 'whatsapp') {
            if ($url !== '') {
                return $url;
            }

            $digits = preg_replace('/\D+/', '', $phone);
            return $digits ? 'https://wa.me/' . $digits . ($message ? '?text=' . rawurlencode($message) : '') : '#contact';
        }

        if ($type === 'phone') {
            return $url !== '' ? $url : ($phone ? 'tel:' . $phone : '#contact');
        }

        if ($type === 'email') {
            return str_starts_with($url, 'mailto:') ? $url : ($url ? 'mailto:' . $url : '#contact');
        }

        return $url !== '' ? $url : '#';
    };

    $positionGroups = $buttons->groupBy(fn ($button) => $button['position'] ?? 'bottom_right');
@endphp

@if($buttons->isNotEmpty())
    <style>
        .floating-actions {
            position: fixed;
            z-index: 80;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        }

        .floating-actions-bottom-right {
            right: 22px;
            bottom: 22px;
            align-items: flex-end;
        }

        .floating-actions-bottom-left {
            left: 22px;
            bottom: 22px;
            align-items: flex-start;
        }

        .floating-actions-top-right {
            right: 22px;
            top: 98px;
            align-items: flex-end;
        }

        .floating-actions-top-left {
            left: 22px;
            top: 98px;
            align-items: flex-start;
        }

        .floating-action-btn {
            border: 0;
            min-width: 50px;
            min-height: 50px;
            border-radius: 999px;
            padding: 0 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: var(--floating-action-color, #fff);
            background: var(--floating-action-bg, #7f2f53);
            box-shadow: 0 16px 36px rgba(22, 8, 18, 0.2);
            font-weight: 800;
            line-height: 1;
            text-decoration: none;
            cursor: pointer;
            pointer-events: auto;
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
        }

        .floating-action-btn:hover,
        .floating-action-btn:focus-visible {
            color: var(--floating-action-color, #fff);
            filter: brightness(1.03);
            transform: translateY(-2px);
            box-shadow: 0 20px 44px rgba(22, 8, 18, 0.25);
            text-decoration: none;
            outline: none;
        }

        .floating-action-btn i {
            font-size: 1.35rem;
        }

        .floating-action-label {
            max-width: 132px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-size: 0.86rem;
        }

        @media (max-width: 575px) {
            .floating-actions-bottom-right,
            .floating-actions-top-right {
                right: 14px;
            }

            .floating-actions-bottom-left,
            .floating-actions-top-left {
                left: 14px;
            }

            .floating-actions-bottom-right,
            .floating-actions-bottom-left {
                bottom: 16px;
            }

            .floating-actions-top-right,
            .floating-actions-top-left {
                top: 84px;
            }

            .floating-action-btn {
                width: 48px;
                min-width: 48px;
                height: 48px;
                min-height: 48px;
                padding: 0;
            }

            .floating-action-label {
                display: none;
            }
        }
    </style>

    @foreach($positionGroups as $position => $groupButtons)
        <div class="floating-actions floating-actions-{{ str_replace('_', '-', $position) }}">
            @foreach($groupButtons as $button)
                @php
                    $type = $button['type'] ?? 'link';
                    $label = $button['label'] ?? 'Aksi';
                    $icon = $button['icon'] ?? 'ri-links-line';
                    $style = '--floating-action-bg: ' . ($button['bgColor'] ?? '#7f2f53') . '; --floating-action-color: ' . ($button['textColor'] ?? '#ffffff') . ';';
                @endphp

                @if($type === 'scroll_top')
                    <button
                        class="floating-action-btn"
                        type="button"
                        style="{{ $style }}"
                        title="{{ $label }}"
                        aria-label="{{ $label }}"
                        data-scroll-top
                    >
                        <i class="{{ $icon }}" aria-hidden="true"></i>
                        <span class="floating-action-label">{{ $label }}</span>
                    </button>
                @else
                    <a
                        class="floating-action-btn"
                        href="{{ $buildFloatingHref($button) }}"
                        style="{{ $style }}"
                        title="{{ $label }}"
                        aria-label="{{ $label }}"
                        @if(($button['openInNewTab'] ?? true) === true) target="_blank" rel="noopener" @endif
                    >
                        <i class="{{ $icon }}" aria-hidden="true"></i>
                        <span class="floating-action-label">{{ $label }}</span>
                    </a>
                @endif
            @endforeach
        </div>
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-scroll-top]').forEach(function (button) {
                button.addEventListener('click', function () {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            });
        });
    </script>
@endif
