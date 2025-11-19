@extends('layouts.parent-layout')

@section('parent-title', 'Messages - Parent Portal')
@section('content')

<div class="page-wrapper">

    <!-- Start Content -->
    <div class="content">
        <div class="section-card">
            <div class="section-title d-flex justify-content-between align-items-center">
                Inquiries & Messages
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#composeModal">Compose Message</button>
            </div>
            <div class="section-subtitle">Track your communications with childcare providers</div>

            <!-- Statistics Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="stat-card text-center">
                        <div class="stat-number">{{ $inquiries->count() }}</div>
                        <div class="stat-label">Total Inquiries</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card text-center">
                        <div class="stat-number">{{ $inquiries->where('status', 'new')->count() }}</div>
                        <div class="stat-label">New</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card text-center">
                        <div class="stat-number">{{ $inquiries->where('status', 'responded')->count() }}</div>
                        <div class="stat-label">Responded</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card text-center">
                        <div class="stat-number">{{ $inquiries->where('status', 'closed')->count() }}</div>
                        <div class="stat-label">Closed</div>
                    </div>
                </div>
            </div>

            <!-- Inquiries List -->
            @php
                $active = $inquiries->filter(function($i) { return !in_array($i->status, ['closed','rejected']); });
                $past = $inquiries->filter(function($i) { return in_array($i->status, ['closed','rejected']); });
            @endphp

            <h5 class="mt-3">Active Requests</h5>
            @forelse($active as $inquiry)
            <div class="message-card">
                <div class="message-header">
                    <div class="d-flex align-items-center">
                        <div class="provider-avatar bg-primary me-3">
                            {{ substr($inquiry->provider->name ?? 'P', 0, 1) }}
                        </div>
                        <div>
                            <div class="provider-name">{{ $inquiry->provider->name ?? 'Provider' }}@includeWhen($inquiry->provider && $inquiry->provider->user, 'components.verified-badge', ['user' => $inquiry->provider->user ?? null])</div>
                            <div class="provider-type">{{ $inquiry->provider->type ?? 'Childcare Provider' }}</div>
                            <div class="mt-2"><strong>{{ $inquiry->subject ?? 'Inquiry' }}</strong></div>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="status-badge status-{{ $inquiry->status }}" id="status-badge-{{ $inquiry->id }}">
                            @if($inquiry->status === 'new')
                                New
                            @elseif($inquiry->status === 'responded')
                                Provider Responded
                            @else
                                Closed
                            @endif
                        </span>
                        <div class="btn-group">
                            <button class="btn btn-light border btn-sm chat-toggle" 
                                    data-inquiry-id="{{ $inquiry->id }}"
                                    data-provider-name="{{ $inquiry->provider->name ?? 'Provider' }}">
                                Contact Provider
                            </button>
                            <button class="btn btn-outline-secondary btn-sm reschedule-btn" 
                                    data-inquiry-id="{{ $inquiry->id }}">
                                Reschedule
                            </button>
                            <button class="btn btn-danger btn-sm cancel-btn" data-inquiry-id="{{ $inquiry->id }}">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
                <p class="mb-2">{{ Str::limit($inquiry->message, 150) }}</p>
                <div class="text-muted small">
                    <i class="far fa-clock me-1"></i> 
                    {{ $inquiry->created_at->format('M d, Y') }} • 
                    {{ $inquiry->messages->count() }} messages
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="fas fa-envelope-open-text fa-3x text-muted mb-3"></i>
                <h5>No Inquiries Yet</h5>
                <p class="text-muted">You haven't sent any inquiries to providers yet.</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#composeModal">
                    Send Your First Inquiry
                </button>
            </div>
            @endforelse

            @if($past->count())
            <h5 class="mt-4">Past Requests</h5>
            @foreach($past as $inquiry)
            <div class="message-card muted">
                <div class="message-header">
                    <div class="d-flex align-items-center">
                        <div class="provider-avatar bg-secondary me-3">
                            {{ substr($inquiry->provider->name ?? 'P', 0, 1) }}
                        </div>
                        <div>
                            <div class="provider-name">{{ $inquiry->provider->name ?? 'Provider' }}</div>
                            <div class="provider-type">{{ $inquiry->provider->type ?? 'Childcare Provider' }}</div>
                            <div class="mt-2"><strong>{{ $inquiry->subject ?? 'Inquiry' }}</strong></div>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="status-badge status-{{ $inquiry->status }}">
                            Closed
                        </span>
                        <button class="btn btn-light border btn-sm ms-2 chat-toggle" 
                                data-inquiry-id="{{ $inquiry->id }}"
                                data-provider-name="{{ $inquiry->provider->name ?? 'Provider' }}">
                            View Chat
                        </button>
                    </div>
                </div>
                <p class="mb-2 text-muted">{{ Str::limit($inquiry->message, 150) }}</p>
                <div class="text-muted small">
                    <i class="far fa-clock me-1"></i> 
                    {{ $inquiry->created_at->format('M d, Y') }} • 
                    {{ $inquiry->messages->count() }} messages
                </div>
            </div>
            @endforeach
            @endif

            <!-- Pagination -->
            @if($inquiries->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $inquiries->links() }}
            </div>
            @endif
        </div>
    </div>
    <!-- End Content -->            

