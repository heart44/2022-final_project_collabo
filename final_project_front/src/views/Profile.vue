<template>
  <div class="container mt-5 mb-5">
    <div class="content">
      <ul class="nav mypage_nav">
        <li>
          <router-link to="/Profile"><button class="btn profile_btn" type="button">프로필 수정</button></router-link>
        </li>
        <li>
          <router-link to="/Diary"><button class="btn" type="button">다이어리</button></router-link>
        </li>
      </ul>
      <!-- alert -->
      <div class="d-flex justify-content-center" :class="{'d-none' : isAlert}">
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
          <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
              d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
          </symbol>
          <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
              d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
          </symbol>
          <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
              d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
          </symbol>
        </svg>

        <div class="alert alert-warning d-flex justify-content-between" style="width: 30%;" role="alert">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
            <use xlink:href="#check-circle-fill" />
          </svg>
          {{ alertmsg }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>

      <div class="profile-box">
        <div class="my-p">
          <div class="my-nick">
            <div class="p_tag">
              닉네임
              <div class="my d-flex mb-2">
                <input type="text" name="name" v-model="inputUser.nick" />
              </div>
            </div>
            <div class="p_tag">
              나이
              <div class="my d-flex mb-2">
                <select :key="i" v-model="inputUser.birthYear" :disabled="user.birth !== 0">
                  <option value="0">birthYear</option>
                  <option v-for="i in year" :key="i" :value="i">{{ new Date().getFullYear() - i + 1 }}</option>
                </select>
              </div>
            </div>
            <div class="p_tag">
              직업
              <div class="my d-flex mb-2">
                <select v-model="inputUser.job">
                  <option value="0">선택 안 함</option>
                  <option value="1">직장인</option>
                  <option value="2">학생</option>
                </select>
              </div>
            </div>

            <div class="p_tag">
              비밀번호 변경
              <div class="d-flex justify-content-center">
                <router-link :to="{ name: 'ResetPassWord', params:{'email': user.email, 'url': 1} }"><button type="button" class="btn profile_btn chg_btn">재설정가즈아</button></router-link>
              </div>
            </div>
          </div>

          <div class="profile-img">
            <div class="image-box">
              <label class="file-button" for="img">업로드</label>
              <input type="file" ref="profileImg" id="img" class="d-none" accept="image/*" @change="previewImage()">
            </div>

            <div v-if="imgSrc !== ''" class="file-preview-content-container">
              <div class="file-preview-container">
                <div class="file-preview-wrapper">
                  <div class="file-close-button" @click="delPreview()">
                    <img src="../assets/close.png" />
                  </div>
                  <img class="preview" :src="imgSrc" />
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
      alertmsg: '',
      isAlert: true,
      pwError: ''
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
     chooseImage () {
      this.$refs.fileInput.click()
    },
    onSelectFile () {
      const input = this.$refs.fileInput
      const files = input.files
      if (files && files[0]) {
        const reader = new FileReader
        reader.onload = e => {
          this.imgSrc = e.target.result
        }
        reader.readAsDataURL(files[0])
        this.$emit('input', files[0])
      }
    },


    getUserInfo() {
      this.inputUser.nick = this.user.nick;
      this.inputUser.birthYear = this.user.birth;
      this.inputUser.job = this.user.job;
      console.log(this.inputUser)
      this.imgSrc = this.user.profileimg ?
      'static/img/profile/'+this.user.iuser+'/'+this.user.profileimg : '';
    },
    async profileMod() {
      let image = '';
      if(this.$refs.profileImg.files.length !== 0) {
        image = await this.$base64(this.$refs.profileImg.files[0]);
      }
      // if(this.isPw()) {
      //   this.$refs.pw.focus();
      //   return;
      // }
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
        this.isAlert = false;
        this.alertmsg = '당신의 프로필이 수정되었습니다.';
        this.$refs.profileImg.value = '';
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
          this.isAlert = false;
          this.alertmsg = '당신의 프로필 사진이 삭제되었습니다.';
        }
        this.$refs.profileImg.value = '';
        console.log(this.user);
      }
    },
    // isPw() {
    //   const regExp = /^(?=.*[a-zA-Z])((?=.*\d)(?=.*\W)).{8,16}$/;
    //   const check = regExp.test(this.inputUser.pw);

    //   if(!check && this.inputUser.pw != '') {
    //     this.$refs.chkpw.innerHTML = '비밀번호는 영문/숫자/특수문자(!@#$%^&*)를 포함하여 8~16자로 입력해야합니다.';
    //     return true;
    //   } else {
    //     this.$refs.chkpw.innerHTML = '';
    //   }
    // },
  }
}
</script>

<style scoped>
.profile_btn {
  background-color: #2B3F6B;
  color: white;
}
.chg_btn{ border-radius: 4px !important; }
.file-button {
  padding: 6px 25px;
  background-color: #2b3f6b;
  border-radius: 4px;
  color: white;
  cursor: pointer;
}
.profile-box {
  margin: 0 auto;
  width: 600px;
  height: 500px;
  border: 1px solid #2b3f6b;
  border-radius: 10px;
  box-shadow: 2px 2px 3px;
  margin-top:40px;
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
  position: relative;
  left: 45%;
  top: 20px;
  z-index: 1;
  cursor: pointer;
}
label {
  width: 100px;
}
.erorr {
  font-size: 0.7rem;
  color: #f78b60;
}
</style>