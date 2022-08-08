<template>
  <div class="container">
    <div class="content">
        <ul class="nav">
            <li><router-link to="/Profile"><button class="btn" type="button">프로필 수정</button></router-link></li>
            <li><router-link to="/Diary"><button class="btn" type="button">다이어리</button></router-link></li>
        </ul>
        <div class="profile-box">
                  <div class="my-p">
                    <div class="my-nick">
                      <div class="p_tag">닉네임 
                        <div class="my d-flex">
                          <input type="text" name="name" :value="user.nick">
                          <input type="button" name="name" value="수정">
                        </div>
                      </div>
                     <div class="p_tag">나이 
                        <div class="my d-flex">
                          <input type="text" name="name" :value="user.birth">
                          <input type="button" name="name" value="수정">
                        </div>
                      </div>
                      <div class="p_tag">직업 
                        <div class="my d-flex">
                          <input type="text" name="name" :value="user.job">
                          <input type="button" name="name" value="수정">
                        </div>
                      </div>
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
                    
                  </div>
                  <div class="btn-profile can_sub">
                    <span class="cancel"><a href="#">CANCEL</a></span>
                    <span class="submit"><a href="#">SUBMIT</a></span>
                  </div>
                          
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
.file-button{
  padding: 6px 25px;
  background-color:#2B3F6B;
  border-radius: 4px;
  color: white;
  cursor: pointer;
}
a{
  text-decoration:none;
  margin-right:10px;
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
.nav{
  margin:0 auto;
}
.btn{
  margin-right:10px;
}
.profile-box{
  margin: 0 auto; 
  margin-top:70px;
  width:600px;
  height:500px;
  border: 1px solid #2B3F6B;
  border-radius: 10px;
  box-shadow: 2px 2px 3px;
}
.preview{
  width:170px;
  height: 170px;
}
.submit a{
  color:#F26C38;
}
.p_tag{
  color:#2B3F6B;
}
.my-p{
  display:flex;
  height:450px;
  width:300px;
}
.my-nick{
  text-align:left;
  padding-left:30px;
  padding-top:50px;
  font-weight: bold;
  font-size: 25px;
  width:300px;
}
.profile-img{
  margin: 30px 100px;
}
.btn-profile{
  border-top:1px solid #a6a6a6;
}
.file-preview-container{
  padding-top:40px;
}
.image-box{
  padding-top:25px;
}
.can_sub{
  padding-top:13px;
}
.content{
  display:flex;
  flex-direction:column;
}
input{
  font-size:17px;
  font-weight: 300;
}
input[type="text"]{
  width:150px;
  height:30px;
  border:1px solid #2B3F6B;
}
input[type="button"]{
  width:50px;
  height:30px;
  margin-left: 10px;
  background-color:#2B3F6B;
  color:white;
  border:1px solid #2B3F6B;
}
.file-close-button img{
  width:32px;
  position:relative;
  left:37%;
  top:20px;
  z-index:1;
  cursor: pointer;
}
label{
  width:100px;
}
</style>