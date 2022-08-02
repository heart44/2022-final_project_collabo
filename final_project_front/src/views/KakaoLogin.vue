<template>
  <div>
    <div>{{ iuser }}</div>
    <a id="custom-login-btn" @click="kakaoLogin"></a>
  </div>
</template>
<script>
export default {
    computed:{
        iuser(){
            return this.$store.state.iuser;
        }
    },
    methods: {
        kakaoLogin() {
            window.Kakao.Auth.login({
                scope: 'profile_nickname, profile_image, account_email',
                success: this.getKakaoAccount,
                fail: e => {
                    console.error(e);
                }
            });
        },
        getKakaoAccount() {            
            window.Kakao.API.request({
                url: '/v2/user/me',
                success: async res => {
                    const acc = res.kakao_account;
                    console.log(acc);
                    const params = {
                        social_type: 1,
                        email: acc.email,
                        nickname: acc.profile.nickname,
                        profile_img: acc.profile.profile_image_url,
                        thumb_img: acc.profile.thumbnail_image_url
                    }
                    console.log(params);
                    const data = await this.$post('/user/signup', params);                       
                    console.log(data.result);
                    this.$store.commit('setIuser', data.result);
                },
                fail: e => {
                    console.error(e);
                }
            });
        }
    }
}
</script>

<style>

</style>