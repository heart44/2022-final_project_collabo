<template>
    <div class="container-fluid">
      <div class="row flex-nowrap">
          <div class="col-3 bd-sidebar">
              <ul class="nav">
                  <li><router-link to="/Profile"><button class="btn" type="button">프로필 수정</button></router-link></li>
                  <li><router-link to="/Diary"><button class="btn" type="button">다이어리</button></router-link></li>
              </ul>
          </div>
          <main>
            <span class="profile_button">나의 프로필</span>
              <div class="profile-box">
                  <div class="my-p">
                    <div class="my-nick">
                      <p>닉네임</p>
                
                      <p>나이</p>
                  
                      <p>직업</p>
                    </div>
                    <div class="profile-img">
                      <div v-if="!files.length" class="room-file-upload-example-container">
                          <div class="image-box">
                            <input type="file" id="file" ref="files" @change="imageUpload" multiple />
                          </div>
                        </div>
          
                        <div v-else class="file-preview-content-container">
                            <div class="file-preview-container">
                                <div v-for="(file, index) in files" :key="index" class="file-preview-wrapper">
                                    <div class="file-close-button" @click="fileDeleteButton" :name="file.number">
                                        x
                                    </div>
                                    <img :src="file.preview" />
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="btn-profile">
                    <span class="cancel"><a href="#">CANCEL</a></span>
                    <span class="submit"><a href="#">SUBMIT</a></span>
                  </div>
              </div> 
          </main>
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
a{
  text-decoration: none;
  color:black;
}
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
    border-radius:10px;
    text-align: center;
    color: #F26C38;
    font-size:20px;
    padding-top:7px;
    box-shadow: 1px 1px 2px;
}
main{
  width:1240px;
}
.profile_button{
  padding:10px 10px;
  border:2px solid #2B3F6B;
  color:#2B3F6B;
  border-radius:10px;
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
.profile-img img{
  width:170px;
}
.btn-profile{
  border-top:1px solid #b2b2b2;
  padding-top:15px;
}
.btn-profile span{
  margin-right:10px;
}
.submit a{
  color:#F26C38;
}
.my-p{
  display:flex;
  height:450px;
}
.my-nick{
  text-align:left;
  padding-left:30px;
  padding-top:50px;
  font-weight: bold;
  font-size: 25px;
  width:200px;
}
.file-preview-container{
  padding-top:40px;
}
.image-box{
  padding-top:25px;
}
</style>