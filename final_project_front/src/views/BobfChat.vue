<template>
  <div>
    <div class="h4">도전ㅠㅠㅠㅠ</div>
    <div>닉네임 : {{user.nick}}</div>
    <div>재훈-재훈~ 헬프미~</div>
        <div v-for="(item, idx) in chatList" :key="idx">
          {{ item.name }} : {{ item.msg }}
        </div>
    <div>
        <input type="text" v-model="input"><button @click="sendMsg">전송</button>
    </div>
  </div>
</template>

<script>
export default {
    data() {
        return {
            input: '',
            chatList: []
        }
    },
    computed: {
        user() {
            return this.$store.state.user;
        },
    },
    created() { //백에서 받은 글을 보냄 (단점은, 보안이 좋지 않으므로 소켓io의 room이라는 것을 통해 보안을 올리면 됨다)
        this.socketId = this.$socket.id 
        this.$socket.on('msg', data => {
            this.chatList.push(data);
        });
    },
    methods: {
        sendMsg() {
            this.$socket.emit("msg", {
                msg: this.input,
                name: this.socketId
            });
        }
    }
}
</script>

<style>

</style>