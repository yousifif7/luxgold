@extends('layouts.parent-layout')

@section('title', 'Support Ticket')

@section('content')
<div class="page-wrapper">

<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Ticket #{{ $ticket->id }} - {{ $ticket->subject }}</div>
                <div class="card-body">
                    <p><strong>From:</strong> {{ $ticket->name }} — {{ $ticket->email }}</p>
                    <div id="supportMessages" style="max-height:400px; overflow:auto;">
                        <!-- messages via AJAX -->
                    </div>

                    <form id="supportReplyForm" class="mt-3">
                        @csrf
                        <input type="hidden" name="support_ticket_id" value="{{ $ticket->id }}">
                        <div class="mb-2">
                            <textarea name="message" class="form-control" rows="4" placeholder="Type your reply..."></textarea>
                        </div>
                        <button class="btn btn-primary">Send Reply</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Ticket Info</div>
                <div class="card-body small text-muted">
                    <p><strong>Status:</strong> {{ ucfirst($ticket->status) }}</p>
                    <p><strong>Submitted:</strong> {{ $ticket->created_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ticketId = {{ $ticket->id }};
    const messagesContainer = document.getElementById('supportMessages');
    const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');

    function fetchMessages() {
        fetch(`/support/${ticketId}/messages`)
            .then(r => r.json())
            .then(list => {
                messagesContainer.innerHTML = '';
                list.forEach(m => {
                    const el = document.createElement('div');
                    el.className = 'mb-2';
                    el.innerHTML = `<div><strong>${m.sender_name || (m.user ? m.user.name : 'User')}</strong> <small class="text-muted">${new Date(m.created_at).toLocaleString()}</small></div><div class="border rounded p-2 bg-light">${escapeHtml(m.message)}</div>`;
                    messagesContainer.appendChild(el);
                });
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            });
    }

    (function(){
        const form = document.getElementById('supportReplyForm');
        if (!form) return;
        const btn = form.querySelector('button[type=submit], button');

        form.addEventListener('submit', function(e){
            e.preventDefault();
            if (form.dataset.sending === '1') return;
            const message = (this.message && this.message.value) ? this.message.value.trim() : '';
            if (!message) return alert('Please enter a message');
            form.dataset.sending = '1'; if (btn) btn.disabled = true;

            const formData = new FormData(this);
            fetch('/support/messages', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token },
                body: formData
            }).then(r => r.json()).then(resp => {
                if (resp.success) { fetchMessages(); form.reset(); }
            }).catch(err => console.error(err)).finally(() => { delete form.dataset.sending; if (btn) btn.disabled = false; });
        });
    })();

    function escapeHtml(str){ return (str||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\"/g,'&quot;').replace(/\'/g, '&#039;'); }

    fetchMessages();
    setInterval(fetchMessages, 15000);
});
</script>
@endpush
@endsection
