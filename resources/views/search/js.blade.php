<script>
    function search() {
        var msg = document.getElementById('search').value;
        if(msg.length>=2)
        {
            $.get('/search/edit/' + msg, function (data) {
                $('#kabsearchform').html(data).fadeIn(600);
                return false;
            });
        }
        else {
            $("#kabsearchform").hide();
        }
    }

    $(document).ready(function() {
        $('#search').keydown(function(e) {
            if(e.keyCode === 13) {
                search_btn($(this).val());
            }
        });
    });
    function search_btn(per) {
        var msg = document.getElementById('search').value;
        if(msg.length>=2)
        {
            document.location.replace("/search/"+msg);
        }
    }

    $('#search').on('click', function(){
        search();
    });

    $('#search').on('input', function () {
        search();
    });

    jQuery(function($){
        $(document).mouseup(function (e){
            var div = $("#find");
            if (!div.is(e.target)
                && div.has(e.target).length === 0) {
                $("#kabsearchform").hide();
            }
            if ($("#search").is(e.target)
                && div.has(e.target).length === 0) {
                search();
            }
        });
    });
</script>