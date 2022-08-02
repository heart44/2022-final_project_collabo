<template>
    <nav class="navbar navbar-expand-lg navbar-dark main-bg shadows p-3 mb-5 bg-body rounded">
    <div class="container">
        <a class="logo" href="#"><img src="../assets/logo.svg" alt="logo"></a>
        <!-- <button class="navbar-toggler" type="button" 
        data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
        aria-controls="navbarSupportedContent" aria-expanded="false">
            <span class="navbar-toggler-icon">
            </span>
        </button> -->
        <div class="input-group align-items-center">
            <input type="text" class="form-control radious" placeholder="오늘은 @@이 많이 검색됐네요~" aria-label="Username" aria-describedby="basic-addon1">
            <a href="#"><span class="search_icon"><img src="../assets/search.png"></span></a>
        </div>
        <div class="dropdown">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">My Page</a>     
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" href="#">마이페이지</a></li>
                    <li><a class="dropdown-item" href="#">다이어리</a></li>
                </ul>
        </div>
        <div class="d-flex">
            <div >
                <button class="btn btn-danger" type="button"><router-link class="login_b" to="/LoginJoin">로그인</router-link></button>
            </div>
            <div>
                <button class="btn btn-danger" type="button" @click="kakaoLogout">로그아웃</button>
            </div>
        </div>
    </div>
  </nav>
</template>

<script>
export default {
 name:'header',
 computed:{
   
    
 },
 
}
</script>

<style scoped>
.main-bg{
   border-bottom: 1px solid #F26C38; 
}
.logo img{
    width: 200px;
}
.logo img{
    width:230px;
}
.input-group{
    width:400px; 
}
.btn{
    margin-left:10px;
}
.search_icon{
    margin-left:10px;
}
input[type="text"]{
    border: 2px solid #F26C38;
}
input::placeholder{
    color: #333333;
}
input:focus {
    outline:none;
    box-shadow:none;
}
.radious{
    border-radius: 30px !important;
}
.shadows{
   box-shadow: 5px 1px 5px #F26C38;
}
.btn-secondary{
    background-color:#F26C38;
    border: 1px solid #F26C38;
}
.btn-secondary:focus{
    box-shadow: none;
}
.dropdown-menu{
    border:1px solid #F26C38;
}
.dropdown-item{
    color: #333333;
}
.dropdown-item:hover{
    background-color:#F26C38;
    color: white;
}
.btn-danger{
    background-color:#2B3F6B;
    border:1px solid #2B3F6B;
}
.btn-danger:focus{
    box-shadow:none;
}
.login_b:hover{
    color: white !important;
}
</style>

