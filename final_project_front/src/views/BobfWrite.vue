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
        }
    },
    created() {
    },
    methods: {
        insBobF() {
            const res = this.$post('/api/insBobF', this.composition);
            console.log(res);
            this.$router.push( {path: '/'} );
        }
    }
}
</script>

<style>

</style>