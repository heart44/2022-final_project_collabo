<template>
    <div class="">

        <!-- 메세지 뜨는 부분 -->
        <div class="chat__body" id="chat__body">
            <div v-for="(item, index) in chatList" :key="index" :msg="item" :prev="[index == 0 ? null : chatList[index - 1]]">
                <div v-if="item.name === userNick" class="chat__mymessage" :class="[sent ? '' : 'chat__first']">
                    <p class="chat__mymessage__paragraph">{{ item.msg }}</p>
                </div>
                <div v-else class="chat__yourmessage" :class="[sent ? '' : 'chat__first']">
                    <div class="chat__yourmessage__avartar">
                        <img :src="avatar" alt="" v-if="!sent" class="chat__yourmessage__img">
                    </div>
                    <div>
                        <p class="chat__yourmessage__user" v-if="!sent">
                            {{ item.name }}
                        </p>
                        <div class="chat__yourmessage__p">
                            <p class="chat__yourmessage__paragraph">
                                {{ item.msg }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 메세지 입력 부분 -->
        <div class="form">
            <input class="form__input" type="text" placeholder="메세지를 입력하세요." v-model.trim="input" @keyup.enter="sendMsg">
            <div class="form__submit" @click="sendMsg">
                <svg width="30" height="30" viewBox="0 0 68 68" fill="#CCCCCC" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_26_10)">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M48.0833 19.799C48.619 20.3347 48.806 21.127 48.5665 21.8457L35.8385 60.0294C35.5946 60.7614 34.9513 61.2877 34.1855 61.382C33.4198 61.4763 32.6681 61.1217 32.2539 60.4707L22.593 45.2893L7.41158 35.6285C6.76065 35.2142 6.40604 34.4625 6.50031 33.6968C6.59458 32.931 7.12092 32.2878 7.85287 32.0438L46.0366 19.3159C46.7553 19.0763 47.5476 19.2633 48.0833 19.799ZM26.5903 44.1204L33.3726 54.7782L42.0926 28.6181L26.5903 44.1204ZM39.2642 25.7897L23.7619 41.292L13.1041 34.5097L39.2642 25.7897Z"
                        fill=""/>
                    </g>
                    <defs>
                        <clipPath id="clip0_26_10">
                        <rect width="48" height="48" fill="white" transform="translate(33.9412) rotate(45)"/>
                        </clipPath>
                    </defs>
                </svg>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            input: '',
            chatList: [],
            iuser: {},
            userNick: '',
            sent: false,
            avatar: require('../assets/carrot-svgrepo-com.svg')
        }
    },
    computed: {
        user() {
            return this.$store.state.user;
        },
    },
    created() {
        console.log(this.user)
        if(this.user) {
            this.iuser = this.$store.state.user;
            this.userNick = this.iuser.nick;
        }
        this.$socket.on('msg', data => {
            this.chatList.push(data);
        });
    },
    updated() {
        if(this.user) {
            this.iuser = this.$store.state.user;
            this.userNick = this.iuser.nick;
        }
        const chatBody = document.querySelector('.chat__body');
              chatBody.scrollTop = chatBody.scrollHeight;
    },
    methods: {        
        sendMsg() {
            if(this.userNick === undefined) {
                this.$swal.fire('🥕채팅 불가🥕', '로그인이 필요한 서비스입니다', 'warning')
                return false
            }
            if(this.input !== '' && this.userNick !== '') {
                this.$socket.emit('msg', {
                    msg: this.input,
                    name: this.userNick,
                });
                this.input = '';
            } else {
                this.input = '';
                this.$swal.fire('🥕내용을 입력해주세요🥕', '내용을 입력해 주세요', 'warning')    
            }
        }
    },
}
</script>

<style scoped>
/* 채팅 리스트 부분 */
.chat__body {
    width: 100%;
    height: 50vh;
    overflow-y: auto;
    padding: 0 20px;
    display: flex;
    flex-direction: column;
    justify-content: start;
}
.chat__body::-webkit-scrollbar {
    display: none;
}
/* .sent {
    display: none;
    flex-direction: column;
    align-items: flex-end;
} */
.chat__mymessage {
    display: flex;
    justify-content: right;
    align-items: flex-end;
    margin: 0;
    min-height: 40px;
    line-break: anywhere;
}
.chat__mymessage__paragraph {
    margin: 0.4rem 0 0 1rem;
    border-radius: 20px 20px 0px 20px;
    max-width: 180px;
    background-color: #2B3F6B;
    color: #ffffff;
    padding: 0.8rem;
    font-size: 14px;
}
.chat__first {
    margin-top: 1.2rem;
}
.chat__yourmessage {
    display: flex;
}
.chat__yourmessage__avartar {
    width: 40px;
    margin-right: 1rem;
}
.chat__yourmessage__img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}
.chat__yourmessage__user {
    font-size: 14px;
    font-weight: 700;
    color: #292929;
    margin-top: 0;
    margin-block-end: 0rem;
}
.chat__yourmessage__p {
    display: flex;
    align-items: flex-end;
    line-break: anywhere;
}
.chat__yourmessage__paragraph {
    margin: 0.4rem 1rem 0 0;
    border-radius: 0px 20px 20px 20px;
    background-color: #F26C38;
    max-width: 180px;
    color: #ffffff;
    padding: 0.8rem;
    font-size: 14px;
}
/* .chat__yourmessage__time {
    margin: 0;
    font-size: 12px;
    color: #9c9c9c;
} */


/* 메세지 입력 부분 CSS */
.form {
    display: flex;
    justify-content: space-between;
    padding: 1.4rem;
    margin-bottom: 10px;
    background: #ffffff;
    border-radius: 30px 30px 24px 24px;
    box-shadow: 0px -5px 30px rgba(0, 0, 0, 0.05);
}
.form__input {
    border: none;
    padding: 0.5rem;
    font-size: 16px;
    width: calc(100% - 60px);
}
.form__input:focus {
    outline: none;
}
.form__submit {
    display: flex;
    align-items: center;
    cursor: pointer;
}
svg {
    transition: 0.3s;
}
svg:hover {
    fill: #999999;
}
</style>