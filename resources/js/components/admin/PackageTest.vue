<template>
  <div class="row">
  	<div class="col-md-6">
	    <select2-multiple-control v-model="selected" :options="options" @change="myChangeEvent($event)" @select="mySelectEvent($event)" />
	    <h4>Value: {{ selected }}</h4>
    </div>
  </div>
</template>
<script>
	export default{
		data(){
    		return{
    			selected:'',
			    options: [
			      { id: 1, text: 'Hello' },
			      { id: 2, text: 'World' },
			      { id: 3, text: 'Red' },
			      { id: 4, text: 'Blue' },
			      { id: 5, text: 'Green' }
			    ]
    		}
    	},
    	method: {
	        myChangeEvent(val){
	            console.log(val);
	        },
	        mySelectEvent({id, text}){
	            console.log({id, text})
	        }
	    },
	}
</script>