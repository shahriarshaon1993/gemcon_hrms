<template>
  <div class="page-wrappers">
    <frontend-header></frontend-header> 
    <router-view />
    <frontend-footer></frontend-footer> 
  </div>
</template>
<script>
import FrontendHeader from "./FrontendHeader";
import FrontendFooter from "./FrontendFooter"; 
export default {
  name: "App",
  base_url: window.base_url,
  components: {
    "frontend-header": FrontendHeader,
    "frontend-footer": FrontendFooter, 
    // VueRecaptcha, facebookLogin
  },
  data() {
    return {};
  },
  methods: {},
  created() {},
};
</script>

<style>
input.form-control.input_custom_2.is-invalid {
  border-color: #f00;
}
</style>
