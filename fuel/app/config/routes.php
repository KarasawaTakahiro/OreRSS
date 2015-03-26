<?php
return array(
	'_root_'  => 'orerss/index',  // The default route
	'_404_'   => 'orerss/404',    // The main 404 route

    '(:any)'    => 'orerss/$1', // コントローラ名を省略
);
