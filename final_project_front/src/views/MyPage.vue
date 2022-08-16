<template>
   <div class="container">
    <div class="d-flex justify-content-center mb-4">
        <ul class="nav mb-3 mypage_nav">
            <li><router-link to="/Profile"><button class="btn" type="button">프로필 수정</button></router-link></li>
            <li><router-link to="/Diary"><button class="btn" type="button">다이어리</button></router-link></li>
        </ul>
    </div>
 </div>
</template>

<script>
export default {

}
</script>

<style scoped>
button{
  border:2px solid #2B3F6B;
  border-radius:15px;
  color:#2B3F6B;
}
button:focus{
    outline:none;
    box-shadow:none;
}
.btn{
  margin-right:10px;
}
</style>