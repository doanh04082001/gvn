import { showResponseErrorMessage } from '../utils/alerts.js';

new Vue({
    el: '#app',

    data: {
        routes: ROUTES,
        authUser: USER,
        defaultAvatar: DEFAULT_SUPPORT_AVATAR,
        imgPath: IMAGE_PATH,
        storeId: "",
        conversationList: [],
        currentRoom: {
            id: "",
            firebasePath: "",
            messages: []
        },
        message: "",
        isTyping: false,
        firebaseRefs: {
            chat: 'chats/',
            typing: 'typing/',
            user: 'customers/'
        }
    },

    mounted() {
        const storeOpts = this.$refs.storeSelect.children;

        if (storeOpts.length) {
            this.storeId = storeOpts[0].value;
        }
    },

    methods: {
        onChangeStore(storeId) {
            axios
                .get(`${this.routes.getFirebaseToken}?storeId=${this.storeId}`)
                .then(({data}) => {
                    this.firebaseAuthWithToken(data.firebaseToken)
                })
                .catch(error => {
                    if (error?.response?.status === 422) {
                        this.errorsForm = error?.response?.data?.errors ?? defaultErrorsForm
                    }
                    showResponseErrorMessage(error);
                })
        },

        changeConversation(conversation) {
            this.currentRoom.id = conversation ? conversation.id : "";
            this.currentRoom.code = conversation ? conversation.code : "";
            this.currentRoom.customerName = conversation ? conversation.customer.name : "";
            this.currentRoom.customerAvatar = conversation ? `${this.imgPath}/${conversation.customer.avatar_url}` : "";
            this.currentRoom.firebasePath = conversation ? `stores/${this.storeId}/orders/${conversation.id}` : "";
            this.currentRoom.messages = conversation ? conversation.messages : [];
            if (conversation) {
                conversation.unread = this.firebaseSetRead(conversation.unread);
            }
        },

        sendMessage() {
            if (this.message) {
                const ref = firebase.database().ref(`${this.firebaseRefs.chat}${this.currentRoom.firebasePath}/messages`);
                ref.push({
                    content: this.message,
                    sender: this.storeId,
                    created_at: Date.now(),
                    seen: false,
                    supportUser: this.authUser.id
                });

                firebase.database().ref(`${this.firebaseRefs.chat}${this.currentRoom.firebasePath}`)
                    .update({updated_at: Date.now()});

                this.message = "";
            }
        },

        firebaseAuthWithToken(token) {
            firebase.auth().signInWithCustomToken(token)
                .then((userCredential) => {
                    this.firebaseGetConversation();
                    this.detectTyping();
                })
                .then(() => {
                    this.firebaseGetNewMessage();
                })
                .catch((error) => {
                    showResponseErrorMessage(error)
                });
        },

        firebaseGetConversation() {
            this.emptyConversationList();
            firebase.database().ref(`${this.firebaseRefs.chat}stores/${this.storeId}/orders`)
                .orderByChild('updated_at')
                .startAt(new Date().setUTCHours(0,0,0,0))
                .on('child_added', (snapshot) => {
                    this.firebaseGetCustomer(snapshot.val(), snapshot.key);
                });
        },

        firebaseGetNewMessage() {
            firebase.database().ref(`${this.firebaseRefs.chat}stores/${this.storeId}/orders`)
                .on('child_changed', (snapshot) => {
                    const orderId = snapshot.key;
                    const data = snapshot.val();

                    const conversation = this.conversationList.find(e => e.id === orderId);
                    if (!conversation) {
                        this.firebaseGetCustomer(data, orderId, true);
                    } else {
                        this.conversationList = this.conversationList.filter(e => e.id != orderId);
                        this.addNewConversation(orderId, data, conversation.customer, true)

                        if (this.currentRoom.id === conversation.id) {
                            this.currentRoom.messages = conversation.messages;
                        }
                    }
                });
        },

        firebaseGetCustomer(data, orderId, isNew = false) {
            firebase.database().ref(this.firebaseRefs.user + data.customer_id)
                .once('value', (snapshot) => {
                    if (snapshot.val()) {
                        this.addNewConversation(orderId, data, snapshot.val(), isNew)
                    }
                });
        },

        firebaseSetRead(messages) {
            return messages.filter(([key, value]) => {
                firebase.database().ref(`${this.firebaseRefs.chat}${this.currentRoom.firebasePath}/messages/${key}`)
                    .update({seen: true});
                return false;
            });
        },

        addNewConversation(id, data, customer, isNew = false) {
            const conversation = {
                id: id,
                code: data.code,
                messages: data.messages,
                customer: customer,
                unread: this.getUnreadMessages(data.messages)
            };

            if(!isNew)
                this.conversationList.push(conversation)
            else
                this.conversationList.unshift(conversation)
        },

        getUnreadMessages(messages) {
            return Object.entries(messages).filter(([key, value]) => (value.seen === false && value.sender !== this.storeId))
        },

        onKeyUp(event) {
            if (event.key === "Enter") {
                this.sendMessage();
            } else {
                const ref = firebase.database().ref(this.firebaseRefs.typing + this.currentRoom.firebasePath);
                ref.set({
                    [this.storeId]: true
                });

                setTimeout(function() {
                    ref.remove();
                }, 2*1000);
            }
        },

        detectTyping() {
            firebase.database().ref(this.firebaseRefs.typing + this.currentRoom.firebasePath)
                .on('value', (snapshot) => {
                    const data = snapshot.val();

                    if (data) {
                        if (data[this.currentRoom.id]) {
                            this.isTyping = true;
                        }
                    } else {
                        this.isTyping = false;
                    }

                });
        },

        emptyConversationList() {
            this.conversationList.splice(0);
        },

        formatTime(value) {
            return moment(value).format('hh:mm A')
        },

        imageLoadError(e) {
            e.target.src = this.defaultAvatar;
        },

        getOrderRoute(orderId) {
            return this.routes.orderDetail.replace(':id', orderId)
        }
    },

    watch: {
        storeId: function(val) {
            this.emptyConversationList();
            this.changeConversation(null);
            this.onChangeStore(val);
        },
        'currentRoom.messages': function(val) {
            this.$nextTick(function () {
                const chatbox = this.$el.querySelector(".chat-messages");
                if (chatbox)
                    chatbox.scrollTop = chatbox.scrollHeight;
            });
        }
    }
});
