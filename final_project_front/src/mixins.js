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
      //   async getWeatherKr(nx, ny, date) {
      //       const parameter = {
      //           ServiceKey: this.ServiceKey,
      //           pageNo: 1,
      //           numOfRows: 266,
      //           dataType: 'json',
      //           base_date: date,
      //           base_time: 2300,
      //           nx,
      //           ny
      //       }
      //       console.log(parameter);
      //       return await this.$api(this.baseurl, parameter);

      //   },
        getOnlyDateStr(date) {
            return new Date(date).toISOString().slice(0, 10).replaceAll('-', '');
        },
    }
}
