<template>
  <main>
    <div class="container">
      <div class=" d-flex justify-content-center" v-if="weatherOk === true">
        <div class="card w-25 text-center border-carrot mb-3" style="min-width: 10rem;">
          <div class="card-header border-carrot bg-transparent bold">{{ today }}</div>
          <div class="w-100"><img :src="'http://openweathermap.org/img/wn/'+wicon+'@2x.png'"></div>
          <div class="card-body">
            <div class="card-text">
              <p>{{ temp }}도</p>
              <p>{{ weather }}</p>
            </div>
          </div>
        </div>
      </div>

      <div class="card-group text-center">
        <div class="card">
          <img src="">
          <div class="card-body">
            <h5 class="card-title">아무메뉴</h5>
          </div>
    </div>

        <div class="card">
          <img src="">
          <div class="card-body">
            <h5 class="card-title">추천메뉴</h5>
          </div>
        </div>
        
        <div class="card">
          <img src="">
          <div class="card-body">
            <h5 class="card-title">어쩌구메뉴</h5>
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
      data: [],
      today: '',
      city: '',
      temp: '',
      weather: '',
      wicon: '',
      weatherKr: {
        201: '가벼운 비를 동반한 천둥구름',
        200: '비를 동반한 천둥구름',
        202: '폭우를 동반한 천둥구름',
        210: '약한 천둥구름',
        211: '천둥구름',
        212: '많은 천둥구름',
        221: '불규칙적인 천둥구름',
        230: '약한 연무를 동반한 천둥구름',
        231: '연무를 동반한 천둥구름',
        232: '많은 안개비를 동반한 천둥구름',
        300: '가벼운 안개비',
        301: '안개비',
        302: '많은 안개비',
        310: '가벼운 이슬비',
        311: '이슬비',
        312: '많은 이슬비',
        313: '소나기와 안개비',
        314: '많은 소나기와 안개비',
        321: '여우비',
        500: '약한 비',
        501: '적당한 비',
        502: '많은 비',
        503: '매우 많은 비',
        504: '매우 심하게 내리는 비',
        511: '우박',
        520: '약한 소나기',
        521: '소나기',
        522: '많은 소나기',
        531: '불규칙적인 소나기',
        600: '가벼운 눈',
        601: '눈',
        602: '많은 눈',
        611: '진눈깨비',
        612: '소낙눈',
        615: '약한 비와 눈',
        616: '비와 눈',
        620: '약한 소낙눈',
        621: '소낙눈',
        622: '많은 소낙눈',
        701: '박무',
        711: '스모그',
        721: '실안개',
        731: '황사',
        741: '안개',
        751: '모래',
        761: '먼지',
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
    }
  },
  methods: {
    askForCoords(){
      navigator.geolocation.getCurrentPosition(pos => {
        console.log(pos);
        this.lat = pos.coords.latitude;
        this.lon = pos.coords.longitude;
        // console.log(this.lat, this.lon);
        this.getPlaceWeather(this.lat, this.lon);
        this.weatherOk = true;
      }, err => { console.log(err); }
      );
    },
    // openweather api
    async getPlaceWeather(lat, lon) {
      const data = await this.getWeather(lat, lon);
      console.log(data);

      const weatherId = data.weather[0].id
      this.city = data.name;
      this.temp = Math.round(data.main.temp);
      this.weather = this.weatherKr[weatherId];
      this.wicon = data.weather[0].icon;
      this.today = new Date(data.dt * 1000).toISOString().slice(0, 10);
    },

    // 10도 이하 : 추움 / 25도 이상 더움
    async getPushMenu() {
      // 추천메뉴 가져오기...
    }
  },
  created() {
    this.askForCoords();
  }
}
</script>

<style scoped>
  .bold { font-weight: bold; }
  .border-carrot { border-color: #F26C38 }
</style>