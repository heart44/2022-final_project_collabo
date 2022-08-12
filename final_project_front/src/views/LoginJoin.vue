<template>
    <main>
        <div class="container" ref="container">
            <div class="form-container sign-up-container">
                <form @keyup.enter="signup()">
                    <h1>JOIN</h1>
                    <div class="infield">
                        <input type="text" placeholder="Nickname" v-model="inputUser.nick" />
                        <label></label>
                    </div>
                    <div class="infield">
                        <input type="email" placeholder="Email" name="email" ref="email" v-model="inputUser.email" @blur="doubleCheck()" @change="isEmail" />
                        <label></label>
                    </div>
                    <span class="errormsg">{{ emailError }}</span>
                    <span class="errormsg">{{ duplication }}</span>
                    <div class="infield">
                        <input type="password" placeholder="Password" ref="pw" v-model="inputUser.pw"/>
                        <label></label>
                    </div>
                    <div class="d-flex flex-row infield">
                        <select class="mt-2 mb-2 me-1" :key="i" v-model="inputUser.birthYear">
                            <option value="0">birthYear</option>
                            <option v-for="i in year" :key="i" :value="i">{{ i }}</option>
                        </select>
                        <select class="mt-2 mb-2 ms-1" v-model="inputUser.job">
                            <option value="0">Job</option>
                            <option value="1">직장인</option>
                            <option value="2">학생</option>
                        </select>
                    </div>
                    <button type="button" @click="signup()">JOIN</button>
                </form>
            </div>
            <div class="form-container sign-in-container">
                <form @keyup.enter="signin()">
                    <h1>LOGIN</h1>
                    <span>Social Login</span>
                    <div class="social-container">
                        <!-- <img @click="NaverLogin()" class="social" src="../assets/naver.svg" role="button"> -->
                        <img @click="KakaoLogin()" class="social" src="../assets/kakao.svg" role="button">
                        <img @click="GoogleLogin()" class="social" src="../assets/google.svg" role="button">
                        <div id="my-signin2" style="display: none"></div>
                    </div>
                    <div class="infield">
                        <input type="email" placeholder="Email" name="email" ref="email" v-model="inputUser.email"/>
                        <label></label>
                    </div>
                    <div class="infield">
                        <input type="password" placeholder="Password" ref="pw" v-model="inputUser.pw" />
                        <label></label>
                    </div>
                    <router-link class="f_password" to="/PassWord"><span class="forgot">비밀번호 찾기</span></router-link>
                    <button type="button" @click="signin()">LOGIN</button>
                </form>
            </div>

            <div class="overlay-container" id="overlayCon">
                <div class="overlay">
                    <div class="overlay-panel overlay-left">
                        <h1>Welcome Back!</h1>
                        <p>To keep connected with us please login with your personal info</p>
                        <button class="btn_login" @click="changeLoginBox" ref="loginBtn">LOGIN</button>
                    </div>
                    <div class="overlay-panel overlay-right">
                        <h1>Hello!</h1>
                        <p>Enter your personal details and start journey with us</p>
                        <button class="btn_join" @click="changeLoginBox">JOIN</button>
                    </div>
                </div>
                <button ref="overlayBtn"></button>
            </div>
        </div>
    </main>
</template>

