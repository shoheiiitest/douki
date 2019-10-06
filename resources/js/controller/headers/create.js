import draggable from 'vuedraggable'

var CtrIndex = new Vue({
    el: "#CtrHeaders",
    data:{
        loading:false,
        color:'#2D93C5',
        col_name:'',
        col_types:[],
        errors:[],
        selecting:'1',
        items:[],
        options:{
            animation:300,
            handle:'.handle',
        },
        show:false,

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
            if(mode == 'edit'){
                this.col_name = result.header.col_name;
                this.selecting = result.header.col_type;
                this.items = result.items;
            }
            this.col_types = result.col_types;
            this.loading = false;

        },

        async submit(mode,project_id,header_id=null){
            if(this.selecting==4 && this.items.length==0){
                alert('アイテムを追加してください。');
                return;
            }
            this.loading = true;
            var count = $('#item-list span').children().length;
            var items = [];
            for(var i=0; i<count; i++){
                items[i] = $('#item-list span').children()[i].childNodes[2]['value'];
            }

            var data = {
              mode : mode,
              header_id: header_id,
              project_id : project_id,
              col_name : this.col_name,
              col_type : this.selecting,
              items:items,
            };
            var requestPath = '/api/headers/submit';
            const result = await axios.post(requestPath,data).then(function (response) {
                return response.data;
            }).catch(function (error) {
                return error;
            });

            if(result.success){
                this.show = true;
                // window.location.href = '/'+project_id+'/headers/list';
                this.loading = false;
                var handler = function(){CtrIndex.show = false};
                var r = setTimeout(handler,2000);
            }else if(result.message != undefined){
                this.errors = result.message;
                this.loading = false;
            }else{
                alert('エラーでござる');
                this.loading = false;
            }
        },

        addItem(){
            this.items.push('');
            this.errors = '';
        },

        deleteItem(index){
            this.items.splice(index,1);
            this.errors = '';

         },

        moveOrder(){
            this.errors = '';

        },

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
        draggable,

    }

});
