<?php
if(!isset($loading_msg)){
    $loading_msg = 'Loading...';
}
?>
<div class="circular-loader-wrapper">
    <div class="circular-loader d-inline-block">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
        </svg>
    </div>
    <div class="d-inline-block circular-loader-text"><?php echo $loading_msg; ?></div>
</div>
