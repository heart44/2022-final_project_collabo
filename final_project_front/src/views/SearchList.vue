<template>
    <main>
        <h3>{{ getSearchWord }}</h3>
        <br>
        <div class="d-flex column">
            <div  class="col-4">
                <div v-for="rest of getSearchList" :key="rest">
                    <div style="width:100px;height:100px;">이미지 : <img :src=rest.thumUrl style="width:100%;height:100%;"></div>
                    <div>가게이름 : {{ rest.name }}</div>
                    <div>가게주소 : {{ rest.address }}</div>
                    <div>카테고리 : {{ rest.category[0] }}</div>
                    <div>전화번호 : {{ rest.tel }}</div>
                    <div>영업시간 : {{ rest.bizhourInfo }}</div>
                    <div>메뉴 : {{ rest.menuInfo }}</div>
                    <hr>
                </div>
            </div>
            <div ref="mapDiv" class="col-8" style="width:400px;height:400px;">{{ mapContainer }}</div>
        </div>
    </main>
</template>

<script>
export default {
    name: "SearchList",
    data() {
        return {

        }
    },
    created() {
        this.insSearchList()
    },
    updated() {
        this.insSearchList()
    },
    mounted() {
        this.mapContainer()
    },
    computed: {
        getSearchList() {
            return this.$store.getters.getSearchList;
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
        async insSearchList() {
            let params = []
            this.getSearchList.forEach(item => {
                params.push({
                    name: item.name,
                    addr: item.address,
                    cate2: item.category[0],
                    tel: item.tel,
                    menu: item.menuInfo,
                    open_close: item.bizhourInfo,
                    lon_x: item.x,
                    lat_y: item.y,
                    img_path: item.thumUrl
                })
            });
            console.log(params)
            const rs = await this.$post('/search/searchList', params);
            console.log(rs)
        }
    },
    
}
</script>

<style>

</style>