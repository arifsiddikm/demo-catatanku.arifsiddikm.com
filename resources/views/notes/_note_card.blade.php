<div class="{{ $layout === 'masonry' ? 'masonry-item' : '' }} note-card fade-in-up"
    style="background:{{ $note->color ?? '#fef9c3' }};border-radius:1rem;padding:1rem;border:1px solid rgba(0,0,0,0.06);position:relative;"
    data-note-id="{{ $note->id }}"
    onmouseenter="this.querySelector('.note-acts').style.opacity='1'"
    onmouseleave="this.querySelector('.note-acts').style.opacity='0'">

    @if($note->is_pinned)
    <span style="position:absolute;top:0.5rem;right:0.5rem;font-size:0.8rem;">📌</span>
    @endif

    <h4 style="font-weight:600;font-size:0.9rem;color:#1f2937;margin:0 0 0.5rem;padding-right:1.5rem;line-height:1.35;">
        {{ $note->title }}
    </h4>

    @if($note->description)
    <p style="font-size:0.8rem;color:#4b5563;line-height:1.55;margin:0 0 0.75rem;display:-webkit-box;-webkit-line-clamp:8;-webkit-box-orient:vertical;overflow:hidden;">
        {{ $note->description }}
    </p>
    @endif

    <div style="display:flex;align-items:center;justify-content:space-between;padding-top:0.5rem;border-top:1px solid rgba(0,0,0,0.06);">
        <div>
            <div style="font-size:0.72rem;color:#9ca3af;">{{ $note->created_at->format('d M Y') }}</div>
            @if($note->updated_at->gt($note->created_at->addSecond()))
            <div style="font-size:0.68rem;color:#9ca3af;">Diperbarui {{ $note->updated_at->diffForHumans() }}</div>
            @endif
        </div>

        <div class="note-acts" style="display:flex;align-items:center;gap:2px;opacity:0;transition:opacity 0.2s;">
            <button onclick="togglePin({{ $note->id }})" title="{{ $note->is_pinned ? 'Lepas sematkan' : 'Sematkan' }}"
                style="width:1.75rem;height:1.75rem;border:none;background:none;cursor:pointer;border-radius:0.375rem;display:flex;align-items:center;justify-content:center;font-size:0.8rem;transition:background 0.15s;"
                onmouseover="this.style.background='rgba(0,0,0,0.08)'" onmouseout="this.style.background='none'">
                {{ $note->is_pinned ? '📌' : '📍' }}
            </button>

            <button onclick='openEditNote({{ json_encode(["id"=>$note->id,"title"=>$note->title,"description"=>$note->description,"category_id"=>$note->category_id,"color"=>$note->color,"is_pinned"=>$note->is_pinned]) }})'
                style="width:1.75rem;height:1.75rem;border:none;background:none;cursor:pointer;border-radius:0.375rem;display:flex;align-items:center;justify-content:center;color:#6b7280;transition:background 0.15s;"
                onmouseover="this.style.background='rgba(0,0,0,0.08)'" onmouseout="this.style.background='none'">
                <svg style="width:0.8rem;height:0.8rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </button>

            <button onclick="deleteNote({{ $note->id }})"
                style="width:1.75rem;height:1.75rem;border:none;background:none;cursor:pointer;border-radius:0.375rem;display:flex;align-items:center;justify-content:center;color:#6b7280;transition:all 0.15s;"
                onmouseover="this.style.background='#fef2f2';this.style.color='#ef4444'" onmouseout="this.style.background='none';this.style.color='#6b7280'">
                <svg style="width:0.8rem;height:0.8rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </div>
    </div>
</div>
