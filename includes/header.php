<!--header-->
            <div class="header">
                <div class="container">
                    <div class="header-top">
                        <nav class="navbar navbar-default">
                            <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
                                <div class="navbar-header">
                                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                            <span class="sr-only">Toggle navigation</span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                      </button>
                                    <div class="navbar-brand">
                                        <h1><a href="index.php">Zoo planet</a></h1>
                                    </div>
                                </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">                              <ul class="nav navbar-nav">
                                    <?php $current_page = basename($_SERVER['PHP_SELF']); ?>
                                    <li class="<?php if($current_page == 'index.php') { echo 'active'; } ?>"><a href="index.php">Trang chủ <?php if($current_page == 'index.php') { ?><span class="sr-only">(current)</span><?php } ?></a></li>
                                    <li class="<?php if($current_page == 'about.php') { echo 'active'; } ?>"><a href="about.php">Về chúng tôi <?php if($current_page == 'about.php') { ?><span class="sr-only">(current)</span><?php } ?></a></li>
                                    <li class="<?php if($current_page == 'contact.php') { echo 'active'; } ?>"><a href="contact.php">Liên hệ <?php if($current_page == 'contact.php') { ?><span class="sr-only">(current)</span><?php } ?></a></li>
                                    <li class="<?php if($current_page == 'animals.php') { echo 'active'; } ?>"><a href="animals.php">Thú <?php if($current_page == 'animals.php') { ?><span class="sr-only">(current)</span><?php } ?></a></li>
                                    <li><a href="admin/index.php">Quản lý</a></li>
                                </ul>
                              
                            </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
                        </nav>

                    </div>
                </div>
            </div>