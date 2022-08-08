<template>
    <main>
        <h3>{{ getSearchWord }}</h3>
        <br>
        <div class="d-flex column pb-5">
            <div class="col-4 aaa bbb" style="height:500px;">
                <div v-for="rest in restList" :key="rest">
                    <div class="d-flex column justify-content-center align-items-center">
                        <div>
                            <div v-if="rest.img_path !== null">
                                <img :src=rest.img_path style="width:100px;height:100px;">
                            </div>
                            <div v-else>
                                <img src="https://cdn.pixabay.com/photo/2015/09/13/21/13/dishes-938747_960_720.jpg" style="width:100px;height:100px;">
                            </div>
                        </div>
                    
                        <div class="ms-4">
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
    },
    
}
</script>

<style scoped>
.aaa { margin: 0 auto; }
.bbb { overflow: scroll; overflow-x: hidden; }
.bold { font-weight: bold; }
</style>