</div>

<!-- Compose Message Modal -->
<div class="modal fade" id="composeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Compose New Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('inquiries.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Provider</label>
                        <select class="form-select" name="provider_id" required>
                            <option value="">Choose a provider...</option>
                            @foreach($providers as $provider)
                            <option value="{{ $provider->id }}">{{ $provider->name }} - {{ $provider->type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Your Name</label>
                                <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Your Email</label>
                                <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" class="form-control" name="subject" placeholder="e.g., Enrollment Inquiry for 3-year-old" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" name="message" rows="5" placeholder="Write your message here..." required></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="newsletter_opt_in" value="1">
                        <label class="form-check-label">
                            Subscribe to newsletter for updates and tips
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Chat Modal -->
<div class="modal fade" id="chatModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chatProviderName">Chat with Provider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="chatMessages" class="chat-messages" style="height: 400px; overflow-y: auto; border: 1px solid #e9ecef; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                    <!-- Chat messages will be loaded here -->
                </div>
                <form id="chatForm">
                    @csrf
                    <input type="hidden" id="currentInquiryId" name="inquiry_id">
                    <div class="input-group">
                        <input type="text" id="chatMessage" name="message" class="form-control" placeholder="Type your message..." required>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // --- Chat toggle functionality ---
    document.querySelectorAll('.chat-toggle').forEach(button => {
        button.addEventListener('click', function() {
            const inquiryId = this.getAttribute('data-inquiry-id');
            const providerName = this.getAttribute('data-provider-name');
            
            document.getElementById('chatProviderName').textContent = 'Chat with ' + providerName;
            document.getElementById('currentInquiryId').value = inquiryId;
            
            loadChatMessages(inquiryId);
            
            const chatModal = new bootstrap.Modal(document.getElementById('chatModal'));
            chatModal.show();
        });
    });

    // --- Load chat messages ---
    function loadChatMessages(inquiryId) {
        const chatMessages = document.getElementById('chatMessages');
        chatMessages.innerHTML = '<div class="text-center py-3"><i class="fas fa-spinner fa-spin"></i> Loading messages...</div>';
        
        fetch(`/inquiries/${inquiryId}/messages`)
            .then(response => response.json())
            .then(data => {
                chatMessages.innerHTML = '';
                data.messages.forEach(message => {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = `message-bubble ${message.sender_type === 'user' ? 'user-message' : 'provider-message'}`;
                    messageDiv.innerHTML = `
                        <div class="message-content">${message.message}</div>
                        <div class="message-time">${message.created_at}</div>
                    `;
                    chatMessages.appendChild(messageDiv);
                });
                chatMessages.scrollTop = chatMessages.scrollHeight;
            })
            .catch(() => {
                chatMessages.innerHTML = '<div class="text-center py-3 text-danger">Error loading messages</div>';
            });
    }

    // --- Prevent multiple submissions ---
    const chatForm = document.getElementById('chatForm');

    // Remove any old event listener before adding a new one
    chatForm.addEventListener('submit', handleChatSubmit);
    
    function handleChatSubmit(e) {
        e.preventDefault();

        const inquiryId = document.getElementById('currentInquiryId').value;
        const messageInput = document.getElementById('chatMessage');
        const message = messageInput.value.trim();
        
        if (!message) return;

        // Disable button temporarily to prevent double-click spam
        const sendButton = chatForm.querySelector('button[type="submit"]');
        sendButton.disabled = true;

        fetch('/inquiries/messages', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({
                inquiry_id: inquiryId,
                message: message
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageInput.value = '';
                loadChatMessages(inquiryId);
            }
        })
        .catch(() => {
            alert('Error sending message');
        })
        .finally(() => {
            // Re-enable button after send completes
            sendButton.disabled = false;
        });
    }
});
</script>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Handle "View Chat" button clicks
    document.querySelectorAll('.chat-toggle').forEach(button => {
        button.addEventListener('click', function() {
            const inquiryId = this.getAttribute('data-inquiry-id');
            const providerName = this.getAttribute('data-provider-name');

            // Always reuse ONE modal
            const chatModalEl = document.getElementById('chatModal');
            const chatForm = chatModalEl.querySelector('form');
            const chatMessages = chatModalEl.querySelector('#chatMessages');

            document.getElementById('chatProviderName').textContent = 'Chat with ' + providerName;
            chatForm.querySelector('#currentInquiryId').value = inquiryId;

            loadChatMessages(inquiryId, chatMessages);

            const chatModal = new bootstrap.Modal(chatModalEl);
            chatModal.show();

            // Remove previous submit listeners to prevent duplicates
            chatForm.replaceWith(chatForm.cloneNode(true));

            // Rebind submit listener
            chatModalEl.querySelector('form').addEventListener('submit', function(e) {
                e.preventDefault();

                const inquiryId = this.querySelector('#currentInquiryId').value;
                const messageInput = this.querySelector('#chatMessage');
                const message = messageInput.value.trim();

                if (!message) return;

                const sendButton = this.querySelector('button[type="submit"]');
                sendButton.disabled = true;

                fetch('/inquiries/messages', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({
                        inquiry_id: inquiryId,
                        message: message
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        messageInput.value = '';
                        loadChatMessages(inquiryId, chatMessages);
                    }
                })
                .catch(() => alert('Error sending message'))
                .finally(() => sendButton.disabled = false);
            });
        });
    });

    // Load chat messages dynamically
    function loadChatMessages(inquiryId, chatMessages) {
        chatMessages.innerHTML = '<div class="text-center py-3"><i class="fas fa-spinner fa-spin"></i> Loading...</div>';

        fetch(`/inquiries/${inquiryId}/messages`)
            .then(res => res.json())
            .then(data => {
                chatMessages.innerHTML = '';
                data.messages.forEach(message => {
                    const div = document.createElement('div');
                    div.className = `message-bubble ${message.sender_type === 'user' ? 'user-message' : 'provider-message'}`;
                    div.innerHTML = `
                        <div class="message-content">${message.message}</div>
                        <div class="message-time">${message.created_at}</div>
                    `;
                    chatMessages.appendChild(div);
                });
                chatMessages.scrollTop = chatMessages.scrollHeight;
            })
            .catch(() => {
                chatMessages.innerHTML = '<div class="text-center py-3 text-danger">Error loading messages</div>';
            });
    }

});
</script>


