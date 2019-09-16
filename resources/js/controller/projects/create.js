var CtrProjects = new Vue({
    el : '#CtrProjects',
    data : {
        loading:false,
        project_name:'',
   },
    methods:{
        async submit(){
            var data = {
              project_name:this.project_name,
            };
            this.loading = true;
            var requestPath = '/api/projects/submit';
            const result = await axios.post(requestPath,data).then(function (response) {
                return response.data.success;
            }).catch(function (error) {
                return error;
            });

            if(result){
                location.href='/';
            }else{
                alert('エラーでござる');
                this.loading = false;
            }

        },
    }
});
