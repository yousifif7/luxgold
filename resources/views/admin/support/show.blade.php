@extends('layouts.admin')

@section('admin-title', 'Support Ticket')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Ticket #{{ $ticket->id }} - {{ $ticket->subject }}</h5>
                <div>
                    @if($ticket->status === 'open')
                        <button class="btn btn-sm btn-outline-success btn-change-status" data-id="{{ $ticket->id }}" data-status="in_progress">Mark In Progress</button>
                        <button class="btn btn-sm btn-outline-secondary btn-change-status" data-id="{{ $ticket->id }}" data-status="closed">Close</button>
                    @elseif($ticket->status === 'in_progress')
                        <button class="btn btn-sm btn-outline-secondary btn-change-status" data-id="{{ $ticket->id }}" data-status="closed">Close</button>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <p><strong>From:</strong> {{ $ticket->name }} — <a href="mailto:{{ $ticket->email }}">{{ $ticket->email }}</a></p>
                <p><strong>Priority:</strong> {{ ucfirst($ticket->priority) }}</p>
                <div class="border rounded p-3 bg-light">{!! nl2br(e($ticket->message)) !!}</div>

                <hr>
                <div id="adminSupportMessages" style="max-height:360px; overflow:auto;">
                    <!-- messages loaded by AJAX -->
                </div>

                <form id="adminReplyForm" class="mt-3">
                    @csrf
                    <div class="mb-2">
                        <textarea name="message" class="form-control" rows="3" placeholder="Reply as admin..."></textarea>
                    </div>
                    <button class="btn btn-primary">Send Reply</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Use window-scoped variable to avoid redeclaration and check if already defined
    if (!window._adminSupportStatusToken) {
        window._adminSupportStatusToken = '{{ csrf_token() }}';
    }
    document.querySelectorAll('.btn-change-status').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (btn.disabled) return;
            btn.disabled = true;
            var id = this.dataset.id; var status = this.dataset.status;
            fetch(`/admin/support/${id}/status`, { method: 'POST', headers: { 'Content-Type':'application/json','X-CSRF-TOKEN': window._adminSupportStatusToken }, body: JSON.stringify({ status }) })
            .then(r => r.json())
            .then(j => {
                console.log('Status change response:', j);
                if (j.success) {
                    setTimeout(() => location.reload(), 700); // short delay to see console
                } else {
                    btn.disabled = false;
                    alert('Error changing status (see console)');
                }
            })
            .catch(e => {
                btn.disabled = false;
                console.error('Status change error:', e);
                alert('Error changing status (see console)');
            });
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ticketId = {{ $ticket->id }};
    const container = document.getElementById('adminSupportMessages');
    const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');

    function fetchMessages() {
        fetch(`/admin/support/${ticketId}/messages`)
        .then(r => r.json())
        .then(list => {
            container.innerHTML = '';
            list.forEach(m => {
                const el = document.createElement('div');
                el.className = 'mb-2';
                el.innerHTML = `<div><strong>${m.sender_name || (m.user ? m.user.name : 'User')}</strong> <small class="text-muted">${new Date(m.created_at).toLocaleString()}</small></div><div class="border rounded p-2 bg-light">${escapeHtml(m.message)}</div>`;
                container.appendChild(el);
            });
            container.scrollTop = container.scrollHeight;
        });
    }

    // Attach submit handler with a shared flag on the form element to guard against duplicate listeners
    (function(){
        const form = document.getElementById('adminReplyForm');
        if (!form) return;
        const btn = form.querySelector('button[type=submit], button');

        form.addEventListener('submit', function(e){
            e.preventDefault();
            if (form.dataset.sending === '1') return; // already sending
            const message = (this.message && this.message.value) ? this.message.value.trim() : '';
            if (!message) return alert('Please enter a message');
            form.dataset.sending = '1'; if (btn) btn.disabled = true;

            const body = { message };
            fetch(`/admin/support/${ticketId}/messages`, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token }, body: JSON.stringify(body) })
            .then(r => r.json()).then(j => {
                if (j.success) { fetchMessages(); form.reset(); } else alert('Error');
            }).catch(e => { console.error(e); alert('Error'); })
            .finally(() => { delete form.dataset.sending; if (btn) btn.disabled = false; });
        });
    })();

    function escapeHtml(str){ return (str||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\"/g,'&quot;').replace(/\'/g, '&#039;'); }

    fetchMessages();
    setInterval(fetchMessages, 15000);
});
</script>
@endpush
@endsection