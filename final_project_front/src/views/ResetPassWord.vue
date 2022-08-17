<template>
    <main>
        <div class="vue-tempalte">
            <a href="#" class="back" v-if="$route.params.url == 0"><router-link to="/LoginJoin"><img src="../assets/arrow-left.png"></router-link></a>
            <a href="#" class="back" v-else-if="$route.params.url == 1"><router-link to="/Profile"><img src="../assets/arrow-left.png"></router-link></a>
            <form>
                <h1>비밀번호 재설정</h1>

                <div class="form-group">
                    <label>새로운 비밀번호를 입력하세요</label>
                    <input ref="pw" type="password" v-model="pw" class="form-control form-control-lg" placeholder="비밀번호" @input="isSame()" />
                    <label ref="chkpw" class="erorr"></label>
                    <input ref="pw2" type="password" v-model="pw2" class="form-control form-control-lg" placeholder="비밀번호 재확인" @input="isSame()" />
                    <label ref="same" class="erorr"></label>
                </div>

                <button type="button" class="btn btn-lg btn-block" @click="updPassword()">전송</button>
            </form>
        </div>
    </main>
</template>

<script>
export default {
    name: 'ResetPassWord',
    data(){
        return {
            pw: '',
            pw2: '',
            pwError: ''
        };
    },
    methods: {
        isSame() {
            const pw = this.pw;
            const pw2 = this.pw2;

            this.checkPassword(pw)
            
            if(pw !== '' && pw2 !== '') {
                if(pw === pw2) {
                    this.$refs.same.innerHTML = '비밀번호가 일치합니다.';
                    this.$refs.same.style.color = '#486cbb';
                    return true;
                } else {
                    this.$refs.pw2.focus();
                    this.$refs.same.innerHTML = '비밀번호가 일치하지 않습니다.';
                    this.$refs.same.style.color = '#f78b60';
                    return false;
                }
            } else {
                this.$refs.same.innerHTML = '';
            }
        },
        checkPassword(pw) {
            const regExp = /^(?=.*[a-zA-Z])((?=.*\d)(?=.*\W)).{8,16}$/;
            const check = regExp.test(pw);
            
            if(!check && pw !== '') {
                this.$refs.chkpw.innerHTML = '비밀번호는 영문/숫자/특수문자(!@#$%^&*)를 포함하여 8~16자로 입력해야합니다.';
            } else {
                this.$refs.chkpw.innerHTML = '';
            }
            
        },
        async updPassword() {
            if(this.pw === "") {
                this.$refs.pw.focus();
                this.$refs.chkpw.innerHTML = '비밀번호는 영문/숫자/특수문자(!@#$%^&*)를 포함하여 8~16자로 입력해야합니다.';
                return;
            } else if(this.pw2 === "") {
                this.$refs.pw2.focus();
                this.$refs.same.innerHTML = '비밀번호가 일치하지 않습니다.';
                return;
            } else if(this.isSame()) {
                const param = { 
                    email: this.$route.params.email,
                    pw: this.pw 
                }
                console.log(param);
                const rs = await this.$post('/user/updPassword', param);
                console.log(rs)
                if(rs['result']) {
                    // this.$swal.fire('비밀번호가 정상적으로 변경되었습니다.', '', 'success');
                    this.$router.push( {path: '/LoginJoin'} );
                }
            }
        }
    }
};
</script>

<style scoped>
    *{
        box-sizing: border-box;
    }
    main{
        height:100vh;
        display:grid;
        place-content: center;
    }
    .vue-tempalte{
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
    .form-control{
        width:350px;
    }
    .form-control:focus{
        border-color: #F26C38;
        box-shadow:none;
    }
    h1{
        padding-top:50px;
        color:#F26C38;
        font-weight: bold;
    }
    label{
        font-weight: bold;
        color:#333333;
        /* padding-right: 123px; */
        letter-spacing: 1px;
        padding: 5px;
    }
    .erorr {
        font-size: 0.7rem;
        color: #f78b60;
    }
    input[type="password"]{
        margin: 0 auto;
        border:2px solid #333333;
    }
    .btn:focus{
        box-shadow: none;
    }
    button[type="button"]{
        margin-top: 30px;
    }
    .form-group{
        margin-top: 30px;
    }
    button{
        background-color: #2B3F6B ;
        border: 2px solid #2B3F6B ;
        color: white;
    }
    button:hover{
        border: 2px solid #2B3F6B;
        background-color: white;
        color:#2B3F6B;
    }
    .back img{
        position: absolute;
        left:0;
        margin: 15px 15px;
    }
    form{
        padding-top: 70px;
    }

</style>