<style>
.message-bubble {
    margin-bottom: 15px;
    padding: 10px 15px;
    border-radius: 18px;
    max-width: 70%;
    position: relative;
}

.user-message {
    background-color: #007bff;
    color: white;
    margin-left: auto;
    border-bottom-right-radius: 5px;
}

.provider-message {
    background-color: #f8f9fa;
    color: #333;
    border: 1px solid #e9ecef;
    border-bottom-left-radius: 5px;
}

.message-time {
    font-size: 0.75rem;
    opacity: 0.7;
    margin-top: 5px;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
}

.status-new {
    background-color: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
}

.status-responded {
    background-color: #d1ecf1;
    color: #0c5460;
    border: 1px solid #bee5eb;
}

.status-closed {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.chat-messages {
    background-color: #f8f9fa;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // CSRF token helper
    function csrfToken() {
        const tokenInput = document.querySelector('input[name="_token"]');
        return tokenInput ? tokenInput.value : '';
    }

    // Handle Cancel button
    document.querySelectorAll('.cancel-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (!confirm('Are you sure you want to cancel this request?')) return;
            const id = this.getAttribute('data-inquiry-id');
            const url = `/inquiries/${id}/cancel`;

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken()
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const badge = document.getElementById('status-badge-' + id);
                    if (badge) {
                        badge.textContent = 'Closed';
                        badge.className = 'status-badge status-closed';
                    }
                } else {
                    alert('Failed to cancel. Please try again.');
                }
            })
            .catch(() => alert('Server error while cancelling.'));
        });
    });

    // Handle Reschedule (open chat modal with prefilled message)
    document.querySelectorAll('.reschedule-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-inquiry-id');
            // find provider name from related chat-toggle (best-effort)
            const chatToggle = document.querySelector(`.chat-toggle[data-inquiry-id='${id}']`);
            const providerName = chatToggle ? chatToggle.getAttribute('data-provider-name') : 'Provider';

            const chatModalEl = document.getElementById('chatModal');
            const chatForm = chatModalEl.querySelector('form');
            chatForm.querySelector('#currentInquiryId').value = id;
            chatForm.querySelector('#chatMessage').value = 'Hello ' + providerName + ",\nI'd like to reschedule our appointment. Proposed new date/time: [please enter your proposed time]";

            document.getElementById('chatProviderName').textContent = 'Chat with ' + providerName;
            const chatModal = new bootstrap.Modal(chatModalEl);
            chatModal.show();
        });
    });

    // Cleanup fallback: ensure backdrops and body class are removed when modal is hidden
    const chatModalEl = document.getElementById('chatModal');
    if (chatModalEl) {
        chatModalEl.addEventListener('hidden.bs.modal', function () {
            // remove any leftover backdrops
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            // ensure body scroll is restored
            document.body.classList.remove('modal-open');
            document.body.style.paddingRight = '';
        });
    }
});
</script>
@endpush