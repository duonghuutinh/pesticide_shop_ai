<section id="slider">

    <div class="container">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide"  data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#slider-carousel" data-slide-to="1"></li>
                        <li data-target="#slider-carousel" data-slide-to="2"></li>
                    </ol>
                    
                    <div class="carousel-inner">

                        <?php 
                            foreach ($sliders as $key => $slide) {
                        ?>
                        <div style="margin: 0 auto" class="item <?php echo ($key==0)?'active' : ''; ?>">
                            <div class="col-sm-11">
                                <img style="width: 930px; height: 300px;" src="<?php echo base_url('uploads/sliders/'.$slide->image) ?>" class="girl img-responsive" alt="<?php echo $slide->title ?>" />
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    
                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
                
            </div>
        </div>
    </div>
</section>
