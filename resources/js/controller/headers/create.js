var CtrIndex = new Vue({
    el: "#CtrHeaders",
    data:{
        loading:false,
        color:'#2D93C5',
        col_name:'',
        col_types:[],
        errors:[],
        selecting:'1',

    },
    methods:{
        async getColTypes(mode,header_id){
            this.loading = true;
            var requestPath = '/api/headers/getColTypes/'+ mode + '/';
            if(mode=='edit'){
                requestPath+=header_id;
            }
            const result = await axios.get(requestPath).then(function (response) {
                return response.data;
            }).catch(function (error) {
                return error;
            });
            console.log(result.header);
            if(mode == 'edit'){
                this.col_name = result.header.col_name;
                this.selecting = result.header.col_type;
            }
            this.col_types = result.col_types;
            this.loading = false;

        },

        async submit(mode,project_id,header_id){
            this.loading = true;
            var data = {
              mode : mode,
              header_id: header_id,
              project_id : project_id,
              col_name : this.col_name,
              col_type : this.selecting,
            };
            var requestPath = '/api/headers/submit';
            const result = await axios.post(requestPath,data).then(function (response) {
                return response.data;
            }).catch(function (error) {
                return error;
            });

            if(result.success){
                window.location.href = '/'+project_id+'/headers/list';
            }else if(result.message != undefined){
                this.errors = result.message;
                this.loading = false;
            }else{
                alert('エラーでござる');
                this.loading = false;
            }
        },
        // async getItems(){
        //     this.loading = true;
        //     var pathArray = window.location.pathname.split('/');
        //     var project_id = pathArray[1];
        //     var requestPath = '/api/' + project_id + '/headers/getItems/';
        //     const result = await axios.get(requestPath).then(function (response) {
        //         return response.data;
        //     }).catch(function (error) {
        //         return error;
        //     });
        //     this.headers = result.headers;
        //     this.col_types = result.col_types;
        //     this.counter = this.headers.length;
        //     this.loading = false;
        // },
        //
        // async submitHeaders(){
        //     if(!confirm('登録してよろしいでござるか？')){
        //         return;
        //     }
        //     this.loading = true;
        //     var pathArray = window.location.pathname.split('/');
        //     var project_id = pathArray[1];
        //     var data = {
        //         data: this.headers,
        //         counter: this.counter,
        //         project_id: project_id,
        //     };
        //
        //     var requestPath = '/api/headers/submitHeaders';
        //     const result = await axios.post(requestPath,data).then(function (response) {
        //         return response.data;
        //     }).catch(function (error) {
        //         return error;
        //     });
        //
        //     if(result.success){
        //         this.getItems();
        //     }else if(result.message != undefined){
        //         this.errors = result.message;
        //         this.loading = false;
        //     }else{
        //         alert('エラーでござる');
        //         this.loading = false;
        //     }
        //
        // },
        //
        // addRow(num){
        //
        //     for(var i=0; i<parseInt(num); i++){
        //         this.headers.push({
        //             col_name:'',
        //             created_at :'',
        //             disp_flg :'',
        //             id :'',
        //             order_num:'',
        //             project_id :'',
        //             updated_at :'',
        //         });
        //         this.counter++;
        //     }
        //
        // },
        //
        // async moveOrder(){
        //     this.loading = true;
        //     var count = $('#header-list').children().length;
        //     var headerIds = [];
        //     for(var i=0; i<count; i++){
        //         headerIds[i] = $('#header-list').children()[i].dataset['headerId'];
        //     }
        //
        //     var data = {
        //         headerIds:headerIds,
        //     };
        //
        //     var requestPath = '/api/headers/moveOrder';
        //     const result = await axios.post(requestPath,data).then(function (response) {
        //         return response.data;
        //     }).catch(function (error) {
        //         return error;
        //     });
        //
        //     if(result.success){
        //         this.headers = result.headers;
        //         this.loading = false;
        //     }else{
        //         alert('エラーでござる');
        //         this.loading = false;
        //     }
        //
        // },
        //
        // async editDispFlg(index,header_id){
        //     this.loading = true;
        //     var disp_flg = $('#customSwitch_'+ header_id).prop('checked') ? 1:0;
        //     var data = {
        //         header_id:header_id,
        //         disp_flg:disp_flg
        //     };
        //
        //     var requestPath = '/api/headers/editDispFlg';
        //     const result = await axios.post(requestPath,data).then(function (response) {
        //         return response.data;
        //     }).catch(function (error) {
        //         return error;
        //     });
        //
        //     if(result.success){
        //         this.headers[index] = result.header;
        //         this.loading = false;
        //     }else{
        //         alert('エラーでござる');
        //         this.loading = false;
        //     }
        //
        // },

        loadLists(){
            var header_id = '';
            if(window.location.pathname.split('/')[3]=='edit'){
                var mode = 'edit';
                var header_id = window.location.pathname.split('/')[4];
            }else{
                var mode = 'create';
            }

            this.getColTypes(mode,header_id);

        },

    },
    computed:{


    },
    mounted(){
        this.loadLists();
    },

    components:{

    }

});
