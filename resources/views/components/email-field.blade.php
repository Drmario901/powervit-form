@props([
    'icon',
    'label',
    'value',
    'href' => null,
    'muted' => false,
    'mono' => false,
    'small' => false,
])

@php
    $iconWrap = $muted
        ? 'bg-slate-200/80 text-slate-600'
        : 'bg-teal-100 text-teal-600';
    $labelClass = $muted ? 'text-slate-500' : 'text-slate-500';
    $valueClass = $muted ? 'text-slate-600' : 'text-slate-900';
    if ($mono) {
        $valueClass .= ' font-mono ' . ($small ? 'text-xs leading-snug break-all' : 'text-sm');
    } else {
        $valueClass .= ' text-[15px] leading-relaxed';
    }
@endphp

<div {{ $attributes->merge(['class' => 'flex gap-3']) }}>
    <div
        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full {{ $iconWrap }}"
        aria-hidden="true"
    >
        @switch($icon)
            @case('user')
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.25" viewBox="0 0 24 24">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" stroke-linecap="round" stroke-linejoin="round" />
                    <circle cx="12" cy="7" r="4" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                @break
            @case('mail')
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.25" viewBox="0 0 24 24">
                    <rect width="20" height="16" x="2" y="4" rx="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                @break
            @case('phone')
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.25" viewBox="0 0 24 24">
                    <path
                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
                @break
            @case('tag')
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.25" viewBox="0 0 24 24">
                    <path
                        d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                    <circle cx="7.5" cy="7.5" r=".5" fill="currentColor" />
                </svg>
                @break
            @case('calendar')
                <svg class="h-[18px] w-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M8 2v4" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M16 2v4" stroke-linecap="round" stroke-linejoin="round" />
                    <rect width="18" height="18" x="3" y="4" rx="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M3 10h18" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                @break
            @case('globe')
                <svg class="h-[18px] w-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M2 12h20" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                @break
            @case('monitor')
                <svg class="h-[18px] w-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect width="20" height="14" x="2" y="3" rx="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 21h8" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M12 17v4" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                @break
            @default
                <span class="text-xs">•</span>
        @endswitch
    </div>
    <div class="min-w-0 flex-1">
        <p class="text-[11px] font-bold uppercase tracking-wider {{ $labelClass }}">{{ $label }}</p>
        @if ($href)
            <a href="{{ $href }}" class="mt-1 block font-semibold text-teal-600 hover:text-teal-700 {{ $valueClass }}">
                {{ $value }}
            </a>
        @else
            <p class="mt-1 {{ $valueClass }}">{{ $value }}</p>
        @endif
    </div>
</div>
