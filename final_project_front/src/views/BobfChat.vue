<template>    
    <div class="container mt-5">
        <div class="chat">
            <div class="chat__header">
                <span class="chat__header__greetings">
                    안녕하세요 {{ user.nick }}님!
                </span>
            </div>
            <div>
                <BobfChatView></BobfChatView>
            </div>
        </div>
    </div>
</template>

<script>
import BobfChatView from '@/components/BobfChatView.vue';

export default {
    components: { BobfChatView },
    computed: {
        user() {
            return this.$store.state.user;
        },
    },

    created() {
        this.getBobfUser()
    },    
    methods: {
        getBobfUser() {
            const param = { bobfUser: this.$route.params.iuser }
            console.log(param)
        }    
    },
}
</script>

<style scoped>
.container {
    max-width: 700px;
    border-radius: 1.5rem;
    box-shadow: 0px 1px 20px #9c9cc855;
}
.chat {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.chat__header {
    background: #ffffff;
    box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.05);
    border-radius: 24px 24px 0px 0px;
    padding: 1.8rem;
    font-size: 16px;
    font-weight: 700;
}
.chat__header__greetings {
    color: #292929;
}
</style>