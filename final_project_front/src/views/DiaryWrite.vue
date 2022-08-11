<template>
    <div class="container">
        <div class="content">
            <ul class="nav">
                <li><router-link to="/Profile"><button class="btn" type="button">프로필 수정</button></router-link></li>
                <li><router-link to="/Diary"><button class="btn" type="button">다이어리</button></router-link></li>
            </ul>
        </div>

        <div class="write">
          <div class="write_ctnt">
            <div class="date">
              <label>날짜</label> 
              <input type="date" v-model="diary.eatdt">
            </div>

            <div class="store">
              <label>가게</label> 
              <input type="text" name="name" v-model="searchRest" @keyup.enter="getRestList()">
              <button class="diary_search d_search" @click="getRestList()">검색</button>
              <div :class="{'d-none':restSearch}" class="searchbox">
                <ul class="list-group list-group-flush pointer">
                  <li class="list-group-item list-group-item-action" @click="selRest(selfinput)"><span class="text-sm">직접 입력</span> ' {{ selfinput }} '</li>
                  <li class="list-group-item list-group-item-action" v-for="item in restlist" :key="item" @click="selRest(item.rest_name, item.irest)">{{ item.rest_name }}</li>
                </ul>
              </div>            
            </div>

            <div class="contents">
              <label class="ctnt">내용</label> 
              <textarea placeholder="" v-model="diary.text"></textarea>
            </div>
          </div>
            <div class="star">
              
                <form class="mb-3" name="myform" id="myform" method="post">
                  <fieldset>
                    <input type="radio"  v-model="diary.rating" name="reviewStar" value="5" id="rate1"><label
                      for="rate1">⭐</label>
                    <input type="radio"  v-model="diary.rating" name="reviewStar" value="4" id="rate2"><label
                      for="rate2">⭐</label>
                    <input type="radio"  v-model="diary.rating" name="reviewStar" value="3" id="rate3"><label
                      for="rate3">⭐</label>
                    <input type="radio"  v-model="diary.rating" name="reviewStar" value="2" id="rate4"><label
                      for="rate4">⭐</label>
                    <input type="radio"  v-model="diary.rating" name="reviewStar" value="1" id="rate5"><label
                      for="rate5">⭐</label>
                  </fieldset>
                </form>
            </div>
          </div>

            <div class="profile-img">
              <div class="image-box">
                <label class="file-button" for="img">업로드</label>
                <input type="file" ref="diaryimg" id="img" class="d-none" accept="image/*" @change="previewImage">
              </div>

              <div v-if="imgSrc !== ''" class="file-preview-content-container">
                <div class="file-preview-container">
                  <div class="file-preview-wrapper">
                    <div class="file-close-button" @click="delPreview">
                      <img src="../assets/close.png" />
                    </div>
                    <img class="preview" :src="imgSrc" />
                  </div>
                </div>
              </div>
            </div>
        
        <div class="submit">
          <button class="btn_ok" type="button" @click="diarySubmit()">등록</button>
        </div>

    
    
    </div>
</template>

<script>
export default {
  data() {
      return {
        diary: {
          idiary: 0,
          irest: 0,
          rest_name: '',
          rating: '0',
          text: '',
          eatdt: '',
          path: '',
          src: '',
        },
        imgSrc: '',
        searchRest: '',
        selfinput: '',
        restlist: [],
        restSearch: true,
      }
  },
  computed:{
    user() {
        return this.$store.state.user;
    },
  },
  created() {
    this.modDetail();
  },
  methods: {
    async previewImage() {
      if(this.$refs.diaryimg.files.length !== 0) {
        // 프리뷰
        let img = this.$refs.diaryimg.files[0];
        this.imgSrc = URL.createObjectURL(img);
        // 프리뷰 띄우면서 데이터에도 일단 저장
        let image = '';
        image = await this.$base64(img);
        this.diary.path = image;
      }
    },
    async delPreview() {
      this.imgSrc = "";
    },
    async diarySubmit() {
      this.diary.iuser = this.user.iuser;
      if(this.diary.irest === 0) {
        this.diary.irest = null;
      }
      if(this.diary.rest_name === '' && this.searchRest !== '') {
        this.diary.rest_name = this.searchRest;
      }
      let rs;
      if(this.$route.query.idiary) {
        rs = await this.$post('user/updateDiary', this.diary);
      } else {
        rs = await this.$post('user/insDiary', this.diary);
      }
      if(rs.result) {
        this.$router.push( 'Diary' );
      }
    },
    async getRestList() {
      const rs = await this.$post('user/selRest', { search_word: this.searchRest });
      if(rs.result) {
        this.restlist = rs.result;
        this.restSearch = false;
        this.selfinput = this.searchRest;
      }
    },
    selRest(name, code = 0) {
      this.searchRest = name;
      this.diary.rest_name = name;
      this.diary.irest = code;
    },
    async modDetail() {
      if(this.$route.query.idiary) {
        const idiary = this.$route.query.idiary;
        const detail = await this.$get(`user/getDiary/${this.user.iuser}/${idiary}`)
        console.log(detail);
        if(detail[0]) {
          this.diary.idiary = idiary;
          this.diary.irest = detail[0].irest;
          this.diary.rest_name = detail[0].rest_name;
          this.diary.rating = detail[0].rating;
          this.diary.text = detail[0].text;
          this.diary.eatdt = detail[0].eatdt;
          this.diary.src = detail[0].path;
          this.searchRest = detail[0].rest_name;
          this.imgSrc = '/static/img/diary/'+this.user.iuser+'/'+detail[0].path;
        }
      }
    }
  }
}
</script>

<style scoped>
.container{
  height:1000px;
}
.list-group > ul > li {
  border: 3px solid #2B3F6B;
}
.searchbox {
  max-height: 10rem;
  overflow: auto;
}
.text-sm {
  font-size: 0.9rem;
  color: rgb(77, 77, 77);
}
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
.file-button{
  padding: 6px 25px;
  background-color:#2B3F6B;
  border-radius: 4px;
  color: white;
  cursor: pointer;
}
.profile-img{
  display:flex;
  justify-content: center;
  align-items: center;
}
.preview{
  width:170px;
  height: 170px;
  
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
  right:18px;
}
.write{
  margin: 0 auto;
  width:700px;
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
.btn_ok{
  border:2px solid #2B3F6B;
  border-radius:5px;
  color:#2B3F6B;
  background-color: white;
  text-align: center;
}
.btn_ok:hover{
  background-color:#2B3F6B;
  color:white;
}
.diary_search{
  border:2px solid #2B3F6B;
  border-radius:5px;
  color:#2B3F6B;
  background-color: white;
}
.d_search{
  margin-left:10px;
}
.submit{
  margin-top:30px;
}
</style>