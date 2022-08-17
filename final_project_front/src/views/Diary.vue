<template>
  <div class="container mt-5 mb-5">
    <div class="content">
        <ul class="nav  mypage_nav">
            <li><router-link to="/Profile"><button class="btn" type="button">프로필 수정</button></router-link></li>
            <li><router-link to="/Diary"><button class="btn diary_btn" type="button">다이어리</button></router-link></li>
        </ul>

      <!-- 다이어리 목록 -->
      <div class="row mt-5 justify-content-md-center">   
          <div class="plus_btn"><router-link to="/DiaryWrite"><img src="../assets/plus.png"></router-link></div>
       
        <div class="col-md-3" :key="item" v-for="(item, idx) in paginatedData">

          <div class="card mb-4">
            <div class="card_img" @click="[openModal, getCtnt(idx)]" id="btnNewFeedModal" data-bs-toggle="modal" data-bs-target="#newFeedModal"><img :src="'static/img/diary/'+user.iuser+'/'+item.path" class="card-img-top"/></div>
            
            <div class="card-body">
              <h5 class="card-title">{{ item.eatdt }}</h5> 
            </div>

            <div class="icon">
              <div class="icon_image">
                <div @click="[modDiary(item.idiary)]"><img src="../assets/update.svg"/></div>
                <div class='v-line'></div>
                <div id="deleteimg" @click="deleteDiary(item.idiary, user.iuser, item.path, idx)"><img src="../assets/delete.svg"/></div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="m-5">
      <button class="btn paging_btn" :disabled="pageNum === 0" @click="prevPage">이전</button>
      <span class="page-count mx-2">{{ pageNum + 1 }} / {{ pageCount }} 페이지</span>
      <button class="btn paging_btn" :disabled="pageNum >= pageCount - 1" @click="nextPage">다음</button>
    </div>

        <!-- 다이어리 상세정보 (모달)-->
        <div class="modal fade" id="newFeedModal" tabindex="-1" aria-labelledby="newFeedModalLabel" aria-hidden="true">

          <div class="modal-dialog modal-lg modal-dialog-centered modal">

            <div class="modal-content" id="newFeedModalContent">
                <div class="modal-header">
                    <h5 class="modal-title" id="newFeedModalLabel">Diary</h5>
                    <!-- <button type="button" class="btn btn_change" @click="updateDiary()">수정</button>
                    <button type="button" class="btn btn_delete" @click="deleteDiary()">삭제</button> -->
                </div>

                  <div class="modal-body" id="id-modal-body">
                    <img :src="'static/img/diary/'+user.iuser+'/'+diaryDetail.path">
                    <div class="read_contents">
                      <p>가게 : {{ diaryDetail.rest_name }} </p>
                      <p>내용 : {{ diaryDetail.text }} </p>
                      <p>날짜 : {{ diaryDetail.eatdt }} </p>
                      <p>별점 : {{ diaryDetail.rating }}</p>
                    </div>
                  </div>

                    <div class="modal-footer">
                      <button class="btn btn-primary btn_close" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">닫기</button>
                    </div>
              </div>
          </div>
        </div>
        
      <!-- 다이어리 수정 (모달)-->
      <!-- <div class="modal fade" id="updateFeedModal" tabindex="-1" aria-labelledby="updateFeedModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal">
            <div class="modal-content" id="newFeedModalContent">
                <div class="modal-header">
                    <h5 class="modal-title" id="newFeedModalLabel">수정</h5>
                     <button type="button" class="btn btn_delete" @click="deleteDiary()">삭제</button> 
                </div>
                <div class="modal-body" id="id-modal-body">
                 
                  
        <div class="write">
          <div class="write_ctnt">

              <div class="profile-img">
                <div v-if="!files.length" class="room-file-upload-example-container">
                  <div class="image-box">
                    <label className="file-button" for="file" >업로드</label>
                    <input type="file" id="file" ref="files" @change="imageUpload" style="display:none;" multiple/>  
                  </div>
              </div>

              <div v-else class="file-preview-content-container">
                  <div class="file-preview-container">
                      <div v-for="(file, index) in files" :key="index" class="file-preview-wrapper">
                          <div class="file-close-button" @click="fileDeleteButton" :name="file.number">
                              <img src="../assets/close.png">
                          </div>
                          <img class="preview" :src="file.preview" />
                      </div>
                  </div>
              </div>
            </div>

            <div class="store">
              <label>가게</label> 
              <input type="text" name="name" value="">
            </div>

            <div class="contents">
              <label class="ctnt">내용</label> 
              <textarea placeholder=""></textarea>
            </div>
          </div>
            <div class="star">
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
              <button type="button" class="btn mod_ok" @click="updateBtn">수정</button>
              <button class="btn btn-primary mod_close" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">닫기</button>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    
  </div>
</template>

<script>

