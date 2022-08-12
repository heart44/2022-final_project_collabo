import io from "socket.io-client";

const socket = io.connect("http://192.168.0.42:3000", {
    path: '/socket.io',
    transports: ['websocket']
});

//전역(this.$socket) 으로 사용할 수 있도록 세팅
const socketPlugin = {
  install: (app, options) => {
    // vue.prototype.$socket = socket;이었던 부분을 아랫줄로 변경
    app.config.globalProperties.$socket = socket;
  },
};

export default socketPlugin;
