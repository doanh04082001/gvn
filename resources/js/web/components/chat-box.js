export class Chatbox {

    constructor() {
        this.uid = '';
        this.firebaseAuthWithToken();
        this.onShowOrderDetailModal();
        this.onHideOrderDetailModal();
        this.onNewMessageAdded();
    }

    openChat() {
        document.getElementById('chatbox').style.display = 'block';
        this.scrollBottom();
    }

    closeChat() {
        document.getElementById('chatbox').style.display = 'none';
    }

    onShowOrderDetailModal() {
        document.getElementById('order-detail').addEventListener('shown.bs.modal', (event) => {
            this.orderId = document.getElementById('btn-reorder').getAttribute('data-order-id');
            this.storeId = document.getElementById('btn-reorder').getAttribute('data-store-id');

            const progress = document.querySelector('.progressbar').querySelectorAll('.active');
            const progressStatus = progress[progress.length - 1].dataset.status;
            if (progressStatus == orderStatus.processing || progressStatus == orderStatus.shipping) {
                document.getElementById('open-chat').style.display = 'block';
            }
            this.firebaseGetConversation()
        })
    }

    onHideOrderDetailModal() {
        document.getElementById('order-detail').addEventListener('hide.bs.modal', (event) => {
            firebase.database().ref(`chats/stores/${this.storeId}/orders/${this.orderId}/messages`).off();
            document.getElementById('open-chat').style.display = 'none';
            this.closeChat();
            document.getElementById('chatbox-content').innerHTML = '';
        })
    }

    onNewMessageAdded() {
        document.getElementById('chatbox-content').addEventListener('DOMNodeInserted',(event) => {
            this.scrollBottom();
        }, false);
    }

    scrollBottom() {
        const chatboxContentElement = document.getElementById('chatbox-content');
        chatboxContentElement.scrollTop = chatboxContentElement.scrollHeight;
    }

    sendMessage() {
        const inputMessage = document.getElementById('chat-message').value;

        if (inputMessage) {
            const ref = firebase.database().ref(`chats/stores/${this.storeId}/orders/${this.orderId}/messages`);
            ref.push({
                content: inputMessage,
                sender: this.uid,
                created_at: Date.now(),
                seen: false,
            });

            firebase.database().ref(`chats/stores/${this.storeId}/orders/${this.orderId}`)
                .update({updated_at: Date.now()});

            document.getElementById('chat-message').value = '';
        }
    }

    addMessage(data) {
        const messageGroupElement = document.createElement('div');
        messageGroupElement.className = 'chat-message-group';
        if (data.sender == this.uid) {
            messageGroupElement.classList.add('self')
        }

        const chatMessageElement = document.createElement('div');
        chatMessageElement.className = 'chat-messages';

        const messageElement = document.createElement('div');
        messageElement.className = 'message';
        messageElement.textContent = data.content;

        const timeElement = document.createElement('div');
        timeElement.className = 'from';
        timeElement.textContent = moment.utc(data.created_at).tz(moment.tz.guess()).format('hh:mm A');

        chatMessageElement.appendChild(messageElement);
        chatMessageElement.appendChild(timeElement);
        messageGroupElement.appendChild(chatMessageElement);

        document.getElementById('chatbox-content').appendChild(messageGroupElement);
    }

    firebaseGetConversation() {
        firebase.database().ref(`chats/stores/${this.storeId}/orders/${this.orderId}/messages`)
            .on('child_added', (snapshot) => {
                this.addMessage(snapshot.val())
            });
    }

    onKeyUp(event) {
        if (event.key === 'Enter') {
            this.sendMessage();
        }
    }

    firebaseAuthWithToken(token) {
        firebase.auth().signInWithCustomToken(FIREBASE_TOKEN)
            .then((userCredential) => {
                this.uid = userCredential.user.uid
            })
            .catch((error) => {

            });
    }
}