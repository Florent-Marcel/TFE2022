<script setup>
import { defineComponent } from 'vue'
</script>

<template>
    <div id="vueModal" class="modal">
        <div :class="{'modal-content' : true, 'resizable' : resizable}">
            <font-awesome-icon v-if="closeButton" icon="fa-solid fa-circle-xmark" title="Close" class="close-modal" @click="close"/>
            <slot></slot>
        </div>
    </div>
</template>


<script>

export default defineComponent({
    props:{
        resizable: {
            type: Boolean,
            default: false
        },
        closeButton: {
            type: Boolean,
            default: true
        },
    },
    methods: {
        close(){
            this.$emit('close');
        }
    },
})

</script>

<style scoped>
.modal {
    background-color: rgba(0,0,0,0.4);
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 39;
    position: fixed;
    left: 0;
    bottom: 0;
    overflow: hidden;
}

.modal-content{
    position: relative;
    width: fit-content;
    height: fit-content;
    border-radius: 10px;
    background: #22577A;
    margin: 20px;
    z-index: 60;
    box-shadow: 0px 0px 8px gray;
    max-height: calc(100% - 85px);
    max-width: calc(100% - 15%);
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    padding: 5px;
    color: white;
}

.modal-body{
    text-align: justify;
}

.modal-footer{
    text-align: center;
    margin-top: auto;
    padding-top: 5px;
}

.modal-header{
    text-align: center;
    font-size: large;
    margin-bottom: 15px;
}

.resizable{
    resize: both;
}

.close-modal{
    position: absolute;
    right: 7px;
    top: 7px;
    height: 20px;
    width: 20px;
    color: rgb(201, 3, 3);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.close-modal:hover{
    color: rgb(255, 94, 94);
}
</style>
