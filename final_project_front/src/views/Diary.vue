<template>
  <div class="container">
    <div class="content">
        <ul class="nav">
            <li><router-link to="/Profile"><button class="btn" type="button">프로필 수정</button></router-link></li>
            <li><router-link to="/Diary"><button class="btn" type="button">다이어리</button></router-link></li>
        </ul>

      <!-- 다이어리 목록 -->
      <div class="row mt-5 justify-content-md-center">   
          <div class="plus_btn"><router-link to="/DiaryWrite"><img src="../assets/plus.png"></router-link></div>
       
        <div class="col-md-3">

          <div class="card">
            <a href="" @click="openModal" id="btnNewFeedModal" data-bs-toggle="modal" data-bs-target="#newFeedModal"><img src="../assets/dog.jpg" class="card-img-top" alt="Fissure in Sandstone"/></a>
            
            <div class="card-body">
              <h5 class="card-title">날짜</h5> <!--{{ user_diary.redgt }}-->
            </div>
          </div>
        </div>
      </div>
    </div>
      <!-- 다이어리 상세정보 (모달)-->
      <div class="modal fade" id="newFeedModal" tabindex="-1" aria-labelledby="newFeedModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal">
            <div class="modal-content" id="newFeedModalContent">
                <div class="modal-header">
                    <h5 class="modal-title" id="newFeedModalLabel">Diary</h5>
                    <button type="button" class="btn btn_change" @click="updateDiary()">수정</button>
                    <button type="button" class="btn btn_delete" @click="deleteDiary()">삭제</button>
                </div>
                <div class="modal-body" id="id-modal-body">
                  <img src="../assets/dog.jpg">
                  <div class="contents">
                    <p>가게 : 어쩌고저쩌고 </p>
                    <p>내용 : 어쩌고저쩌고 </p>
                    <p>날짜 : 어쩌고저쩌고 </p>
                    <p>별점 : ⭐⭐⭐⭐⭐</p>
                  </div>
                </div>
                  <div class="modal-footer">
                    <button class="btn btn-primary btn_close" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">닫기</button>
                  </div>
            </div>
        </div>
      </div>
      <!-- 다이어리 수정 (모달)-->
      <div class="modal fade" id="newFeedModal" tabindex="-1" aria-labelledby="newFeedModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal">
            <div class="modal-content" id="newFeedModalContent">
                <div class="modal-header">
                    <h5 class="modal-title" id="newFeedModalLabel">수정</h5>
                    <button type="button" class="btn btn_delete" @click="deleteDiary()">삭제</button>
                </div>
                <div class="modal-body" id="id-modal-body">
                  <img src="../assets/dog.jpg">
                  
                    <div class="mod_store">가게
                        <div class="my d-flex">
                          <input type="text" name="name" value="">
                        </div>
                    </div>
                    <div class="mod_ctnt">내용
                        <div class="my d-flex">
                          <textarea name="ctnt" placeholder=""></textarea>
                        </div>
                    </div>
                    <div class="mod_date">날짜
                        <div class="my d-flex">
                            <input type="date">
                        </div>
                    </div>
                    <div class="mod_star">별점
                        <form class="mb-3" name="myform" id="myform" method="post">
                            <fieldset>
                            <input type="radio" name="reviewStar" value="5" id="rate1"><label
                                for="rate1">⭐</label>
                            <input type="radio" name="reviewStar" value="4" id="rate2"><label
                                for="rate2">⭐</label>
                            <input type="radio" name="reviewStar" value="3" id="rate3"><label
                                for="rate3">⭐</label>
                            <input type="radio" name="reviewStar" value="2" id="rate4"><label
                                for="rate4">⭐</label>
                            <input type="radio" name="reviewStar" value="1" id="rate5"><label
                                for="rate5">⭐</label>
                            </fieldset>
                        </form>   
                    </div>
                </div>
                  <div class="modal-footer">
                    <button type="button" class="btn mod_ok">수정</button>
                    <button class="btn btn-primary mod_close" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">닫기</button>
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
    async deleteDiary(){
      this.$swal.fire({
          title: '정말 삭제 하시겠습니까?',
          showCancelButton: true, 
          confirmButtonText: '삭제',
          cancelButtonText: '취소'
      }).then(async result => {
          if(result.isConfirmed) {
              const res = await this.$delete(`api/deleteDiary/${productId}`, {});

          if(res.result === 1) {
              this.$swal.fire('삭제되었습니다.', '', 'success');
              this.productList.splice(idx, 1);
            }
          }
        });
    },
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
  border-radius:15px !important;
}
.update_btn{
  position: relative;
  bottom:3px;
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
.card:hover{
  cursor: pointer;
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
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
  margin-left:70%;
}
.btn_change:hover , .btn_delete:hover{
  background:#2B3F6B !important;
  border:2px solid #2B3F6B;
  color:white;
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
  background:#2B3F6B !important;
  border:2px solid #2B3F6B;
  color:white;
}
.btn_close:focus{
  outline:none;
  box-shadow:none;
}
#newFeedModalLabel{
 padding-left:10px;
}

</style>