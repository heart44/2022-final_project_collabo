<template>
  <Transition name="modal">

      <div v-if="show" class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-container">
            <div class="modal-header">
              <slot name="header">
                <h3>{{ getSearchWord }}</h3>
              </slot>
            </div>

            <div class="modal-body">
              <slot name="body">
                <div class="input-group align-items-center">
                  <div class="infiniteScroll">

                    <div  v-for="rest of getSearchList" :key="rest">
                        <div style="width:100px;height:100px;">이미지 : <img :src=rest.thumUrl style="width:100%;height:100%;"></div>
                          <div>
                            가게 이름 : <input type="hidden" id="name" v-model="rest.name" >{{ rest.name }}
                          </div>
                          <div>
                            가게 주소 : <input type="hidden" v-model="rest.address">{{rest.address}}
                          </div>
                          <input type="button" @click="[RestInfo(rest.name, rest.address), $emit('close')]" >
                        <hr>
                    </div>
                    
                  </div>
                </div>
              </slot>
            </div>


            <div class="modal-footer">
              <slot name="footer">
                  <button class="modal-default-button" @click="$emit('close')">
                  OK
                  </button>
              </slot>
            </div>
            
          </div>
        </div>
      </div>

  </Transition>
</template>

<script>
export default {
    name: "Modal",
    props: {
        show: Boolean
    },
    data() {
        return {
            searchList: {},
            searchWord: '',
        }
    },
    created() {
        this.searchList = this.getSearchList
        this.searchWord = this.getSearchWord
    },
    computed: {
        getSearchList() {
            return this.$store.getters.getSearchList;
        },
        getSearchWord() {
            return this.$store.getters.getSearchWord;
        },
    },
    methods: {
      RestInfo(name, addr) { 

        const param = { name : name, addr : addr}

        this.$store.commit('restInfo', param)
      }
    },

}
</script>

<style>

    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: table;
        transition: opacity 0.3s ease;
    }
    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }
    .modal-container {
        width: 600px;
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
        transition: all 0.3s ease;
    }
    .modal-header h3 {
        margin-top: 0;
        color: #F26C38;
    }
    .modal-body {
        margin: 20px 0;
    }
    .modal-default-button {
        float: right;
        background-color:#2B3F6B;
        border:1px solid #2B3F6B;
        color: #fff;
    }
    .modal-enter-from {
        opacity: 0;
    }
    .modal-leave-to {
        opacity: 0;
    }
    .modal-enter-from .modal-container,
    .modal-leave-to .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
</style>