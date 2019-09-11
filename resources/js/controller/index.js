
var test_data = '';
var CtrIndex = new Vue({
    el: "#CtrIndex",
    data:{
        headers:[],
        result:[],
    },
    methods:{
        async getItems(){

            var data = {
                project_id : 1,
                sheet_id : 1
            };
            await axios.get('/api/cases/getItems/1/1').then(function (response) {
                console.log(this.headers);
                this.headers = response.data.headers[0];
                console.log(this.headers);
            }).catch(function (error) {
                return error;
            });
            // this.result = result;
            //console.log(result);
        },
        loadLists(){
            this.getItems();
            //console.log(this.headers);
        },
    },
    computed:{


    },
    mounted(){
        this.loadLists();
    }
});
