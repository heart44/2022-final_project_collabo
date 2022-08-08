<template>
    <main>
        <h3>{{ getSearchWord }}</h3>
        <br>
        <div class="d-flex column pb-5">
            <div class="col-4 aaa bbb" style="height:500px;">
                <div v-for="rest in restList" :key="rest">
                    <div class="d-flex column">
                        <span v-if="rest.img_path !== null" style="float:left;">
                            <img :src=rest.img_path style="width:100px;height:100px;">
                        </span>
                        <span v-else style="float:left;">
                            <img src="https://cdn.pixabay.com/photo/2015/09/13/21/13/dishes-938747_960_720.jpg" style="width:100px;height:100px;">
                        </span>
                    
                        <div>
                            <div class="bold">{{ rest.rest_name }}</div>
                            <div>주소 : {{ rest.rest_address }}</div>
                            <div>카테고리 : {{ rest.menu }}</div>
                            <div>전화번호 : {{ rest.tel }}</div>
                            <div>영업시간 : {{ rest.open_close }}</div>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <div ref="mapDiv" class="col-8 aaa" style="width:600px;height:500px;"></div>
        </div>
    </main>
</template>

<script>
export default {
    name: "SearchList",
    data() {
        return {
            restList: []
        }
    },
    created() {
        this.restList = this.getRestList
    },
    updated() {
        // this.insSearchList()
    },
    mounted() {
        this.mapContainer()
    },
    computed: {
        restList() {
            return this.$store.getters.getRestList;
        },
        getSearchWord() {
            return this.$store.getters.getSearchWord;
        },
        getCurrentLoc() {
            return this.$store.getters.getCurrentLoc;
        }
    },
    methods: {
        mapContainer() {
            const options = {
                center: new kakao.maps.LatLng(this.getCurrentLoc.lat, this.getCurrentLoc.lon),
                level: 5
            };

            const map = new kakao.maps.Map(this.$refs.mapDiv, options);
            console.log(map)
        },
        // async insSearchList() {
        //     let params = []
        //     this.getSearchList.forEach(item => {
        //         params.push({
        //             name: item.name,
        //             addr: item.address,
        //             cate2: item.category[0],
        //             tel: item.tel,
        //             menu: item.menuInfo,
        //             open_close: item.bizhourInfo,
        //             lon_x: item.x,
        //             lat_y: item.y,
        //             img_path: item.thumUrl
        //         })
        //     });
        //     params.push(this.getSearchWord);
        //     console.log(params)
        //     const rs = await this.$post('/search/searchList', params);
        //     console.log(rs)
        // },
        // async getRestList() {
        //     const rs = await this.$get(`/search/restList/${this.getSearchWord}`);
        //     console.log(rs);
        //     this.restList = rs;
        // }
    },
    
}
</script>

<style scoped>
.aaa { margin: 0 auto; }
.bbb { overflow: scroll; overflow-x: hidden; }
.bold { font-weight: bold; }
</style>