<section class="bg-primary border-top border-bottom" id="page">
    <div class="container py-8">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-body flex-fill h-100 py-4 px-md-4 border-0 shadow-sm">
                    <h2 class="my-4"><?php echo $page->name ?></h2>          
                    <article>
                        <?php echo $page->content ?>
                    </article>
                </div>
            </div>
        </div>
    </div>
</section>