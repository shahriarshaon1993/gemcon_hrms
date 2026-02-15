<template>
  <div class="loading-screen" v-show="loading" v-bind:class="classes" v-bind:style="{backgroundColor:bc}">
    <component v-if="customLoader" v-bind:is="customLoader"></component>
    <div v-else>
      <div class="loading-circle"></div>
      <p class="loading-text">{{text}}</p>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      text: 'Loading...',
      dark: false,
      classes: null,
      loading: true,
      background: null,
      customLoader: null
    }
  },
  computed:{
    bc(){
      return this.background || (this.dark ? 'rgba(0,0,0,0.8)' : 'rgba(255,255,255,0.8)')
    }
  },
}
</script>
<style scoped>
.loading-screen {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
  width: 100vw;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 300;
  flex-direction: column;
  user-select: none;
}
/* .loading-circle {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 10px solid #2f96b4;
  border-right: 10px solid #d7ecf7;
  border-bottom: 10px solid #2f96b4;
  border-left: 10px solid #d7ecf7;
  width: 80px;
  height: 80px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
} */
.loading-circle {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 10px solid #fac100;
  border-right: 10px solid #ffefbb;
  border-bottom: 10px solid #fac100;
  border-left: 10px solid #ffefbb;
  width: 80px;
  height: 80px;
  -webkit-animation: spin 1.5s linear infinite;
  animation: spin 1.5s linear infinite;
}
.loading-text {
  margin-top: 15px;
  color: #808080;
  font-size: 12px;
  text-align: center;
}
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