export default {

  data() {
      return {
        diaryList: [],
        diaryDetail: {},
        //페이징
        pageNum: 0,
        pageSize: 8
      }
  },
  computed: {
    user() {
        return this.$store.state.user;
    },
    //페이징
    pageCount() {
      let listLeng = this.diaryList.length,
          listSize = this.pageSize,
          page = Math.floor((listLeng - 1) / listSize) + 1;
      // if(listLeng % listSize > 0) page +=  1;

      return page;
    },
    paginatedData() {
      const start = this.pageNum * this.pageSize,
            end = start + this.pageSize;

      return this.diaryList.slice(start, end);
    }
  },
  created() {
    this.getDiaryList();
  },
  methods: {
    async getDiaryList() {
      this.diaryList = await this.$get(`user/getDiary/${this.user.iuser}`);
    },
    updateBtn(){

    },
    async deleteDiary(pk, id, path, idx){
      this.$swal.fire({
          title: '정말 삭제 하시겠습니까?',
          showCancelButton: true, 
          confirmButtonText: '삭제',
          cancelButtonText: '취소'
      }).then(async result => {
          if(result.isConfirmed) {
              const res = await this.$delete(`user/deleteDiary/${pk}/${id}/${path}`);
            if(res.result) {
              this.diaryList.splice(idx, 1);
              this.$swal.fire('삭제되었습니다.', '', 'success');
            }
          }
        })
    },
    getCtnt(idx) {
      this.diaryDetail = this.diaryList[idx];
      console.log(this.diaryDetail);
    },
    modDiary(idx) {
        this.$router.push( {path: '/DiaryWrite', query: {iuser: this.user.iuser, idiary: idx}})
    },
    //페이징
    nextPage() {
      this.pageNum += 1;
    },
    prevPage() {
      this.pageNum -= 1;      
    },
    
  }
}
</script>

<style scoped>
.diary_btn {
  background-color: #2B3F6B;
  color: white;
}
.paging_btn{
    border:2px solid #2B3F6B;
    border-radius:15px;
    color:#2B3F6B;
    margin-left: 0.5rem;
}
.v-line {
  border-left : thin solid rgba(0,0,0,.125);
  height : 25px;
}
.card{
  height:400px;
}
#btnNewFeedModal img{
  height:300px;
  object-fit: cover;
}
.card:hover{
  cursor: pointer;
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
}
.card-body{
  height:40px;
}
.card_img{
  height:300px;
}
.plus_btn img{
  float:right;
  margin-right:13%;
  margin-bottom:30px;
}
.btn_change{
  margin-left:70%;
}
.btn_change:hover , .btn_delete:hover , .mod_close:hover , .mod_ok:hover{
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
.btn:focus{
  outline:none;
  box-shadow:none;
}
#newFeedModalLabel{
 padding-left:10px;
}
.icon{
  display:flex;
  border-top: 1px solid rgba(0,0,0,.125);
  background-color:rgba(217, 217, 217, 0.125);
  height:35px;
}
.icon_image{
  width:60%;
  margin: 0 auto;
  display:flex;
  justify-content: space-between;
  align-items: center;
}
.icon_image a{
  height:19px;
}
.icon img{
  width: 22px;
}
#updateimg img{
  height:19px;
}
.modal-footer button{
  background-color:#2B3F6B !important;
  color: white !important;
  border: 1px solid #2B3F6B !important;
}
.modal-footer button:hover{
  background-color: white;
  color: #2B3F6B;
}
.file-close-button img{
  width:32px;
}
.preview{
  width:170px !important;
  height: 170px;
}
.file-button{
  padding: 6px 25px;
  background-color:#2B3F6B;
  border-radius: 4px;
  color: white;
  cursor: pointer;
}
label{
  margin-right: 20px;
  font-weight: bold;
}
label.ctnt{
  width: 50px;
}
.write_ctnt{
  padding-left: 55px;
}
.contents{
  display:flex;
  align-items: center;
  height:300px;
}
textarea{
  border:2px solid #2B3F6B;
  border-radius: 5px;
  width:450px;
  height:300px;
  position: relative;
  right:8px;
}
.write{
  margin: 0 auto;
  width:600px;
  text-align: left;
  margin-top: 50px;
}
.write p{
  text-align:left;
}
.write input{
  border: 2px solid #2B3F6B;
  border-radius: 5px;
}
.write div{
  margin-bottom: 50px;
}
.read_contents{
  padding-top:10px;
}
#myform fieldset{
    display: inline-block;
    direction: rtl;
    border:0;
}
#myform fieldset legend{
    text-align: right;
}
#myform input[type=radio]{
    display: none;
}
#myform label{
    font-size: 2.1em;
    color: transparent;
    text-shadow: 0 0 0 #f0f0f0;
}
#myform label:hover{
    text-shadow: 0 0 0 rgba(2, 10, 99, 0.99);
}
#myform label:hover ~ label{
    text-shadow: 0 0 0 rgba(2, 10, 99, 0.99);
}
#myform input[type=radio]:checked ~ label{
    text-shadow: 0 0 0 rgba(2, 10, 99, 0.99);
}
#myform label{
  margin-right:10px !important; 
}
#reviewContents {
    width: 100%;
    height: 150px;
    padding: 10px;
    box-sizing: border-box;
    border: solid 1.5px #D3D3D3;
    border-radius: 5px;
    font-size: 16px;
    resize: none;
}
fieldset label{
  cursor: pointer;
}
.star{
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding-left:0.6%;
  text-align: center;
}
.profile-img{
 display:flex;
 flex-direction: column;
 justify-content: center;
}
</style>