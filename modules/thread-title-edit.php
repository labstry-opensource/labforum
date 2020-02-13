<div class="container py-5">
    <div class="row align-items-center">
        <select name="forum" class="custom-select fid-select d-none col-12 col-md-4" id="">

        </select>
        <div class="fixed-forum-label text-light d-none col-12 col-md-4"></div>
        <div class="col-12 col-md-8 mb-3">
            <input type="text" name="thread_topic" placeholder="輸入主題" class="form-control thread-topic thread_topic text-white">
            <div class="thread_topic-invalid-feedback invalid-feedback bg-light"></div>
        </div>
    </div>

</div>

<script>
    function initCustomSelect(){
        $('.custom-select').wrap('<div class="select col-12 col-md-4 mb-3"></div>').after('<div class="form-control forum select-styled">Select forum</div>' +
            '<ul class="select-list position-absolute list-group list-group-flush overflow-hidden"></ul>' +
            '<div class="forum-invalid-feedback invalid-feedback bg-light"></div>');

        // Iterate over each select element
        var optionValues = [];
        $('.custom-select option').each(function (index) {
            if(index === 0){
                $('.select-styled').text($(this).html());
            }
            option_item = {value: $(this).val(), text: $(this).html()}
            optionValues.push(option_item);
        });

        for(var i = 0; i < optionValues.length; i++){
            var list_li = '<li class="list-group-item" data-value="'+ optionValues[i]['value']+'">' + optionValues[i]['text'] + '</li>';
            $('.select-list').append(list_li);
        }

        $('.select-styled').on('click', function(){
            $(this).siblings('.select-list').toggleClass('active');
        });

        $('.select-list li').on('click', function(){
            $('.custom-select').val($(this).data('value'));
            $(this).parent().removeClass('active');
            $(this).parent().siblings('.select-styled').text($(this).text());
        });
    }
</script>