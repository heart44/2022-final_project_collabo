import axios from "axios";

export default {
   data() {
      return {
         appid: '088c76fad55fab4a1cdf8d0d78fec66b',
         url:'https://api.openweathermap.org/data/2.5/weather',
         baseurl:'https://apis.data.go.kr/1360000/VilageFcstInfoService_2.0/getUltraSrtNcst',
         lang: 'kr',
         units: 'metric',
      }
   },
   methods: {
      async $post(url, data) {
         return (await axios({
            method: 'post',
            url,
            data
         }).catch(e =>{
            console.error(e);
         })).data;
      },
      async $get(url, param){
         return (await axios.get(url,{
            params: param
         }).catch(e =>{
            console.error(e);
         })).data;
      },
      async $delete(url, param){
         return (await axios.delete(url,{
            params: param
         }).catch(e =>{
            console.error(e);
         })).data;
      },
      
      $base64(file) {
         return new Promise(resolve => {
            const fr = new FileReader();
            fr.onload = e => {
               resolve(e.target.result);
            }
            fr.readAsDataURL(file);
         });
      },

      async getWeather(lat, lon) {
         const parameter = {
            lat: lat,
            lon: lon,
            units: this.units,
            appid: this.appid,
            lang: this.lang
         }
         return await this.$get(this.url, parameter);
      },
      getOnlyDateStr(date) {
            return new Date(date).toISOString().slice(0, 10).replaceAll('-', '');
      },

      async naverSearch(search, lon, lat) {
         //이거는 네이버에서 메뉴 가져오는 거 통신
         const result = await this.$get(`https://map.naver.com/v5/api/search?caller=pcweb&query=${search}&type=all&searchCoord=${lon};${lat}&page=1&displayCount=20&isPlaceRecommendationReplace=true&lang=ko`);
         const searchList = result['result']['place']['list']
         let params = []
         searchList.forEach(item => {    //for문 돌려서 데이터 가공쓰
            params.push({
               name: item.name,
               addr: item.address,
               tel: item.tel,
               menu: item.menuInfo,
               open_close: item.bizhourInfo,
               lon_x: item.x,
               lat_y: item.y,
               img_path: item.thumUrl
            })
         });
         params.push(search);
         console.log('네이버통신', params)

         return params;    //네이버 결과 값 저장
      },
      async searchList(params) {
         // console.log(params)
         //여기는 db에 검색해서 나온 내용 저장쓰
         const rs = await this.$post('/search/searchList', params);
         // console.log('aa', rs)
      },
      async getRestList(search, lon, lat, iuser) {
         if(iuser === undefined) {
            iuser = 0
         }
         console.log(search, lon, lat, iuser)
         console.log(iuser)
         //여기는 그 뭐냐,,,검색하면 디비에 저장된 내용 가져와서 searchList.vue에 뿌려줄라고
         const rs2 = await this.$get(`/search/restList/${search}/${lon}/${lat}/${iuser}`);
         console.log(rs2["rs"]);
         
         return rs2["rs"];
      },
      async getMenuList() {
         const rs = await this.$get('/search/menuList')
         console.log(rs)
         this.$store.commit('setMenuList', rs);
      }
   }
}
