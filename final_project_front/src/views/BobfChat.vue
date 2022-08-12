<template>
  <div>
    <h1>도전...!</h1>
    <div class="chat">
        <div class="chat_header">
            <span class="chat_header_greetings">
                안녕하세요. {{ user.nick }}님!
            </span>
        </div>
        <div></div>
    </div>
  </div>
</template>

<script>
export default {
    data() {
        return {

        }
    },
    components: {

    },
    computed: {
        user() {
            return this.$store.state.user;
        },
    },
    created() {

    },
    mounted(){

    },
    methods: {
        
        
    }
}
</script>

<style scoped>
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