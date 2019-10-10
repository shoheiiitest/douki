
var CtrSheets = new Vue({
    el : '#CtrSheets',
    data : {
        show:true,
        loading:false,
        file_name:'',
        sheet_name:'',
        errors:[],
    },
    methods:{
        async submit(mode,project_id,sheet_id=null){
            var data = {
                mode:mode,
                project_id: project_id,
                sheet_id:sheet_id,
                sheet_name:this.sheet_name,
            };
            this.loading = true;
            var requestPath = '/api/sheets/submit';
            const result = await axios.post(requestPath,data).then(function (response) {
                return response.data;
            }).catch(function (error) {
                return error;
            });

            if(result.success){
                alert('成功でござる');
            }else if(result.message != undefined){
                this.errors = result.message;
                this.loading = false;
            }else{
                alert('何かエラーがあるでござる');
                this.loading = false;
            }
            this.loading = false;

        },

        upFile(e,target){
            console.log(e);
            this.file_name = e.target.files[0].name;
        },

    },

    mounted(){

    },

    components:{

    },

});
