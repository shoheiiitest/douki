import draggable from 'vuedraggable'

var CtrIndex = new Vue({
    el: "#CtrHeaders",
    data:{
        loading:false,
        color:'#2D93C5',
        headers:[],
        col_types:[],
        counter:0,
        add:'',
        errors:[],
        options:{
            animation:300,
            handle:'.handle',
        },
        element:'tbody',


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
            this.col_types = result.col_types;
            this.counter = this.headers.length;
            this.loading = false;
        },

        async submitHeaders(){
            if(!confirm('登録してよろしいでござるか？')){
                return;
            }
            this.loading = true;
            var pathArray = window.location.pathname.split('/');
            var project_id = pathArray[1];
            var data = {
                data: this.headers,
                counter: this.counter,
                project_id: project_id,
            };

            var requestPath = '/api/headers/submitHeaders';
            const result = await axios.post(requestPath,data).then(function (response) {
                return response.data;
            }).catch(function (error) {
                return error;
            });

            if(result.success){
                this.getItems();
            }else if(result.message != undefined){
                this.errors = result.message;
                this.loading = false;
            }else{
                alert('エラーでござる');
                this.loading = false;
            }

        },

        addRow(num){

            for(var i=0; i<parseInt(num); i++){
                this.headers.push({
                    col_name:'',
                    created_at :'',
                    disp_flg :'',
                    id :'',
                    order_num:'',
                    project_id :'',
                    updated_at :'',
                });
                this.counter++;
            }

        },

        moveOrder(e){
          console.log(e);
          console.log(this.lists);

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
        draggable,
    }

});
