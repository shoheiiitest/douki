
var CtrSheets = new Vue({
    el : '#CtrSheets',
    data : {
        show:false,
        loading:false,
        file_name:'',
        files:[],
        sheet_name:'',
        errors:[],
    },
    methods:{
        async importFile(project_id){
            this.loading = true;
            let formData = new FormData();
            formData.append('customFile',this.files);
            formData.append('customFileName',this.file_name);
            formData.append('project_id',project_id);

            this.loading = true;
            var requestPath = '/api/sheets/importFile';
            let result = await axios.post(requestPath,formData,{ 'content-type': 'multipart/form-data' }).then(function (response) {
                return response.data;
            }).catch(function (error) {
                return error;
            });

            if(result.success = true){
                alert('success');
                this.loading = false;
                this.show = true;
                var handler = function(){CtrSheets.show = false};
                var r = setTimeout(handler,2000);
            }else{
                alert('失敗じゃよ');
            }

        },

        upFile(e,target){
            console.log(e);
            this.file_name = e.target.files[0].name;
            this.files = e.target.files[0];
        },

    },

    mounted(){

    },

    components:{

    },

});
