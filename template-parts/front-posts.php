<!-- Slide  <?php echo $args['counter'] ?> -->
<div class="min-w-full">
    <a href="<?php echo $args['data']['ogUrl'];?>">
        <img src="<?php echo $args['data']['ogImage'];?>" alt="Slide <?php echo $args['counter'] ?>" class="w-full h-full object-cover aspect-[21/9] bg-slate-300"/>
    </a>
    <div class="hidden lg:block absolute w-11/12 bottom-4 p-4 mx-4 rounded-lg text-slate-100 bg-slate-800 bg-opacity-75 hover:bg-opacity-100">
        <h1 class="text-2xl font-bold">
        <a href="<?php echo $args['data']['ogUrl'];?>">
            <?php echo $args['data']['pageTitle'];?>
        </a></h1>
        <p><?php echo $args['data']['ogDescription'];?></p>
    </div>
</div>

