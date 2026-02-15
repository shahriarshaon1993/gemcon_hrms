<template>
    <ul id="nav">
        <li  :class="$route.meta.title == 'Dashboard'?'current':''">
            <router-link to="/">
                <i class="icon-dashboard"></i>
                Dashboard
            </router-link>  
        </li>
        <li :class="$route.meta.title == 'Menu'?'current':''">
            <router-link to="/menu">
                <i class="icon-table"></i>
                Menu
            </router-link>
        </li>

        <li v-for="list in menuListData" :class="$route.meta.title == list.menu_name?'current':''">
            <router-link :to="list.menu_link ? list.menu_link :''">
                <i :class="list.menu_icon"></i>
                {{list.menu_name}}
            </router-link>
            <ul class="sub-menu" v-if="list.children">
                <li v-for="sub in list.children" :class="$route.meta.subtitle == sub.menu_name?'current':''">
                    <router-link :to="sub.menu_link ? sub.menu_link :''">
                        <i :class="sub.menu_icon"></i>
                        {{sub.menu_name}}
                        <span v-if="sub.children" class="arrow"></span>
                    </router-link>
                    <ul class="sub-menu" v-if="sub.children">
                        <li v-for="deep in sub.children"  :class="$route.meta.deeptitle == deep.menu_name?'current':''">
                            <router-link :to="deep.menu_link">
                                <i :class="deep.menu_icon"></i>
                                {{deep.menu_name}}
                            </router-link>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>

    </ul>
</template>

<script>
    export default {
        data(){
            return {
                menuListData : []    
            }
        },
        methods:{
            getmenuList(){
                axios.get(URL.baseUrl('getmenu'))
                .then(res => {
                    this.menuListData=res.data.menu_list;
                    setTimeout(function(){
                        initAllJs();
                    }, 1000);
                })
                .catch(error => {
                    console.log(error);               
                });
            }
        },
        created() {
            this.getmenuList();
        }
    }
</script>
