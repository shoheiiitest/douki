
var CtrSheets = new Vue({
    el : '#CtrSheets',
    data : {
        show:false,
        loading:false,
        file_name:'',
        files:[],
        sheet_name:'',
        msg:"　",
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
                this.loading = false;
                this.modal("取込成功じゃよ！");
                setTimeout(() => {
                    location.href="/sheets/"+ project_id
                }, 2000);
            }else{
                alert('失敗じゃよん');
            }

        },

        upFile(e,target){
            console.log(e);
            this.file_name = e.target.files[0].name;
            this.files = e.target.files[0];
        },

        modal(msg){
            //.modalについたhrefと同じidを持つ要素を探す
                var modalThis = $('body').find("#demo1");
                this.msg = msg;
                //bodyの最下にwrapを作る 
                $('body').append('<div id="modalWrap" />');
                var wrap = $('#modalWrap'); wrap.fadeIn('200');
                modalThis.fadeIn('200');
                //モーダルの高さを取ってくる 
                function mdlHeight() {
                    var wh = $(window).innerHeight();
                    var attH = modalThis.find('.modalInner').innerHeight();
                    modalThis.css({ height: attH });
                }
                mdlHeight();
                $(window).on('resize', function () {
                    mdlHeight();
                });
                function clickAction() {
                    modalThis.fadeOut('200');
                    wrap.fadeOut('200', function () {
                        wrap.remove();
                    });
                }
                //wrapクリックされたら 
                wrap.on('click', function () {
                    clickAction(); return false;
                });
                //2秒後に消える 
                setTimeout(clickAction.bind(this), 2000);
        },

    },

    mounted(){

    },

    components:{

    },

});
