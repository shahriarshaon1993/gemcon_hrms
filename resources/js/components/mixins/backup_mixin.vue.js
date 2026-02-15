export default {
  data(){
    return { 
    lists:{},
    page_loading:false,
    form_data:{},
    edit:false,
    sort:'id',
    order:'desc',
    paginate_num:5,
    search_key:'',
    dataUrl:null,
    validate:false,
    current_page_no:1,
    modal_page_loading:false,
    pagetitle:'',
    order_no:0,
    errors:null
    }
  },
  computed:{
    isComplete: {
      cache: false,
      get: function () {
        return this.$v.form_data.$invalid;
      }
    }
  },

  methods:{
    showModal () {
      this.$modal.show('myModal');
    },
    hideModal () {
      this.$modal.hide('myModal');
    },
    reload(){
      this.$router.go();
    },
    onChange(event) {
      let paginate =event.target.value; 
      this.getResults();
    },
    isObject (v) {
      return (typeof v ==='object') ? true : false;
    },
    onFileSelected(event){
      let file = event.target.files[0];

      if(file.size > 1048770){
        this.showToster({status:0,message:"Image size is big"});
      }else{
        let reader = new FileReader();
        reader.onload = (e) => {
          this.form_data.photo = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    },
    add(addUrl){
      axios.post(addUrl.add,this.form_data)
      .then(res => {
        if(res.data.status==1){
          if(!this.form_data.id){
            this.formReset();
            this.getResults(1);
          }else{
            this.hideModal();
            this.getResults(this.current_page_no);   
          }
        }
        this.errors =null;
        this.showToster(res.data);
      })
      .catch(error => {
        if(error.response.status == 422){
          this.errors = error.response.data.errors;
        }
        var msg = 'opps! something went wrong';
        this.showToster({status:0,message:msg});
      });
    },
    formReset(){
      this.form_data={};
    },
    showToster(info){
      if(info.status == 1){
        this.$toast.success({
          title:'Success!',
          message:info.message
        });   
      }else{
        if(typeof info.message === 'object'){
          this.errors = info.message; 
          var msg = 'opps! something went wrong';
        }else{
          var msg = info.message;
        }
        this.$toast.error({
          title:'Error!',
          message:msg
        });   
      }    
    },
    deleteItem(deleteUrl){   
      this.$swal({
        title: 'Are you sure?',
        text: 'You can\'t revert your action',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes Delete it!',
        cancelButtonText: 'No, Keep it!',
        showCloseButton: true,
        showLoaderOnConfirm: true
      }).then((result) => {
        if(result.value) {
          axios.delete(deleteUrl.delUrl)
          .then(res => {
            this.$swal('Deleted', 'You successfully deleted this file', 'success');
            //this.getResults(this.lists.current_page);
            this.getResults(this.current_page_no);
          })
          .catch(error => {
            // handle error
            this.showToster({status:0,message:'Opps something went wrong'});
          })
        } else {
          this.$swal('Cancelled', 'Your file is still intact', 'info')
        }
      });
    },
    getResults(page){
      if (typeof page === 'undefined') {
          page = 1;
      }
      var fetchUrl = this.$route.meta.fetchUrl;
      this.current_page_no = page;
      axios.get(fetchUrl, {
        params: {
          paginate_num: this.paginate_num,
          search_key: this.search_key,
          page: page,
          sort:this.sort,
          order:this.order
        }
      })
      .then(res => {
        if(res.data.status =='logout'){
          window.location.href=res.data.url;
        }else{
          this.lists=res.data;
          console.log(this.data_length);
          if(res.data.formData){
            this.form_data = res.data.formData;
          }
          this.pagetitle = res.data.pagetitle;
        }
        if( page > 1){
          this.order_no = this.paginate_num * (page - 1);
        }else{
          this.order_no = 0;
        }
        this.page_loading = true;
      })
      .catch(error => {
        console.log(error);
        this.showToster({status:0,message:'opps! something went wrong'});
        this.page_loading = true;
      })
    },
    getModalData(event,obj,callback){
      this.showModal();
      if(obj && obj.dataUrl){

        this.modal_page_loading= false;
        axios.get(obj.dataUrl)
        .then(res => {
          this.form_data = res.data;
          this.modal_page_loading= true;
          this.errors =null;
          if(callback){
            callback();
          }
        })
        .catch(error => {
          this.showToster({status:0,message:'opps! something went wrong'});
          this.modal_page_loading= true;
        })

      }else{
        this.form_data = {}; 
        this.modal_page_loading= true; 
      }
    },
    sortingChanged(column){
      if(this.sort != column){
        this.order = 'asc';  
      }else{
        if(this.order == 'asc') this.order = 'desc';  
        else this.order = 'asc';   
      }
      this.sort = column;
      this.getResults();
    },
    getSortingClass(column){
      if(this.sort == column){
        return (this.order == 'asc') ? 'asc' : 'desc';
      }
    },
  }
}