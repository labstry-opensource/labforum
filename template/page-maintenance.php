<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Maintenance</title>
</head>
<body style="background-color:#800080; color: white">
    <div class="container" >
        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="maintenance-container" style="max-width: 500px">
                <img class="p-4 w-100 logo svg" src="<?php echo BASE_URL . '/assets/product_logo.svg' ?>" alt="Labforum Logo">
                <h1 class="h5 text-center">The site is undergoing maintenance.</h1>
                <div class="py-5">
                    <article>
                        <p>
                            Due to the reason of <?php echo strlen($maintain_arr['reason'])? $maintain_arr['reason'] : 'Unknown Reasons'?>, our site is currently unavailable.
                        </p>

                    </article>
                    <div>
                        <div><b>Please come back in <?php echo $maintain_arr['e_date'] ?></b>. Sorry for any inconvenience that might cause.</div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <script src="https://unpkg.com/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://unpkg.com/bootstrap@5.0.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

<script>
    $('img.svg').each(function (){
        var self = $(this);
        var src = $(this).attr('src');
        var id = $(this).attr('id');
        var class_name = $(this).attr('class');

        $.get(src, function(data){
            var svg_tag = $(data).find('svg');
            if(id !== undefined){
                svg_tag = svg_tag.attr('id', id);
            }
            if(class_name !== undefined){
                svg_tag = svg_tag.attr('class', class_name + ' replaced_svg');
            }
            svg_tag = svg_tag.removeAttr('xmlns:a');
            self.replaceWith(svg_tag);
        });
    })
</script>
</html>


