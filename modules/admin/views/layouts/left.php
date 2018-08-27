<aside class="main-sidebar">
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->hoten ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    ['label' => 'Danh sách thành phố','icon' => 'fort-awesome' ,'url' => ['/admin/city/index']],
                    ['label' => 'Danh sách đạo diễn','icon' => 'edit', 'url' => ['/admin/daodien/index']],
                    ['label' => 'Danh sách rạp','icon' => 'list' , 'url' => ['/admin/rap/index']],        
                    [
                        'label' => 'Danh mục phim',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Thể loại', 'icon' => 'file-code-o', 'url' => ['/admin/theloai/index']],
                            ['label' => 'Phim', 'icon' => 'film', 'url' => ['/gii']]
                        ],
                    ],
                     [
                        'label' => 'Quản lý giao diện',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Logo', 'icon' => 'reddit', 'url' => ['#']],
                            ['label' => 'Slide', 'icon' => 'sliders', 'url' => ['#']],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
