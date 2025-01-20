<?php 
$message = $args['texte'];
if ($message != '') {
    echo '<div class="py-4">';
    echo '  <div class="container mx-auto relative overflow-hidden">';
    echo '      <div class="flash-animation absolute top-0 bottom-0 h-full w-full py-2 -translate-x-full"></div>';
    echo '      <div class="alerte bg-red-500 text-white">';
    echo '          <p class="py-2 px-4">'.$message.'</p>';
    echo '      </div>';
    echo '  </div>';
    echo '</div>';
}
?>