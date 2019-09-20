

var CtrIndex = new Vue({
    el: "#CtrHeaders",
    data:{
        loading:false,
        color:'#2D93C5',
        headers:[],


    },
    methods:{
        async getItems(){
            this.loading = true;
            var pathArray = window.location.pathname.split('/');
            var project_id = pathArray[1];
            var requestPath = '/api/' + project_id + '/headers/getItems/';
            const result = await axios.get(requestPath).then(function (response) {
                return response.data;
            }).catch(function (error) {
                return error;
            });
            this.headers = result.headers;
            this.loading = false;
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
