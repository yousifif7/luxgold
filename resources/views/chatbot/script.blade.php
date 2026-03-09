<script>
// Chatbot functionality
class Chatbot {
    constructor() {
        this.isOpen = false;
        this.messages = [];
        this.isTyping = false;
        this.conversationId = null;
        this.init();
    }

    init() {
        this.createChatbotHTML();
        this.attachEventListeners();
        this.sendWelcomeMessage();
    }

    createChatbotHTML() {
        const chatbotHTML = `
            <div class="chatbot-container">
                <button class="chatbot-trigger" id="chatbotTrigger">
                    <i class="fas fa-comments"></i>
                </button>
                
                <div class="chatbot-window" id="chatbotWindow">
                    <div class="chatbot-header">
                        <div class="chatbot-header-info">
                            <div class="chatbot-avatar">
                                <i class="fas fa-robot"></i>
                            </div>
                            <div class="chatbot-header-text">
                                <h4>luxGold Assistant</h4>
                                <p>Online • Ready to help</p>
                            </div>
                        </div>
                        <button class="chatbot-close" id="chatbotClose">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <div class="chatbot-messages" id="chatbotMessages">
                        <!-- Messages will be appended here -->
                    </div>
                    
                    <div class="chatbot-input-area">
                        <input 
                            type="text" 
                            class="chatbot-input" 
                            id="chatbotInput" 
                            placeholder="Type your message..."
                            autocomplete="off"
                        />
                        <button class="chatbot-send-btn" id="chatbotSend">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', chatbotHTML);
    }

    attachEventListeners() {
        const trigger = document.getElementById('chatbotTrigger');
        const close = document.getElementById('chatbotClose');
        const send = document.getElementById('chatbotSend');
        const input = document.getElementById('chatbotInput');

        trigger.addEventListener('click', () => this.toggleChat());
        close.addEventListener('click', () => this.toggleChat());
        send.addEventListener('click', () => this.sendMessage());
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') this.sendMessage();
        });
    }

    toggleChat() {
        this.isOpen = !this.isOpen;
        const window = document.getElementById('chatbotWindow');
        const trigger = document.getElementById('chatbotTrigger');

        if (this.isOpen) {
            window.classList.add('show');
            trigger.classList.add('active');
            trigger.innerHTML = '<i class="fas fa-times"></i>';
            document.getElementById('chatbotInput').focus();
        } else {
            window.classList.remove('show');
            trigger.classList.remove('active');
            trigger.innerHTML = '<i class="fas fa-comments"></i>';
        }
    }

    sendWelcomeMessage() {
        setTimeout(() => {
            this.addBotMessage(
                "👋 Hello! I'm the luxGold Assistant. I can help you find premium cleaning services across Ireland. How can I assist you today?",
                [
                    { text: "Find Cleaners", value: "find_cleaners" },
                    { text: "Our Services", value: "browse_services" },
                    { text: "How It Works", value: "how does it work" },
                    { text: "Contact Support", value: "contact_support" }
                ]
            );
        }, 500);
    }

    addBotMessage(text, quickReplies = []) {
        const messagesContainer = document.getElementById('chatbotMessages');
        
        const messageHTML = `
            <div class="chatbot-message bot">
                <div class="chatbot-message-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div>
                    <div class="chatbot-message-content">${text}</div>
                    ${quickReplies.length > 0 ? this.createQuickReplies(quickReplies) : ''}
                </div>
            </div>
        `;

        messagesContainer.insertAdjacentHTML('beforeend', messageHTML);
        this.scrollToBottom();
        this.messages.push({ type: 'bot', text });
    }

    addUserMessage(text) {
        const messagesContainer = document.getElementById('chatbotMessages');
        
        const messageHTML = `
            <div class="chatbot-message user">
                <div class="chatbot-message-content">${text}</div>
            </div>
        `;

        messagesContainer.insertAdjacentHTML('beforeend', messageHTML);
        this.scrollToBottom();
        this.messages.push({ type: 'user', text });
    }

    createQuickReplies(replies) {
        const repliesHTML = replies.map(reply => 
            `<button class="chatbot-quick-reply" onclick="chatbot.handleQuickReply('${reply.value}', '${reply.text}')">${reply.text}</button>`
        ).join('');

        return `<div class="chatbot-quick-replies">${repliesHTML}</div>`;
    }

    handleQuickReply(value, text) {
        // Remove all quick reply buttons
        document.querySelectorAll('.chatbot-quick-replies').forEach(el => el.remove());
        
        this.addUserMessage(text);
        // Handle frontend-native quick actions
        if (value === 'login') {
            try {
                if (typeof openLoginModal === 'function') {
                    openLoginModal();
                    return;
                }
            } catch (e) {}
            // fallback: send to backend if modal not present
        }

        if (value === 'contact_info') {
            // map to email_support
            this.processUserInput('email_support');
            return;
        }

        this.processUserInput(value);
    }

    async sendMessage() {
        const input = document.getElementById('chatbotInput');
        const message = input.value.trim();

        if (!message) return;

        this.addUserMessage(message);
        input.value = '';

        // Show typing indicator
        this.showTypingIndicator();

        // Process the message
        await this.processUserInput(message);
    }

    showTypingIndicator() {
        const messagesContainer = document.getElementById('chatbotMessages');
        const typingHTML = `
            <div class="chatbot-message bot" id="typingIndicator">
                <div class="chatbot-message-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="chatbot-message-content">
                    <div class="chatbot-typing">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        `;
        messagesContainer.insertAdjacentHTML('beforeend', typingHTML);
        this.scrollToBottom();
    }

    removeTypingIndicator() {
        const indicator = document.getElementById('typingIndicator');
        if (indicator) indicator.remove();
    }

    async processUserInput(input) {
        try {
            const response = await fetch('/api/chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: input })
            });

            const data = await response.json();

            setTimeout(() => {
                this.removeTypingIndicator();
                this.addBotMessage(data.response, data.quickReplies || []);
            }, 800);

        } catch (error) {
            console.error('Chatbot error:', error);
            setTimeout(() => {
                this.removeTypingIndicator();
                this.addBotMessage("I'm sorry, I'm having trouble connecting right now. Please try again later or contact our support team.");
            }, 800);
        }
    }

    scrollToBottom() {
        const messagesContainer = document.getElementById('chatbotMessages');
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
}

// Initialize chatbot when DOM is ready
let chatbot;
document.addEventListener('DOMContentLoaded', function() {
    chatbot = new Chatbot();
});


</script>