<template>
  <div class="container">

    <!-- alert -->
    <div class="alert alert-warning">
      {{ alertmsg }}
    </div>  

    <div class="content">
      <ul class="nav">
        <li>
          <router-link to="/Profile"><button class="btn" type="button">프로필 수정</button></router-link>
        </li>
        <li>
          <router-link to="/Diary"><button class="btn" type="button">다이어리</button></router-link>
        </li>
      </ul>
      <div class="profile-box">
        <div class="my-p">
          <div class="my-nick">
            <div class="p_tag">
              닉네임
              <div class="my d-flex">
                <input type="text" name="name" v-model="inputUser.nick" />
              </div>
            </div>
            <div class="p_tag">
              나이
              <div class="my d-flex">
                <select
                  :key="i"
                  v-model="inputUser.birthYear"
                  :disabled="user.birth !== 0"
                >
                  <option value="0">birthYear</option>
                  <option v-for="i in year" :key="i" :value="i">{{ new Date().getFullYear() - i + 1 }}</option>
                </select>
              </div>
            </div>
            <div class="p_tag">
              직업
              <div class="my d-flex">
                <select v-model="inputUser.job">
                    <option value="0">선택 안 함</option>
                    <option value="1">직장인</option>
                    <option value="2">학생</option>
                </select>
              </div>
            </div>

            <div class="p_tag">
              비밀번호 변경
              <div class="my d-flex">
                <input type="password" v-model="inputUser.pw"/>
              </div>
            </div>
          </div>

          <div class="profile-img">
            <div class="image-box">
              <label class="file-button" for="img">업로드</label>
              <input type="file" ref="profileImg" id="img" class="d-none" accept="image/*" @change="previewImage">
            </div>

            <div v-if="imgSrc !== ''" class="file-preview-content-container">
              <div class="file-preview-container">
                <div class="file-preview-wrapper">
                  <div class="file-close-button"
                    @click="delPreview">
                    <img src="../assets/close.png" />
                  </div>
                  <img class="preview" :src="imgSrc"/>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="btn-profile can_sub">
          <span class="cancel m-2 text-info pointer">CANCEL</span>
          <span class="submit m-2 text-danger pointer" @click="profileMod()">SUBMIT</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      inputUser:{
        nick: '',
        pw: '',
        birthYear: 0,
        job: 0,
      },
      imgSrc: '',
    };
  },
  created() {
    this.$store.commit("year");
    this.getUserInfo();
  },
  computed: {
    user() {
      return this.$store.state.user;
    },
    year() {
      return this.$store.state.year;
    },
  },
  methods: {
    getUserInfo() {
      this.inputUser.nick = this.user.nick;
      this.inputUser.birthYear = this.user.birth;
      this.inputUser.job = this.user.job;
      this.imgSrc = this.user.profileimg ?
      'static/img/profile/'+this.user.iuser+'/'+this.user.profileimg : '';
    },
    async profileMod() {
      let image = '';
      if(this.$refs.profileImg.files.length !== 0) {
        image = await this.$base64(this.$refs.profileImg.files[0]);
      }
      const param = {
        iuser: this.user.iuser,
        pw: this.inputUser.pw,
        nick: this.inputUser.nick,
        birth: this.inputUser.birthYear,
        job: this.inputUser.job,
        profileimg: image
      };

      const userInfo = await this.$post('user/profile', param);
      if(userInfo.result) {
        param.pw = null;
        param.profileimg = userInfo.result.profileimg;
        this.$store.commit('updateUser', param);
      }
    },
    // 이미지 미리보기
    previewImage() {
      let img = this.$refs.profileImg.files[0];
      this.imgSrc = URL.createObjectURL(img)
    },
    async delPreview() {
      this.imgSrc = "";
      if(this.user.profileimg) {
        const rs = await this.$delete(`user/profile/${this.user.iuser}/${this.user.profileimg}`);
        console.log(rs);
        if(rs.result) {
          this.user.profileimg = '';
        }
        console.log(this.user);

      }
    },
  },
};
</script>

<style scoped>
.file-button {
  padding: 6px 25px;
  background-color: #2b3f6b;
  border-radius: 4px;
  color: white;
  cursor: pointer;
}

button {
  border: 2px solid #2b3f6b;
  border-radius: 15px;
  color: #2b3f6b;
}
button:focus {
  outline: none;
  box-shadow: none;
}
.nav {
  margin: 0 auto;
}
.btn {
  margin-right: 10px;
}
.profile-box {
  margin: 0 auto;
  margin-top: 70px;
  width: 600px;
  height: 500px;
  border: 1px solid #2b3f6b;
  border-radius: 10px;
  box-shadow: 2px 2px 3px;
}
.preview {
  width: 170px;
  height: 170px;
}
.submit a {
  color: #f26c38;
}
.p_tag {
  color: #2b3f6b;
}
.my-p {
  display: flex;
  height: 450px;
  width: 300px;
}
.my-nick {
  text-align: left;
  padding-left: 30px;
  padding-top: 50px;
  font-weight: bold;
  font-size: 22px;
  width: 300px;
}
.profile-img {
  margin: 30px 100px;
}
.btn-profile {
  border-top: 1px solid #a6a6a6;
}
.file-preview-container {
  padding-top: 40px;
}
.image-box {
  padding-top: 25px;
}
.can_sub {
  padding-top: 13px;
}
.content {
  display: flex;
  flex-direction: column;
}
input, select {
  font-size: 17px;
  font-weight: 300;
}
input[type="text"], input[type="password"], select {
  width: 150px;
  height: 30px;
  border: 1px solid #2b3f6b;
}
input[type="button"] {
  width: 50px;
  height: 30px;
  margin-left: 10px;
  background-color: #2b3f6b;
  color: white;
  border: 1px solid #2b3f6b;
}
.file-close-button img {
  width: 32px;
  position: relative;
  left: 37%;
  top: 20px;
  z-index: 1;
  cursor: pointer;
}
label {
  width: 100px;
}
</style>