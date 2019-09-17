var CtrProjects = new Vue({
    el : '#CtrProjects',
    data : {
        loading:false,
        project_name:'',
        errors:[],
   },
    methods:{
        async submit(){
            var data = {
              project_name:this.project_name,
            };
            this.loading = true;
            var requestPath = '/api/projects/submit';
            const result = await axios.post(requestPath,data).then(function (response) {
                return response.data;
            }).catch(function (error) {
                return error;
            });

            if(result.success){
                location.href='/';
            }else if(result.message != undefined){
                this.errors = result.message;
                this.loading = false;
            }else{
                alert('エラーでござる');
                this.loading = false;
            }

        },
    }
});
