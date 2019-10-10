
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
        async submit(){
            this.loading = true;
            let formData = new FormData();
            formData.append('customFile',this.files);
            formData.append('customFileName',this.file_name);

            this.loading = true;
            var requestPath = '/api/sheets/import';
            await axios.post(requestPath,formData,{ 'content-type': 'multipart/form-data' }).then(function (response) {
                this.loading = false;
                this.show = true;
                var handler = function(){CtrSheets.show = false};
                var r = setTimeout(handler,2000);
            }).catch(function (error) {
                return error;
            });

            this.loading = false;

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
