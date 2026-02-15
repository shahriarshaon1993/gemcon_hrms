<template>
<div>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-1 mt-0">
                    <div class="row breadcrumbs-top">
                        <div class="col-sm-9">
                            <div class="breadcrumb-wrapper col-9">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item">
                                        <router-link :to="{ path: '/' }"><i class="bx bx-home-alt"></i></router-link>
                                    </li>
                                    <li class="breadcrumb-item active"> KRA & KPI  
                                    </li>
                                </ol>
                            </div>
                        </div>
                        <div class=" col-sm-3">
                            <!-- <router-link class="btn btn-primary add-btn" :to="{ path: '/' }"> <i class="bx bx-add-alt"></i> Add daily work </router-link> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
         
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card"> 
                                    <div class="container">
                                        <vue-tree
                                        style="width: 1570px; height: 800px; border: 1px solid gray;"
                                        :dataset="sampleData"
                                        :config="treeConfig"
                                      >
                                        <template v-slot:node="{ node, collapsed }">
                                          <div
                                            class="rich-media-node"
                                            :style="{ border: collapsed ? '2px solid grey' : '' }"
                                          >
                                            <span style="padding: 4px 0; font-weight: bold;"
                                              >{{ node.value }}</span
                                            >
                                          </div>
                                        </template>
                                      </vue-tree>
                                        
                                      </div> 
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import axios from "../../axios_instance";
// import OrganizationChart from 'vue-organization-chart';
// import 'vue-organization-chart/dist/orgchart.css';
import VueTree from '@ssthouse/vue-tree-chart'
export default {
    props: {},
    components: {
        'vue-tree': VueTree
        // VueRecaptcha, facebookLogin
    },
    data() {
        return {
            base_url: window.base_url,
            api_url: window.api_url,
            token: this.$localStorage.get("d_token"),
            items: [],   
            status: '',
            sampleData : [],
            treeConfig: { nodeWidth: 200, nodeHeight: 100, levelHeight: 170 }


           
        };
    },
    created() { 
        this.getDate();  
       // this.getItems();
           
    },
    methods: {
        async getDate(){
            this.sampleData = {
                value: 'IT',
                children: [
                    { 
                        value: 'KRA : 1', 
                        children: [
                            { 
                                value: 'KPI 1:1' ,
                                children :[
                                    {value : 'MOS'},
                                    {value : 'MOS'},
                                    {value : 'MOS'},
                                    {value : 'MOS : Sale Automission'},
                                ]
                            }, 
                            { value: 'KPI 1:2' }
                        ]
                    },
                    {  
                        value: 'KRA : 2' 
                    },
                    { 
                        value: 'KRA : 2' 
                    },
                    { 
                        value: 'KRA : 2' 
                    },
                    { 
                        value: 'KRA : 2' 
                    },
                    { 
                        value: 'KRA : 1', 
                        children: [
                            { value: 'MOS 1:1' }, 
                            { value: 'MOS 1:2' },
                            { value: 'MOS 1:1' }, 
                            { value: 'MOS 1:2' }
                        ] 
                    },
                    { 
                        value: 'KRA : 2' 
                    }
                ]           
            }
            console.log('a');
            console.log(this.sampleData);
            console.log('a');
        },
        async getItems() {
            let where = '?'; 
      
            // if (this.status) {
            //     where += '&status=' + this.status;
            // }
            let loader = this.$loading.show();
            try {
                await axios
                    .get(this.api_url + "kar_kpi_mos_chart" + where, {
                        headers: {
                            "Content-Type": "application/json",
                            Authorization: this.token ? `Bearer ${this.token}` : ""
                        },
                    })
                    .then(({  data }) => { 
                        this.sampleData = JSON.parse(data.data) ;
                        console.log('this.sampleData');
                        console.log(  this.sampleData);
                        console.log('this.sampleData');
                        loader.hide();
                    });
            } catch (error) {
                loader.hide();
            }
        },
    
    },
    computed: {},
};
</script>
<style>
    .avat {
        width: 20px !important;
        height: 20px !important;
        border: none !important;
    }
</style>

<style scoped  >
    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    
    .rich-media-node {
  width: 180px;
  padding: 8px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: center;
  color: white;
  background-color: #f7c616;
  border-radius: 4px;
}
</style>