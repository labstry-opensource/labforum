<?php
if(!isset($_SESSION)) session_start();

include_once dirname(__FILE__) . '/../autoload.php';

$opt_in_script = array(
    'https://unpkg.com/quill@1.3.7/dist/quill.min.js',
    'https://unpkg.com/quill-image-resize-module@3.0.0/image-resize.min.js',
    'https://unpkg.com/quill-video-resize-module@1.0.2/video-resize.min.js',
    'https://unpkg.com/quill-emoji@0.1.7/dist/quill-emoji.js',
);
$opt_in_css = array(
    'https://unpkg.com/quill@1.3.7/dist/quill.snow.css',
    'https://fonts.googleapis.com/css?family=Noto+Sans+TC&display=swap',
    'https://unpkg.com/quill-emoji@0.1.7/dist/quill-emoji.css',
);


$userroles = new UserRoles($pdoconnect);
$essential = new Essentials($pdoconnect);
$userroles->getUserRole(@$_SESSION['id']);
$right = $userroles->rights;

$essential->imposeRestrictAccess($right, 90);

$forum = new Forum($pdoconnect);
$forum_arr = $forum->getSubformByFid(@$_GET['id']);

include dirname(__FILE__ ) . '/view/page-forum-manage.php';