<script>
export default {
    data(){
        return{
            inputUser:{
                nick: '',
                email: '',
                pw: '',
                birthYear: 0,
                job: 0,
            },
            duplication: '',
            emailError: '',
        }
    },
    methods:{
        KakaoLogin(){
           window.Kakao.Auth.login({
                scope: 'profile_nickname, profile_image, account_email',
                success: this.getProfile,
                fail: e => {
                    console.error(e);
                }
            });
        },
        getProfile(authObj){
            console.log(authObj);
             window.Kakao.API.request({
                url: '/v2/user/me',
                success: async res => {
                    const acc = res.kakao_account;
                    console.log(acc);
                    const params = {
                        social_type: 1,
                        email: acc.email,
                        nick: acc.profile.nickname,
                        profile_img: acc.profile.profile_image_url,
                        thumb_img: acc.profile.thumbnail_image_url
                    }
                    console.log(params);
                    this.login(params);
                    
                },
                fail: e => {
                    console.error(e);
                }
            });
        },
        async login(params){
            const data = await this.$post('/user/signup', params);                       
            params.iuser = data.result;
            this.$store.commit('user', params);
        },



    

        GoogleLogin(){ 
            var self = this;
            window.gapi.signin2.render('my-signin2', {
                scope:'profile email',
                width: 240,
                height: 50,
                longtitle: true,
                theme: 'dark',
                onsuccess: this.GoogleLoginSuccess,
                onfailure: this.GoogleLoginFailure,
            });

                setTimeout(function () {
                    if (!self.googleLoginCheck) {
                    const auth = window.gapi.auth2.getAuthInstance();
                    auth.isSignedIn.get();
                    document.querySelector('.abcRioButton').click();
                    }
                }, 1000)
            },
            async GoogleLoginSuccess(googleUser) {
            const googleEmail = googleUser.getBasicProfile().getEmail();
            if (googleEmail !== 'undefined') {
                console.log(googleEmail);
            }
            },
            GoogleLoginFailure(error) {
                console.log(error);
        },



        async signin() {
            if(this.inputUser.email === "") {
                this.$refs.email.focus();
                this.$swal.fire('이메일을 입력해주세요.', '', 'warning');
            } else if(this.inputUser.pw === "") {
                this.$refs.pw.focus();
                this.$swal.fire('비밀번호를 입력해주세요.', '', 'warning');
            }
            const param = {
                email: this.inputUser.email,
                pw: this.inputUser.pw
            }
            const dbUser = await this.$post('user/signin', param);
            if(dbUser.result) {
                this.$store.commit('user', dbUser.result);
                this.$router.push('../');
            } else {
                this.$swal.fire('로그인 실패!', '아이디와 비밀번호를 다시 한 번 확인해주세요.', 'error');
            }
        },
        changeLoginBox() {
            const container = this.$refs.container;
            const overlayBtn = this.$refs.overlayBtn;
            
            container.classList.toggle('right-panel-active');

            overlayBtn.classList.remove('btnScaled');
            window.requestAnimationFrame( () =>{
                overlayBtn.classList.add('btnScaled');
            });
        },
        async signup(){
            const join = this.inputUser;

            if(join.email === "") {
                this.$refs.email.focus();
                this.$swal.fire('이메일을 입력해주세요.', '', 'warning');
                return;
            } else if(this.inputUser.pw === "") {
                this.$refs.pw.focus();
                this.$swal.fire('비밀번호를 입력해주세요.', '', 'warning');
                return;
            }
            const param = {
                social_type: 0,
                email: this.inputUser.email,
                pw: this.inputUser.pw,
                nick: this.inputUser.nick,
                birth: this.inputUser.birthYear,
                job: this.inputUser.job
            }
            const joinUser = await this.$post('user/signup', param);
            if(joinUser.result) {
                this.$refs.loginBtn.click();
                this.$swal.fire('회원 가입에 성공했습니다.', '', 'success');
                this.inputUser.nick = "";
                this.inputUser.birthYear = 0;
                this.inputUser.job = 0;
                this.inputUser.pw = "";
            }
        },
        async doubleCheck() {
            const param = {
                social_type: 0,
                email: this.inputUser.email
            }
            const rs = await this.$post('user/doubleCheck', param);
            if(rs.result) {
                this.duplication = '중복된 이메일이 존재합니다.';
            } else {
                this.duplication = '';
            }
        },
        isEmail() {
            const regExp = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
            const check = regExp.test(this.inputUser.email);
            if(!check) {
                this.emailError = '올바른 이메일 형식이 아닙니다.';
            } else {
                this.emailError = '';
            }
        },
    },

    created(){
        this.$store.commit('year');
    },
    computed: {
        year() {
            return this.$store.state.year;
        }
    }
}
</script>

<style scoped>

