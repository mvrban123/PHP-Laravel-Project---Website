@if(session()->has('success'))
    <script type="text/javascript">
        $(window).load(function(){
            $.notify({
                message: "{{ session()->get('success') }}" 
            },{
                type: 'success',
                animate: {
                    enter: 'animated fadeInUp',
                    exit: 'animated flipOutX'
                },
                placement: {
                    from: "bottom",
                    align: "right"
                },
                delay: 500,
                timer: 3000,
                onShow: function() {
                this.css({'width':'auto', 'height':'auto', 'padding':'1rem 3rem'});
            },
            });
        });
    </script>
@endif