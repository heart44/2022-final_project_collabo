<template>
    <div class="container">
        <div class="content">
            <ul class="nav">
                <li><router-link to="/Profile"><button class="btn" type="button">프로필 수정</button></router-link></li>
                <li><router-link to="/Diary"><button class="btn" type="button">다이어리</button></router-link></li>
            </ul>
        </div>

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

        <div class="write">
          <div class="store">
            가게 <input type="text" name="name" value="">
          </div>
           <div class="content">
            내용 <input type="text" name="name" value="">
          </div>
          <div class="date">
            날짜 <input type="text" name="name" value="">
          </div>
          <div class="star">
            <p>별점</p> 
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
    
    
    
    
    
    </div>
</template>

<script>
export default {
  data() {
      return {

          files: [], //업로드용 파일
          filesPreview: [],
          uploadImageIndex: 0 // 이미지 업로드를 위한 변수
      }
  },
  computed:{
        user() {
            return this.$store.state.user;
        },
  },
  methods: {
    imageUpload() {
        console.log(this.$refs.files.files);
        let num = -1;
        for (let i = 0; i < this.$refs.files.files.length; i++) {
          this.files = [
              ...this.files,
              //이미지 업로드
              {
                  //실제 파일
                  file: this.$refs.files.files[i],
                  //이미지 프리뷰
                  preview: URL.createObjectURL(this.$refs.files.files[i]),
                  //삭제및 관리를 위한 number
                  number: i
              }
          ];
          num = i;
        }
        this.uploadImageIndex = num + 1; 
        console.log(this.files);
        
    },
    fileDeleteButton(e) {
        const name = e.target.getAttribute('name');
        this.files = this.files.filter(data => data.number !== Number(name));
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
  margin-top:70px;
}
.preview{
  width:170px;
  height: 170px;
}
.write{
  margin-top: 70px;
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
    font-size: 3em;
    color: transparent;
    text-shadow: 0 0 0 #f0f0f0;
}
#myform label:hover{
    text-shadow: 0 0 0 rgba(250, 208, 0, 0.99);
}
#myform label:hover ~ label{
    text-shadow: 0 0 0 rgba(250, 208, 0, 0.99);
}
#myform input[type=radio]:checked ~ label{
    text-shadow: 0 0 0 rgba(250, 208, 0, 0.99);
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
  justify-content: center;
  align-items: center;
  padding-left:9.5%;
}
</style>