@extends('layouts.provider-layout')

@section('parent-title', 'Messages - Parent Portal')
@section('content')
<div class="page-wrapper">

    <!-- Start Content -->
    <div class="content">
        <div class="section-card">
            <div class="section-title d-flex justify-content-between align-items-center">
                Inquiries & Messages
            </div>
            <div class="section-subtitle">Track your communications with users</div>

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
                        <div class="stat-number">{{ $inquiries->where('status', 'pending')->count() }}</div>
                        <div class="stat-label">New</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card text-center">
                        <div class="stat-number">{{ $inquiries->where('status', 'contacted')->count() }}</div>
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
            @forelse($inquiries as $inquiry)
            <div class="message-card">
                <div class="message-header">
                    <div class="d-flex align-items-center">
                        <div class="provider-avatar bg-primary me-3">
                            {{ substr($inquiry->user->name ?? 'P', 0, 1) }}
                        </div>
                        <div>
                            <div class="provider-name">{{ $inquiry->user->first_name ?? 'Provider' }}</div>
                            <div class="mt-2"><strong>{{ $inquiry->subject ?? 'Inquiry' }}</strong></div>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="status-badge status-{{ $inquiry->status }}">
                            @if($inquiry->status === 'pending')
                                New
                            @elseif($inquiry->status === 'contacted')
                                Provider Responded
                            @else
                                Closed
                            @endif
                        </span>
                        <button class="btn btn-light border btn-sm ms-2 chat-toggle" 
                                data-inquiry-id="{{ $inquiry->id }}"
                                data-provider-name="{{ $inquiry->user->first_name ?? 'Provider' }}"
                                data-status="{{ $inquiry->status }}">
                            View Chat
                        </button>
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
                <p class="text-muted">You haven't recieved any inquiries yet.</p>
               
            </div>
            @endforelse

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


<!-- Chat Modal -->
<div class="modal fade" id="chatModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chatProviderName">Chat with Provider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Status Toggle Buttons -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <span class="badge" id="currentStatusBadge"></span>
                    </div>
                    <button type="button" class="btn btn-sm" id="toggleStatusBtn">
                        <!-- Text will be set dynamically -->
                    </button>
                </div>

                <div id="chatMessages" class="chat-messages" style="height: 400px; overflow-y: auto; border: 1px solid #e9ecef; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                    <!-- Chat messages will be loaded here -->
                </div>
                
                <!-- Closed Inquiry Notice -->
                <div id="closedNotice" class="alert alert-info" style="display: none;">
                    <i class="fas fa-info-circle me-2"></i>
                    This inquiry is closed. Reopen it to send messages.
                </div>

                <form id="chatForm">
                    @csrf
                    <input type="hidden" id="currentInquiryId" name="inquiry_id">
                    <input type="hidden" id="currentInquiryStatus" name="inquiry_status">
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

    // Handle "View Chat" button clicks
    document.querySelectorAll('.chat-toggle').forEach(button => {
        button.addEventListener('click', function() {
            const inquiryId = this.getAttribute('data-inquiry-id');
            const providerName = this.getAttribute('data-provider-name');
            const status = this.getAttribute('data-status');

            // Always reuse ONE modal
            const chatModalEl = document.getElementById('chatModal');
            const chatForm = chatModalEl.querySelector('form');
            const chatMessages = chatModalEl.querySelector('#chatMessages');

            document.getElementById('chatProviderName').textContent = 'Chat with ' + providerName;
            chatForm.querySelector('#currentInquiryId').value = inquiryId;
            chatForm.querySelector('#currentInquiryStatus').value = status;

            // Update status display
            updateStatusDisplay(status);

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

    // Handle status toggle button
    document.getElementById('toggleStatusBtn').addEventListener('click', function() {
        const inquiryId = document.getElementById('currentInquiryId').value;
        const currentStatus = document.getElementById('currentInquiryStatus').value;
        const newStatus = currentStatus === 'closed' ? 'contacted' : 'closed';

        // Disable button during request
        this.disabled = true;

        fetch(`/inquiries/${inquiryId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({
                status: newStatus
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Update the hidden status field
                document.getElementById('currentInquiryStatus').value = data.status;
                
                // Update status display
                updateStatusDisplay(data.status);

                // Update the status badge in the main list
                const messageCard = document.querySelector(`.chat-toggle[data-inquiry-id="${inquiryId}"]`)
                    .closest('.message-card');
                const statusBadge = messageCard.querySelector('.status-badge');
                statusBadge.className = `status-badge status-${data.status}`;
                statusBadge.textContent = data.status === 'closed' ? 'Closed' : 'Provider Responded';

                // Update the data-status attribute
                document.querySelector(`.chat-toggle[data-inquiry-id="${inquiryId}"]`)
                    .setAttribute('data-status', data.status);

                // Show success message
                showToast('Status updated successfully', 'success');
            }
        })
        .catch(() => {
            showToast('Error updating status', 'error');
        })
        .finally(() => {
            this.disabled = false;
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
                    div.className = `message-bubble ${message.sender_type === 'provider' ? 'user-message' : 'provider-message'}`;
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

    // Update status display in modal
    function updateStatusDisplay(status) {
        const statusBadge = document.getElementById('currentStatusBadge');
        const toggleBtn = document.getElementById('toggleStatusBtn');
        const chatForm = document.getElementById('chatForm');
        const closedNotice = document.getElementById('closedNotice');

        if (status === 'closed') {
            statusBadge.className = 'badge bg-success';
            statusBadge.textContent = 'Closed';
            toggleBtn.className = 'btn btn-sm btn-outline-primary';
            toggleBtn.innerHTML = '<i class="fas fa-folder-open me-1"></i> Reopen Inquiry';
            
            // Hide chat form and show closed notice
            chatForm.style.display = 'none';
            closedNotice.style.display = 'block';
        } else {
            statusBadge.className = 'badge bg-warning';
            statusBadge.textContent = status === 'pending' ? 'New' : 'Active';
            toggleBtn.className = 'btn btn-sm btn-outline-danger';
            toggleBtn.innerHTML = '<i class="fas fa-check me-1"></i> Mark as Closed';
            
            // Show chat form and hide closed notice
            chatForm.style.display = 'block';
            closedNotice.style.display = 'none';
        }
    }

    // Simple toast notification function
    function showToast(message, type) {
        const toast = document.createElement('div');
        toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed top-0 end-0 m-3`;
        toast.style.zIndex = '9999';
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
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

.status-pending {
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