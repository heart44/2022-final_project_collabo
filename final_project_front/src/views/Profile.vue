<template>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-3 bd-sidebar">
            <ul class="nav">
                <li><router-link class="" to="/Profile"><button class="btn" type="button">프로필 수정</button></router-link></li>
                <li><router-link class="" to="/Diary"><button class="btn" type="button">다이어리</button></router-link></li>
            </ul>
        </div>
    </div>
</div>
</template>

<script>
export default {

}
</script>

<style scoped>
.bd-sidebar {
  position: sticky;
  top: 4rem;
  z-index: 1000;
  height: calc(100vh - 4rem);
  overflow-y: auto;
  min-width: 160px;
  max-width: 220px;
}
.bd-sidebar .nav {
  display: block;
}
.bd-sidebar li {
  display: block;
  padding: 1.2rem 1.5rem;
}
button:focus{
    outline:none;
    box-shadow:none;
}
.btn{
    border:2px solid #F26C38;
    text-align: center;
    color: #F26C38;
    font-size:20px;
    padding-top:7px;
    box-shadow: 1px 1px 2px;
}
</style>