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
            <a href="" @click="openModal" id="btnNewFeedModal" data-bs-toggle="modal" data-bs-target="#newFeedModal"><img src="../assets/dog.jpg" class="card-img-top" alt="Fissure in Sandstone"/></a>
            
            <div class="card-body">
              <h5 class="card-title">날짜</h5>
            </div>
          </div>

        </div>
        

      </div>
    
    </div>
      <div class="modal fade" id="newFeedModal" tabindex="-1" aria-labelledby="newFeedModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal">
            <div class="modal-content" id="newFeedModalContent">
                <div class="modal-header">
                    <h5 class="modal-title" id="newFeedModalLabel">Diary</h5>
                    <button type="button" class="btn btn_change">수정</button>
                    <button type="button" class="btn btn_delete">삭제</button>
                </div>
                <div class="modal-body" id="id-modal-body">
                  <img src="../assets/dog.jpg">
                  <div class="contents">
                    <p>가게 : 어쩌고저쩌고 </p>
                    <p>총평 : 어쩌고저쩌고 </p>
                    <p>별점 : ⭐⭐⭐⭐⭐</p>
                  </div>
                </div>
                  <div class="modal-footer">
                    <button class="btn btn-primary btn_close" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">CLOSE</button>
                  </div>
            </div>
        </div>
      </div>
  
  </div>
</template>

<script>
export default {

  data() {
   
  },
  methods: {
    
  }
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
  border-radius:10px !important;
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
.btn_change{
  margin-left:74%;
}
.modal-body img{
  width:500px;
}
.contents{
  margin-top:20px;
}
.btn_close{
 background-color:white !important;
}
.btn_close:hover{
  color:#2B3F6B;
  border:2px solid #2B3F6B;
}
.btn_close:focus{
  outline:none;
  box-shadow:none;
}
</style>