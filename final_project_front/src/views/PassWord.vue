<template>
    <main>
        <div class="vue-tempalte">
            <a href="#" class="back"><router-link to="/LoginJoin"><img src="../assets/arrow-left.png"></router-link></a>
            <form>
            <h1>비밀번호 찾기</h1>

            <div class="form-group">
                <label>Email을 입력하세요.</label>
                <input type="email" class="form-control form-control-lg"/>
            </div>

            <button type="submit" class="btn btn-lg btn-block">
                전송
            </button>
            </form>
        </div>
    </main>
</template>

<script>
export default {
    data(){
        return {};
    },
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
        padding-right: 185px;
        letter-spacing: 1px;
        padding-bottom: 5px;
    }
    input[type="email"]{
        margin: 0 auto;
        border:2px solid #333333;
    }
    .btn:focus{
        box-shadow: none;
    }
    button[type="submit"]{
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