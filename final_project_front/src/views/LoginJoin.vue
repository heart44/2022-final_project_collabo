<template>
    <main>
  <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="#">
                <h1>JOIN</h1>
                <div class="social-container">
                    <a href="#" class="social"><img src="../assets/naver.svg"></a>
                    <a href="#" class="social" @click="kakaoLogin"><img src="../assets/kakao.svg"></a>
                    <a href="#" class="social"><img src="../assets/google.svg"></a>
                </div>
                <span>or use your email for registration</span>
                <div class="infield">
                    <input type="text" placeholder="Name" />
                    <label></label>
                </div>
                <div class="infield">
                    <input type="email" placeholder="Email" name="email"/>
                    <label></label>
                </div>
                <div class="infield">
                    <input type="password" placeholder="Password" />
                    <label></label>
                </div>
                <button>JOIN</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="#">
                <h1>LOGIN</h1>
                <span>Social Login</span>
                <div class="social-container">
                    <a href="#" class="social" @click="NaverLogin"><img src="../assets/naver.svg"></a>
                    <a href="#" class="social" @click="kakaoLogin"><img src="../assets/kakao.svg"></a>
                    <a href="#" class="social"><img src="../assets/google.svg"></a>
                </div>
                <div class="infield">
                    <input type="email" placeholder="Email" name="email"/>
                    <label></label>
                </div>
                <div class="infield">
                    <input type="password" placeholder="Password" />
                    <label></label>
                </div>
                <a href="#" class="forgot"><router-link class="f_password" to="/PassWord">비밀번호 찾기</router-link></a>
                <button>LOGIN</button>
            </form>
        </div>
        <div class="overlay-container" id="overlayCon">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button>LOGIN</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button>JOIN</button>
                </div>
            </div>
            <button id="overlayBtn"></button>
        </div>
    </div>
     </main>
</template>

<script>

export default {
    data(){

    },
    methods:{
        kakaoLogin(){
           window.Kakao.Auth.login({
                scope: 'profile_nickname, profile_image, account_email',
                success: this.getProfile,
                fail: e => {
                    console.error(e);
                }
            });
        },
        NaverLogin(){
            window.Naver.Auth.login({
                scope: '',
                success: this.getProfile2,
                fail: e => {
                    console.error(e);
                }
            });
        },
        NaverLogout(){
            window.Naver.Auth.logout(async res => {
                console.log(res);
                this.$store.commit('user', {});
                this.$router.push({path: '/'}); 
                await this.$post('/user/logout');
            })
        },
        kakaoLogout(){
            window.Kakao.Auth.logout(async res => {
                console.log(res);
                this.$store.commit('user', {});
                this.$router.push({path: '/'}); //라우터 주소 이동. (option 사항)
                await this.$post('/user/logout');
            })
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
                        nickname: acc.profile.nickname,
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
        getProfile2(authObj){
            console.log(authObj);
             window.Naver.API.request({
                url: '/v2/user/me',
                success: async res => {
                    const acc = res.naver_account;
                    console.log(acc);
                    const params = {
                        social_type: 1,
                        email: acc.email,
                        nickname: acc.profile.nickname,
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
    },
    created(){

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
    margin: 8px 0px;
    width:100%;
}
input{
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
input::placeholder {
    color: #2B3F6B;
 
}
input:focus ~ label{
    width:100%;
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
#overlayBtn{
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
}
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
</style>