<template>
  <main>
    <router-link to="/BobfChat">채팅 잠시 실례합니다</router-link>
    <div class="container">    
      <div class="mb-3 d-flex justify-content-end" v-if="weatherOk === true">
        <div class="d-flex flex-column justify-content-center align-items-end">
          <div id="weatherText">
            {{ temp }}
            {{ weather }}
          </div>
          <span class="text-sm color-gray">{{ today }} 기준 <span class="pointer" @click="askForCoords">🔄</span></span>
        </div>
        <div id="weatherIcon">
          <img :src="'http://openweathermap.org/img/wn/'+wicon+'@2x.png'">
        </div>
      </div>

      <div class="card-group text-center">
        <div class="card" v-for="item in menuList" :key="item">
          <div class="card-body pointer" @click="clickList(item.menucd)">
            <div class="menuimg"><img :src="item.path"></div>
            <h5 class="card-title m-0">{{ item.menucd }}</h5>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>

export default {
  data(){
    return{
      weatherOk: false,
      lat: '',
      lon: '',
      today: '',
      city: '',
      temp: '',
      weather: '',
      wicon: '',
      weatherKr: {
        201: '가벼운 비를 동반한 뇌우',
        200: '비를 동반한 뇌우',
        202: '폭우를 동반한 뇌우',
        210: '뇌우 조금',
        211: '뇌우',
        212: '많은 뇌우',
        221: '불규칙적인 뇌우',
        230: '연무를 조금 동반한 뇌우',
        231: '연무를 동반한 뇌우',
        232: '많은 가랑비를 동반한 뇌우',
        300: '가랑비 약간',
        301: '가랑비',
        302: '많은 가랑비',
        310: '이슬비 약간',
        311: '이슬비',
        312: '많은 이슬비',
        313: '소나기와 가랑비',
        314: '많은 소나기와 가랑비',
        321: '여우비',
        500: '비 약간',
        501: '비',
        502: '장대비',
        503: '호우',
        504: '폭우',
        511: '우박',
        520: '소나기 약간',
        521: '소나기',
        522: '많은 소나기',
        531: '불규칙적인 소나기',
        600: '눈 약간',
        601: '눈',
        602: '폭설',
        611: '진눈깨비',
        612: '소낙눈',
        615: '비와 눈 약간',
        616: '비와 눈',
        620: '소낙눈 약간',
        621: '소낙눈',
        622: '많은 소낙눈',
        701: '박무',
        711: '연기',
        721: '실안개',
        731: '황사',
        741: '안개',
        751: '모래 바람',
        761: '미세먼지',
        762: '화산재',
        771: '돌풍',
        781: '토네이도',
        800: '맑음',
        801: '구름 약간',
        802: '조금 흐림',
        803: '흐림',
        804: '매우 흐림',
        900: '토네이도',
        901: '태풍',
        902: '허리케인',
        903: '추움',
        904: '더움',
        905: '바람',
        906: '우박',
        951: '잔잔함',
        952: '가벼운 바람',
        953: '산들바람',
        954: '적당한 바람',
        955: '신선한 바람',
        956: '센 바람',
        957: '돌풍에 가까운 센 바람',
        958: '돌풍',
        959: '심각한 돌풍',
        960: '폭풍',
        961: '심한 폭풍',
        962: '허리케인'
      },
      menuList: [],
    }
  },
  computed: {
    getCurrentLoc() {
      return this.$store.getters.currentLoc;
    }
  },
  methods: {
    //검색리스트에 뽀려가욘~@--
    askForCoords() {
      navigator.geolocation.getCurrentPosition(pos => {
        console.log(pos);
        this.lat = pos.coords.latitude;
        this.lon = pos.coords.longitude;
        console.log('로케이션', this.lat, this.lon);
        this.getPlaceWeather(this.lat, this.lon);
        this.weatherOk = true;
      }, err => {
        this.$swal.fire('현재 날씨를 가져올 수 없습니다.', '우리가 현재 위치의 날씨 정보를 가져올 수 있도록 <br> 위치 정보 접근을 허용해주세요.', 'warning');
        console.log(err);
      }
      );
    },
    // openweather api
    async getPlaceWeather(lat, lon) {
      const params = {
          lat: lat,
          lon: lon
      }
      console.log('dkdkdkdk',params)
      this.$store.commit('currentLoc', params);

      const data = await this.getWeather(lat, lon);
      console.log(data);

      const weatherId = data.weather[0].id
      this.city = data.name;
      this.temp = Math.round(data.main.temp) + '℃';
      this.weather = this.weatherKr[weatherId];
      this.wicon = data.weather[0].icon;
      this.today = new Date(data.dt * 1000).toLocaleString('ko-KR',{year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false});
      this.getPushMenu(this.temp, data.weather[0].main);
    },

    async getPushMenu(temp, weather) {
      console.log(parseInt(temp));
      console.log(weather);
      const rsArr = await this.$get(`menu/menuListbyWeather/${parseInt(temp)}/${weather}`);
      
      // console.log(rsArr);

      while(this.menuList.length < 4){
        let rndMenu = rsArr.splice(Math.floor(Math.random() * rsArr.length),1)[0];
        this.menuList.push(rndMenu);
      }
      console.log(this.menuList)
    },
    async clickList(menucd) {
      const params = await this.naverSearch(menucd, this.lon, this.lat)
      await this.searchList(params)
      const restList = await this.getRestList(menucd, this.lon, this.lat)
      await this.getMenuList();

      this.$store.commit('restList', restList)
      this.$store.commit('setSearchWord', menucd);
      this.$router.push( {path: '/SearchList'} );
    }
  },
  created() {
    this.askForCoords();
  },
  updated(){
    this.askForCoords();
  }
}
</script>

<style scoped>
  .bold { font-weight: bold; }
  .border-carrot { border-color: #F26C38; }
  .text-sm { font-size: 0.8rem; }
  .color-gray { color: #ccc; }
  .pointer { cursor: pointer; }
  .menuimg { width: 250px; height: 270px; }
  .menuimg > img { width: 100%; height: 100%; object-fit: contain; }
</style>