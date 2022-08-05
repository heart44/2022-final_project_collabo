<template>
    <main class="">
        <div class="container">
            <h2 class="text-center">~ 글 쓰기 ~</h2>

            <div class="">
                <label for="" class="form-label">제목</label>
                <div class="">
                    <input type="text" class="form-control" ref="title" v-model="composition.title">
                </div>
            </div>

            <div class="">
                <label for="" class="form-label">작성자</label>
                <div class="">
                    <input type="text" class="form-control" ref="iuser" v-model="composition.iuser">
                </div>
            </div>
                
                
            <div class="">
                <label for="" class="form-label">매장 이름</label>
                <div>
                    <select class="form-select" @change="changeAreaCate1" v-model="selectedAreaCate1">
                        <option value="" >시/도 선택</option>
                        <option :value="key" v-for="item, key in AreaCate1" :key="key">
                            {{ key }}
                        </option>
                    </select>
                </div>
                <div class="">
                    <input type="text" class="form-control" ref="irest" v-model="composition.irest">
                </div>
            </div>

            <div class="">
                <label for="" class="form-label">날짜 시간</label>
                <div class="">
                    <input type="datetime-local" class="form-control" ref="partydt" v-model="composition.partydt">
                </div>
            </div>

            <div class="">
                <label for="" class="form-label">내용</label>
                <div class="">
                    <input type="text" class="form-control" ref="ctnt" v-model="composition.ctnt">
                </div>
            </div>

            <div class="">
                <label for="" class="form-label">총 인원 수</label>
                <div class="">
                    <input type="number" class="form-control" ref="total_mem" v-model="composition.total_mem">
                </div>
            </div>

            <div class="">
                <div class="">
                    <button type="button" class="btn" @click="HomeView">취소</button>
                </div>
                <div class="">
                    <button type="button" class="btn" @click="insBobF">저장</button>
                </div>
            </div>
            
        </div>
    </main>
</template>

<script>
export default {
    data() {
        return {
            composition: {
                title: '',
                iuser: 1,
                irest: 3,
                partydt: '',
                ctnt: '',
                total_mem: '',
                cur_mem: 1,
                img_path: ''
            },
            AreaCate1: {
                "서울특별시": "서울",
                "경기도": "경기",
                "인천광역시": "인천",
                "세종특별자치시": "세종",
                "강원도": "강원",
                "충청북도": "충북",
                "충청남도": "충남",
                "대전광역시": "대전",
                "경상북도": "경북",
                "경상남도": "경남",
                "대구광역시": "대구",
                "울산광역시": "울산",
                "부산광역시": "부산",
                "전라북도": "전북",
                "전라남도": "전남",
                "광주광역시": "광주",
                "제주특별자치도": "제주"
            },
            BobFList: [],
            selectedAreaCate1: '',
        }
    },
    created() {
    },
    methods: {
        insBobF() {
            const res = this.$post('api/insBobF', this.composition);
            console.log(res);
            this.$router.push( {path: '/'} );
        },
        selBobF() {
            this.BobFList = this.$get('api/selBobfList', {})
        },
        changeAreaCate1() {
            
        }
        
    }
}
</script>

<style>

</style>