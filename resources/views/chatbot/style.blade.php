<style>

/* Chatbot Styles */
.chatbot-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
    font-family: "Roboto", sans-serif;
}

.chatbot-trigger {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: var(--gradient-gold);
    border: none;
    box-shadow: 0 4px 12px rgba(212,175,55,0.4);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    position: relative;
}

.chatbot-trigger:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 16px rgba(212,175,55,0.6);
}

.chatbot-trigger i {
    font-size: 28px;
    color: white;
}

.chatbot-trigger.active {
    background: var(--brand-dark);
}

.chatbot-window {
    display: none;
    position: fixed;
    bottom: 90px;
    right: 20px;
    width: 380px;
    height: 550px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(18,18,18,0.15);
    flex-direction: column;
    overflow: hidden;
    animation: slideUp 0.3s ease;
}

.chatbot-window.show {
    display: flex;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.chatbot-header {
    background: var(--gradient-gold);
    color: white;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chatbot-header-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.chatbot-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
}

.chatbot-avatar i {
    font-size: 20px;
    color: var(--brand-gold-200);
}

.chatbot-header-text h4 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
}

.chatbot-header-text p {
    margin: 0;
    font-size: 12px;
    opacity: 0.9;
}

.chatbot-close {
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    padding: 0;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: background 0.2s ease;
}

.chatbot-close:hover {
    background: rgba(255,255,255,0.2);
}

.chatbot-messages {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    background: #FAF9F7;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.chatbot-message {
    display: flex;
    gap: 8px;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.chatbot-message.bot {
    justify-content: flex-start;
}

.chatbot-message.user {
    justify-content: flex-end;
}

.chatbot-message-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--brand-gold-200);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.chatbot-message-avatar i {
    font-size: 16px;
    color: white;
}

.chatbot-message-content {
    max-width: 70%;
    padding: 12px 16px;
    border-radius: 16px;
    font-size: 14px;
    line-height: 1.5;
}

.chatbot-message.bot .chatbot-message-content {
    background: white;
    color: var(--text-color);
    border-bottom-left-radius: 4px;
}

.chatbot-message.user .chatbot-message-content {
    background: var(--brand-gold-200);
    color: white;
    border-bottom-right-radius: 4px;
}

.chatbot-typing {
    display: flex;
    gap: 4px;
    padding: 8px;
}

.chatbot-typing span {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--brand-gold-200);
    animation: typing 1.4s infinite;
}

.chatbot-typing span:nth-child(2) {
    animation-delay: 0.2s;
}

.chatbot-typing span:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes typing {
    0%, 60%, 100% {
        transform: translateY(0);
        opacity: 0.6;
    }
    30% {
        transform: translateY(-10px);
        opacity: 1;
    }
}

.chatbot-quick-replies {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 8px;
}

.chatbot-quick-reply {
    padding: 8px 14px;
    border: 1px solid var(--brand-gold-200);
    background: white;
    color: var(--brand-gold-200);
    border-radius: 20px;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.chatbot-quick-reply:hover {
    background: var(--brand-gold-200);
    color: white;
}

.chatbot-input-area {
    padding: 16px;
    background: white;
    border-top: 1px solid rgba(148,163,184,0.2);
    display: flex;
    gap: 12px;
}

.chatbot-input {
    flex: 1;
    border: 1px solid rgba(148,163,184,0.2);
    border-radius: 24px;
    padding: 12px 16px;
    font-size: 14px;
    outline: none;
    transition: border-color 0.2s ease;
}

.chatbot-input:focus {
    border-color: var(--brand-gold-200);
}

.chatbot-send-btn {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: var(--brand-gold-200);
    border: none;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.chatbot-send-btn:hover {
    background: var(--brand-gold-300);
    transform: scale(1.05);
}

.chatbot-send-btn:disabled {
    background: #ccc;
    cursor: not-allowed;
    transform: scale(1);
}

.chatbot-send-btn i {
    font-size: 18px;
}

/* Scrollbar styling */
.chatbot-messages::-webkit-scrollbar {
    width: 6px;
}

.chatbot-messages::-webkit-scrollbar-track {
    background: transparent;
}

.chatbot-messages::-webkit-scrollbar-thumb {
    background: var(--brand-gold-200);
    border-radius: 3px;
}

.chatbot-messages::-webkit-scrollbar-thumb:hover {
    background: var(--brand-gold-300);
}

/* Mobile responsiveness */
@media (max-width: 480px) {
    .chatbot-window {
        width: calc(100vw - 40px);
        height: calc(100vh - 120px);
        right: 20px;
        bottom: 90px;
    }
}


</style>