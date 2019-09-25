

var CtrIndex = new Vue({
    el: "#CtrProjects",
    data:{
        loading:false,
        color:'#2D93C5',
        projects:[],


    },
    methods:{
        async getItems(){
            this.loading = true;

            var requestPath = '/api/projects/getItems/';
            const result = await axios.get(requestPath).then(function (response) {
                return response.data;
            }).catch(function (error) {
                return error;
            });
            this.projects = result.projects;
            this.loading = false;
        },

        async deleteProject(project_id){
            if(!confirm('削除してよろしいでござるか？')){
                return;
            }
            this.loading = true;
            var data = {
                project_id:project_id,
            };

            const result = await axios.post('/api/project/delete',data).then(function (response) {
                return response.data;
            }).catch(function (error) {
                return error;
            });

            if(result.success){
                this.getItems();
            }else{
                alert(result.message);
                this.loading = false;
            }

        },

        toEditHeaders(project_id){
            location.href=project_id + '/headers/list';
        },

         loadLists(){
             this.getItems();

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
