<template>
  <div class="container">
    <div class="content">
        <ul class="nav">
            <li><router-link to="/Profile"><button class="btn" type="button">프로필 수정</button></router-link></li>
            <li><router-link to="/Diary"><button class="btn" type="button">다이어리</button></router-link></li>
        </ul>

      <div class="row mt-5 justify-content-md-center">
          <div class="plus_btn"><router-link to="/DiaryWrite"><img src="../assets/plus.png"></router-link></div>
        <div class="col-md-3">

          <div class="card">
            <a href=""><router-link to="/ModalDiary"><img src="../assets/dog.jpg" class="card-img-top" alt="Fissure in Sandstone"/></router-link></a>
            <div class="card-body">
              <h5 class="card-title">날짜</h5>
            </div>
          </div>
          
        </div>
        
        <div class="col-md-3">
          
            <div class="card">
            <img src="../assets/dog.jpg" class="card-img-top" alt="Fissure in Sandstone"/>
            <div class="card-body">
              <h5 class="card-title">날짜</h5>
            </div>
          </div>

        </div>
        
        <div class="col-md-3">
          
            <div class="card">
            <img src="../assets/dog.jpg" class="card-img-top" alt="Fissure in Sandstone"/>
            <div class="card-body">
              <h5 class="card-title">날짜</h5>
            </div>
          </div>

        </div>
      
      
      
      </div>
    
    
    
    
    </div>
  </div>
</template>

<script>
import ModalDiary from '../views/ModalDiary.vue';

export default {
  data(){
   
  },
  methods: {
     
  },
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
.nav{
  display:flex;
  justify-content: center;
}
.card{
  height:400px;
}
.card img{
  height:360px;
  object-fit: cover;
}
.card-body{
  height:40px;
}
.plus_btn img{
  float:right;
  padding-right:13%;
  padding-bottom:30px;
}
</style>