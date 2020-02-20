<div class="container">
    <div id="toolbar" class="position-sticky" style="top: 50px; z-index: 2;background-color: #fff;">
        <select class="ql-font">
            <option selected>Sans Serif</option>
            <option value="Calibri">Calibri</option>
            <option value="Times New Roman">Times New Roman</option>
            <option value="Noto Sans">Noto Sans TC</option>
            <option value="Tahoma">Tahoma</option>
            <option value="Roboto">Roboto</option>
            <option value="Arial">Arial</option>
            <option value="Monospace">Monospace</option>

        </select>
        <!-- Add font size dropdown -->
        <div class="ql-formats">
            <select class="ql-size">
                <option selected value="12px">Small</option>
                <!-- Note a missing, thus falsy value, is used to reset to default -->
                <option value="15px">Normal</option>
                <option value="18px">Large</option>
                <option value="24px">Huge</option>
                <option value="32px">Gigantic</option>
            </select>
            <select class="ql-color"></select>
        </div>

        <div class="ql-formats">
            <button class="ql-bold"></button>
            <button class="ql-underline"></button>
            <button class="ql-italic"></button>
        </div>
        <div class="ql-formats">
            <button class="ql-script" value="sub"></button>
            <button class="ql-script" value="super"></button>
        </div>
        <div class="ql-formats">
            <button class="ql-align"></button>
            <button class="ql-align" value="center"></button>
            <button class="ql-align" value="right"></button>
        </div>
        <div class="ql-formats">
            <button class="ql-indent" value="-1" />
            <button class="ql-indent" value="+1" />
        </div>
        <div class="ql-formats">
            <button class="ql-image"></button>
            <button class="ql-emoji"></button>
            <button class="ql-code-block"></button>
            <button class="ql-link"></button>
            <button class="ql-video"></button>
        </div>


    </div>

    <div class="thread-editor form-control thread_content p-0">

    </div>
    <div class="thread_content-invalid-feedback invalid-feedback"></div>
</div>
<textarea name="thread_content" class="form-control thread-content d-none" placeholder="Happy foruming..."></textarea>

<script>
    //Let third party app stays alone
    var upload_image_url = <?php echo json_encode(BASE_URL . '/api/upload-image.php'); ?>;
    var server_name = <?php echo json_encode($_SERVER['SERVER_ADDR']); ?>;

    var BackgroundStyle = Quill.import('attributors/style/background');
    var AlignStyle = Quill.import('attributors/style/align');
    var FontStyle = Quill.import('attributors/style/font');
    var ColorStyle = Quill.import('attributors/style/color');
    var SizeStyle = Quill.import('attributors/style/size');
    var Parchment = Quill.import('parchment');

    SizeStyle.whitelist = ['12px', '15px','18px', '24px', '32px'];
    FontStyle.whitelist = ['Tahoma', 'Calibri', 'Times New Roman', 'Noto Sans', 'Roboto', 'Arial', 'Monospace'];

    const pixelLevels = [1, 2, 3, 4, 5, 6, 7, 8];
    const TAB_MULTIPLIER = 3;

    class IndentAttributor extends Parchment.Attributor.Style {
        add(node, value) {
            return super.add(node, `${+value * TAB_MULTIPLIER}rem`);
        }

        value(node) {
            return parseFloat(super.value(node)) / TAB_MULTIPLIER || undefined // Don't return NaN
        }
    }
    const IndentStyle = new IndentAttributor("indent", "margin-left", {
        scope: Parchment.Scope.BLOCK,
        whitelist: pixelLevels.map(value => `${value * TAB_MULTIPLIER}rem`),
    })

    Quill.register({ "formats/indent": IndentStyle }, true);
    Quill.register(BackgroundStyle, true);
    Quill.register(ColorStyle, true);
    Quill.register(SizeStyle, true);
    Quill.register(FontStyle, true);
    Quill.register(AlignStyle, true);

    Quill.prototype.getHtml = function() {
        const tempCont = document.createElement('div');
        const tempEditor= new Quill(tempCont);
        var el = document.createElement('div');
        el.innerHTML = editor.root.innerHTML;

         $(el).find('.ql-emojiblot span span').contents().unwrap().unwrap().unwrap();
         $(el).find('.ql-video').each(function(){
             //Show video according to ratio
             var width = $(this).attr('width');
             $(this).addClass('embed-responsive-item').removeClass('ql-video')
                 .removeAttr('width').removeAttr('height')
                 .wrap('<div style="max-width: ' + width + 'px"></div>')
                 .wrap('<div class="embed-responsive-16by9 embed-responsive"></div>');
         })
        console.log(el);
        return '' + el.innerHTML;
    };

    var editor = new Quill('.thread-editor',{
        modules: {
            toolbar: '#toolbar',
            imageResize: {},
            videoResize: {},
            "emoji-toolbar": true,
            "emoji-textarea": true,
            "emoji-shortname": true,
        },
        placeholder: "Happy foruming...",
        theme: 'snow',
    });
    function selectAndUploadImage(){
        var input = $('<input type="file" name="file" class="">');
        input.click();
        input.on('change', function(e){
            $('#fileUploadModal').modal('show');
            var file = $(this).prop('files')[0];
            if(/^image\//.test(file.type)){
                $('.upload-file-modal-body').html('<div class="d-flex align-items-center" style="color: #0088ff">\n' +
                    '  <strong>Uploading ' + file.name + '...</strong>\n' +
                    '  <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>\n' +
                    '</div>');
                var formData = new FormData();
                formData.append('file', file);
                $.ajax({
                    url: upload_image_url,
                    method: 'POST',
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(data){
                        if(data.success){
                            $('.upload-file-modal-body').html('<div class="text-success">' + data.success.msg + '</div>');
                            const range = editor.getSelection();
                            editor.insertEmbed(range.index, 'image', '//' + window.location.host + BASE_URL + '/images/post/' + data.success.uploaded_file);
                        }else if(data.error){
                            $('.upload-file-modal-body').html('<div class="text-danger">' + data.error.msg + '</div>');
                        }
                        setTimeout(function(){
                            $('#fileUploadModal').modal('toggle');
                        }, 2000);

                    },
                });
            }else{
                $('.upload-file-modal-body').html('<span class="text-warning">The file you selected isn\'t an image</span>');
            }
        });
    }
    editor.getModule('toolbar').addHandler('image', function() {
        selectAndUploadImage();
    });

</script>