/* @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap'); */
    
    :root {
    --linear-grad: linear-gradient(to right, #141E30, #243B55);
    --grad-clr1: #141E30;
    --grad-clr2: #243B55;
}
main{
    height:100vh;
    display:grid;
    place-content: center;
}
.container {
    position: relative;
    width:850px;
    height:500px;
    background: #fff;
    box-shadow: 25px 30px 55px #5557;
    border-radius:13px;
    overflow: hidden;
    margin-top:100px;
    margin-bottom:137px;
}
.form-container{
    position: absolute;
    width:60%;
    height:100%;
    padding:0px 40px;
    transition: all 0.6s ease-in-out;
}
.sign-up-container{
    opacity: 0;
    z-index:1;
}
.sign-in-container{
    z-index: 2;
}
form{
    height:100%;
    display:flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding:0px 50px;
}
h1{
    color: #2B3F6B;
    font-weight: bold;
}
.social-container{
    margin: 20px 0px;
}
.social-container img{
    border-radius:50%;
    display:inline-flex;
    justify-content:center;
    align-items: center;
    margin: 0px 5px;
    height:40px;
    width:40px;
}
span{
    font-size:15px;
    color:#333333;
}
.infield{
    position: relative;
    margin: 0.5rem 0;
    width:100%;
}
input, select{
    width:100%;
    padding: 12px 15px;
    border: 2px solid #2B3F6B;
    outline:none;
}
label{
    position:absolute;
    left: 50%;
    top: 100%;
    transform: translateX(-50%);
    width:0%;
    height:2px;
    background:#2B3F6B;
    transition: 0.3s;
}
input::placeholder, select {
    color: #2B3F6B;
}
input:focus ~ label{
    width:100%;
}
select:focus {
    outline: 3px solid #2b3f6b33;
    transition: 0.1s;
}
a{
    color: #2B3F6B;
    font-size:14px;
    text-decoration: none;
    margin:15px 0px;
}
a:hover{
    font-weight: bold;
}
a.forgot{
    padding-bottom: 3px;
    border-bottom: 2px solid #333333;
}
button{
    border-radius: 20px;
    border:2px solid #2B3F6B;
    background:#2B3F6B;
    color: white;
    font-size: 12px;
    font-weight: bold;
    padding: 12px 45px;
    letter-spacing: 1px;
    text-transform: uppercase;
}
.form-container button {
    margin-top:17px;
    transition:80ms ease-in;
}
.form-container button:hover {
    background:#fff;
    color: #2B3F6B;
}
.btn_login , .btn_join{
    border: 2px solid white !important;
}
.overlay-container{
    position:absolute;
    top:0;
    left:60%;
    width:40%;
    height:100%;
    overflow:hidden;
    transition:transform 0.6s ease-in-out;
    z-index: 9;
}
/* #overlayBtn{
    cursor: pointer;
    position:absolute;
    left:50%;
    top: 304px;
    transform:translateX(-50%);
    width:143.67px;
    height:40px;
    border:2px solid white;
    background:transparent;
    border-radius: 20px;
} */

.overlay{
    position:relative;
    background:#F26C38;
    color:white;
    left:-150%;
    height:100%;
    width:250%;
    transition: transform 0.6s ease-in-out;
}
.overlay-panel{
    position:absolute;
    display:flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding:0px 40px;
    text-align:center;
    height:100%;
    width:340px;
    transition:0.6s ease-in-out;
}
.overlay-left{
    right:60%;
    transform:translateX(-12%);
}
.overlay-right{
    right:0;
    transform:translateX(0%);
}
.overlay-panel h1{
    color:white;
}
p{
    font-size: 14px;
    font-weight: 300;
    line-height: 20px;
    letter-spacing: 0.5px;
    margin:25px 0px 35px;
}
.overlay-panel button{
    border: none;
    background-color:transparent;
}
.right-panel-active .overlay-container{
    transform:translateX(-150%);
}
.right-panel-active .overlay{
    transform:translateX(50%);
}
.right-panel-active .overlay-left{
    transform:translateX(25%);
}
.right-panel-active .overlay-right{
    transform:translateX(35%);
}
.right-panel-active .sign-in-container{
    transform:translateX(20%);
    opacity: 0;
}
.right-panel-active .sign-up-container{
    transform:translateX(66.7%);
    opacity:1;
    z-index: 5;
    animation: show 0.6s;
}
@keyframes show{
    0%, 50%{
        opacity:0;
        z-index: 1;
    }
    50.1%, 100%{
        opacity: 1;
        z-index: 5;
    }
}
.btnScaled{
    animation: scaleBtn 0.6s;
}
@keyframes scaleBtn{
    0%{
        width:143.67px;
    }
    50%{
        width:250px;
    }
    100%{
        width:143.67px;
    }
}
.errormsg {
    font-size: 0.7rem;
    color: #F26C38;
}
</style>